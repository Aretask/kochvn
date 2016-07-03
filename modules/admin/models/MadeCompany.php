<?php
namespace app\modules\admin\models;

use Yii;
use \yii\db\ActiveRecord;

Class MadeCompany extends ActiveRecord{
    
    public static function tableName()
    {
        return 'madeCompany';
    }
      public function getMadeCompany(){
          $madeCompany=array();
          $madeCompanys=  self::find()->orderBy('nameCompany')->all();
            foreach ($madeCompanys as $key => $value) {
                $madeCompany[$key]['idCompany']=$value->idCompany;
                $madeCompany[$key]['nameCompany']=$value->nameCompany;
                $madeCompany[$key]['imageMade']=$value->imageMade;
                $madeCompany[$key]['eng']=$value->eng;
          }
          return $madeCompany;
      }
      public function getMadeCompanyByIds($ids){
        $madeCompanys=  self::find()->where("idCompany IN ({$ids})")->all();
            foreach ($madeCompanys as $key => $value) {
                $madeCompany[$key]['idCompany']=$value->idCompany;
                $madeCompany[$key]['nameCompany']=$value->nameCompany;
                $madeCompany[$key]['imageMade']=$value->imageMade;
                $madeCompany[$key]['eng']=$value->eng;
          }
          return $madeCompany;
      }
      
}
