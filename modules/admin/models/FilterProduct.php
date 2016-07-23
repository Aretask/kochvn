<?php

namespace app\modules\admin\models;

use \Yii;
use \yii\db\ActiveRecord;

Class FilterProduct extends ActiveRecord {

    public static function tableName() {
        return 'filterProduct';
    }

    public function getFilterItemCheck($data){
            $filter_check=    self::find()
                    ->where("filter=".$data['filter'])
                    ->andWhere("productId=".$data['productId'])
                    ->count();
            return $filter_check;
    }
    
    public function addFilterItem($data){
       $filter_add=  new FilterProduct();
        foreach ($data as $key => $value) {
                $filter_add->$key=$value;
        }
        return $filter_add->save();
        
    }
    
    public function delFilterItem($filter_id){
        $filter_del = self::findOne($filter_id);
        return $filter_del->delete();

    }

     public function getFilterByIdItem($item_id){
                  $filter_list=    self::find()
                    ->where("productId=".$item_id)
                    ->all();
            return $filter_list;

    }

}
