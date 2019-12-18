<?php
class Validator
{
    public function isUser($data)
    {
        $ret = preg_match('/^[A-Za-z0-9]{6,24}+$/', $data['user']);
        if ($ret)
            return TRUE;
        else
            return FALSE;
    }
    
    public function isPassword($data)
    {
        $ret = preg_match('/^[A-Za-z0-9]{6,24}+$/', $data['password']);
        if ($ret)
            return TRUE;
        else
            return FALSE;
    }    

    public function isMail($data)
    {
        $ret = preg_match('/^\w+@\w+\..{2,3}(.{2,3})?$/', $data['mail']);
        if ($ret)
            return TRUE;
        else
            return FALSE;
    }
    
    public function isComment($data)
    {

            return TRUE;
    }
}
?>