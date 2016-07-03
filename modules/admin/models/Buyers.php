<?php
namespace app\modules\admin\models;

use Yii;
use \yii\db\ActiveRecord;

Class Buyers extends ActiveRecord{
    
    public static function tableName()
    {
        return 'buyers';
    }
}
