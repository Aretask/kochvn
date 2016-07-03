<?php

namespace app\modules\admin\models;

use app\modules\admin\models\PhotoProducts;
use app\modules\admin\managers\ResizeCrop;

class SearchProductForm extends \yii\base\Model
{
    public $suplier="";
    public $category='';
    public $productId='';

    public function rules()
    {
        return [
           [] 
        ];
    }
    
    public function searchProduct($data){
        echo "<pre>";
        print_r($data);
        echo "</pre>";
        die('+++');
    }
    
    
}
