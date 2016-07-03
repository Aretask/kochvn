<?php
namespace app\modules\admin\models;

use Yii;
use \yii\db\ActiveRecord;

Class TmpSettings extends ActiveRecord{
    
    public static function tableName()
    {
        return 'tmpSettings';
    }
    
    public function getTmpSetting(){
      return  self::find()
            ->where("status=0")
            ->groupBy("fileName")
            ->orderBy("addDate DESC")
            ->all();
    }
    public function getTmpSettingByFile($file_name){
      return  self::find()
            ->where("fileName='".$file_name."'")
            ->all();
    }
}
