<?php
class Helper_Image {
    
    static public function resize($file, $size_width, $size_height)
    {
        $uploaddir = Kohana::$config->load('config')->get('image_dir');
        if(!is_dir($uploaddir))
            mkdir($uploaddir, 0777);
        $info           = pathinfo($file['name']);
        $name           = time() . '.' . strtolower($info['extension']);
        $uploadfile     = $uploaddir . $name;
        $image          = Image::factory($file['tmp_name']);
        $ratio          = $image->width / $image->height;
        $original_ratio = $size_width / $size_height;
        $crop_width     = $image->width;
        $crop_height    = $image->height;
        if($ratio > $original_ratio) {
            $crop_width = round($original_ratio * $crop_height);
        } else {
            $crop_height = round($crop_width / $original_ratio);
        }
        $image->crop($crop_width, $crop_height);
        $image->resize($size_width, $size_height, Image::NONE);
        $image->save($uploadfile); 
        chmod($uploadfile, 0777);
        return $name;
    }
}