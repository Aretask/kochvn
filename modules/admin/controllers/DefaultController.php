<?php

namespace app\modules\admin\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\modules\admin\models\LoginForm;
//use app\models\LoginForm;
use app\modules\admin\models\InfoGallery;
use app\modules\admin\models\Youtube;
use app\modules\admin\managers\ResizeCrop;




class DefaultController extends Controller
{
    
        public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                    'allow' => true,
                    'actions' => ['login'],
                    'roles' => ['?'],  
                    ],
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
    public function actionLogin()
    {
       $this->layout='admin_login';
        if (!\Yii::$app->user->isGuest) {
           return $this->redirect('/admink32/main/');
        }
        
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $this->redirect('/admink32/main/');
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }
    public function actionLogout()
    {
      Yii::$app->user->logout();

       return $this->redirect('/admink32/');
      
    }
    public function actionMain()
    {
        $data=\Yii::$app->request->post();
        if (!empty($data)) {
            if (!empty($data['youtube'])) {
                $youtube = new Youtube();
                $youtube->youtubeKey = $data['youtube'];
                $youtube->save();
                return $this->redirect("/admink32/main/"); 
            } else if (!empty($data['gallery'])) {
                $image = $_FILES['image'];
                $uploaddir = '/home/kochevni/domains/kochevnik.com.ua/public_html/web/images/gallery/';
                if ($image['name'] && $image['size']) {
                    $photoUrl = '/images/gallery/' . $image['name'];
                    $uploadfile = $uploaddir . basename($image['name']);
                    $photoUrl = '/images/gallery/' . basename($image['name']);
                    $resizeCrop = new ResizeCrop();
                    $resizeCrop->resize($image['tmp_name'], $uploadfile, 600, 300);
                    $insertGallery = new InfoGallery();
                    $insertGallery->photoUrl = $photoUrl;
                    $insertGallery->linkUrl = $data['link'];
                    $insertGallery->titleName = $data['text'];
                    $insertGallery->big = 1;
                    $insertGallery->save();
                }
                 return $this->redirect("/admink32/main/"); 
            }
        }
        
        $infoGallery = InfoGallery::find()->where(['big' => '1'])->all();
        $youtube = Youtube::find()->orderBy(['id' => SORT_DESC])->one();
        $youtube=!empty($youtube->youtubeKey)?$youtube->youtubeKey:"";
        foreach ($infoGallery as $key=> $value) {
            $dataGalley[$key]['photoUrl']=$value->photoUrl;
            $dataGalley[$key]['linkUrl']=$value->linkUrl;
            $dataGalley[$key]['titleName']=$value->titleName;
            $dataGalley[$key]['id']=$value->id;
        }
 
      return $this->render('main',[
            'title' => "Общие настройки админки",
             'dataGalley'=>$dataGalley,
             'youtube'=>$youtube,
          
        ]);
      
    }
    public function actionDelGallery(){
        $result=false;
          $data=\Yii::$app->request->get();
          if(!empty($data['photo'])){
                $infoGallery = new InfoGallery();
              $result=  $infoGallery->delPhoto($data['photo']); 
          }
           Yii::$app->response->format = 'json';       
          return array('status'=>$result);
    }

}

