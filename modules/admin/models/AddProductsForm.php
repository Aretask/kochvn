<?php

namespace app\modules\admin\models;

use app\modules\admin\models\Pruducts;
use app\modules\admin\managers\ResizeCrop;
use app\modules\admin\models\SqlQueryData;
use app\modules\admin\models\FilterProduct;
use app\modules\admin\models\ProductSpecifications;

class AddProductsForm extends \yii\base\Model
{
    public $productId=0;
    public $image='';
    public $title='';
    public $translit='';
    public $description='';
    public $currency=0;
    public $priceSet=0;
    public $price=0;
    public $priceAction=0;
    public $actionPriceSet=0;
    public $rubricId=0;
    public $categoryId=0;
    public $made=0;
    public $copy=0;

    public function rules()
    {
        return [
           [ ["title","translit","description","currency","price",
               "priceSet","rubricId","categoryId","made"],'required'] 
        ];
    }
    
    public function saveForm($data){
        $image_data = $_FILES['AddProductsForm'];
        $postArray=$data['AddProductsForm'];
        if(!empty($data['copy']) && $data['copy']==1){
            $postArray['productId']=0;
            $postArray['status']=1;
        }else{
          $postArray['status']=0;
          unset($postArray['image']);  
        }
        if ($postArray['productId']!=0) {
             $pruducts = Pruducts::findOne($postArray['productId']);
             $pruducts=$this->setArray($pruducts,$postArray, array('productId','translit'));
             $pruducts->update();
        } else {
            $pruducts=new Pruducts();
            $pruducts=$this->setArray($pruducts,$postArray, array('productId'));
            $pruducts->save();
            $postArray['productId'] = \Yii::$app->db->getLastInsertID();
        }
        $sqlQueryData=new SqlQueryData();
        $sqlQueryData->setMadeCategory($postArray['rubricId'],$postArray['categoryId'],$postArray['made']);
        
       if ($image_data['size']['image'] && $postArray['productId']!=0) {
           $photo_prod=new PhotoProducts();
           $photo_prod->productId=$postArray['productId'];
           $photo_prod->save();
           $photoId = \Yii::$app->db->getLastInsertID();
           $uploaddir = '/home/kochevni/domains/kochevnik.com.ua/public_html/web/images/products';
    //       $uploaddir = '/var/www/html/kochevn/web/images/products';
            if ($image_data['name']['image']) {
                $typePhoto = array(
                    '/medium/' => ['400', '250'],
                     '/big/' => ['550', '400'],
                    '/thumb/' => ['112', '85'],
                );
                $mainName = basename($image_data['name']['image']);
                foreach ($typePhoto as $key => $value) {
                    $uploadfile = $uploaddir . $key . $mainName;
                    $photoUrl = '/images/products' . $key . $mainName;
                    $photo=new ResizeCrop();
                    $res=$photo->resize($image_data['tmp_name']['image'], $uploadfile, $value[0], null);
                    if(!empty($res)){
                        if ($key == '/medium/') {
                              $pruducts = Pruducts::findOne($postArray['productId']);
                              $pruducts->image=$photoUrl;
                              $pruducts->update();
                        }
                        $key = str_replace('/', '', $key);
                        $photo_pruducts = PhotoProducts::findOne($photoId);
                        $photo_pruducts->$key=$photoUrl;
                        $photo_pruducts->update();
                    }
                }
            }
        }
        
        return $postArray['productId'];
    }
    
    public function copyItemData($fromId,$toId){
       $filter_from=new FilterProduct();
       $product_specifications=new ProductSpecifications();
       $filter_data=$filter_from->getFilterByIdItem($fromId);
       $specification_data=$product_specifications->getSpecifications($fromId);
       
       foreach($filter_data as $filter){
           $params['productId']=$toId;
           $params['categoryId']=$filter['categoryId'];
           $params['made']=$filter['made'];
           $params['filter']=$filter['filter'];
           $filter_from->addFilterItem($params);
       }
       
       foreach($specification_data as $specification){
           $paramss['productId']=$toId;
           $paramss['nameSpecifications']=$specification['nameSpecifications'];
           $paramss['valueSpecifications']=$specification['valueSpecifications'];
           $product_specifications->addSpecification($paramss);
       }
    }
    
    private function setArray($model, $data, $exept = array()) {
        foreach ($data as $key => $value) {
            if (!in_array($key, $exept)) {
                $model->$key=$value;
            }
        }
        return $model;
    }
    
}
