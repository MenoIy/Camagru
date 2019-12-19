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
        $query = "INSERT INTO `users` SET `user` = ? , `mail` = ?, `password` = ?, `status` = ? ,`notification` = ?"; 
        $password = hash('whirlpool', $data['password']);
        if ($this->_database->execute($query, [$data['user'], $data['mail'], $password, 'Inactive', 'Active']))
        {
            if(($token = $this->_addAccount($data['user'], $data['mail'])))
                return ($token);
            else
            {
                $query = "DELETE FROM users WHERE user = ?";
                $this->_database->execute($query, [$data['user']]);
                return (null);
            }
        }
        return null;
    }

    private function _addAccount($user, $mail)
    {
        $token = $this->_generateToken($user, $mail);
        $query = "INSERT INTO `accounts` SET `user` = ?, `mail` = ? , `token` = ?";
        if ($this->_database->execute($query, [$user, $mail, $token]))
            return $token;
        else
            return null;
    }

    private function _generateToken($user, $mail)
    {
        $time = time();
        $time = strval($time);
        $token = $time.$mail.$user;
        $token = str_shuffle($token);
        $token = hash('whirlpool', $token);
        return ($token);
    }

    public function getUser($user)
    {
        $query = "SELECT * from users WHERE user = ?";
        if (!($data = $this->_database->select($query, [$user])))
            return null;
        else
            return (count($data) == 0 ? null : $data);
    }

    public function getStatus($user)
    {
        $query = "SELECT * from users WHERE user = ?";
        if (!($data = $this->_database->select($query, [$user])))
            return null;
        else
            return (count($data) == 0 ? null : $data['notification']);
    }

    public function getAccountUser ($token)
    {
        $query = "SELECT * from accounts WHERE token = ?";
        if (!($data = $this->_database->select($query, [$token])))
            return (null);
        return (count($data) == 0 ? null : $data['user']);
    }

    public function updateUserStatus($user)
    {
        $query = "UPDATE users SET `status` = 'active' WHERE user = ?"; 
        if ($this->_database->execute($query, [$user]))
        {
            if ($this->_deleteAccount($user))
                return (true);
        }
        return false;
    }

    private function _deleteAccount($user)
    {
        $query = "DELETE FROM accounts WHERE user = ?";
        if ($this->_database->execute($query, [$user]))
            return TRUE;
        else
            return FALSE;
    }

    public function resetPassword($mail, $user)
    {
        $token = $this->_generateToken($user, $user);
        $query = "INSERT INTO `accounts` SET `user` = ?, `mail` = ? , `token` = ?";
        if ($this->_database->execute($query, [$user, $mail, $token]))
            return $token;
        return null;
    }

    public function updatePassword($user, $password, $token = null)
    {
        $query = "UPDATE users SET password = ? WHERE user = ?";
        if ($this->_database->execute($query, [$password, $user]))
        {
            if (isset($token))
            {
                if ($this->_deleteAccount($user))
                    return true;
                return false;
            }
            return true;
        }
        return false;
    }

    public function updateUser($user, $new)
    {
        $query = "UPDATE users SET user = ? WHERE user = ?";
        if (!($this->_database->execute($query, [$new, $user])))
            return FALSE;
        $query = "UPDATE likes SET user = ? WHERE user = ?";
        if (!($this->_database->execute($query, [$new, $user])))
            return FALSE;
        $query = "UPDATE comments SET user = ? WHERE user = ?";
        if (!($this->_database->execute($query, [$new, $user])))
            return FALSE;
        $query = "UPDATE images SET user = ? WHERE user = ?";
        if (!($this->_database->execute($query, [$new, $user])))
            return FALSE;
        return TRUE;   
    }

    public function updateMail($user, $new)
    {
        $query = "UPDATE users SET mail = ? WHERE user = ?";
        if ($this->_database->execute($query, [$new, $user]))
            return TRUE;
        else
            return FALSE;   
    }

    public function updateNotification($user, $new)
    {
        $query = "UPDATE users SET `notification` = ? WHERE user = ?";
        if ($this->_database->execute($query, [$new, $user]))
            return TRUE;
        else
            return FALSE;   
    }
}