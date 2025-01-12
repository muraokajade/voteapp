<?php
namespace lib;
use db\UserQuery;
use model\UserModel;
use Throwable;

class Auth {
    public static function login($id, $pwd) {
        try {
            if(!(UserModel::validateId($id) * !UserModel::validatePwd($pwd))) {
                return false;
            }
            $is_success = false;
            $user = USerQuery::fetchById($id);
    
        if(!empty($user) && $user->del_flg !== 1) {
    
            if(password_verify($pwd,$user->pwd)) {
                $is_success = true;
                UserModel::setSession($user);
            } else {
                echo 'パスワードが一致しません';
            }
        } else {
            echo 'ユーザーが見つかりません';
        }
        } catch(Throwable $e) {
            $is_success = false;
            Msg::push(Msg::DEBUG, $e->getMessage());
            Msg::push(Msg::ERROR, 'ユーザーログインの処理でエラーが起きました');
        }

        
    
        return $is_success;
    }

    public static function regist($user) {
        try {
            if(!($user->isValidId() * $user->isValidPwd() * $user->isValidNickname())) {
                return false;
            }
            $is_success = false;

            $exist_user = UserQuery::fetchById($user->id);

            if(!empty($exist_user)) {
                echo 'ユーザーが既に存在しています';
                return false;
            }
            $is_success =  UserQuery::insert($user);

            if($is_success) {
                UserModel::setSession($user);
            }
        } catch(Throwable $e) {
            $is_success = false;
            Msg::push(Msg::DEBUG, $e->getMessage());
            Msg::push(Msg::ERROR, 'ユーザーログインの処理でエラーが起きました');
        }
        
        return $is_success;
    }

    public static function isLogin() {
        try {

            $user = UserModel::getSession();
        } catch(Throwable $e) {
            UserModel::clearSession();
            Msg::push(Msg::DEBUG, $e->getMessage());
            Msg::push(Msg::ERROR, 'エラーが起きました。');
            return false;
        }
        $user = UserModel::getSession();

        if(isset($user)) {
            return true;
        } else {
            return false;
        }
    }

    public static function logout() {
        try {
            UserModel::clearSession();
        } catch(Throwable $e) {
            Msg::push(Msg::DEBUG, $e->getMessage());
            return false;
        }
        return true;
    }
}
