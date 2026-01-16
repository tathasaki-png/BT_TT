<?php

namespace App\Jobs;

use App\Models\JobLog;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeEmail;
use Throwable;

class SendWelcomeEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email;
    protected $userName;
    protected $jobLogId;

    /**
     * Create a new job instance.
     */
    public function __construct($email, $userName)
    {
        $this->email = $email;
        $this->userName = $userName;
        $this->onQueue('default');
        $this->delay(0); // Không delay, thực hiện ngay
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $jobLog = null;
        
        // Ghi vào file riêng để debug
        file_put_contents(__DIR__ . '/../../debug_job.log', "[" . date('Y-m-d H:i:s') . "] 🎬 SendWelcomeEmailJob starting for {$this->email}\n", FILE_APPEND);
        \Log::info("🎬 SendWelcomeEmailJob starting for {$this->email}");

        try {
            // Tạo log entry với trạng thái pending đầu tiên
            file_put_contents(__DIR__ . '/../../debug_job.log', "[" . date('Y-m-d H:i:s') . "] Creating job log\n", FILE_APPEND);
            $jobLog = JobLog::firstOrCreate(
                [
                    'email' => $this->email,
                    'job_name' => self::class,
                    'status' => 'pending',
                ],
                [
                    'payload' => json_encode([
                        'userName' => $this->userName,
                        'email' => $this->email,
                    ]),
                    'retry_count' => 0,
                    'max_retries' => $this->maxTries() ?? 3,
                ]
            );
            file_put_contents(__DIR__ . '/../../debug_job.log', "[" . date('Y-m-d H:i:s') . "] Job log created\n", FILE_APPEND);

            // Cập nhật thành processing
            $jobLog->update([
                'status' => 'processing',
                'started_at' => now(),
                'retry_count' => $this->attempts(),
            ]);
            file_put_contents(__DIR__ . '/../../debug_job.log', "[" . date('Y-m-d H:i:s') . "] Updated to processing\n", FILE_APPEND);

            // Gửi email
            file_put_contents(__DIR__ . '/../../debug_job.log', "[" . date('Y-m-d H:i:s') . "] About to send email\n", FILE_APPEND);
            \Log::info("🔄 Attempting to send email to {$this->email}");
            \Log::info("Mail mailer config: " . config('mail.mailer'));
            \Log::info("Mail driver details - host: " . config('mail.mailers.smtp.host') . ", port: " . config('mail.mailers.smtp.port'));
            
            try {
                file_put_contents(__DIR__ . '/../../debug_job.log', "[" . date('Y-m-d H:i:s') . "] Before Mail::to()->send()\n", FILE_APPEND);
                \Log::info("Before Mail::to()->send()");
                $sendResult = Mail::to($this->email)->send(new WelcomeEmail($this->userName));
                file_put_contents(__DIR__ . '/../../debug_job.log', "[" . date('Y-m-d H:i:s') . "] After Mail::to()->send() - SUCCESS\n", FILE_APPEND);
                \Log::info("After Mail::to()->send() - Result: " . var_export($sendResult, true));
            } catch (\Throwable $sendError) {
                file_put_contents(__DIR__ . '/../../debug_job.log', "[" . date('Y-m-d H:i:s') . "] CAUGHT EXCEPTION: " . $sendError->getMessage() . "\n", FILE_APPEND);
                \Log::error("❌ Mail send caught exception: " . $sendError->getMessage(), [
                    'class' => get_class($sendError),
                    'file' => $sendError->getFile(),
                    'line' => $sendError->getLine(),
                ]);
                throw $sendError;
            }

            // Cập nhật log thành công
            $jobLog->update([
                'status' => 'success',
                'completed_at' => now(),
                'error_message' => null,
            ]);

            \Log::info("✅ Email marked as success in database for {$this->email}");

        } catch (Throwable $e) {
            // Cập nhật log thất bại
            if ($jobLog) {
                $jobLog->update([
                    'status' => 'failed',
                    'error_message' => $e->getMessage() . "\n" . $e->getTraceAsString(),
                    'retry_count' => $this->attempts(),
                    'max_retries' => $this->maxTries() ?? 3,
                    'completed_at' => now(),
                ]);
            }
            
            file_put_contents(__DIR__ . '/../../debug_job.log', "[" . date('Y-m-d H:i:s') . "] OUTER EXCEPTION: " . $e->getMessage() . "\n", FILE_APPEND);

            \Log::error("❌ Failed to send email to {$this->email}. Attempt: {$this->attempts()}", [
                'error' => $e->getMessage(),
                'max_tries' => $this->maxTries(),
            ]);

            // Throw lại exception để Laravel xử lý retry
            throw $e;
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(Throwable $exception): void
    {
        $jobLog = JobLog::where('email', $this->email)
            ->where('job_name', self::class)
            ->latest()
            ->first();

        if ($jobLog) {
            $jobLog->update([
                'status' => 'failed',
                'error_message' => "❌ Job failed after {$this->attempts()} attempts\n\n" . 
                                  $exception->getMessage() . "\n" .
                                  $exception->getTraceAsString(),
                'retry_count' => $this->attempts(),
                'max_retries' => $this->maxTries() ?? 3,
                'completed_at' => now(),
            ]);

            \Log::error("🔴 Job PERMANENTLY FAILED for {$this->email}", [
                'attempts' => $this->attempts(),
                'max_tries' => $this->maxTries(),
                'error' => $exception->getMessage(),
            ]);
        }
    }

    /**
     * Get the number of seconds to wait before retrying the job.
     *
     * @return int
     */
    public function backoff(): int
    {
        // Exponential backoff: 10s, 20s, 40s
        return 10 * (2 ** ($this->attempts() - 1));
    }

    /**
     * Determine the time at which the job should timeout.
     *
     * @return int
     */
    public function timeout(): int
    {
        return 120; // 2 phút timeout
    }

    /**
     * Determine the number of times the job should be attempted.
     *
     * @return int
     */
    public function maxTries(): ?int
    {
        return 3; // Retry tối đa 3 lần
    }
}
