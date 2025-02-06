<?php
session_start();

// Flash message helper
function flash($name = '', $message = '', $class = 'alert alert-success') {
    if(!empty($name)) {
        if(!empty($message) && empty($_SESSION[$name])) {
            if(!empty($_SESSION[$name])) {
                unset($_SESSION[$name]);
            }

            if(!empty($_SESSION[$name . '_class'])) {
                unset($_SESSION[$name . '_class']);
            }

            $_SESSION[$name] = $message;
            $_SESSION[$name . '_class'] = $class;
        } elseif(empty($message) && !empty($_SESSION[$name])) {
            $class = !empty($_SESSION[$name . '_class']) ? $_SESSION[$name . '_class'] : '';
            echo '<div class="' . $class . '" id="msg-flash">' . $_SESSION[$name] . '</div>';
            unset($_SESSION[$name]);
            unset($_SESSION[$name . '_class']);
        }
    }
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function isAdmin() {
    return isLoggedIn() && $_SESSION['user_role'] === 'admin';
}

function isTeacher() {
    return isLoggedIn() && $_SESSION['user_role'] === 'teacher';
}

function isStudent() {
    return isLoggedIn() && $_SESSION['user_role'] === 'student';
}

function setFlash($name, $message, $class = 'success') {
    if(!empty($_SESSION['flash'])) {
        unset($_SESSION['flash']);
    }
    $_SESSION['flash'] = [
        'name' => $name,
        'message' => $message,
        'class' => $class
    ];
}

// function flash() {
//     if(isset($_SESSION['flash'])) {
//         $flash = $_SESSION['flash'];
//         unset($_SESSION['flash']);
//         return $flash;
//     }
//     return null;
// } 