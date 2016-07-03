<?php
namespace app\modules\admin\models;

use Yii;
use \yii\db\ActiveRecord;

Class PhotoProducts extends ActiveRecord{
    
    public static function tableName()
    {
        return 'photoProducts';
    }
       
      public function getPhotoProducts($id){
          $galleryArray=array();
         $photoProducts=self::find()
                  ->where('productId='.$id)->all();
         
            foreach ($photoProducts as $key => $value) {
                $galleryArray[$key]['idPhoto']=$value->idPhoto;
                $galleryArray[$key]['medium']=$value->medium;
                $galleryArray[$key]['thumb']=$value->thumb;
            }
            return $galleryArray;
    }
}
