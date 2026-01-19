<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function setFlashAlert($icon, $title, $text) {
    $_SESSION['flash_alert'] = [
        'icon'  => $icon,   // success | error | warning | info
        'title' => $title,
        'text'  => $text
    ];
}