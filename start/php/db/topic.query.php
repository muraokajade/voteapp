<?php 
namespace db;

use db\DataSource;
use model\TopicModel;

class TopicQuery {
    public static function fetchByUserId($user) {

        if(!$user->isValidId()) {
            return false;
        } 

        $db = new DataSource;
        $sql = 'select * from pollapp.topics t where user_id = :id and del_flg != 1';

        $result = $db->select($sql, [
            ':id' => $user->id
        ], DataSource::CLS, TopicModel::class);

        return $result;

    }

    // public static function insert($user) {

    //     $db = new DataSource;
    //     $sql = 'insert into users(id, pwd, nickname) values (:id, :pwd, :nickname)';

    //     $user->pwd = password_hash($user->pwd, PASSWORD_DEFAULT);

    //     return $db->execute($sql, [
    //         ':id' => $user->id,
    //         ':pwd' => $user->pwd,
    //         ':nickname' => $user->nickname,
    //     ]);

    // }
}