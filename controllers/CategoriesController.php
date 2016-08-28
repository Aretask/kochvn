<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\SqlSiteData;
use app\modules\admin\models\Pruducts;
use app\modules\admin\models\MadeCompany;
use yii\data\Pagination;

 Class CategoriesController extends Controller{
     
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
        Yii::$app->view->params['image'] = "http://kochevn/images/logo-koch1.png";
        Yii::$app->view->params['url']= "http://kochevnik.com.ua".$_SERVER['REQUEST_URI'];
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ]
            
        ];
    }

    public function actionMain()
    {     
        $rubricsData = require(__DIR__ . '/data/rubricsData.php');
        $brandsData = require(__DIR__ . '/data/brandsData.php');
        $data_search=array();
        $brands_array=array();
        $pages=array();
        $rubric_params=array('eng'=>'','name'=>'','id'=>'');
        $brand_params=array('eng'=>'');
        $page_param='';
        $get_data = Yii::$app->request->get();
         if(!empty($get_data['rubric'])){
            $rubric=$get_data['rubric'];
            if(empty($rubricsData[$rubric])){
                 return $this->redirect("/empty");  
            }
            $rubric_params=$rubricsData[$rubric];
             Yii::$app->view->params['title'] = "Кочевник сайт туристического снаряжения. Рубрика ".$rubric_params['name'];
              Yii::$app->view->params['url']= "http://kochevnik.com.ua".$_SERVER['REQUEST_URI'];
            $rubric_params['eng']=$rubric;
            $data_search['rubric']=$rubric_params['id'];
         }
        if(!empty($get_data['brand'])){
            $brand=$get_data['brand'];
          if(empty($brandsData[$brand])){
               return $this->redirect("/empty");  
          }
            $brand_params=$brandsData[$brand];
            Yii::$app->view->params['title'] = "Кочевник сайт туристического снаряжения. Бренд ".$brand_params['name'];
            $brand_params['eng']=$brand;
            $data_search['brand_id']=$brand_params['id'];
        }
        if(empty($get_data['page'])){
           $get_data['page']=1; 
        }
        $current_page=$get_data['page']-1;
        $pruducts=new Pruducts();
        $pruduct_clothess=$pruducts->getProducts($data_search,12,$current_page);
        if(!empty($pruduct_clothess['made'])){
            $madeCompany=new MadeCompany();
            $brands=$madeCompany->getMadeCompanyByIds($pruduct_clothess['made']);
            foreach ($brands as $value) {
               $brands_array[$value['idCompany']]['imageMade'] =$value['imageMade'];
               $brands_array[$value['idCompany']]['nameCompany'] =$value['nameCompany'];
            }
        }
        $total=$pruduct_clothess['total'];
        $pruduct_cat=$pruduct_clothess['data'];
         if($total>9){
            $pages = new Pagination(['totalCount' => $total,
                'defaultPageSize'=>12]);
            $pages->setPage($current_page);
        };
        if($current_page>1){
           $page_param="?page=".($current_page-1); 
        }
        return $this->render('main',[
           "pruducts"=>$pruduct_cat,
            'pages' => $pages,
            'total' => $total,
            "rubric_params"=>$rubric_params,
            "brand_params"=>$brand_params,
            "page_param"=>$page_param,
            "brands_array"=>$brands_array
        ]);
    }
    
    public function actionCategory()
    { 
       $rubricsData = require(__DIR__ . '/data/rubricsData.php');
       $categoriesData = require(__DIR__ . '/data/categoriesData.php');
       $brandsData = require(__DIR__ . '/data/brandsData.php');
        $data_search=array();
        $brands_array=array();
        $pages=array();
        $rubric_params=array();
        $brand_params=array('eng'=>'','id'=>'');
        $page_param='';
        $morefilter=false;
        $limit=9;
        $get_data = Yii::$app->request->get();
        if(!empty($get_data['filters'])){
           $filter=$get_data['filters'];
           $filter=explode(",",$filter);
           $countfilter=count($filter);
           if($countfilter!=1){
              $morefilter=true;
           }
           $filters=$get_data['filters'];
           $data_search['filters']=$get_data['filters'];
        }else{
            $filters='';
        }
        
        $rubric=$get_data['rubric'];
        if(empty($rubricsData[$rubric])){
           return $this->redirect("/empty");   
        };
        $rubric_params=$rubricsData[$rubric];
        $rubric_params['eng']=$rubric;
        $data_search['rubric']=$rubric_params['id'];
        $category=$get_data['category'];
         if(empty($categoriesData[$category])){
           return $this->redirect("/empty");   
        };
        $category_params=$categoriesData[$category];
         Yii::$app->view->params['title'] = "Кочевник сайт туристического снаряжения. Категория  ".$category_params['name'];
          Yii::$app->view->params['url']= "http://kochevnik.com.ua".$_SERVER['REQUEST_URI'];
        $category_params['eng']=$category;
        $data_search['category']=$category_params['id'];
        
        if(!empty($get_data['brand'])){
            $brand=$get_data['brand'];
            if (empty($brandsData[$brand])) {
                return $this->redirect("/empty");
            };
            $brand_params=$brandsData[$brand];
            $brand_params['eng']=$brand;
            $data_search['brand_id']=$brand_params['id'];
        }else{
           $brand='';
           $brand_id=0; 
        }
        if(empty($get_data['page'])){
           $get_data['page']=1; 
        }
        $current_page=$get_data['page']-1;
        if(empty($morefilter)){
            $pruducts=new Pruducts();
            $pruduct_clothess=$pruducts->getProducts($data_search,$limit,$current_page);
        }else{
           $qlSiteData=new SqlSiteData(); 
           $pruduct_clothess=$qlSiteData->getProductsFilter($data_search,$countfilter,$limit,$current_page);
        }
         if(!empty($pruduct_clothess['made'])){
            $madeCompany=new MadeCompany();
            $brands=$madeCompany->getMadeCompanyByIds($pruduct_clothess['made']);
            foreach ($brands as $value) {
              $brands_array[$value['idCompany']]['imageMade'] =$value['imageMade'];
               $brands_array[$value['idCompany']]['nameCompany'] =$value['nameCompany'];
            }
         }
        $total=$pruduct_clothess['total'];
        $pruduct_cat=$pruduct_clothess['data'];
         if($total>9){
            $pages = new Pagination(['totalCount' => $total,
                'defaultPageSize'=>9]);
            $pages->setPage($current_page);
        };
        if($current_page>1){
           $page_param="?page=".($current_page-1); 
        }
        return $this->render('category',[
           "pruducts"=>$pruduct_cat,
            'pages' => $pages,
            'total' => $total,
            "rubric_params"=>$rubric_params,
            "category_params"=>$category_params,
            "brand_params"=>$brand_params,
            "page_param"=>$page_param,
            "filters"=>$filters,
            "brands_array"=>$brands_array
        ]); 
    }
    
    
     public function actionCategoryAjax()
    { 
       $this->layout=false;  
       $rubricsData = require(__DIR__ . '/data/rubricsData.php');
       $categoriesData = require(__DIR__ . '/data/categoriesData.php');
       $brandsData = require(__DIR__ . '/data/brandsData.php');
        $data_search=array();
        $brands_array=array();
        $pages=array();
        $rubric_params=array();
        $brand_params=array('eng'=>'','id'=>'');
        $page_param='';
        $morefilter=false;
        $limit=9;
        $get_data = Yii::$app->request->get();
        
           if(!empty($get_data['filters'])){
           $filter=$get_data['filters'];
           $filter=explode(",",$filter);
           $countfilter=count($filter);
           if($countfilter!=1){
              $morefilter=true;
           }
           $data_search['filters']=$get_data['filters'];
        }
        
        $rubric=$get_data['rubric'];
        if(empty($rubricsData[$rubric])){
           return $this->redirect("/empty");   
        };
        $rubric_params=$rubricsData[$rubric];
        $data_search['rubric']=$rubric_params['id'];
        $category=$get_data['category'];
         if(empty($categoriesData[$category])){
           return $this->redirect("/empty");   
        };
        $category_params=$categoriesData[$category];
        $data_search['category']=$category_params['id'];
        if(!empty($get_data['brand'])){
            $brand=$get_data['brand'];
            if (empty($brandsData[$brand])) {
                return $this->redirect("/empty");
            };
            $brand_params=$brandsData[$brand];
            $data_search['brand_id']=$brand_params['id'];
        }else{
           $brand='';
           $brand_id=0; 
        }
        if(empty($get_data['page'])){
           $get_data['page']=1; 
        }
        $current_page=$get_data['page']-1;
        if(empty($morefilter)){
            $pruducts=new Pruducts();
            $pruduct_clothess=$pruducts->getProducts($data_search,$limit,$current_page);
        }else{
           $qlSiteData=new SqlSiteData(); 
           $pruduct_clothess=$qlSiteData->getProductsFilter($data_search,$countfilter,$limit,$current_page);
        }
         if(!empty($pruduct_clothess['made'])){
            $madeCompany=new MadeCompany();
            $brands=$madeCompany->getMadeCompanyByIds($pruduct_clothess['made']);
            foreach ($brands as $value) {
              $brands_array[$value['idCompany']]['imageMade'] =$value['imageMade'];
               $brands_array[$value['idCompany']]['nameCompany'] =$value['nameCompany'];
            }
         }
        $total=$pruduct_clothess['total'];
        $pruduct_cat=$pruduct_clothess['data'];
         if($total>9){
            $pages = new Pagination(['totalCount' => $total,
                'defaultPageSize'=>9]);
            $pages->setPage($current_page);
        };
        if($current_page>1){
           $page_param="?page=".($current_page-1); 
        }
        return $this->render('product_category',[
           "pruducts"=>$pruduct_cat,
            'pages' => $pages,
            'total' => $total,
            "page_param"=>$page_param,
            "brands_array"=>$brands_array
        ]); 
    }
    
   
    
    
 }
?>
