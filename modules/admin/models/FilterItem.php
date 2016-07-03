<?php

namespace app\modules\admin\models;

use Yii;
use \yii\db\ActiveRecord;

Class FilterItem extends ActiveRecord {

    public static function tableName() {
        return 'filterItem';
    }

    public function getFilterItems($filter_id=0) {
        $flter_item = array();
        $flters_item = self::find()
                ->where("filterId=" . $filter_id)
                ->orderBy('nameItem')
                ->all();
        foreach ($flters_item as $key => $value) {
            $flter_item[$key]['idItem'] = $value->idItem;
            $flter_item[$key]['nameItem'] = $value->nameItem;
        }
        return $flter_item;
    }

}
