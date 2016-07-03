<?php
namespace app\modules\admin\models;

use Yii;
use \yii\db\ActiveRecord;

Class TmpProducts extends ActiveRecord{
    
    public static function tableName()
    {
        return 'tmpProducts';
    }
    
    public function getMainValueTmp($value,$idSuplier){
       $data=  self::find()
                ->where("typeValue=$value")
                ->andWhere("suplierProduct=$idSuplier")
                ->groupBy("valueProduct")
                ->all();
       if(!empty($data)){
         foreach ($data as $key => $val) {
                $categoryTmp[$key]['valueProduct']=$val->valueProduct;
          }
       }else{
          $categoryTmp= $data;
       }
          return $categoryTmp;
    }
    
    public function findByIds($ids){
         return self::find()
                 ->where("articul IN (".$ids.")")
                 ->all();
    }
}
