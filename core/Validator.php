<?php
class Validator
{
    public function isUser($data)
    {
        if (!isset($data['user']) || !is_string($data['user']))
            return FALSE;
        $ret = preg_match('/^[A-Za-z0-9]{6,24}+$/', $data['user']);
        if ($ret)
            return TRUE;
        else
            return FALSE;
    }
    

    public function isPassword($data)
    {
        if (!isset($data['password']) || !is_string($data['password']))
            return FALSE;
        $len = strlen($data['password']);
        if ($len < 8 || $len >= 24)
            return FALSE;
        $ret = preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.{8,24})/', $data['password']);
        if (!$ret)
            return FALSE;
        $ret = preg_match('/[^\w]/', $data['password']);
        if ($ret)
            return FALSE;
        return TRUE;
    }    

    public function isMail($data)
    {
        if (!isset($data['mail']) || !is_string($data['mail']))
            return FALSE;
        if (!filter_var($data['mail'], FILTER_VALIDATE_EMAIL))
            return FALSE;
        if (strlen($data['mail']) > 255)
            return FALSE;
        return TRUE;
    }
    
    public function isComment($data)
    {
        if (!isset($data['comment']) || !is_string($data['comment']))
            return FALSE;
        if (strlen($data['comment']) < 500)
            return TRUE;
        return FALSE;
    }
}
?>