<?php
namespace app\modules\admin\models;

use Yii;
use \yii\db\ActiveRecord;

Class Pruducts extends ActiveRecord{
    
    public static function tableName()
    {
        return 'pruducts';
    }

    public function setNewPrice($data){
        $priceSet=' priceSet=(priceSet'.$data['operation'].$data['number'].')';
        if($data['operation']==1){
            $priceSet=' priceSet='.$data['number'];
        }
        $command = \Yii::$app->db->createCommand(
        'UPDATE kochevni_new.pruducts SET'. $priceSet.'  WHERE productId IN('.$data['idsSet'].')');
        $command->execute();
        return true;
    }
    public function recountPriceProduct($data,$prudutctIds){
           $qs="UPDATE kochevni_new.pruducts SET price=priceSet*".$data['curenccy'].
            " WHERE productId IN (".$prudutctIds.") AND currency=".$data['idSuplier'] ;
          $command = \Yii::$app->db->createCommand($qs);
          return $command->execute();
    }
    public function getProductsByIds($ids){
           return self::find()
                ->where("productId IN (".$ids.")")
                ->all();
    }
    public function getProducts($data,$limit=8,$page=0){
        $ofset=$page*$limit;
        $gallery_date=array();
        $and=false;
           $products_sql= self::find();
           if(!empty($data['filters'])){
            $products_sql->innerJoin("filterProduct",'pruducts.productId=filterProduct.productId');
            $products_sql->where("filterProduct.filter IN({$data['filters']})");
             $and=true;
           }
           
           if(!empty($data['rubric'])){
               if(!empty($and)){
                  $products_sql->andWhere("pruducts.rubricId IN('{$data['rubric']}')");
               }else{
                  $products_sql->where("pruducts.rubricId IN('{$data['rubric']}')");
             $and=true;
           }
           }
           if(!empty($data['category'])){
               if(!empty($and)){
                  $products_sql->andWhere("pruducts.categoryId IN('{$data['category']}')");
               }else{
                  $products_sql->where("pruducts.categoryId IN('{$data['category']}')");
                   $and=true;
               }
           }
           
           if(!empty($data['brand_id'])){
               if(!empty($and)){
                  $products_sql->andWhere("pruducts.made={$data['brand_id']}");
               }else{
                  $products_sql->where("pruducts.made={$data['brand_id']}");
               }
           }
           $products_sql->andWhere("pruducts.status=0");
           $products_sql->groupBy("pruducts.productId");
           $total=$products_sql->count();  
           $products_sql->orderBy("pruducts.dateAdd DESC, pruducts.countOrder DESC");
           $products_sql->limit($limit);
           $products_sql->offset($ofset);
           $products= $products_sql->all();
         //  print_r($products_sql->createCommand()->sql);
           $made='';
        foreach ($products as $key => $value) {
             $gallery_date[$key]['title']=$value['title'];
             $gallery_date[$key]['image']=$value['image'];
             $gallery_date[$key]['price']=$value['price'];
             $gallery_date[$key]['priceAction']=$value['priceAction'];
             $gallery_date[$key]['translit']=$value['translit'];
             $gallery_date[$key]['productId']=$value['productId'];
             $gallery_date[$key]['made']=$value['made'];
             if($made)$made.=",";
                $made.=$value['made'];
        }
        return array('data'=>$gallery_date,'total'=>$total,'made'=>$made);
    }
}
