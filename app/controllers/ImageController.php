<?php

class ImageController
{   
    private $_UserModel;
    private $_Validator;
    private $_ImageModel;

    public function __construct($db)
    {
        $this->_UserModel = new UserModel($db);
        $this->_Validator = new Validator();
        $this->_ImageModel = new ImageModel($db);
        $db->execute("Use db_camagru", ['']);
    }

    private function _saveImageLocal($image, $output_file)
    {
        $path = "./public/images/".$output_file;
        $file = fopen($path, "wb");
        $imageData = explode(',', $image);
        fwrite($file, base64_decode($imageData[1]));
        fclose($file);
    }

    public function saveImage($data, $user)
    {
        $time = time();
        $time = strval($time);
        $output_file = $user."_".$time;
        $output_file = hash('sha256', $output_file).".png";
        $image = $this->_mergeSuperposable($data);
        $this->_saveImageLocal($image, $output_file);
        $this->_ImageModel->addImage($output_file, $user);
    }
    public function deleteImage($data)
    {
        $filename = $data['image'];
        $path = "./public/images/".$filename;
        unlink($path);
        $this->_ImageModel->deleteImage($filename);
    }

    private function _mergeSuperposable($data)
    {
        return ($data['data']);
    }
}