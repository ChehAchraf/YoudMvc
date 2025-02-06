<?php
// Simple page redirect
function redirect($page){
    header('location: ' . URLROOT . '/' . $page);
}

// URL helper function
function url($path = '') {
    return URLROOT . '/' . $path;
} 