<?php

namespace App\Services;

use Illuminate\Support\Str;

class VNPayService
{
    protected $tmnCode;
    protected $hashSecret;
    protected $paymentUrl;
    protected $queryUrl;
    protected $refundUrl;
    protected $appUrl;

    public function __construct()
    {
        $this->tmnCode = config('vnpay.tmn_code');
        $this->hashSecret = config('vnpay.hash_secret');
        $this->paymentUrl = config('vnpay.payment_url');
        $this->queryUrl = config('vnpay.query_url');
        $this->refundUrl = config('vnpay.refund_url');
        $this->appUrl = config('vnpay.app_url');
    }

    /**
     * Tạo URL thanh toán VNPay
     * 
     * @param array $data
     * @return string
     */
    public function createPaymentUrl($data)
    {
        $vnp_Params = [
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $this->tmnCode,
            "vnp_Amount" => (int)($data['amount'] * 100),
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $this->getClientIp(),
            "vnp_Locale" => 'vn',
            "vnp_OrderInfo" => $data['order_info'] ?? 'Thanh toan don hang',
            "vnp_OrderType" => 'other',
            "vnp_ReturnUrl" => $data['return_url'],
            "vnp_TxnRef" => $data['txn_ref']
        ];

        if (isset($data['bank_code']) && !empty($data['bank_code'])) {
            $vnp_Params['vnp_BankCode'] = $data['bank_code'];
        }

        ksort($vnp_Params);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($vnp_Params as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $this->paymentUrl . "?" . $query;
        $vnpSecureHash = hash_hmac('sha512', $hashdata, $this->hashSecret);
        $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;

        return $vnp_Url;
    }

    /**
     * Xác minh response từ VNPay
     * 
     * @param array $data
     * @return array
     */
    public function verifyPaymentResponse($data)
    {
        $vnp_SecureHash = $data['vnp_SecureHash'] ?? '';
        unset($data['vnp_SecureHash']);
        unset($data['vnp_SecureHashType']);

        ksort($data);
        $i = 0;
        $hashData = "";
        foreach ($data as $key => $value) {
            if ($i == 1) {
                $hashData .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }

        $calculatedHash = hash_hmac('sha512', $hashData, $this->hashSecret);

        return [
            'is_valid' => hash_equals($vnp_SecureHash, $calculatedHash),
            'transaction_code' => $data['vnp_TxnRef'] ?? null,
            'response_code' => $data['vnp_ResponseCode'] ?? null,
            'transaction_no' => $data['vnp_TransactionNo'] ?? null,
            'order_info' => $data['vnp_OrderInfo'] ?? null,
        ];
    }

    /**
     * Lấy thông tin giao dịch từ VNPay
     * 
     * @param string $txnRef
     * @param string $transDate
     * @return array
     */
    public function queryTransaction($txnRef, $transDate)
    {
        $params = [
            'vnp_RequestId' => Str::random(),
            'vnp_Version' => '2.1.0',
            'vnp_Command' => 'querydr',
            'vnp_TmnCode' => $this->tmnCode,
            'vnp_TxnRef' => $txnRef,
            'vnp_OrderInfo' => '',
            'vnp_TransactionDate' => $transDate,
            'vnp_CreateDate' => $this->getCurrentDateTime(),
            'vnp_IpAddr' => $this->getClientIp(),
        ];

        ksort($params);
        $hashData = '';
        foreach ($params as $key => $value) {
            if ($value != "") {
                $hashData .= '&' . $key . "=" . urlencode($value);
            }
        }
        $hashData = ltrim($hashData, '&');

        $params['vnp_SecureHash'] = hash_hmac('sha512', $hashData, $this->hashSecret);

        return $this->sendRequest($this->queryUrl, $params);
    }

    /**
     * Hoàn tiền giao dịch
     * 
     * @param string $txnRef
     * @param string $transDate
     * @param int $amount
     * @return array
     */
    public function refundTransaction($txnRef, $transDate, $amount)
    {
        $params = [
            'vnp_RequestId' => Str::random(),
            'vnp_Version' => '2.1.0',
            'vnp_Command' => 'refund',
            'vnp_TmnCode' => $this->tmnCode,
            'vnp_TxnRef' => $txnRef,
            'vnp_Amount' => (int)($amount * 100),
            'vnp_OrderInfo' => '',
            'vnp_TransactionDate' => $transDate,
            'vnp_CreateDate' => $this->getCurrentDateTime(),
            'vnp_IpAddr' => $this->getClientIp(),
        ];

        ksort($params);
        $hashData = '';
        foreach ($params as $key => $value) {
            if ($value != "") {
                $hashData .= '&' . $key . "=" . urlencode($value);
            }
        }
        $hashData = ltrim($hashData, '&');

        $params['vnp_SecureHash'] = hash_hmac('sha512', $hashData, $this->hashSecret);

        return $this->sendRequest($this->refundUrl, $params);
    }

    /**
     * Gửi request HTTP tới VNPay
     * 
     * @param string $url
     * @param array $data
     * @return array
     */
    private function sendRequest($url, $data)
    {
        try {
            $response = \Http::asForm()->post($url, $data);
            return $response->json();
        } catch (\Exception $e) {
            return [
                'error' => $e->getMessage(),
                'success' => false,
            ];
        }
    }

    /**
     * Lấy thời gian hiện tại định dạng YYYYMMDDHHmmss
     */
    private function getCurrentDateTime()
    {
        return now()->format('YmdHis');
    }

    /**
     * Lấy thời gian hết hạn (30 phút sau)
     */
    private function getExpireDate()
    {
        return now()->addMinutes(30)->format('YmdHis');
    }

    /**
     * Lấy IP của client
     */
    private function getClientIp()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    /**
     * Tạo mã giao dịch duy nhất
     */
    public function generateTransactionRef()
    {
        return 'ORD' . now()->format('YmdHis') . Str::random(6);
    }
}
