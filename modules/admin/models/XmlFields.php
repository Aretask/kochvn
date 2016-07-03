<?php
namespace app\modules\admin\models;

use Yii;
use \yii\db\ActiveRecord;

Class XmlFields extends ActiveRecord{
    
    public static function tableName()
    {
        return 'xmlFields';
    }
    
    public function getXmlFields(){
          $xmlFields=self::find()->orderBy('name')->all();
          foreach ($xmlFields as $key => $value) {
                $xmlField[$key]['id']=$value->id;
                $xmlField[$key]['name']=$value->name;
          }
          return $xmlField;
    }
}
