<?php
namespace app\modules\admin\models;

use Yii;
use \yii\db\ActiveRecord;

Class Filter extends ActiveRecord{
    
    public static function tableName()
    {
        return 'filter';
    }
    
     public function getFilter(){
           $flters=self::find()->orderBy('nameFilter')->all();
            foreach ($flters as $key => $value) {
                $filter[$key]['filterId']=$value->filterId;
                $filter[$key]['nameFilter']=$value->nameFilter;
          }
          return $filter;
      }
      
}
