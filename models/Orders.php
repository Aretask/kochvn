<?php
namespace app\models;

use Yii;
use \yii\db\ActiveRecord;

Class Orders extends ActiveRecord{
    
    public static function tableName()
    {
        return 'orders';
    }
    
     public function checkOrder($data){
           $flters=self::find();
               $flters->where("status=0");
               $flters->andWhere("productId=".$data['productId']);
                if(!empty($data['filter'])){
              $flters->andWhere("filterOrder='".implode(",",$data['filter'])."'");
                    }  
                     // print_r($flters->createCommand()->sql);
            return       $flters->count();
      }
     public function setOrder($data){
         $order=new Orders();
         $order->productId=$data['productId'];
         $order->indent=$data['indent'];
          if(!empty($data['filter'])){
             $order->filterOrder=implode(",",$data['filter']);
          }
         return $order->save();
      }
     public function delOrder($order_id){
        $order_del = self::findOne($order_id);
        return $order_del->delete();
      }
      
      public function getCountOrders($indent){
         if(!empty($indent)){
           return   $orders=self::find()
                     ->where('status=0')
                     ->andWhere("indent={$indent}")
                     ->count();
         } 
      }
      
      public function confirmOrder($data){
          $orders=self::findOne($data['order_id']);
          $orders->countItem=$data['count'];
          $orders->priceTottal=$data['price_total'];
          $orders->idBuyer=$data['id_buyer'];
          $orders->status=1;
          return  $orders->update();
      }
      
}