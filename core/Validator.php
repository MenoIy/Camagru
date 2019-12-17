<?php
class Validator
{
    public function isLogin($login)
    {
        $ret = preg_match('/^[A-Za-z0-9]{6,24}+$/', $login);
        if ($ret)
            return TRUE;
        else
            return FALSE;
    }
    
    public function isPassword($password)
    {
        $ret = preg_match('/^[A-Za-z0-9]{6,24}+$/', $password);
        if ($ret)
            return TRUE;
        else
            return FALSE;
    }    

    public function isMail($mail)
    {
        $ret = preg_match('/^\w+@\w+\..{2,3}(.{2,3})?$/', $mail);
        if ($ret)
            return TRUE;
        else
            return FALSE;
    }

    public function isAlreadyRegistred($login, $userModel)
    {
        $user = $userModel->getUserByLogin($login);
        if (isset($user))
            return TRUE;
        return FALSE;
    }
    public function isComment($data)
    {
        if (!(is_array($data)))
            return FALSE;
        else 
            return TRUE;
    }
}
?>