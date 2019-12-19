<?php

class UserController
{
    private $_userModel;
    private $_validator;
    private $_ImageModel;

    public function __construct($db)
    {
        $this->_userModel = new UserModel($db);
        $this->_validator = new Validator();
        $this->_ImageModel = new ImageModel($db);
        $db->execute("Use db_camagru");
    }
    
    public function addUser(array $data)
    {
        if (!($this->_validator->isUser($data)))
            return [ "error_type" => "Invalid Username"];
        if ($user = $this->_userModel->getUser($data['user']))
            return [ "error_type" => "Error Username already used !"];
        if (!($this->_validator->isMail($data)))
            return [ "error_type" => "Error Invalide mail !"];
        if (!($this->_validator->isPassword($data)))
            return [ "error_type" => "Error Invalide password !"];
        if (!($token = $this->_userModel->addUser($data)))
            return [ "error_type" => "Error Something wrong happened !"]; 
        if (!($this->_sendConfirmationMail($data['mail'], $token)))
            return [ "error_type" => "Error Can't send a confirmation mail !"]; 
        return null;
    }

    private function _sendConfirmationMail($mail, $token)
    {       
        $subject = "Account confirmation !";
        $message = "localhost/?url=verify&token=".$token ;
        $headers = "From camagru@kdaou";
        if (mail($mail , $subject ,$message, $headers))
            return true;
        return false;
    }

    public function verifyAccount($data)
    {
        if (!isset($data['token']) || !is_string($data['token']))
            return false;
        if (!($user = $this->_userModel->getAccountUser($data['token'])))
            return false;
        if (!($this->_userModel->updateUserStatus($user)))
            return false;
        return true;
    }

    public function login($data)
    {
        $_SESSION['loggued_on_user'] = null;
        if (!($this->_validator->isUser($data)))
            return [ "error_type" => "Invalid Username"];
        if (!($this->_validator->isPassword($data)))
            return [ "error_type" => "Error Invalide password !"];
        $user = $data['user'];
        $password = hash('whirlpool', $data['password']);
        if (!($ret = $this->_userModel->getUser($user)))
            return ["error_type" => "Invalide Username"];
        if (strcmp($password , $ret['password']) != 0)
            return ["error_type" => "Invalide password"];
        if (strcmp($ret['status'], 'active') != 0)
            return ["error_type" => "account non activated"];
        $_SESSION['loggued_on_user'] = $user;
        return null;        
    }

    public function logout()
    {
        $_SESSION['loggued_on_user'] = null;
    }

    public function resetPassword($data)
    {
        if (!($this->_validator->isUser($data)))
            return [ "error_type" => "Invalid Username"];
        if (!($this->_validator->isMail($data)))
            return [ "error_type" => "Error Invalide Mail !"];
        $user = $data['user'];
        $mail = $data['mail'];
        if (!($ret = $this->_userModel->getUser($user)))
            return ["error_type" => "Invalide Username"];
        if (strcmp($mail, $ret['mail']) != 0)
            return ["error_type" => "Invalide mail"];
        if (strcmp($ret['status'], 'active') != 0)
            return ["error_type" => "account non activated"];
        if (!($token = $this->_userModel->resetPassword($mail, $user)))
            return [ "error_type" => "Error Something wrong happened !"];
        if (!($this->_sendResetPasswordMail($mail, $token)))
            return [ "error_type" => "Error Can't send a Reset password mail !"]; 
        return null;
    }

    private function _sendResetPasswordMail($mail, $token)
    {       
        $subject = "RESET PASSWORD !";
        $message = "localhost/?url=reset&token=".$token ;
        $headers = "From camagru@kdaou";
        if (mail($mail , $subject ,$message, $headers))
            return true;
        return false;
    }

    public function newPassword($data)
    {
        $token = $_SESSION['token'];
        if (!($this->_validator->isPassword($data)))
            return [ "error_type" => "Error Invalide password !"];
        $password = hash('whirlpool', $data['password']);
        if (!($user = $this->_userModel->getAccountUser($token)))
            return ["error_type" => "invalide token"];
        if (!($this->_userModel->updatePassword($user, $password, $token)))
            return [ "error_type" => "Error Something wrong happened !"];
        $_SESSION['token'] = "";
        return (null);
    }

    public function getStatus($user)
    {
        if (!isset($user) || !is_string($user))
            return ('Undefined');
        if (!($status = $this->_userModel->getStatus($user)))
            return ('Undefined');
        return ($status);
    }

    public function changeProfile($data)
    {
        $user = $_SESSION['loggued_on_user'];
        if (!isset($data['TASK']) || !is_string($data['TASK']))
            return null;
        switch ($data['TASK'])
        {
            case 'CHANGE LOGIN' :
            {
                if (!($this->_validator->isUser($data)))
                    return [ "error_type" => "Invalid Username"];
                if ($user = $this->_userModel->getUser($data['user']))
                    return [ "error_type" => "Error Username already used !"];
                if (!($this->_userModel->updateUser($_SESSION['loggued_on_user'], $data['user'])))
                    return ["error_type" => "something happend retry later !"];
                $_SESSION['loggued_on_user'] = $data['user'];
                return ["error_type" => "Username changed ."];
            }break;
            case 'CHANGE MAIL' :
            {
                if (!($this->_validator->isMail($data)))
                    return [ "error_type" => "Error Invalide mail !"];
                if (!($this->_userModel->updateMail($user, $data['mail'])))
                    return ["error_type" => "something happend retry later !"];
                return ["error_type" => "Mail changed ."];
            }break;
            case 'CHANGE PASSWORD' :
            {
                if (!($this->_validator->isPassword($data)))
                    return [ "error_type" => "Error Invalide password !"];
                $password = hash('whirlpool', $data['password']);
                if (!($this->_userModel->updatePassword($user, $password)))
                    return ["error_type" => "something happend retry later !"];
                return ["error_type" => "password changed ."];
            }break ;
            case 'CHANGE NOTIFICATION' :
            {
                $status = $this->getStatus($user);
                $new = (strcmp($status, 'Active') == 0) ? 'Inactive' :  'Active';
                if (!($this->_userModel->updateNotification($user, $new)))
                    return ["error_type" => "something happend retry later !"];
                return ["error_type" => "notification changed changed ."];
            }break ; 
            case 'RETURN' :
            {
                return null;
            }break;
            return null;
        }
    }
}