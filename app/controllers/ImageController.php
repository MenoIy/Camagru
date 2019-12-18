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

    private function _generateFileName($user)
    {
        $time = time();
        $time = strval($time);
        $file = $user."_".$time;
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
        if (!($file = fopen($path, "wb")))
            return false;
        $imageData = explode(',', $image);
        if (!(fwrite($file, base64_decode($imageData[1]))))
            return false;
        fclose($file);
        return true;
    }

    public function saveImage($data, $user)
    {
        $filename = $this->_generateFileName($user);
        $image = $this->_mergeSuperposable($data);
        if (!($this->_imageModel->saveImage($user, $filename)))
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
        $user = $_SESSION['loggued_on_user']; 
        if ($this->_imageModel->alreadyLiked($user, $data['image']) != 0)
            if (!($this->_imageModel->deleteLike($user, $data['image'])))
                return (["error_type" => "Error Something wrong happened !"]);
        else
            if (!($this->_imageModel->addLike($user, $data['image'])))
                return (["error_type" => "Error Something wrong happened !"]);
        return null;
    }

    public function alreadyLiked($user, $filename)
    {
        if ($this->_imageModel->alreadyLiked($user, $filename))
            return true;
        return false;
    }

    public function comment($data)
    {
        if (!(isset($_SESSION['loggued_on_user'])))
            return (["error_type"=> "Login to like"]);
        $user = $_SESSION['loggued_on_user'];
        if (!($this->_validator->isComment($data)))
            return null;
        if (!($this->_imageModel->addComment($data['comment'], $user, $data['image'])))
            return null;
        return null;
    }   
    public function getImages()
    {
        return ($this->_imageModel->getImages());
    }

    public function getComments($filename)
    {
        return ($this->_imageModel->getComments($filename));
    }

    public function getLikeCount($filename)
    {
        if (!($count = $this->_imageModel->getLikeCount($filename)))
            return (0);
        return ($count);
    }








}