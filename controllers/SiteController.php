<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\SqlSiteData;
use app\modules\admin\models\InfoGallery;
use app\modules\admin\models\Pruducts;
use app\modules\admin\models\MadeCompany;

class SiteController extends Controller
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
        Yii::$app->view->params['image'] = "http://kochevnik.com.ua/images/logo-koch1.png";
        Yii::$app->view->params['url'] = "http://kochevnik.com.ua/";
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ]
        ];
    }


    public function actionIndex()
    {      
         $infoGallery=new InfoGallery();
        $slider=$infoGallery->getGallery();
         $data_search=array();
         $made_array=array();
         $brands_array=array();
         $pruducts=new Pruducts();
        $pruduct=$pruducts->getProducts($data_search,12);
        $made_array=$pruduct['made'];
        $counr_prod=count($pruduct['data']);
        if($counr_prod<12){
            $left=$counr_prod%4;
            $left=$counr_prod-$left;
            $pruduct=array_slice($pruduct['data'], 0,$left);
            $pruduct['data']=$pruduct;
        }
        for($i=1;$i<5;$i++){
          $data_search['rubric']=$i;
          $data=$pruducts->getProducts($data_search,4);
          $pruducts_rub[$i]=$data['data'];
          if(!empty($data['made']))
             $made_array.=",".$data['made'];
        }
        if(!empty($made_array)){
            $madeCompany=new MadeCompany();
            $brands=$madeCompany->getMadeCompanyByIds($made_array);
            foreach ($brands as $value) {
               $brands_array[$value['idCompany']]['nameCompany'] =$value['nameCompany'];
            }
        }
        return $this->render('index',[
           "slider"=>$slider,
           "pruducts"=>$pruduct['data'],
           "pruducts_rub"=>$pruducts_rub,
           "brands_array"=>$brands_array
        ]);
    }

    public function actionLogin()
    {      
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {

        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        
        return $this->render('contact', [
            
        ]);
    }

    public function actionAbout()
    {
        return $this->render('about');
    }
    public function actionEmpty()
    {
        return $this->render('empty');
    }
    public function actionCart()
    {
        $orders=array();
        if(!empty($_COOKIE['indent'])){
           $indent=$_COOKIE['indent'];
            $sqlSiteData=new SqlSiteData();
            $orders=$sqlSiteData->getOrdersUser($indent);
            foreach ($orders as $key => $product) {
                if(!empty($product['filterOrder'])){
                 $orders[$key]['filter']=$sqlSiteData->getFilterNamesByIds($product['filterOrder']);
                } else{
                  $orders[$key]['filter']=array();  
                }
            }
        }
        return $this->render('cart',[
            'orders'=>$orders
        ]);
    }
}
