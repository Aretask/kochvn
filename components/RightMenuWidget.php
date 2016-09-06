<?php

namespace app\components;

use yii\base\Widget;
use yii\helpers\Html;
use app\models\SqlSiteData;

class RightMenuWidget extends Widget
{

    public $rub=0;
    public $cat=0;
    public $brand='';
    public $brand_id='';
    public $filters='';

    public function run()
    {
        $filter_ids=explode(",",$this->filters);
        $active['cat']=$this->cat;
        $active['rub']=$this->rub;
        $brands=array();
        $filters=array();
        $sqlSiteData=new SqlSiteData();
        $brands=$sqlSiteData->getMadeCategory($this->rub,$this->cat);
        $filters_group=$sqlSiteData->getFilterCategory($this->cat,$this->brand_id);
        foreach ($filters_group as $key => $value) {
            $filters[$value['filterId']]['name']=$value['nameFilter'];
            $filters[$value['filterId']]['filters'][$value['idItem']]=$value['nameItem'];
        }
        foreach ($filters as $key=>$filter){
          natsort($filters[$key]['filters']);
        }
        return $this->render('rightMenu',[
             'brands' => $brands,
             'brand_active'=>$this->brand,
             'filters'=>$filters,
             'filter_ids'=>$filter_ids
        ]);
    }
}
?>
