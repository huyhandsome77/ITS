// Payment History Management
(function() {
    'use strict';
    
    let currentPage = 1;
    let filters = {
        status: '',
        method: '',
        from_date: '',
        to_date: ''
    };

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', () => {
        loadPaymentHistory();
        setupEventListeners();
    });

    // Setup event listeners
    function setupEventListeners() {
        // Filter button
        const filterBtn = document.getElementById('filterButton');
        if (filterBtn) {
            filterBtn.addEventListener('click', applyFilters);
        }

        // Reset button
        const resetBtn = document.getElementById('resetButton');
        if (resetBtn) {
            resetBtn.addEventListener('click', resetFilters);
        }

        // Filter inputs - update filters object when changed
        document.getElementById('filterStatus')?.addEventListener('change', (e) => {
            filters.status = e.target.value;
        });

        document.getElementById('filterMethod')?.addEventListener('change', (e) => {
            filters.method = e.target.value;
        });

        document.getElementById('filterFromDate')?.addEventListener('change', (e) => {
            filters.from_date = e.target.value;
        });

        document.getElementById('filterToDate')?.addEventListener('change', (e) => {
            filters.to_date = e.target.value;
        });
    }

    // Apply filters
    function applyFilters() {
        currentPage = 1;
        loadPaymentHistory();
    }

    // Reset filters
    function resetFilters() {
        // Reset filter values
        filters = {
            status: '',
            method: '',
            from_date: '',
            to_date: ''
        };

        // Reset UI elements
        document.getElementById('filterStatus').value = '';
        document.getElementById('filterMethod').value = '';
        document.getElementById('filterFromDate').value = '';
        document.getElementById('filterToDate').value = '';

        // Reset to page 1 and reload
        currentPage = 1;
        loadPaymentHistory();
    }

    // Load payment history from API
    async function loadPaymentHistory() {
        try {
            // Show loading state
            showLoading(true);

            const params = new URLSearchParams({
                page: currentPage,
                ...filters
            });

            const response = await fetch(`../../../php/admin/get_payment_history.php?${params}`);
            const data = await response.json();

            if (data.success) {
                updateStats(data.stats);
                updateTotalCount(data.pagination.total_records);
                renderTransactions(data.data);
                renderPagination(data.pagination);
            } else {
                console.error('Failed to load payment history:', data.message);
                showError('Không thể tải dữ liệu lịch sử thanh toán');
            }
        } catch (error) {
            console.error('Error loading payment history:', error);
            showError('Lỗi kết nối đến server');
        } finally {
            // Hide loading state
            showLoading(false);
        }
    }

    // Show/hide loading state
    function showLoading(isLoading) {
        const filterBtn = document.getElementById('filterButton');
        const tbody = document.querySelector('tbody');

        if (isLoading) {
            // Disable filter button
            if (filterBtn) {
                filterBtn.disabled = true;
                filterBtn.classList.add('opacity-50', 'cursor-not-allowed');
            }

            // Show loading in table
            if (tbody) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="8" class="px-4 py-8 text-center text-gray-500">
                            <svg class="animate-spin h-8 w-8 mx-auto mb-2 text-teal-600" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Đang tải dữ liệu...
                        </td>
                    </tr>
                `;
            }
        } else {
            // Enable filter button
            if (filterBtn) {
                filterBtn.disabled = false;
                filterBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            }
        }
    }

    // Update statistics cards
    function updateStats(stats) {
        // Total Revenue
        const revenueEl = document.querySelector('.from-green-500 h3');
        if (revenueEl) {
            revenueEl.textContent = formatCurrency(stats.total_revenue);
        }

        // Total Transactions
        const totalEl = document.querySelector('.from-blue-500 h3');
        if (totalEl) {
            totalEl.textContent = formatNumber(stats.total_transactions);
        }

        // Today's Transactions
        const todayEl = document.querySelector('.from-blue-500 .text-xs');
        if (todayEl) {
            todayEl.textContent = `${stats.today_transactions} giao dịch hôm nay`;
        }

        // UNPAID Orders (Yellow card)
        const unpaidEl = document.querySelector('.from-yellow-500 h3');
        if (unpaidEl) {
            unpaidEl.textContent = formatNumber(stats.unpaid_orders);
        }

        // REFUNDED Orders (Red card)
        const refundedEl = document.querySelector('.from-red-500 h3');
        if (refundedEl) {
            refundedEl.textContent = formatNumber(stats.refunded_orders);
        }
    }

    // Render transactions table
    function renderTransactions(transactions) {
        const tbody = document.querySelector('tbody');
        if (!tbody) return;

        if (transactions.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="8" class="px-4 py-8 text-center text-gray-500">
                        Không có giao dịch nào
                    </td>
                </tr>
            `;
            return;
        }

        tbody.innerHTML = transactions.map(tx => createTransactionRow(tx)).join('');
    }

    // Update total count display
    function updateTotalCount(totalRecords) {
        const totalCountEl = document.getElementById('totalCount');
        if (totalCountEl) {
            totalCountEl.textContent = formatNumber(totalRecords);
        }
    }

    // Create transaction row HTML
    function createTransactionRow(tx) {
        const statusInfo = getStatusInfo(tx.result_code);
        const methodInfo = getMethodInfo(tx.payment_type);
        const rowClass = statusInfo.rowClass;

                return `
            <tr class="hover:bg-gray-50 ${rowClass}">
                <td class="px-4 py-3 text-sm font-mono">#${tx.trans_id || 'N/A'}</td>
                <td class="px-4 py-3 text-sm">
                    <div class="font-semibold">${tx.full_name || 'N/A'}</div>
                    <div class="text-xs text-gray-500">${tx.phone || 'N/A'}</div>
                </td>
                <td class="px-4 py-3 text-sm font-mono">${tx.order_code}</td>
                <td class="px-4 py-3 text-sm">
                    <span class="font-bold ${statusInfo.amountClass}">${formatCurrency(tx.amount)}</span>
                </td>
                <td class="px-4 py-3 text-sm">
                    <span class="px-3 py-1 rounded-full text-xs font-semibold ${methodInfo.class}">
                        ${methodInfo.label}
                    </span>
                </td>
                <td class="px-4 py-3 text-sm">
                    <div>${formatDate(tx.created_at)}</div>
                    <div class="text-xs text-gray-500">${formatTime(tx.created_at)}</div>
                </td>
                <td class="px-4 py-3">
                    <span class="px-3 py-1 rounded-full text-xs font-semibold ${statusInfo.class}">
                        ${statusInfo.label}
                    </span>
                </td>
                <td class="px-4 py-3 text-center">
                    <button class="text-blue-600 hover:text-blue-800 mx-1" title="Xem chi tiết" onclick="viewPaymentDetail(${tx.transaction_id})">
                        <svg class="w-5 h-5 inline-block" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                    ${tx.result_code === 0 ? `
                        <button class="text-gray-600 hover:text-gray-800 mx-1" title="In hóa đơn" onclick="printInvoice('${tx.order_code}')">
                            <svg class="w-5 h-5 inline-block" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5 4v3H4a2 2 0 00-2 2v3a2 2 0 002 2h1v2a2 2 0 002 2h6a2 2 0 002-2v-2h1a2 2 0 002-2V9a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v3h6V4zm0 8H7v4h6v-4z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                    ` : ''}
                    ${tx.result_code === -1 ? `
                        <button class="text-green-600 hover:text-green-800 mx-1" title="Xác nhận thanh toán" onclick="confirmPayment('${tx.order_code}', ${tx.transaction_id})">
                            <svg class="w-5 h-5 inline-block" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                    ` : ''}
                </td>
            </tr>
        `;
    }

    // Get status information based on result_code
    function getStatusInfo(resultCode) {
        if (resultCode === 0) {
            return {
                label: 'Thành công',
                class: 'bg-green-100 text-green-700',
                amountClass: 'text-green-600',
                rowClass: ''
            };
        } else if (resultCode === -1) {
            return {
                label: 'Chờ xác nhận',
                class: 'bg-yellow-100 text-yellow-700',
                amountClass: 'text-yellow-600',
                rowClass: 'bg-yellow-50'
            };
        } else {
            return {
                label: 'Thất bại',
                class: 'bg-red-100 text-red-700',
                amountClass: 'text-red-600',
                rowClass: 'bg-red-50'
            };
        }
    }

    // Get payment method information
    function getMethodInfo(paymentType) {
        const methods = {
            'MOMO': { label: 'MoMo', class: 'bg-pink-100 text-pink-700' },
            'CASH': { label: 'Tiền mặt', class: 'bg-green-100 text-green-700' },
            'TRANSFER': { label: 'Chuyển khoản', class: 'bg-blue-100 text-blue-700' },
            'CREDIT': { label: 'Thẻ tín dụng', class: 'bg-purple-100 text-purple-700' },
            'EWALLET': { label: 'Ví điện tử', class: 'bg-indigo-100 text-indigo-700' }
        };

        return methods[paymentType] || { label: paymentType, class: 'bg-gray-100 text-gray-700' };
    }

    // Render pagination
    function renderPagination(pagination) {
        const paginationContainer = document.querySelector('.flex.space-x-2');
        if (!paginationContainer) return;

        const { page, total_pages, total_records, limit } = pagination;
        const start = (page - 1) * limit + 1;
        const end = Math.min(page * limit, total_records);

        // Update summary text
        const summaryEl = paginationContainer.previousElementSibling;
        if (summaryEl) {
            summaryEl.textContent = `Hiển thị ${start}-${end} của ${formatNumber(total_records)} giao dịch`;
        }

        // Generate pagination buttons
        let buttons = [];

        // Previous button
        buttons.push(`
            <button class="px-4 py-2 border rounded-lg hover:bg-gray-50 ${page === 1 ? 'opacity-50 cursor-not-allowed' : ''}" 
                    ${page === 1 ? 'disabled' : ''} 
                    onclick="goToPage(${page - 1})">
                Trước
            </button>
        `);

        // Page numbers
        const maxButtons = 5;
        let startPage = Math.max(1, page - Math.floor(maxButtons / 2));
        let endPage = Math.min(total_pages, startPage + maxButtons - 1);

        if (endPage - startPage < maxButtons - 1) {
            startPage = Math.max(1, endPage - maxButtons + 1);
        }

        for (let i = startPage; i <= endPage; i++) {
            buttons.push(`
                <button class="px-4 py-2 border rounded-lg ${i === page ? 'text-white' : 'hover:bg-gray-50'}" 
                        style="${i === page ? 'background: var(--primary-color);' : ''}"
                        onclick="goToPage(${i})">
                    ${i}
                </button>
            `);
        }

        // Next button
        buttons.push(`
            <button class="px-4 py-2 border rounded-lg hover:bg-gray-50 ${page === total_pages ? 'opacity-50 cursor-not-allowed' : ''}" 
                    ${page === total_pages ? 'disabled' : ''} 
                    onclick="goToPage(${page + 1})">
                Sau
            </button>
        `);

        paginationContainer.innerHTML = buttons.join('');
    }

    // Go to page
    window.goToPage = function(page) {
        currentPage = page;
        loadPaymentHistory();
    };

    // View payment detail
    window.viewPaymentDetail = function(transactionId) {
        // TODO: Implement detail view
        alert(`Xem chi tiết giao dịch #${transactionId}`);
    };

    // Print invoice
    window.printInvoice = function(orderCode) {
        // TODO: Implement invoice printing
        alert(`In hóa đơn cho đơn hàng ${orderCode}`);
    };

    // Confirm payment (for UNPAID orders)
    window.confirmPayment = async function(orderCode, transactionId) {
        // Show confirmation dialog
        const result = await Swal.fire({
            title: 'Xác nhận thanh toán?',
            html: `
                <p>Bạn có chắc chắn đã nhận được thanh toán cho đơn hàng <strong>${orderCode}</strong>?</p>
                <p class="text-sm text-gray-600 mt-2">Hành động này sẽ cập nhật trạng thái thành "Đã thanh toán"</p>
            `,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#10b981',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Xác nhận',
            cancelButtonText: 'Hủy'
        });

        if (!result.isConfirmed) return;

        try {
            // Show loading
            Swal.fire({
                title: 'Đang xử lý...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Call API to confirm payment
            const response = await fetch('../../../php/admin/confirm_payment.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    order_code: orderCode,
                    transaction_id: transactionId
                })
            });

            const data = await response.json();

            if (data.success) {
                // Success
                await Swal.fire({
                    icon: 'success',
                    title: 'Thành công!',
                    text: 'Đã xác nhận thanh toán',
                    confirmButtonColor: '#10b981'
                });

                // Reload data
                loadPaymentHistory();
            } else {
                // Error
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi!',
                    text: data.message || 'Không thể xác nhận thanh toán',
                    confirmButtonColor: '#d33'
                });
            }
        } catch (error) {
            console.error('Error confirming payment:', error);
            Swal.fire({
                icon: 'error',
                title: 'Lỗi!',
                text: 'Lỗi kết nối đến server',
                confirmButtonColor: '#d33'
            });
        }
    };

    // Format currency
    function formatCurrency(amount) {
        return new Intl.NumberFormat('vi-VN', {
            style: 'currency',
            currency: 'VND'
        }).format(amount || 0);
    }

    // Format number
    function formatNumber(num) {
        return new Intl.NumberFormat('vi-VN').format(num || 0);
    }

    // Format date
    function formatDate(dateString) {
        const date = new Date(dateString);
        return date.toLocaleDateString('vi-VN');
    }

    // Format time
    function formatTime(dateString) {
        const date = new Date(dateString);
        return date.toLocaleTimeString('vi-VN', { hour: '2-digit', minute: '2-digit' });
    }

    // Show error message
    function showError(message) {
        alert(message); // TODO: Replace with better UI notification
    }
})();
