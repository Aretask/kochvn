<?php
namespace app\modules\admin\models;

use Yii;
use \yii\db\ActiveRecord;

Class InfoGallery extends ActiveRecord{
    
    public static function tableName()
    {
        return 'infoGallery';
    }
    
    public function getGallery(){
      $gallery_date=array();
      $gallery=  self::find()
                ->where("big=1")
                ->orderBy("id DESC")
                ->all();
        foreach ($gallery as $key => $value) {
            $gallery_date[$key]['photoUrl']=$value['photoUrl'];
            $gallery_date[$key]['linkUrl']=$value['linkUrl'];
            $gallery_date[$key]['titleName']=$value['titleName'];
        }
        return $gallery_date;
    }
    
    public function delPhoto($photo){
      return  self::findOne($photo)->delete();
    }
}
