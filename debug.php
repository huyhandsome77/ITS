<?php
session_start();
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Debug Session</title>
    <style>
    body {
        font-family: monospace;
        background: #f8fafc;
        padding: 20px;
    }

    .box {
        background: #fff;
        padding: 16px;
        border-radius: 8px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, .1);
    }

    h2 {
        margin-top: 0;
    }

    pre {
        background: #111827;
        color: #e5e7eb;
        padding: 12px;
        border-radius: 6px;
        overflow: auto;
    }
    </style>
</head>

<body>

    <div class="box">
        <h2>🧪 DEBUG SESSION</h2>

        <p><b>Session ID:</b> <?= session_id(); ?></p>

        <p><b>Session Status:</b>
            <?php
        echo session_status() === PHP_SESSION_ACTIVE
            ? "✅ ACTIVE"
            : "❌ NOT ACTIVE";
        ?>
        </p>

        <h3>📦 Dữ liệu trong $_SESSION</h3>

        <?php if (empty($_SESSION)): ?>
        <p style="color:red;">❌ SESSION RỖNG (chưa login hoặc đã logout)</p>
        <?php else: ?>
        <pre><?php print_r($_SESSION); ?></pre>
        <?php endif; ?>
    </div>

</body>

</html>