<?php

namespace app\modules\admin\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\data\Pagination;
use app\modules\admin\models\SqlQueryData;
use app\modules\admin\models\Pruducts;
use app\modules\admin\models\Categories;
use app\modules\admin\models\ProductSpecifications;
use app\modules\admin\models\PhotoProducts;
use app\modules\admin\models\MadeSuplier;
use app\modules\admin\models\MadeCompany;
use app\modules\admin\models\Filter;
use app\modules\admin\models\FilterItem;
use app\modules\admin\models\FilterProduct;
use app\modules\admin\models\AddProductsForm;
use app\modules\admin\models\AddProductsGalleryForm;




class ProductsController extends Controller
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
    public function actionList()
    {
         $categoriesInfo=array();
         $madeSuplier=array();
         $flter=array();
         
         $categories=new Categories();
         $madeSupliers=new MadeSuplier();
         $flters=new Filter();
         $filter=$flters->getFilter();
         $categoriesInfo=$categories->getCategories();
         $madeSuplier=$madeSupliers->getMadeSuplier();
         
        return $this->render('list', [
            "filter"=>$filter,
            "madeSuplier"=>$madeSuplier,
            "categoriesInfo"=>$categoriesInfo
            
        ]);
    }
    public function actionAdd()
    {
       Yii::$app->assetManager->bundles['yii\web\YiiAsset'] = [
            'js' => ['/ckeditor/ckeditor.js']
        ];
        $sqlQueryData=new SqlQueryData;
        $model= new AddProductsForm();
        $model_photo=new AddProductsGalleryForm();
        $request=Yii::$app->request->get();
        $post_data=Yii::$app->request->post();
        $pruductInfo=array();
         $galleryArray=array();
         $categoriesInfo=array();
         $filtersArray=array();
         $modificationArray=array();
         $error=false;
         
        if($post_data && $model->load($post_data)){
            if($model->validate()){
               $id=$model->saveForm($post_data);
               if(!empty($post_data['copy']) && $post_data['copy']==1){
                   $model->copyItemData($post_data['AddProductsForm']['productId'],$id);
               }
               return $this->redirect("/admink32/products/add?id=".$id);
            }else{
               return $this->redirect("/admink32/products/add?errr=1&id=".$request['id']);
            }
        }
        //Если есть ID
        if(!empty($request)){
          $id=$request['id'];
          $pruductInfo=Pruducts::findOne($id);
          if(!empty($pruductInfo)){
          $pruductInf['productId']=$pruductInfo->productId;
          $pruductInf['image']=$pruductInfo->image;
          $pruductInf['title']=$pruductInfo->title;
          $pruductInf['translit']=$pruductInfo->translit;
          $pruductInf['description']=$pruductInfo->description;
          $pruductInf['currency']=$pruductInfo->currency;
          $pruductInf['priceSet']=$pruductInfo->priceSet;
          $pruductInf['price']=$pruductInfo->price;
          $pruductInf['priceAction']=$pruductInfo->priceAction;
          $pruductInf['actionPriceSet']=$pruductInfo->actionPriceSet;
          $pruductInf['rubricId']=$pruductInfo->rubricId;
          $pruductInf['categoryId']=$pruductInfo->categoryId;
          $pruductInf['made']=$pruductInfo->made;
          $model->setAttributes($pruductInf,'');
          $categories=new Categories();
          $categoriesInfo=$categories->getCategories($pruductInfo->rubricId);
          
          $productSpecifications=new ProductSpecifications();
          $modificationArray=$productSpecifications->getSpecifications($id);
          
          $photoProducts=new PhotoProducts();
          $galleryArray=$photoProducts->getPhotoProducts($id);
          
          $filters=$sqlQueryData->getFilterProduct($id);
          foreach ($filters as $key => $value) {
               $filtersArray[$value['filterId']]['name']=$value['nameFilter'];
               $filtersArray[$value['filterId']]['filter'][$value['productIdItem']]=$value['nameItem'];
          }
          
        }else{
            $error=true;
        }
        }
        //Остальная инфо
        
          $madeSupliers=new MadeSuplier();
          $madeSuplier=$madeSupliers->getMadeSuplier();
          
          $madeCompanys=new MadeCompany();
          $madeCompany=$madeCompanys->getMadeCompany();
          
          $flters=new Filter();
          $filter=$flters->getFilter();
        
        return $this->render('add', [
            "model"=>$model,
            "model_photo"=>$model_photo,
            'pruductInfo'=>$pruductInfo,
            'categoriesInfo'=>$categoriesInfo,
            'filtersArray'=>$filtersArray,
            'modificationArray'=>$modificationArray,
            'galleryArray'=>$galleryArray,
            'madeSuplier'=>$madeSuplier,
            'madeCompany'=>$madeCompany,
            'filter'=>$filter,
            'error'=>$error
        ]);
    }

    public function actionGetCategory(){
        $request = Yii::$app->request->get();
          $categories=new Categories();
          $data=$categories->getCategories($request['rubricId']);
          Yii::$app->response->format = 'json';       
          return $data;
    }
    
    public function actionGetFilter(){
        $request = Yii::$app->request->get();
         $flters=new FilterItem();
         $filter=$flters->getFilterItems($request['filter']);
          Yii::$app->response->format = 'json';       
          return $filter;
    }
    public function actionSetFilterProduct(){
        $request = Yii::$app->request->get();
        $flters=new FilterProduct();
          if(!empty($request['filterIdDel'])){
               $result['affectedRows']=$flters->delFilterItem($request['filterIdDel']);
          }else{
              if(!empty($request['idsSet'])){
                  $pruduct=new Pruducts();
                $data_product=  $pruduct->getProductsByIds($request['idsSet']);
                foreach ($data_product as $value) {
                    foreach ($request['filter'] as $filter) {
                        $data['filter'] = $filter;
                        $data['productId'] = $value->productId;
                        $count_filter = $flters->getFilterItemCheck($data);
                        if ($count_filter == 0) {
                            $data['categoryId'] = $value->categoryId;
                            $data['made'] = $value->made;
                            $result['affectedRows'] = $flters->addFilterItem($data);
                        }
                    }
                }
              }else{
                $count_filter=$flters->getFilterItemCheck($request);
                  if($count_filter==0){
                     $result['affectedRows']= $flters->addFilterItem($request);
                  }else{
                     $result['exist']=true; 
                  }
              }
          }
          Yii::$app->response->format = 'json';       
          return $result;
    }
    public function actionModeficationAdd(){
        $request = Yii::$app->request->get();
        $specifications=new ProductSpecifications();
          if(!empty($request['modeficationIdDel'])){
              $result['affectedRows']=$specifications->delSpecification($request['modeficationIdDel']);
          }elseif($request['type']==2 && !empty($request['modeficationId'])&& $request['modeficationId']!=0){
               $result['editId']= $specifications->editSpecification($request);
          }else if($request['type']==1){
              unset($request['modeficationId']);
              unset($request['type']);
              $result['modeficationId']= $specifications->addSpecification($request);
          }
          Yii::$app->response->format = 'json';       
          return $result;
    }
    
    public function actionAddGallery(){
        $post_data = Yii::$app->request->post();
         $model_photo=new AddProductsGalleryForm();
         $data=array();
        //Добавление фотогалереи
         if($post_data && $model_photo->load($post_data)){
            if($model_photo->validate()){
               $data=$model_photo->savePhoto($post_data);
            }
        }
          Yii::$app->response->format = 'json';       
          return $data;
    }
    public function actionDelPhotoGallery(){
        $get_data = Yii::$app->request->get();
        $data=array();
        if(!empty($get_data['photoDel'])){
          $data['affectedRows']=PhotoProducts::findOne($get_data['photoDel'])->delete();
        }
 
          Yii::$app->response->format = 'json';       
          return $data;
    }
    
    public function actionSearch(){
        $this->layout = false;
        $pages=array();
        $get_data = Yii::$app->request->get();
        $sqlQueryData=new SqlQueryData;
        $data=$sqlQueryData->searchProduct($get_data);
        $total=$data['total'][0]['count'];
        if($total>10){
            $pages = new Pagination(['totalCount' => $total,
                'defaultPageSize'=>10]);
            $pages->setPage($get_data['page']-1);
        };
        return $this->render('search', [
            "data"=>$data['data'],
            'pages' => $pages,
            'total' => $total
        ]);
    }
    
    public function actionSetNewParam(){
        $get_data = Yii::$app->request->get();
        $pruducts= new Pruducts();
        $pruducts->setNewPrice($get_data);
        $sqlQueryData=new SqlQueryData();
        $suply_currency=$sqlQueryData->getSuplierCurrency($get_data['idsSet']);
        foreach ($suply_currency as $key => $value) {
          $done=$pruducts->recountPriceProduct($value,$get_data['idsSet']);
        }
        Yii::$app->response->format = 'json';       
          return $done;
    }
    
    public function actionDelProduct(){
         $get_data = Yii::$app->request->get();
          $sqlQueryData=new SqlQueryData();
         $done= $sqlQueryData->delProductsTable($get_data['idsDel']);
         Yii::$app->response->format = 'json';       
          return $done;
    }


}

