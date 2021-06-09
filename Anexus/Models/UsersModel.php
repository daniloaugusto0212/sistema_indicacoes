<?php

namespace Anexus\Models;

class UsersModel
{
    public static function usersList()
    {
        $list = \Anexus\MySql::connect()->prepare("SELECT * from users");
        $list->execute();
        return $list = $list->fetchAll();
    }

    
    public static function emailExists($email)
    {
        $verify = \Anexus\MySql::connect()->prepare("SELECT email from users WHERE email = ?");
        $verify->execute(array($email));
        $verify = $verify->fetchAll();
        if (empty($verify)) {
            return false;
        } else {
            return true;
        }
    }
}
