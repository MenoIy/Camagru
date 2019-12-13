<?php


Class picture
{
    private $_base64;

    public function savePictureLocal($base64, $user)
    {
        $path = "./public/images/";
        $time = time();
        $time = strval($time);
        $output_file = $user."_".$time;
        $output_file = $path.hash('sha256', $output_file).".png";
        $file = fopen($output_file, "wb");
        $data = explode(',', $base64);
        fwrite($file, base64_decode($data[1]));
        fclose($file);
        return $output_file;
   }
}
?>