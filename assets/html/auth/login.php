<?php
session_start();

// Nếu đã đăng nhập → chuyển về trang chủ
if (isset($_SESSION['user_id'])) {
    header("Location: ../../../public/index.php"); // hoặc dashboard.php
    exit();
}
?>

<!doctype html>
<html lang="vi" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập | Thuexe.com</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="../../css/style.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
    body {
        background-image: url('../../img/background.jpg');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        background-attachment: fixed;
    }

    body::before {
        content: '';
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        z-index: -1;
    }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center p-4">
    <?php
    // Get old data if exists
    $login_email = $_SESSION['login_email'] ?? '';
    unset($_SESSION['login_email']);
    ?>
    <div class="w-full max-w-md">
        <!-- Login Form Card -->
        <div class="bg-white/95 backdrop-blur-sm rounded-2xl shadow-2xl p-6 md:p-8 lg:p-10 animate-fadeInUp">
            <form id="loginForm" method="POST" action="../../php/auth/login_process.php" class="space-y-6">
                <div class="text-center mb-8 animate-fadeInUp">
                    <h2 class="text-3xl md:text-4xl font-bold mb-3 text-black-900 drop-shadow-lg">
                        ĐĂNG NHẬP
                    </h2>
                    <p class="text-gray-600 text-sm">Chào mừng bạn trở lại!</p>
                </div>



                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-semibold mb-2" style="color: var(--text-primary);">
                        Email
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                            </svg>
                        </div>
                        <input type="email" id="email" name="email" required
                            class="w-full pl-10 pr-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 transition-all"
                            placeholder="example@email.com" value="<?php echo htmlspecialchars($login_email); ?>">
                    </div>
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-semibold mb-2" style="color: var(--text-primary);">
                        Mật khẩu
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input type="password" id="password" name="password" required
                            class="w-full pl-10 pr-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 transition-all"
                            placeholder="Nhập mật khẩu">
                    </div>
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input type="checkbox" id="remember" name="remember"
                            class="h-4 w-4 rounded border-gray-300 focus:ring-2" style="color: var(--primary-color);">
                        <label for="remember" class="ml-2 text-sm text-gray-600">
                            Ghi nhớ đăng nhập
                        </label>
                    </div>
                    <a href="#" class="text-sm font-semibold hover:underline" style="color: var(--primary-color);">
                        Quên mật khẩu?
                    </a>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    class="w-full btn-primary py-4 rounded-lg font-bold text-base shadow-lg text-white hover:shadow-xl transform hover:-translate-y-1 transition-all"
                    style="background: var(--accent-gradient);">
                    Đăng nhập
                </button>

                <!-- Divider -->
                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-4 bg-white text-gray-500">Hoặc đăng nhập với</span>
                    </div>
                </div>

                <!-- Social Login -->
                <div class="grid grid-cols-2 gap-4">
                    <button type="button"
                        class="flex items-center justify-center px-4 py-3 border-2 border-gray-300 rounded-lg font-medium hover:bg-gray-50 transition-all">
                        <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24">
                            <path fill="#4285F4"
                                d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                            <path fill="#34A853"
                                d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                            <path fill="#FBBC05"
                                d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" />
                            <path fill="#EA4335"
                                d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
                        </svg>
                        Google
                    </button>
                    <button type="button"
                        class="flex items-center justify-center px-4 py-3 border-2 border-gray-300 rounded-lg font-medium hover:bg-gray-50 transition-all">
                        <svg class="w-5 h-5 mr-2" fill="#1877F2" viewBox="0 0 24 24">
                            <path
                                d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                        </svg>
                        Facebook
                    </button>
                </div>

                <!-- Signup Link -->
                <div class="text-center mt-6">
                    <p class="text-sm text-gray-600">
                        Chưa có tài khoản?
                        <a href="signup.php" class="font-bold hover:underline" style="color: var(--primary-color);">
                            Đăng ký ngay
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../../js/main.js"></script>
    <script>
    // Simple form validation
    document.getElementById('loginForm').addEventListener('submit', function(e) {
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;

        if (!email || !password) {
            e.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Thiếu thông tin!',
                text: 'Vui lòng điền đầy đủ email và mật khẩu!',
                confirmButtonColor: '#3085d6'
            });
            return false;
        }

        if (password.length < 8) {
            e.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Mật khẩu quá ngắn!',
                text: 'Mật khẩu phải có ít nhất 8 ký tự!',
                confirmButtonColor: '#3085d6'
            });
            return false;
        }
    });

    <?php
    // Display success message from signup
    if (isset($_SESSION['signup_success'])) {
        $msg = addslashes($_SESSION['signup_success']);
        echo "
        Swal.fire({
            icon: 'success',
            title: 'Thành công!',
            text: '$msg',
            confirmButtonColor: '#10b981'
        });
        ";
        unset($_SESSION['signup_success']);
    }
    
    // Display errors
    if (isset($_SESSION['login_errors'])) {
        $errorMsg = "";
        foreach ($_SESSION['login_errors'] as $error) {
            $errorMsg .= $error . "\\n";
        }
        $errorMsg = addslashes($errorMsg);
        
        echo "
        Swal.fire({
            icon: 'error',
            title: 'Đăng nhập thất bại!',
            html: '" . str_replace("\\n", "<br>", $errorMsg) . "',
            confirmButtonColor: '#d33'
        });
        ";
        unset($_SESSION['login_errors']);
    }
    ?>
    </script>
</body>

</html>