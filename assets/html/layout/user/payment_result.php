<!doctype html>
<html lang="vi" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kết quả thanh toán | Thuexe.com</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen p-4">

    <?php
    $status = $_GET['status'] ?? 'error'; // success | error
    $message = $_GET['message'] ?? 'Giao dịch thất bại';
    $order_code = $_GET['order_code'] ?? '';
    $amount = $_GET['amount'] ?? 0;
    ?>

    <div class="bg-white rounded-2xl shadow-xl max-w-md w-full overflow-hidden text-center">
        
        <div class="p-8">
            <?php if ($status === 'success'): ?>
                <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-gray-800 mb-2">Thanh toán thành công!</h1>
                <p class="text-gray-600 mb-6">Cảm ơn bạn đã đặt xe. Đơn hàng của bạn đã được xác nhận.</p>
            <?php else: ?>
                <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-gray-800 mb-2">Thanh toán thất bại</h1>
                <p class="text-red-500 mb-6"><?= htmlspecialchars($message) ?></p>
            <?php endif; ?>

            <div class="bg-gray-50 rounded-xl p-4 mb-6 text-left space-y-2">
                <div class="flex justify-between">
                    <span class="text-gray-500">Mã đơn hàng</span>
                    <span class="font-medium text-gray-800"><?= htmlspecialchars($order_code) ?></span>
                </div>
                <?php if ($amount > 0): ?>
                <div class="flex justify-between">
                    <span class="text-gray-500">Số tiền</span>
                    <span class="font-bold text-gray-800"><?= number_format($amount, 0, ',', '.') ?>đ</span>
                </div>
                <?php endif; ?>
            </div>

            <div class="space-y-3">
                <a href="/ITS/assets/html/layout/user/list_car.php" 
                   class="block w-full py-3 rounded-lg text-white font-semibold transition bg-black hover:opacity-80">
                    Quay về danh sách xe
                </a>
                <a href="/ITS/public/index.php" class="block w-full py-3 rounded-lg text-gray-600 font-medium hover:bg-gray-100 transition">
                    Về trang chủ
                </a>
            </div>
        </div>
        
    </div>

</body>
</html>
