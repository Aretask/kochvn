<?php
namespace app\modules\admin\models;

use Yii;
use \yii\db\ActiveRecord;

Class Users extends ActiveRecord{
    
    public static function tableName()
    {
        return 'users';
    }
  
}