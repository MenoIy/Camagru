<?php

class ImageController
{   
    private $_userModel;
    private $_validator;
    private $_imageModel;

    public function __construct($db)
    {
        $this->_userModel = new UserModel($db);
        $this->_validator = new Validator();
        $this->_imageModel = new ImageModel($db);
        $db->execute("Use db_camagru", ['']);
    }

    private function _generateFileName($user, $time)
    {
        $strtime = strval($time);
        $file = $user."_".$strtime;
        $file = hash('sha256', $file).".png";
        return $file;
    }

    private function _mergeSuperposable($data)
    {
        /* return  merged images */
        return ($data['data']);
    }

    private function _saveImageLocal($image, $filename)
    {
        $path = "./public/images/".$filename;
        $imageData = explode(',', $image);
        if (count($imageData) != 2)
            return false;
        if (!($file = fopen($path, "wb")))
            return false;
        if (!(fwrite($file, base64_decode($imageData[1]))))
            return false;
        fclose($file);
        return true;
    }

    public function saveImage($data, $user)
    {
        $time = time();
        $filename = $this->_generateFileName($user, $time);
        $image = $this->_mergeSuperposable($data);
        if (!($this->_imageModel->saveImage($user, $filename, $time)))
            return null;
        if (!($this->_saveImageLocal($image, $filename)))
        {
            $this->_imageModel->deleteImage($filename);
            return (null);
        }
        return true;
    }

    public function deleteImage($data)
    {
        if (!isset($data['image']))
            return false;
        $filename = $data['image'];
        $path = "./public/images/".$filename;
        if (!(unlink($path)))
            return false;
        if (!($this->_imageModel->deleteImage($filename)))
            return false;
        return true;
    }

    public function like($data)
    {
        if (!(isset($_SESSION['loggued_on_user'])))
            return (["error_type"=> "Login to like"]);
        if (!(isset($data['image'])))
            return (["error_type" => "Error Something wrong happened !"]);
        if (!(is_string($data['image'])))
            return (["error_type" => "Error Something wrong happened !"]);
        $user = $_SESSION['loggued_on_user'];
        if ($this->_imageModel->alreadyLiked($user, $data['image']))
        {
            if (!($this->_imageModel->deleteLike($user, $data['image'])))
                return (["error_type" => "Error Something wrong happened !"]);
            else
                return null;
        }
        else
            if (!($this->_imageModel->addLike($user, $data['image'])))
                return (["error_type" => "Error Something wrong happened !"]);
        return null;
    }

    public function alreadyLiked($filename)
    {
        if (!(isset($_SESSION['loggued_on_user'])))
            return (["error_type"=> "Login to like"]);
        if (!is_string($filename))
            return (["error_type" => "Error Something wrong happened !"]); 
        $user = $_SESSION['loggued_on_user'];
        if ($this->_imageModel->alreadyLiked($user, $filename))
            return true;
        return false;
    }

    public function comment($data)
    {
        if (!(isset($_SESSION['loggued_on_user'])))
            return (["error_type"=> "Login to Comment"]);
        if (!isset($data['image']) || !isset($data['owner']))
            return (["error_type" => "Error Something wrong happened !"]);
        if (!is_string($data['image']) || !is_string($data['owner']))
            return (["error_type" => "Error Something wrong happened !"]); 
        $user = $_SESSION['loggued_on_user'];
        if (!($this->_validator->isComment($data)))
            return (["error_type"=> "Comment length limit 500 caracteres !"]);
        if (!($this->_imageModel->addComment($data['comment'], $user, $data['image'])))
            return (["error_type" => "Error Something wrong happened !"]);
        if (!($select = $this->_userModel->getUser($data['owner'])))
            return (["error_type" => "Error Something wrong happened !"]);
        if (strcmp($user, $select['user']) != 0 && strcmp($select['notification'], 'Active') == 0)
            if (!($this->_sendNotificationtionMail($user, $select['mail'])))
                return (["error_type" => "Error Can't send a notification mail !"]);
        return null;
    }

    private function _sendNotificationtionMail($user, $mail)
    {       
        $subject = "Notification !";
        $message = $user." has commented on your publication.";
        $headers = "From camagru@kdaou";
        if (mail($mail , $subject ,$message, $headers))
            return true;
        return false;
    }

    public function getImages($start, $limit)
    {
        return ($this->_imageModel->getImages($start, $limit));
    }

    public function getComments($filename)
    {
        if (!isset($filename) || !is_string($filename))
            return null;
        return ($this->_imageModel->getComments($filename));
    }

    public function getLikeCount($filename)
    {
        if (!isset($filename) || !is_string($filename))
            return null;
        if (!($count = $this->_imageModel->getLikeCount($filename)))
            return (0);
        return ($count);
    }

    public function getImageCount()
    {
        return ($this->_imageModel->getImagesCount());
    }

    public function getUserImages()
    {
        if (!(isset($_SESSION['loggued_on_user'])))
            return (null);
        $user = $_SESSION['loggued_on_user'];
        return ($this->_imageModel->getUserImages($user)); 
    }

}