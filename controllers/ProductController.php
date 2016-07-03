<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\SqlSiteData;
use app\models\Orders;
use app\modules\admin\models\Pruducts;
use app\modules\admin\models\MadeCompany;
use app\modules\admin\models\PhotoProducts;
use app\modules\admin\models\ProductSpecifications;

class ProductController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }
    
    public function beforeAction($action) {
       $this->enableCsrfValidation = false;
       return parent::beforeAction($action);
    }
    
       public function actions()
    {
        $menu_date=array();
        $sqlSiteData=new SqlSiteData();
        $menu=$sqlSiteData->getMenu();
        
        foreach ($menu as $value) {
            $menu_date[$value['rubricId']][]=$value;
        }
        Yii::$app->view->params['menu'] = $menu_date;
        Yii::$app->view->params['title'] = "Кочевник сайт туристического снаряжения";
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ]
            
        ];
    }


    public function actionShow()
    { 
        
        $product_filter=array();
         $brands_array=array();
         $rubricsData = require(__DIR__ . '/data/rubricsData.php');
         $get_data = Yii::$app->request->get();
         preg_match('/_([\d]+)/',$get_data['product'],$matches);
         if (!empty($matches[1])) {
            $product_id = $matches[1];
            $sqlSiteData = new SqlSiteData();
            $product = $sqlSiteData->getProductInfo($product_id);
            if (!empty($product)) {
                $product_filter_data = $sqlSiteData->getProductFilter($product_id);
                foreach ($product_filter_data as $key => $value) {
                    $product_filter[$value['filterId']]['name'] = $value['nameFilter'];
                    $product_filter[$value['filterId']]['filter'][$value['idItem']] = $value['nameItem'];
                }
                if (!empty($product[0]['made'])) {
                    $madeCompany = new MadeCompany();
                    $brands = $madeCompany->getMadeCompanyByIds($product[0]['made']);
                    foreach ($brands as $value) {
                        $product[0]['nameCompany'] = $value['nameCompany'];
                    }
                }
                if(!empty($product[0]['nameCompany'])){
                   Yii::$app->view->params['title'] = $product[0]['nameCompany']." ".$product[0]['title'];
                }else{
                   Yii::$app->view->params['title'] = $product[0]['title'];
                }
                Yii::$app->view->params['image'] = !empty($product[0]['image'])?$product[0]['image']:"";
                 Yii::$app->view->params['url'] = "http://kochevnik.com.ua".$_SERVER['REQUEST_URI'];
                $photoProducts = new PhotoProducts();
                $photo_product = $photoProducts->getPhotoProducts($product_id);
                $productSpecifications = new ProductSpecifications();
                $specification_product = $productSpecifications->getSpecifications($product_id);
                $pruducts=new Pruducts();
                $data_search['category']=$product[0]['categoryId'];
                $special_product=$pruducts->getProducts($data_search,12);
                $counr_prod=count($special_product['data']);
                if($counr_prod<12){
                    $left=$counr_prod%4;
                    $left=$counr_prod-$left;
                    $special_product['data']=array_slice($special_product['data'], 0,$left);
                    $special_product['data']=$special_product['data'];
                }
                  if (!empty($special_product['made'])) {
                    $madeCompany = new MadeCompany();
                    $brands = $madeCompany->getMadeCompanyByIds($special_product['made']);
                    foreach ($brands as $value) {
                        $brands_array[$value['idCompany']]['nameCompany'] = $value['nameCompany'];
                    }
                }
            } else {
               return $this->redirect("/empty");  
            }
        } else {
            return $this->redirect("/empty"); 
        }
       return $this->render('show',[
             "product"=>$product[0],
             "photo_product"=>$photo_product,
             "product_filter"=>$product_filter,
             "specification_product"=>$specification_product,
             "special_product"=>$special_product['data'],
             "brands_array"=>$brands_array
        ]);
    }
    
    public function actionSetOrder(){
        $result['status']=0;
         $post_data = Yii::$app->request->post();
         if(!empty($post_data)){
             $orders= new Orders();
             $count=$orders->checkOrder($post_data);
             if($count && $count!=0){
                 $result['status']=2; 
             }else{
                $done= $orders->setOrder($post_data);
                $result['status']=1;
             }
         }
          Yii::$app->response->format = 'json';       
          return $result;
        
    }
    
    public function actionCountOrders(){
         $get_data = Yii::$app->request->get();
         $orders= new Orders();
          Yii::$app->response->format = 'json';       
         $count=$orders->getCountOrders($get_data['indent']);
         return array('count'=>$count);
         
    }
    public function actionDelOrder(){
         $post_data = Yii::$app->request->post();
         $orders= new Orders();
          Yii::$app->response->format = 'json';       
         $result=$orders->delOrder($post_data['delItem']);
         return array('status'=>$result);
         
    }
    public function actionComfirmOrder(){
         $post_data = Yii::$app->request->post();
         $status=0;
         $result=array();
         if(!empty($post_data['orderId'])){
             foreach ($post_data['orderId'] as $order_id =>$product_id) {
                 $orders_buy[$order_id]['count']=$post_data['quantity'][$order_id];
                 $orders_buy[$order_id]['product_id']=$product_id;
             }
              $user_buy['nameBuyer']=$post_data['nameBuyer'];
              $user_buy['phoneBuyerf']=$post_data['phoneBuyer'];
              $user_buy['mailBuyer']=$post_data['mailBuyer'];
                  
                $replace=array('/\+38/','/\-/','/\(/','/\)/');
               foreach ($replace as $value) {
                   $post_data['phoneBuyer']= preg_replace($value, "", $post_data['phoneBuyer']);
               }
               $user_buy['phoneBuyer']=$post_data['phoneBuyer'];
               $sqlSiteData=new SqlSiteData();
               $id_buyer= $sqlSiteData->setUserData($user_buy);
               $id_buyer=$id_buyer[0]['idBuyer'];
               
               $orders= new Orders();
               $pruducts=new Pruducts();
               foreach ($orders_buy as $order_id => $value) {
                    //get Product Data
                    $product_data=$pruducts->getProductsByIds($value['product_id'])[0];
                    //set Order Data
                    $orders_data['order_id']=$order_id;
                    $orders_data['count']=$value['count'];
                    $orders_data['price_total']=$value['count']*$product_data->price;
                    $orders_data['id_buyer']=$id_buyer;
                    $orders_data['filters']=$post_data['filters'][$order_id];
                    $orders->confirmOrder($orders_data);
                    $result[]=$order_id;
                    $formail[$order_id]['product_data']=$product_data;
                    $formail[$order_id]['order_data']=$orders_data;
               }
               $this->sendMail($formail,$user_buy);
               $status=1;
         }
         
          Yii::$app->response->format = 'json';       
         return array('status'=>$status,'result'=>$result);
         
    }
    
    private function sendMail($formail,$user_buy){
        $sqlSiteData=new SqlSiteData();
        $user_buy['total']=0;
        foreach ($formail as $key => $value) {
           $orders[$key]['title'] =$value['product_data']->title;
           $orders[$key]['translit'] =$value['product_data']->translit; 
           $orders[$key]['productId'] =$value['product_data']->productId; 
           $orders[$key]['price'] =$value['product_data']->price; 
           $orders[$key]['order_id'] =$value['order_data']['order_id']; 
           $orders[$key]['count'] =$value['order_data']['count']; 
           $orders[$key]['price_total'] =$value['order_data']['price_total']; 
           $orders[$key]['image'] =$value['product_data']->image;; 
           $user_buy['total']+=$value['order_data']['price_total']; 
           if(!empty($value['order_data']['filters'])){
             $orders[$key]['filter'] =$sqlSiteData->getFilterNamesByIds($value['order_data']['filters']);
           }else{
             $orders[$key]['filter']=array();  
           }
        }
      Yii::$app->mailer->compose('contact',[
        'user_data'=>$user_buy,
        'orders'=>$orders,      
       ])
     ->setFrom('info@kochevnik.com.ua')
     ->setTo('olesya.riltsova@gmail.com')
     ->setSubject('Заказ с сайта Кочевник')
     ->send();
        
    }
    

   
}
