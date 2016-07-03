<?php

namespace app\modules\admin\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\modules\admin\models\SqlQueryData;
use app\modules\admin\models\Buyers;




class OrdersController extends Controller
{
    
        public function behaviors()
    {
       return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                       [
                    'allow' => false,
                    'verbs' => ['POST'],
                    'verbs' => ['GET'],
                    'roles' => ['?'],
                ],
                // allow authenticated users
                [
                    'allow' => true,
                    'roles' => ['@'],
                ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post','get'],
                ],
            ]
            
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ]
        ];
    }
    public function actionOrders()
    {
      $sqlQueryData=new SqlQueryData();
      $data=array();
      $data_item=$sqlQueryData->getOrderProducts();
      if(!empty($data_item)){
          foreach ($data_item as $key => $value) {
              if(empty($value['filterOrder']) || $value['filterOrder']!='undefined'){
                $value['filter']=$this->getFilter($value['filterOrder']);
              }

              $data[$value['idBuyer']][]=$value;
          }
      }
        return $this->render('orders', [
            'data_item'=>$data
         
        ]);
    }
    public function actionBuyers()
    {
      $data=  Buyers::find()
              ->orderBy('name')
              ->all();
 
        return $this->render('buyers', [
            'buyers'=>$data
         
        ]);
    }
    public function actionBlackListBuyer(){
        $request=Yii::$app->request->get();
        $idbuyer=intval($request['idbuyer']);
        $status=intval($request['status']);
        
        $buyers= Buyers::findOne($idbuyer);
        $buyers->statusBuyer=$status;
        $data=$buyers->update();
         
         \Yii::$app->response->format ='json';
         return ['status'=>$data];
        
    }
    public function actionCompleteOrder(){
         $sqlQueryData=new SqlQueryData();
        $request=Yii::$app->request->get();
        $idbuyer=intval($request['idbuyer']);
        $data=$sqlQueryData->updateOrderStatus($idbuyer);
         \Yii::$app->response->format ='json';
         return ['status'=>$data];
        
    }
    private function getFilter($filter){
        $sqlQueryData=new SqlQueryData();
        return $sqlQueryData->getFilterItem($filter);
    }
   

}

