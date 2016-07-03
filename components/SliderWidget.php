<?php

namespace app\components;

use yii\base\Widget;
use app\modules\admin\models\InfoGallery;

class SliderWidget extends Widget
{

    public function run()
    {
        $infoGallery=new InfoGallery();
        $photo=$infoGallery->getGallery();
        return $this->render('slider',[
             'photo'=>$photo
        ]);
    }
}
?>
