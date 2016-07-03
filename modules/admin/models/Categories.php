<?php
namespace app\modules\admin\models;

use Yii;
use \yii\db\ActiveRecord;
use app\managers\QueryManager;

Class Categories extends ActiveRecord{
    
    public static function tableName()
    {
        return 'categories';
    }
    
    public function getCategories($rubricId=0){
        if($rubricId){
           $categoriesInfos=self::find()
                   ->where('rubricId='.$rubricId)
                   ->orderBy('name')
                   ->all();  
        }else{
          $categoriesInfos=self::find()
                  ->orderBy('name')
                  ->all();    
        }
        foreach ($categoriesInfos as $key => $value) {
            $categoriesInfo[$key]['categoryId']=$value->categoryId;
            $categoriesInfo[$key]['name']=$value->name;
        }
        return $categoriesInfo;
    }
    
    public function getCategoriesOrder(){
        $arryCat=array();
        $categoriesInfo=self::find()
                  ->orderBy('orderCat')
                  ->all(); 
          foreach ($categoriesInfo as $key => $value) {
             $arryCat[$value['rubricId']][$value['categoryId']]['name']=$value['name']; 
             $arryCat[$value['rubricId']][$value['categoryId']]['orderCat']=$value['orderCat']; 
             $arryCat[$value['rubricId']][$value['categoryId']]['eng']=$value['eng']; 
          }
          return $arryCat;
    }
    public function saveDatetCategory($getArray) {
        if (!empty($getArray['add'])) {
            $category=new Categories();
            $category->rubricId=$getArray['rubricId'];
            $category->name=$getArray['name'];
            $category->eng=$getArray['eng'];
            $category->orderCat=$getArray['orderCat'];
             return $category->save();
        } else if (!empty($getArray['redug'])) {
            $queryManager=new QueryManager();
            $qs = "UPDATE kochevni_new.categories SET name='" .$getArray['name']
                    ."', eng='".$getArray['eng']."',orderCat=".$getArray['orderCat'] 
                    . " WHERE  rubricId=" . $getArray['rubricId'] 
                    . " AND categoryId=" . $getArray['categoryId'];
             return $queryManager->updateSqlData($qs);
        }
        
    }
    
    
}
