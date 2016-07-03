<?php
namespace app\modules\admin\models;

use Yii;
use \yii\db\ActiveRecord;

Class ProductSpecifications extends ActiveRecord{
    
    public static function tableName()
    {
        return 'productSpecifications';
    }
    
      public function getSpecifications($id){
          $modificationArray=array();
                $modification=self::find()
                  ->where('productId='.$id)->all();
          
            foreach ($modification as $key => $value) {
                $modificationArray[$key]['id']=$value->id;
                $modificationArray[$key]['nameSpecifications']=$value->nameSpecifications;
                $modificationArray[$key]['valueSpecifications']=$value->valueSpecifications;
            }
            return $modificationArray;
    }
      public function delSpecification($id){
        $filter_del = self::findOne($id);
        return $filter_del->delete();

    }
    
       public function addSpecification($data){
       $filter_add=  new ProductSpecifications();
        foreach ($data as $key => $value) {
                $filter_add->$key=$value;
        }
        return $filter_add->save();
        
    }
}
