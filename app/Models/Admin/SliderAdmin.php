<?php


namespace App\Models\Admin;
use Illuminate\Support\Facades\DB;

class SliderAdmin
{
    private $start;
    private $length;

    private $name;
    private $text;
    private $link;
    private $alt;
 private $slideId;
    private $imgId;
    /**
     * @param mixed $start
     */
    public function setStart($start): void
    {
        $this->start = $start;
    }

    /**
     * @return mixed
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * @param mixed $length
     */
    public function setLength($length): void
    {
        $this->length = $length;
    }

    /**
     * @return mixed
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * @param mixed $link
     */
    public function setLink($link): void
    {
        $this->link = $link;
    }

    /**
     * @return mixed
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @param mixed $alt
     */
    public function setAlt($alt): void
    {
        $this->alt = $alt;
    }

    /**
     * @return mixed
     */
    public function getAlt()
    {
        return $this->alt;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $text
     */
    public function setText($text): void
    {
        $this->text = $text;
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param mixed $imgId
     */
    public function setImgId($imgId): void
    {
        $this->imgId = $imgId;
    }

    /**
     * @return mixed
     */
    public function getImgId()
    {
        return $this->imgId;
    }

    /**
     * @param mixed $slideId
     */
    public function setSlideId($slideId): void
    {
        $this->slideId = $slideId;
    }

    /**
     * @return mixed
     */
    public function getSlideId()
    {
        return $this->slideId;
    }

    public function getSliders(){
        return DB::table('slider AS s')->join('images2 AS i' , 's.img_id' , '=' , 'i.img_id')->select('s.*' , 'i.link' , 'i.alt')->paginate(5);
    }

    public function getSlidersLimit(){
        return DB::table('slider AS s')->join('images2 AS i' , 's.img_id' , '=' , 'i.img_id')->select('s.*' , 'i.link' , 'i.alt')->offset($this->start)->limit($this->length)->get();
    }

    public function getOneSlide(){
        return DB::table('slider AS s')->join('images2 AS i' , 's.img_id' , '=' , 'i.img_id')->where('s.img_id' , '=' , $this->imgId)->select('s.*' , 'i.link' , 'i.alt')->first();
    }

    public function countSldier(){
        return DB::table('slider')->count('slide_id');
    }

    public  function addSlide(){
          DB::transaction(function (){
              DB::table('images2')->insert(
                  ['link' => $this->link , 'alt' => $this->alt]
              );
              $ImgId = DB::getPdo()->lastInsertId();
              DB::table('slider')->insert([
                     ['name' => $this->name , 'text' => $this->text , 'img_id' => $ImgId]
              ]);

          });
    }

    public function updateSldie(){
        DB::transaction(function (){
            DB::table('images2')->where('img_id' ,'=' , $this->imgId)->update(
                ['link' => $this->link , 'alt' => $this->alt]
            );

            DB::table('slider')->where([['slide_id' , $this->slideId ],['img_id' , $this->imgId]])->update(
                ['name' => $this->name , 'text' => $this->text , 'img_id' => $this->imgId]
            );

        });
    }

    public function deleteSlide(){
       return DB::table('images2')->where('img_id' , '=' , $this->imgId)->delete();
    }

}
