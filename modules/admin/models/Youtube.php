<?php
namespace app\modules\admin\models;

use Yii;
use \yii\db\ActiveRecord;

Class Youtube extends ActiveRecord{
    
    public static function tableName()
    {
        return 'youtube';
    }
    public function findLastVideo(){
        return self::find()->orderBy('id DESC')->one();
    }
}
