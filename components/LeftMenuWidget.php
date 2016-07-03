<?php

namespace app\components;

use yii\base\Widget;
use yii\helpers\Html;
use app\models\SqlSiteData;
use app\modules\admin\models\Youtube;

class LeftMenuWidget extends Widget
{

    public $rub='';
    public $rub_eng='';
    public $cat='';
    public $cat_eng='';
    public $brand='';
    public $brand_id='';

    public function run()
    {
        $active['rub']=$this->rub;
        $active['rub_eng']=$this->rub_eng?$this->rub_eng."/":"";
        $active['cat']=$this->cat;
        $active['cat_eng']=$this->cat_eng?$this->cat_eng."/":"";
        $active['brand']=$this->brand;
        $active['brand_act']='';
        if(!empty($this->brand)){
          $active['brand']="/brand/".$this->brand;
          $active['brand_act']=$this->brand;
        }
        $menu_date=array();
        $youtube=new Youtube();
        $video=$youtube->findLastVideo();
        $video=!empty($video->youtubeKey)?$video->youtubeKey:'';
        $sqlSiteData=new SqlSiteData();
        $menu=$sqlSiteData->getMenu();
          foreach ($menu as $value) {
            $menu_date[$value['rubricId']]['category'][]=$value;
            $menu_date[$value['rubricId']]['rubric']=$value['rubric'];
            $menu_date[$value['rubricId']]['eng_rubric']=$value['engr'];
          }
            $sqlSiteData=new SqlSiteData();
            $companies=$sqlSiteData->getMadeCategory($active['rub']);
        return $this->render('leftMenu',[
             'menu_date' => $menu_date,
             'active'=>$active,
             'companies'=>$companies,
             'video'=>$video
        ]);
    }
}
?>
