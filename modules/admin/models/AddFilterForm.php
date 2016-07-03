<?php

namespace app\modules\admin\models;

use app\modules\admin\models\SqlQueryData;
use app\modules\admin\models\Filter;
use app\modules\admin\models\FilterItem;

class AddFilterForm extends \yii\base\Model
{
    public $filter='';
    public $filter_name='';
    public $filter_item='';
    public $filter_item_name='';
    public $filterItem='';

    public function rules()
    {
        return [

        ];
    }
    
    public function saveFilter($data){
        $done=false;
     if(!empty($data['redug'])){
        $filter=Filter::findOne($data['filter']);
        $filter->nameFilter=$data['filter_name'];
        $done=$filter->update();
     }else if(!empty($data['add'])){
         $filter=new Filter();
         $filter->nameFilter=$data['filter_name'];
         $done=$filter->save();
     }
        return $done;
    }
    
    public function saveFilterItem($data) {
     if(!empty($data['redug'])){
        $filter= FilterItem::findOne($data['filter_item']);
        $filter->nameItem=$data['filter_item_name'];
        $done=$filter->update();
     }else if(!empty($data['add'])){
         $filter=new FilterItem();
         $filter->nameItem=$data['filter_item_name'];
         $filter->filterId=$data['filterItem'];
         $done=$filter->save();
     }
      return$done;
    }
    
 
    
}
