<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RealCppQuizSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $course = \App\Models\Course::where('title', 'like', '%C++%')->first();
        if (!$course) return;

        $lessons = $course->lessons()->orderBy('position')->get();

        foreach ($lessons as $lesson) {
            // Clear old questions
            $lesson->questions()->delete();

            // 10 Questions for the first few lessons to show variety
            $questionsData = [
                ['q' => 'Trong C++, hàm nào là hàm bắt đầu sự thực thi của chương trình?', 'options' => ['main()', 'start()', 'init()', 'begin()'], 'correct' => 0],
                ['q' => 'Ký tự nào dùng để kết thúc một câu lệnh trong C++?', 'options' => [';', ':', '.', ','], 'correct' => 0],
                ['q' => 'Từ khóa nào dùng để khai báo một số nguyên?', 'options' => ['int', 'integer', 'num', 'float'], 'correct' => 0],
                ['q' => 'Lệnh nào dùng để xuất dữ liệu ra màn hình (trong namespace std)?', 'options' => ['cout', 'cin', 'print', 'out'], 'correct' => 0],
                ['q' => 'Ngôn ngữ C++ là sự mở rộng của ngôn ngữ nào?', 'options' => ['C', 'Java', 'Python', 'Pascal'], 'correct' => 0],
                ['q' => 'C++ là một ngôn ngữ lập trình thuộc loại nào?', 'options' => ['Bậc cao', 'Bậc thấp', 'Ngôn ngữ máy', 'Ngôn ngữ Assembly'], 'correct' => 0],
                ['q' => 'Ký hiệu nào dùng để viết ghi chú (comment) trên một dòng?', 'options' => ['//', '/*', '#', '--'], 'correct' => 0],
                ['q' => 'Kiểu dữ liệu nào dùng để lưu trữ một ký tự đơn?', 'options' => ['char', 'string', 'character', 'byte'], 'correct' => 0],
                ['q' => 'Thư viện chuẩn để nhập xuất trong C++ là gì?', 'options' => ['iostream', 'stdio.h', 'conio.h', 'math.h'], 'correct' => 0],
                ['q' => 'Ai là người phát triển ngôn ngữ C++?', 'options' => ['Bjarne Stroustrup', 'Dennis Ritchie', 'Bill Gates', 'Steve Jobs'], 'correct' => 0],
            ];

            // If it's the 3rd lesson (Data types), give specific data type questions
            if (str_contains($lesson->title, 'Kiểu dữ liệu')) {
                $questionsData = [
                    ['q' => 'Kiểu dữ liệu nào chiếm 4 byte trên hầu hết các máy tính hiện nay?', 'options' => ['int', 'char', 'bool', 'double'], 'correct' => 0],
                    ['q' => 'Kiểu dữ liệu thực (số thập phân) có độ chính xác đơn là?', 'options' => ['float', 'double', 'long', 'int'], 'correct' => 0],
                    ['q' => 'Kiểu dữ liệu nào chỉ nhận giá trị true hoặc false?', 'options' => ['bool', 'int', 'char', 'void'], 'correct' => 0],
                    ['q' => 'Từ khóa nào dùng để xác định biến là hằng số?', 'options' => ['const', 'static', 'final', 'fixed'], 'correct' => 0],
                    ['q' => 'Phép toán % trong C++ dùng để làm gì?', 'options' => ['Chia lấy dư', 'Chia lấy nguyên', 'Tính phần trăm', 'Lũy thừa'], 'correct' => 0],
                    ['q' => 'Kiểu dữ liệu nào dùng để lưu trữ văn bản dài?', 'options' => ['string', 'chars', 'text', 'word'], 'correct' => 0],
                    ['q' => 'Cách khai báo biến đúng là?', 'options' => ['int x = 10;', 'x = 10 int;', 'declare x as int;', 'int: x = 10;'], 'correct' => 0],
                    ['q' => 'Kích thước của kiểu double thường là bao nhiêu byte?', 'options' => ['8', '4', '2', '16'], 'correct' => 0],
                    ['q' => 'Biến toàn cục được khai báo ở đâu?', 'options' => ['Bên ngoài các hàm', 'Bên trong hàm main', 'Trong cặp ngoặc nhọn', 'Ở cuối file'], 'correct' => 0],
                    ['q' => 'Tên biến nào sau đây là KHÔNG hợp lệ?', 'options' => ['2nd_value', '_value', 'value2', 'Value'], 'correct' => 0],
                ];
            }

            foreach ($questionsData as $data) {
                $q = \App\Models\Question::create([
                    'lesson_id' => $lesson->id,
                    'question_text' => $data['q'],
                ]);

                foreach ($data['options'] as $index => $optText) {
                    \App\Models\Option::create([
                        'question_id' => $q->id,
                        'option_text' => $optText,
                        'is_correct' => ($index === $data['correct']),
                    ]);
                }
            }
        }
    }
}
