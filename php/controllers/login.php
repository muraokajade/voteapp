<?php
namespace controller\login;
function get() {
    require_once SOURCE_BASE . 'views/login.php';
}

function post() {
    echo 'postメソッドを受け取りました';
}