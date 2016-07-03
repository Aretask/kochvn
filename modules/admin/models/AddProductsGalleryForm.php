<?php

namespace app\modules\admin\models;

use app\modules\admin\models\PhotoProducts;
use app\modules\admin\managers\ResizeCrop;

class AddProductsGalleryForm extends \yii\base\Model
{
    public $productId=0;
    public $image='';

    public function rules()
    {
        return [
           [ "productId",'required'] 
        ];
    }
    
    public function savePhoto($data){
        $image_data = $_FILES['AddProductsGalleryForm'];
        $postArray=$data['AddProductsGalleryForm'];
        $data=array();
       if ($image_data['size']['image'] && $postArray['productId']!=0) {
           $photo_prod=new PhotoProducts();
           $photo_prod->productId=$postArray['productId'];
           $photo_prod->save();
           $photoId = \Yii::$app->db->getLastInsertID();
            $uploaddir = '/home/kochevni/domains/kochevnik.com.ua/public_html/web/images/products';
            if ($image_data['name']['image']) {
                $typePhoto = array(
                 '/medium/' => ['400', '250'],
                     '/big/' => ['550', '400'],
                    '/thumb/' => ['112', '85'],
                );
                $mainName = preg_replace("/\s/","",basename($image_data['name']['image']));
                foreach ($typePhoto as $key => $value) {
                    $uploadfile = $uploaddir . $key . $mainName;
                    $photoUrl = '/images/products' . $key . $mainName;
                    $photo=new ResizeCrop();
                    $res=$photo->resize($image_data['tmp_name']['image'], $uploadfile, $value[0], null);
                    if(!empty($res)){
                        $key = str_replace('/', '', $key);
                        $photo_pruducts = PhotoProducts::findOne($photoId);
                        $photo_pruducts->$key=$photoUrl;
                        $photo_pruducts->update();
                    }
                }
                 if(!empty($res)){
                   $data['photo']='/images/products/medium/'.$mainName;
                 }
            }
        }
        return $data;
    }
    
    
}
