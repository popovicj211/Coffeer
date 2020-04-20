<?php


namespace App\ImageResize;
use Image;

class ImageResize
{
    private $hasFile;
    private $file;
    private $width;
    private $height;
    /**
     * @param mixed $hasFile
     */
    public function setHasFile($hasFile): void
    {
        $this->hasFile = $hasFile;
    }

    /**
     * @return mixed
     */
    public function getHasFile()
    {
        return $this->hasFile;
    }

    /**
     * @param mixed $file
     */
    public function setFile($file): void
    {
        $this->file = $file;
    }

    /**
     * @return mixed
     */
    public function getFile()
    {
        return $this->file;
    }



    public function resizeImg($width, $height ){
        if($this->hasFile) {

            $image = $this->file;
            $filename = $image->getClientOriginalName();
            $newFilename = time()."_".$filename;
             $alt =  strstr( $newFilename,  '.'  , true);
            $image_resize = Image::make($image->getRealPath());
            $image_resize->resize($width, $height);
            $path = 'images/products/'.$newFilename;
            $image_resize->save(public_path($path));
             return array( 'link' => $newFilename , 'alt' => $alt );
        }
    }

}
