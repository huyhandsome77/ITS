<?php
// assets/php/payment/momo_create_payment.php
require_once 'config_momo.php';

function execPostRequest($url, $data) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data))
    );
    curl_setopt($ch, CURLOPT_TIMEOUT, 20); // Increase timeout
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
    
    // DISABLE SSL VERIFY FOR HOST (Fix for XAMPP/Localhost)
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

    $result = curl_exec($ch);
    
    if (curl_errno($ch)) {
        $error_msg = curl_error($ch);
        curl_close($ch);
        return json_encode(['message' => 'CURL Error: ' . $error_msg]);
    }
    
    curl_close($ch);
    return $result;
}

function createMomoPayment($orderCode, $amount) {
    global $momo_config;

    $partnerCode = $momo_config['partnerCode'];
    $accessKey = $momo_config['accessKey'];
    $secretKey = $momo_config['secretKey'];
    
    // Config
    $requestId = $orderCode . "-" . time();
    $orderInfo = "Thanh toan don hang " . $orderCode;
    $redirectUrl = "http://localhost/ITS/assets/php/payment/momo_return.php";
    $ipnUrl = "http://localhost/ITS/assets/php/payment/momo_ipn.php";
    $extraData = "";

    // Signature
    $rawHash = "accessKey=" . $accessKey .
               "&amount=" . $amount .
               "&extraData=" . $extraData .
               "&ipnUrl=" . $ipnUrl .
               "&orderId=" . $orderCode .
               "&orderInfo=" . $orderInfo .
               "&partnerCode=" . $partnerCode .
               "&redirectUrl=" . $redirectUrl .
               "&requestId=" . $requestId .
               "&requestType=captureWallet";
               
    $signature = hash_hmac("sha256", $rawHash, $secretKey);

    $data = array(
        'partnerCode' => $partnerCode,
        'partnerName' => "Test MoMo",
        'storeId' => "MomoTestStore",
        'requestId' => $requestId,
        'amount' => $amount,
        'orderId' => $orderCode,
        'orderInfo' => $orderInfo,
        'redirectUrl' => $redirectUrl,
        'ipnUrl' => $ipnUrl,
        'lang' => 'vi',
        'extraData' => $extraData,
        'requestType' => 'captureWallet',
        'signature' => $signature
    );
    
    $result = execPostRequest($momo_config['endpoint'], json_encode($data));
    return json_decode($result, true);
}
?>
