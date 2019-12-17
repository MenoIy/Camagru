<?php

class UserModel
{
    private $_database;

    public function __construct(Database $db_instance)
    {
        $this->_database = $db_instance;
    }

    public function addUser($data)
    {
        $query = "INSERT INTO `camagru_users` SET `user_login` = ? , `user_mail` = ?, `user_password` = ?, `account_status` = ?"; 
        $password = hash('whirlpool', $data['passwd']);
        if ($this->_database->execute($query, [$data['login'], $data['mail'], $password, 'Inactive']))
        {
            $this->_addAccount($data['mail'], $data['login']);
            return TRUE;
        }
        else
            return FALSE;
    }
    public function getUserByLogin($login)
    {
        $query = "SELECT user_login from camagru_users WHERE user_login = ?";
        $user = $this->_database->select($query, [$login]);
        if (!$user)
            return null;
        else
            return ($user['user_login']);
    }
    public function getUserByMail($mail)
    {
        $query = "SELECT user_login from camagru_users WHERE user_mail = ?";
        $user = $this->_database->select($query, [$mail]);
        if (!$user)
            return null;
        else
            return ($user['user_login']);
    }

    private function _addAccount($mail, $login)
    {
        $token = $this->_generateToken($mail, $login);
        $query = "INSERT INTO `camagru_account` SET `account_login` = ?, `account_mail` = ? , `account_token` = ?"; 
        if ($this->_database->execute($query, [$login, $mail, $token]))
        {
            return TRUE;
        }
        else
            return FALSE;
    }

    public function getAccountUser ($token)
    {
        $query = "SELECT account_login from camagru_account WHERE account_token = ?";
        $login = $this->_database->select($query, [$token]);
        if (!$login)
            return null;
        else
            return ($login['account_login']);
    }

    public function getAccountToken($login)
    {
        $query = "SELECT account_token from camagru_account WHERE account_login = ?";
        $token = $this->_database->select($query, [$login]);
        if (!$token)
            return null;
        else
            return ($token['account_token']);
    }

    public function updateUserStatus($user)
    {
        $query = "UPDATE camagru_users SET account_status = 'active' WHERE user_login = ?";
        if ($this->_database->execute($query, [$user]))
        {
            if ($this->_deleteAccount($user))
                return (TRUE);
            else
                return FALSE;
        }
        else
            return FALSE;
    }

    private function _deleteAccount($login)
    {
        $query = "DELETE FROM camagru_account WHERE account_login = ?";
        if ($this->_database->execute($query, [$login]))
            return TRUE;
        else
        return FALSE;
    }

    public function getUser($login)
    {
        $query = "SELECT * from camagru_users WHERE user_login = ?";
        $user = $this->_database->select($query, [$login]);
        if (!$user)
            return null;
        else
            return ($user);

    }

    private function _generateToken($mail, $login)
    {
        $time = time();
        $time = strval($time);
        $token = $time.$mail.$login;
        $token = str_shuffle($token);
        $token = hash('whirlpool', $token);
        return ($token);

    }

    public function resetAccountquery($mail, $login)
    {
        $token = $this->_generateToken($mail, $login);
        $query = "INSERT INTO `camagru_account` SET `account_login` = ?, `account_mail` = ? , `account_token` = ?"; 
        if ($this->_database->execute($query, [$login, $mail, $token]))
        {
            return TRUE;
        }
        else
            return FALSE; 
    }

    public function updateUserPassword($user, $password, $token)
    {
        $query = "UPDATE camagru_users SET user_password = ? WHERE user_login = ?";
        if ($this->_database->execute($query, [$password, $user]))
        {
            if ($token == FALSE)
                return TRUE;
            if ($token == TRUE && $this->_deleteAccount($user))
               return (TRUE);
            else
                return FALSE;
        }
        else
            return FALSE;
    }

    public function updateUserMail($user, $mail)
    {
        $query = "UPDATE camagru_users SET user_mail = ? WHERE user_login = ?";
        if ($this->_database->execute($query, [$mail, $user]))
        {
            return TRUE;
        }
        else
            return FALSE;
        
    }

    public function updateUserLogin($user, $login)
    {
        $query = "UPDATE camagru_users SET user_login = ? WHERE user_login = ?";
        if ($this->_database->execute($query, [$login, $user]))
        {
            return TRUE;
        }
        else
            return FALSE;   
    }
    public function addComment($comment, $user, $filename)
    {
        $query = "INSERT INTO comments SET `comment` = ?, `user` = ? , `filename` = ?"; 
        if ($this->_database->execute($query, [$comment, $user, $filename]))
        {
            return TRUE;
        }
        else
            return FALSE;  
    }

    public function addLike($user, $filename)
    {
        $query = "INSERT INTO likes SET `filename` = ?, `user` = ? "; 
        if ($this->_database->execute($query, [$filename, $user]))
        {
            return TRUE;
        }
        else
            return FALSE;  
    }

    public function deleteLike($user, $filename)
    {
        $query = "DELETE FROM likes WHERE `filename` = ? AND `user` = ? "; 
        if ($this->_database->execute($query, [$filename, $user]))
        {
            return TRUE;
        }
        else
            return FALSE; 
    }

}