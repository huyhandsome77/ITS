<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once $_SERVER['DOCUMENT_ROOT'] . '/ITS/assets/php/auth/check_permission.php';
requireDispatcher();
// Include Dispatcher specific handling logic which contains helper functions and data fetching
require_once dirname(__DIR__, 3) . '/php/dispatcher/xuly_dispatcher_review.php';
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý đánh giá - Dispatcher Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../../../css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
    body {
        font-family: 'Inter', sans-serif;
    }
    </style>
</head>

<body class="min-h-full font-[Inter] bg-gray-50 text-gray-800">
<?php $baseUrl = '../../../..'; ?>
    <div id="app" class="flex min-h-screen">
        <!-- Sidebar -->
        <?php include '../../../includes/dispatcher/dispatcher_sidebar.php'; ?>

        <div id="contentWrapper" class="flex-1 flex flex-col min-h-screen ml-64 lg:ml-72 transition-all duration-300">
            <!-- Navbar -->
            <?php include '../../../includes/navbar.php'; ?>

            <!-- Main Content -->
            <main class="flex-1 overflow-auto p-4 md:p-6 lg:p-8" style="margin-top:76px">
                <!-- Page Header -->
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Quản lý đánh giá</h1>
                        <p class="text-sm text-gray-600 mt-1">Xem và phản hồi đánh giá từ khách hàng tại trạm.</p>
                    </div>
                </div>

                <!-- Statistics Cards -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                    <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-2xl shadow-lg p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-yellow-100 text-sm">Tổng đánh giá</p>
                                <h3 class="text-3xl font-bold mt-1"><?= number_format($totalReviews) ?></h3>
                            </div>
                            <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl shadow-lg p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-green-100 text-sm">Điểm TB</p>
                                <h3 class="text-3xl font-bold mt-1"><?= $avgRating ?> ⭐</h3>
                            </div>
                            <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl shadow-lg p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-blue-100 text-sm">Chờ duyệt</p>
                                <h3 class="text-3xl font-bold mt-1"><?= number_format($pendingReviews) ?></h3>
                            </div>
                            <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-2xl shadow-lg p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-red-100 text-sm">Báo cáo vi phạm</p>
                                <h3 class="text-3xl font-bold mt-1"><?= number_format($reportedReviews) ?></h3>
                            </div>
                            <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filter Section -->
                <section class="bg-white rounded-2xl shadow-sm border p-5 mb-6">
                    <h2 class="text-lg font-semibold mb-4">Bộ lọc</h2>
                    <form action="" method="GET">
                        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                            <select name="rating" class="border rounded-lg px-4 py-2 text-black">
                                <option value="">Tất cả đánh giá</option>
                                <option value="5" <?= $rating == '5' ? 'selected' : '' ?>>5 sao ⭐⭐⭐⭐⭐</option>
                                <option value="4" <?= $rating == '4' ? 'selected' : '' ?>>4 sao ⭐⭐⭐⭐</option>
                                <option value="3" <?= $rating == '3' ? 'selected' : '' ?>>3 sao ⭐⭐⭐</option>
                                <option value="2" <?= $rating == '2' ? 'selected' : '' ?>>2 sao ⭐⭐</option>
                                <option value="1" <?= $rating == '1' ? 'selected' : '' ?>>1 sao ⭐</option>
                            </select>

                            <select name="status" class="border rounded-lg px-4 py-2 text-black">
                                <option value="">Tất cả trạng thái</option>
                                <option value="pending" <?= $status == 'PENDING' ? 'selected' : '' ?>>Chờ duyệt</option>
                                <option value="approved" <?= $status == 'APPROVED' ? 'selected' : '' ?>>Đã duyệt</option>
                                <option value="rejected" <?= $status == 'REJECTED' ? 'selected' : '' ?>>Từ chối</option>
                                <option value="hidden" <?= $status == 'HIDDEN' ? 'selected' : '' ?>>Đã ẩn</option>
                            </select>

                            <select name="type" class="border rounded-lg px-4 py-2 text-black">
                                <option value="">Tất cả loại</option>
                                <option value="vehicle" <?= $type == 'VEHICLE' ? 'selected' : '' ?>>Đánh giá xe</option>
                                <option value="station" <?= $type == 'STATION' ? 'selected' : '' ?>>Đánh giá trạm</option>
                                <option value="service" <?= $type == 'SERVICE' ? 'selected' : '' ?>>Đánh giá dịch vụ</option>
                            </select>

                            <input type="date" name="date" value="<?= htmlspecialchars($date) ?>" class="border rounded-lg px-4 py-2 text-black">

                            <button type="submit" class="px-6 py-2 rounded-lg font-semibold text-white bg-black">
                                <svg class="w-5 h-5 inline-block mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                </svg>
                                Lọc
                            </button>
                        </div>
                    </form>
                </section>

                <!-- Review List -->
                <section class="bg-white rounded-2xl shadow-sm border p-5">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-semibold">Danh sách đánh giá</h2>
                        <span class="text-gray-600">Tổng số: <strong><?= number_format($filteredTotal) ?></strong> đánh giá</span>
                    </div>

                    <div class="space-y-4">
                        <?php if (empty($reviews)): ?>
                            <div class="text-center py-8 text-gray-500">Không tìm thấy đánh giá nào phù hợp.</div>
                        <?php else: ?>
                            <?php foreach ($reviews as $review): 
                                $initials = getInitials($review['full_name']);
                                $stars = getStarDisplay($review['rating']);
                                [$statusText, $statusClass] = getStatusBadge($review['status']);
                                $reviewTypeName = getReviewTypeName($review['review_type']);
                                $timeAgoText = timeAgo($review['created_at']);
                                
                                $reviewTarget = '';
                                if ($review['review_type'] === 'VEHICLE' && $review['vehicle_name']) {
                                    $reviewTarget = $review['vehicle_name'] . ' (' . $review['license_plate'] . ')';
                                } elseif ($review['review_type'] === 'STATION' && $review['station_name']) {
                                    $reviewTarget = $review['station_name'];
                                } else {
                                    $reviewTarget = 'Mã đơn: ' . $review['order_code'];
                                }

                                $bgClass = '';
                                if ($review['status'] === 'PENDING') $bgClass = 'bg-blue-50';
                                elseif ($review['is_reported']) $bgClass = 'bg-red-50 border-2 border-red-300';
                            ?>
                            <!-- Review Item -->
                            <div class="border rounded-lg p-5 hover:shadow-md transition <?= $bgClass ?>">
                                <div class="flex justify-between items-start mb-3">
                                    <div class="flex items-start space-x-4">
                                        <div class="w-12 h-12 bg-blue-500 text-white rounded-full flex items-center justify-center font-semibold text-lg">
                                            <?= htmlspecialchars($initials) ?>
                                        </div>
                                        <div>
                                            <h4 class="font-semibold text-lg"><?= htmlspecialchars($review['full_name']) ?> <span class="text-sm font-normal text-gray-500">(<?= $review['phone'] ?? '' ?>)</span></h4>
                                            <div class="flex items-center space-x-2 mt-1">
                                                <div class="flex text-yellow-400">
                                                    <span><?= $stars ?></span>
                                                </div>
                                                <span class="text-sm text-gray-500">• <?= $timeAgoText ?></span>
                                            </div>
                                            <p class="text-sm text-gray-600 mt-1"><?= $reviewTypeName ?>: <span class="font-semibold"><?= htmlspecialchars($reviewTarget) ?></span></p>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold <?= $statusClass ?>">
                                            <?= $statusText ?>
                                        </span>
                                    </div>
                                </div>
                                <div class="ml-16">
                                    <p class="text-gray-700 mb-3"><?= nl2br(htmlspecialchars($review['comment'])) ?></p>
                                    
                                    <?php if ($review['is_reported'] && $review['report_reason']): ?>
                                        <div class="bg-red-100 border border-red-300 rounded-lg p-3 mb-3">
                                            <p class="text-sm font-semibold text-red-800">⚠️ Lý do báo cáo: <?= htmlspecialchars($review['report_reason']) ?></p>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($review['reply']): ?>
                                        <div class="bg-gray-100 p-3 rounded-lg border-l-4 border-blue-500 mb-3">
                                            <p class="text-sm font-semibold text-blue-800 mb-1">Cửa hàng phản hồi:</p>
                                            <p class="text-sm text-gray-700"><?= nl2br(htmlspecialchars($review['reply'])) ?></p>
                                        </div>
                                    <?php endif; ?>

                                    <div class="flex space-x-2 mt-3">
                                        <button class="px-4 py-2 text-sm border rounded-lg hover:bg-gray-50" onclick="viewReview(<?= $review['review_id'] ?>)">
                                            <svg class="w-4 h-4 inline-block mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                                            </svg>
                                            Chi tiết
                                        </button>
                                        
                                        <?php if ($review['status'] === 'PENDING'): ?>
                                            <button class="px-4 py-2 text-sm bg-green-600 text-white rounded-lg hover:bg-green-700" onclick="approveReview(<?= $review['review_id'] ?>)">
                                                <svg class="w-4 h-4 inline-block mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                </svg>
                                                Duyệt
                                            </button>
                                            <button class="px-4 py-2 text-sm border rounded-lg hover:bg-gray-50 text-red-600" onclick="rejectReview(<?= $review['review_id'] ?>)">
                                                <svg class="w-4 h-4 inline-block mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                                </svg>
                                                Từ chối
                                            </button>
                                        <?php endif; ?>
                                        
                                        <?php if ($review['status'] === 'APPROVED' && !$review['is_reported']): ?>
                                            <button class="px-4 py-2 text-sm border rounded-lg hover:bg-gray-50 text-yellow-600" onclick="hideReview(<?= $review['review_id'] ?>)">
                                                <svg class="w-4 h-4 inline-block mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.78-1.781zm4.261 4.26l1.514 1.515a2.003 2.003 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z" clip-rule="evenodd"/>
                                                    <path d="M12.454 16.697L9.75 13.992a4 4 0 01-3.742-3.741L2.335 6.578A9.98 9.98 0 00.458 10c1.274 4.057 5.065 7 9.542 7 .847 0 1.669-.105 2.454-.303z"/>
                                                </svg>
                                                Ẩn
                                            </button>
                                        <?php endif; ?>
                                        
                                        <?php if ($review['is_reported']): ?>
                                            <button class="px-4 py-2 text-sm bg-yellow-600 text-white rounded-lg hover:bg-yellow-700" onclick="clearReport(<?= $review['review_id'] ?>)">
                                                <svg class="w-4 h-4 inline-block mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                                </svg>
                                                Xóa báo cáo
                                            </button>
                                        <?php endif; ?>
                                        
                                        <button class="px-4 py-2 text-sm border rounded-lg hover:bg-gray-50 text-red-600" onclick="deleteReview(<?= $review['review_id'] ?>)">
                                            <svg class="w-4 h-4 inline-block mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                            </svg>
                                            Xóa
                                        </button>
                                        
                                        <?php if (!$review['reply']): ?>
                                        <button class="px-4 py-2 text-sm border rounded-lg hover:bg-gray-50 text-blue-600" onclick="replyReview(<?= $review['review_id'] ?>)">
                                            <svg class="w-4 h-4 inline-block mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8s1-1.5 5-2.5c0 .5-.5 1-1.5 1.5s-2 1.5-3.5 1z" clip-rule="evenodd"/>
                                            </svg>
                                            Trả lời
                                        </button>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                    <!-- Pagination -->
                    <?php if ($totalPages > 1): ?>
                    <div class="flex justify-between items-center mt-6">
                        <span class="text-sm text-gray-600">Trang <?= $page ?>/<?= $totalPages ?></span>
                        <div class="flex space-x-2">
                            <?php if ($page > 1): ?>
                                <a href="?page=<?= $page - 1 ?>&rating=<?= $rating ?>&status=<?= $status ?>&type=<?= $type ?>&date=<?= $date ?>" class="px-4 py-2 border rounded-lg hover:bg-gray-50">Trước</a>
                            <?php endif; ?>

                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                <a href="?page=<?= $i ?>&rating=<?= $rating ?>&status=<?= $status ?>&type=<?= $type ?>&date=<?= $date ?>" class="px-4 py-2 border rounded-lg <?= $i == $page ? 'bg-black text-white' : 'hover:bg-gray-50' ?>">
                                    <?= $i ?>
                                </a>
                            <?php endfor; ?>
                            
                            <?php if ($page < $totalPages): ?>
                                <a href="?page=<?= $page + 1 ?>&rating=<?= $rating ?>&status=<?= $status ?>&type=<?= $type ?>&date=<?= $date ?>" class="px-4 py-2 border rounded-lg hover:bg-gray-50">Sau</a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </section>

            </main>

            <?php include '../../../includes/footer.php'; ?>
        </div>
    </div>
    <script src="../../../js/main.js"></script>
    <script>
    const API_BASE = '../../../php/dispatcher';

    function viewReview(id) {
        fetch(`${API_BASE}/get_dispatcher_review_detail.php?review_id=${id}`)
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    const r = data.data;
                    let starHtml = '';
                    for(let i=0; i<r.rating; i++) starHtml += '⭐';
                    
                    const replyContent = r.reply ? 
                        `<div class="mt-4 bg-blue-50 p-4 rounded-lg border border-blue-100">
                            <p class="text-sm font-semibold text-blue-800 mb-1">💬 Cửa hàng đã trả lời:</p>
                            <p class="text-gray-700 text-sm whitespace-pre-wrap">${r.reply}</p>
                            <p class="text-xs text-blue-500 mt-2 text-right">Lúc: ${new Date(r.replied_at).toLocaleString('vi-VN')}</p>
                         </div>` : 
                        '<p class="text-sm text-gray-500 italic mt-4 text-center">Chưa có phản hồi</p>';

                    Swal.fire({
                        width: '600px',
                        title: `Chi tiết đánh giá #${id}`,
                        html: `
                            <div class="text-left font-[Inter]">
                                <div class="flex items-center space-x-3 mb-4 p-3 bg-gray-50 rounded-lg">
                                    <div class="w-10 h-10 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center font-bold">
                                        ${r.full_name ? r.full_name.charAt(0).toUpperCase() : '?'}
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-800">${r.full_name}</p>
                                        <p class="text-sm text-gray-500">${r.phone || 'N/A'}</p>
                                    </div>
                                </div>
                                
                                <div class="mb-4">
                                     <div class="flex items-center mb-2">
                                        <span class="text-2xl mr-2">${starHtml}</span>
                                        <span class="text-gray-400 text-sm">(${r.rating}/5)</span>
                                    </div>
                                    <p class="text-sm text-gray-600 mb-2"><strong>Mã đơn:</strong> ${r.order_code}</p>
                                    <p class="text-sm text-gray-600 mb-2"><strong>Phương tiện:</strong> ${r.vehicle_name || 'N/A'}</p>
                                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-100 text-gray-700 italic">
                                        "${r.comment}"
                                    </div>
                                    ${r.report_reason ? `<p class="text-red-500 mt-2 p-2 bg-red-100 rounded"><strong>Báo cáo:</strong> ${r.report_reason}</p>` : ''}
                                </div>
                                ${replyContent}
                            </div>
                        `,
                        showCloseButton: true,
                        showConfirmButton: false
                    });
                } else {
                    Swal.fire('Lỗi', data.message, 'error');
                }
            });
    }

    function replyReview(id) {
        Swal.fire({
            title: 'Phản hồi đánh giá',
            html: `
                <p class="text-sm text-gray-500 mb-4">Câu trả lời của bạn sẽ được hiển thị công khai dưới đánh giá này.</p>
                <textarea id="swal-input-reply" class="w-full border rounded-lg p-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all" rows="4" placeholder="Nhập câu trả lời..."></textarea>
            `,
            showCancelButton: true,
            confirmButtonText: 'Gửi',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (result.isConfirmed) {
                const val = document.getElementById('swal-input-reply').value;
                if(!val.trim()) {
                     Swal.fire('Lỗi', 'Vui lòng nhập nội dung', 'error');
                     return;
                }
                const formData = new FormData();
                formData.append('review_id', id);
                formData.append('reply', val);

                fetch(`${API_BASE}/reply_dispatcher_review.php`, {
                    method: 'POST',
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    if(data.success) {
                        Swal.fire('Thành công', data.message, 'success').then(() => location.reload());
                    } else {
                        Swal.fire('Lỗi', data.message, 'error');
                    }
                })
                .catch(err => Swal.fire('Lỗi', 'Có lỗi xảy ra', 'error'));
            }
        });
    }

    function updateStatus(id, action) {
        const formData = new FormData();
        formData.append('review_id', id);
        formData.append('action', action);

        fetch(`${API_BASE}/update_dispatcher_review_status.php`, {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                Swal.fire('Thành công', data.message, 'success').then(() => location.reload());
            } else {
                Swal.fire('Lỗi', data.message, 'error');
            }
        })
        .catch(err => Swal.fire('Lỗi', 'Có lỗi xảy ra', 'error'));
    }

    function approveReview(id) {
        Swal.fire({
            title: 'Duyệt đánh giá?',
            text: "Đánh giá sẽ hiển thị công khai.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Duyệt'
        }).then(res => {
            if (res.isConfirmed) updateStatus(id, 'approve');
        });
    }

    function rejectReview(id) {
        Swal.fire({
            title: 'Từ chối đánh giá?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Từ chối',
            confirmButtonColor: '#d33'
        }).then(res => {
            if (res.isConfirmed) updateStatus(id, 'reject');
        });
    }

    function hideReview(id) {
        Swal.fire({
            title: 'Ẩn đánh giá?',
            text: "Đánh giá sẽ bị ẩn.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ẩn',
            confirmButtonColor: '#fbbf24'
        }).then(res => {
            if (res.isConfirmed) updateStatus(id, 'hide');
        });
    }

    function clearReport(id) {
        Swal.fire({
            title: 'Xóa báo cáo?',
            text: "Xác nhận đánh giá không vi phạm.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Xóa báo cáo'
        }).then(res => {
            if (res.isConfirmed) updateStatus(id, 'clear_report');
        });
    }

    function deleteReview(id) {
        Swal.fire({
            title: 'Xóa vĩnh viễn?',
            text: "Không thể hoàn tác!",
            icon: 'error',
            showCancelButton: true,
            confirmButtonText: 'Xóa!',
            confirmButtonColor: '#d33'
        }).then((result) => {
            if (result.isConfirmed) {
                const formData = new FormData();
                formData.append('review_id', id);
                fetch(`${API_BASE}/delete_dispatcher_review.php`, {
                    method: 'POST',
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire('Đã xóa!', 'Đánh giá đã bị xóa.', 'success').then(() => location.reload());
                    } else {
                        Swal.fire('Lỗi', data.message, 'error');
                    }
                });
            }
        });
    }
    </script>
</body>
</html>