<?php

namespace app\modules\admin\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\modules\admin\models\MadeSuplier;
use app\modules\admin\models\MadeCompany;
use app\modules\admin\models\AddMadeForm;
use app\modules\admin\models\AddFilterForm;
use app\modules\admin\models\Categories;
use app\modules\admin\models\Filter;




class DifferentController extends Controller
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

    public function actionFilter()
    {
    $filter=new Filter();
    $filterArray=$filter->getFilter();
    $model= new AddFilterForm();
    $post_data=Yii::$app->request->post();
    if($post_data && $model->load($post_data)){
        if($model->validate()){
            if(!empty($post_data['AddFilterForm']['filter_name'])){
                $done=$model->saveFilter($post_data['AddFilterForm']);   
             }else if(!empty($post_data['AddFilterForm']['filter_item_name'])){
                 $done=$model->saveFilterItem($post_data['AddFilterForm']);   
             }
             if(!empty($done)){
                  return $this->redirect("/admink32/different/filter?done=".$done);
             }
        }
    }
       
       return $this->render('filter', [
           "model"=>$model,
           "filters"=>$filterArray
        ]);
    }
    public function actionCategory()
    {
        $categories=new Categories();
        $arryCat=$categories->getCategoriesOrder();
         $get_data=Yii::$app->request->get();
         if(!empty($get_data['rubricId'])){
             $categories->saveDatetCategory($get_data);
             $this->setCategoryDataFile();
             return $this->redirect("/admink32/different/category");
         }
       return $this->render('category', [
           "arryCat"=>$arryCat
        ]);
    }
    public function actionCourse()
    {
        $madeCompany=new MadeCompany();
         $getMadeCompany=$madeCompany->getMadeCompany();
         $madeSupliers=new MadeSuplier();
         $madeSuplier=$madeSupliers->getMadeSuplier();
         $model= new AddMadeForm();
         $post_data=Yii::$app->request->post();
            if($post_data && $model->load($post_data)){
            if($model->validate()){
                if(!empty($post_data['AddMadeForm']['made'])){
                        $done=$model->saveMade($post_data['AddMadeForm']);
                        $this->setBrandDataFile();
                }else if(!empty($post_data['AddMadeForm']['nameSuplier'])){
                  $done= $model->saveBrend($post_data['AddMadeForm']);   
                }
                return $this->redirect("/admink32/different/course?done=".$done);
            }
        }
       return $this->render('course', [
            "model"=>$model,
            "madeSuplier"=>$madeSuplier,
            "madeCompany"=>$getMadeCompany,
        ]);
    }
    
    private function setCategoryDataFile() {
        $file_cat='/home/kochevni/domains/kochevnik.com.ua/public_html/controllers/data/categoriesData.php';
        unlink($file_cat);
        $fp=fopen($file_cat, 'a');
        $category=  Categories::find()->all();
        $text="<?php\n";
        $text.="return[\n";
        foreach ($category as $value) {
            $text.="'$value->eng' => array('id'=>$value->categoryId,'name'=>'$value->name'),\n"; 
        }
         $text.="];\n";
         $text.="?>\n";
        fwrite($fp, $text);
        fclose($fp);
    }
    private function setBrandDataFile() {
        $file_cat='/home/kochevni/domains/kochevnik.com.ua/public_html/controllers/data/brandsData.php';
        unlink($file_cat);
        $fp=fopen($file_cat, 'a');
        $brand=  MadeCompany::find()->all();
        $text="<?php\n";
        $text.="return[\n";
        foreach ($brand as $value) {
            $text.="'$value->eng' => array('id'=>$value->idCompany,'name'=>'$value->nameCompany'),\n"; 
        }
         $text.="];\n";
         $text.="?>\n";
        fwrite($fp, $text);
        fclose($fp);
    }
   
}

