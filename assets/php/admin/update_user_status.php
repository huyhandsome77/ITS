<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/QuanTriMang/config/Connect_DB.php';

$data = json_decode(file_get_contents("php://input"), true);

$user_id = (int)($data['user_id'] ?? 0);
$status  = $data['status'] ?? '';

if (!$user_id || !in_array($status, ['ACTIVE', 'BLOCKED'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Dữ liệu không hợp lệ'
    ]);
    exit;
}

if ($user_id == ($_SESSION['user_id'] ?? 0)) {
    echo json_encode([
        'success' => false,
        'message' => 'Không thể tự khóa tài khoản của chính bạn'
    ]);
    exit;
}


$stmt = $conn->prepare(
    "UPDATE users SET status = ? WHERE user_id = ?"
);
$stmt->execute([$status, $user_id]);

echo json_encode([
    'success' => true,
    'message' => $status === 'ACTIVE'
        ? 'Tài khoản đã được mở khóa'
        : 'Tài khoản đã bị khóa'
]);