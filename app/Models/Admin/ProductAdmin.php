<?php


namespace App\Models\Admin;
use Illuminate\Support\Facades\DB;

class ProductAdmin
{
    private $start;
    private $length;
  private $dfID;
  private $imgID;

private $link;
private $alt;

private $name;
private $desc;
private $price;
private $newPrice;
private $disId;
private $catId;
private $created;
private $modified;
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
     * @param mixed $dfID
     */
    public function setDfID($dfID): void
    {
        $this->dfID = $dfID;
    }

    /**
     * @return mixed
     */
    public function getDfID()
    {
        return $this->dfID;
    }

    /**
     * @param mixed $imgID
     */
    public function setImgID($imgID): void
    {
        $this->imgID = $imgID;
    }

    /**
     * @return mixed
     */
    public function getImgID()
    {
        return $this->imgID;
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
     */public function setName($name): void
{
    $this->name = $name;
}

/**
 * @return mixed
 */public function getName()
{
    return $this->name;
}

/**
 * @param mixed $desc
 */public function setDesc($desc): void
{
    $this->desc = $desc;
}

/**
 * @return mixed
 */public function getDesc()
{
    return $this->desc;
}

/**
 * @param mixed $price
 */public function setPrice($price): void
{
    $this->price = $price;
}

/**
 * @return mixed
 */public function getPrice()
{
    return $this->price;
}

    /**
     * @param mixed $newPrice
     */
    public function setNewPrice($newPrice): void
    {
        $this->newPrice = $newPrice;
    }

    /**
     * @return mixed
     */
    public function getNewPrice()
    {
        return $this->newPrice;
    }

    /**
     * @param mixed $disId
     */public function setDisId($disId): void
{
    $this->disId = $disId;
}

/**
 * @return mixed
 */public function getDisId()
{
    return $this->disId;
}

    /**
     * @param mixed $catId
     */
    public function setCatId($catId): void
    {
        $this->catId = $catId;
    }

    /**
     * @return mixed
     */
    public function getCatId()
    {
        return $this->catId;
    }

    /**
     * @param mixed $created
     */
    public function setCreated($created): void
    {
        $this->created = $created;
    }

    /**
     * @return mixed
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param mixed $modified
     */
    public function setModified($modified): void
    {
        $this->modified = $modified;
    }

    /**
     * @return mixed
     */
    public function getModified()
    {
        return $this->modified;
    }

      public function getProducts(){
              return DB::table('categories AS c')->join('drinkfood AS df' , 'c.cat_id','=','df.cat_id')->leftJoin('discount AS di','df.dis_id','=' , 'di.dis_id')->join('images2 AS img','df.img_id','=','img.img_id')->select('c.name AS catname','df.*', 'img.*' , 'di.percent'  )->paginate(5);
      }

    public function getProductsLimit(){
        return DB::table('categories AS c')->join('drinkfood AS df' , 'c.cat_id','=','df.cat_id')->leftJoin('discount AS di','df.dis_id','=' , 'di.dis_id')->join('images2 AS img','df.img_id','=','img.img_id')->select('c.name AS catname','df.*','img.*' , 'di.percent'  )->offset($this->start)->limit($this->length)->get();
    }

    public function countProducts(){
           return DB::table('drinkfood')->count('df_id');
    }

    public function addProduct(){
        DB::transaction(function (){

            DB::table('images2')->insert(
                     ['link' => $this->link , 'alt' => $this->alt]
            );
            $ImgId = DB::getPdo()->lastInsertId();
            DB::table('drinkfood')->insert([
                'name' => $this->name , 'desc' => $this->desc , 'price' => $this->price , 'newprice' => $this->newPrice , 'dis_id' => $this->disId , 'cat_id' => $this->catId , 'img_id' => $ImgId ,'created' => $this->created , 'modified' => $this->modified
            ]);

        });
    }

    public function getOneProduct(){
        return DB::table('categories AS c')->join('drinkfood AS df' , 'c.cat_id','=','df.cat_id')->leftJoin('discount AS di','df.dis_id','=' , 'di.dis_id')->join('images2 AS img','df.img_id','=','img.img_id')->where([ ['df.df_id' , $this->dfID], ['img.img_id', $this->imgID ] ])->select('c.name AS catname','df.*', 'img.*' , 'di.percent'  )->first();
    }

    public function updateProduct(){
        DB::transaction(function (){

            DB::table('images2')->where('img_id' , '=' , $this->imgID)->update(
                ['link' => $this->link , 'alt' => $this->alt]
            );

            DB::table('drinkfood')->where([['df_id' , $this->dfID] , ['img_id' , $this->imgID]])->update([
                'name' => $this->name , 'desc' => $this->desc , 'price' => $this->price , 'newprice' => $this->newPrice , 'dis_id' => $this->disId , 'cat_id' => $this->catId , 'img_id' => $this->imgID  , 'modified' => $this->modified
            ]);

        });
    }

    public function deleteProduct()
    {
        return DB::table('images2')->where('img_id', '=', $this->imgID)->delete();
    }

    public function discountProduct(){
          return DB::table('discount')->get();
    }

    public function category(){
          return DB::table('categories')->get();
    }

    public function getProductsList(){
        return DB::table('drinkfood AS df')->leftJoin('discount AS di','df.dis_id','=' , 'di.dis_id')->select('df.df_id', 'df.name' , 'df.price' , 'newprice', 'di.percent')->get();
    }

}
