<?php
namespace app\modules\admin\models;

use Yii;
use \yii\db\ActiveRecord;

Class MadeSuplier extends ActiveRecord{
    
    public static function tableName()
    {
        return 'madeSuplier';
    }
    
      public function getMadeSuplier(){
          $madeSuplier=array();
          $madeSupliers=self::find()->orderBy('nameSuplier')->all();
          foreach ($madeSupliers as $key => $value) {
                $madeSuplier[$key]['idSuplier']=$value->idSuplier;
                $madeSuplier[$key]['curenccy']=$value->curenccy;
                $madeSuplier[$key]['nameSuplier']=$value->nameSuplier;
          }
          return $madeSuplier;
    }
}
