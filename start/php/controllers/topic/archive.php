<?php 
namespace controller\topic\archive;

use db\TopicQuery;
use lib\Auth;
use model\UserModel;

function get() {

    Auth::requireLogin();
    $user = UserModel::getSession();

    $topics = TopicQuery::fetchByUserId($user);

    echo '<pre>', print_r($topics), '</pre>';
}