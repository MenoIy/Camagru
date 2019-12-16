<?php

class UserController
{
    private $_UserModel;
    private $_Validator;

    public function __construct($db)
    {
        $this->_UserModel = new UserModel($db);
        $this->_Validator = new Validator();
        $db->execute("Use db_camagru", ['']);
    }

    public function addUser(array $data)
    {
        if (!($this->_Validator->isLogin($data['login'])))
        {
            return [ "error_type" => "Invalid login" ];
        }
        if ($this->_Validator->isAlreadyRegistred($data['login'], $this->_UserModel))
        {
            return [ "error_type" => "Error Login already used !" ];
        }
        if (!($this->_Validator->isMail($data['mail'])))
        {
            return [ "error_type" => "Error Invalide mail !" ];
        }
        if (!($this->_Validator->isPassword($data['passwd'])))
        {
            return [ "error_type" => "Error Invalide password !" ];
        }
        $this->_UserModel->addUser($data);
        $this->_sendConfirmationMail($this->_UserModel, $data['login'], $data['mail']);
        return NULL;
    }

    public function like($data)
    {
        if (!(isset($_SESSION['loggued_on_user'])))
            return null;
        else
            var_dump($data);
        return ( [" er"=> "good"]);
    }
    public function comment($data)
    {
        if (!(isset($_SESSION['loggued_on_user'])))
            return null;
        else
            var_dump($data);
        return ( [" er"=> "good"]);
    }



    private function _sendConfirmationMail($UserModel, $login, $mail)
    {       
        $token = $UserModel->getAccountToken($login);
        $subject = "Account confirmation !";
        $message = "localhost/?url=verify&token=".$token ;
        $headers = "From camagru@kdaou";
        mail($mail , $subject ,$message, $headers);
    }

    public function verifyAccount($token)
    {
        if (!($user = $this->_UserModel->getAccountUser($token)))
            return FALSE;
        if (!($this->_UserModel->updateUserStatus($user)))
            return (FALSE);
        return TRUE;
    }

    public function login($data)
    {
        $_SESSION['loggued_on_user'] = null;
        $login = $data['login'];
        $password = hash('whirlpool', $data['passwd']);
        if (!($user = $this->_UserModel->getUser($login)))
            return ["error_type" => "Invalide login"];
        if (strcmp($password, $user['user_password']) != 0)
            return ["error_type" => "Invalide password"];
        if (strcmp($user['account_status'], 'active') != 0)
            return ["error_type" => "account non activated"];
        $_SESSION['loggued_on_user'] = $login;
        return (NULL);
    }

    public function logout()
    {
        $_SESSION['loggued_on_user'] = null;
    }

    public function resetPassword($data)
    {
        $login = $data['login'];
        $mail = $data['mail'];
        if (!($user = $this->_UserModel->getUser($login)))
            return ["error_type" => "Invalide login"];
        if (strcmp($user['account_status'], 'active') != 0)
            return ["error_type" => "account non activated"];
        if (strcmp($mail, $user['user_mail']) != 0)
            return ["error_type" => "Invalide mail"];
        if (!($this->_UserModel->resetAccountquery($mail, $login)))
            return ["error_type" => "something happend retry later !"];  
        $this->_sendResetPasswordMail($this->_UserModel, $data['login'], $data['mail']);
        return null;
    }
    private function _sendResetPasswordMail($UserModel, $login, $mail)
    {       
        $token = $UserModel->getAccountToken($login);
        $subject = "RESET PASSWORD !";
        $message = "localhost/?url=reset&token=".$token ;
        $headers = "From camagru@kdaou";
        mail($mail , $subject ,$message, $headers);
    }

    public function newPassword($data)
    {
        if (!isset($_SESSION['token']) || $_SESSION['token'] === "")
            $_SESSION['token'] = $data['token'];
        if (!($this->_Validator->isPassword($data['passwd'])))
            return [ "error_type" => "Error Invalide password !" ];
        if (!($user = $this->_UserModel->getAccountUser($_SESSION['token'])))
            return ["error_type" => "invalide token"];
        $password = hash('whirlpool', $data['passwd']);
        if (!($this->_UserModel->updateUserPassword($user ,$password , true)))
            return ["error_type" => "something happend retry later !"];
        $_SESSION['token'] = "";
        return (null);
    }



    public function changeProfile($data)
    {
        switch ($data['TASK']) 
        {
            case 'CHANGE LOGIN':
            {   
                $login = $_SESSION['loggued_on_user'];
                if (!($this->_Validator->isLogin($data['login'])))
                    return [ "error_type" => "Error Invalide Login !" ];
                if ($this->_Validator->isAlreadyRegistred($data['login'], $this->_UserModel))
                {
                    return [ "error_type" => "Error Login already used !" ];
                }
                if (!($this->_UserModel->updateUserLogin($login, $data['login'])))
                    return ["error_type" => "something happend retry later !"];
                $_SESSION['loggued_on_user'] = $data['login'];
                return ["error_type" => "Login changed ."];
            }break;
            case 'CHANGE PASSWORD':
            {
                $login = $_SESSION['loggued_on_user'];
                if (!($this->_Validator->isPassword($data['passwd'])))
                    return [ "error_type" => "Error Invalide password !" ];
                $password = hash('whirlpool', $data['passwd']);
                if (!($this->_UserModel->updateUserPassword($login, $password, false)))
                    return ["error_type" => "something happend retry later !"];
                return ["error_type" => "Password changed ."];
            }break;
            case 'CHANGE MAIL':
            {
                $login = $_SESSION['loggued_on_user'];
                if (!($this->_Validator->isMail($data['mail'])))
                    return [ "error_type" => "Error Invalide Mail !" ];
                if (!($this->_UserModel->updateUserMail($login, $data['mail'])))
                    return ["error_type" => "something happend retry later !"];
                return ["error_type" => "Mail changed ."];
            }break;
            case 'RETURN':
            {
                return NULL;
            }break;
            return NULL;
        }
        
    }
}