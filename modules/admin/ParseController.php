<?php

namespace app\modules\admin\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\modules\admin\models\MadeSuplier;
use app\modules\admin\models\MadeCompany;
use app\modules\admin\models\TmpSettings;
use app\modules\admin\models\TmpProducts;
use app\modules\admin\models\XmlFields;
use app\modules\admin\models\LoadParseFileForm;
use app\modules\admin\models\SqlQueryData;





class ParseController extends Controller
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
//   public function beforeAction($action) {
//       $this->enableCsrfValidation = false;
//       return parent::beforeAction($action);
//    }
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ]
        ];
    }
    
     public function actionParse()
    {
         $loadParseFileForm=new LoadParseFileForm();
         $madeSupliers=new MadeSuplier();
         $madeSuplier=$madeSupliers->getMadeSuplier();
         $xmlFields=new XmlFields();
         $xmlField=$xmlFields->getXmlFields();
         $tmpSettings=new TmpSettings();
         $tmpSet=$tmpSettings->getTmpSetting();
         $post_data=Yii::$app->request->post();
          if(!empty($post_data)){
              if(!empty($post_data['LoadParseFileForm'])){
                     $loadParseFileForm->saveSettings($post_data['LoadParseFileForm']); 
                     return $this->redirect("/admink32/parse/parse");
              }
          }
         
        return $this->render('parse', [
            "model_file_parse"=>$loadParseFileForm,
            "madeSuplier"=>$madeSuplier,
            "xmlFileds"=>$xmlField,
            "tmpSet"=>$tmpSet
        ]);
    }
    
    public function actionParseParse() {
          $loadParseFileForm=new LoadParseFileForm();
         $post_data=Yii::$app->request->post();
          if(!empty($post_data)){
              if(!empty($post_data['parseProductFileReady'])){
                  if(!empty($post_data['parseProductFileReady'])){
                      $loadParseFileForm->parseXml($post_data); 
                       return $this->redirect("/admink32/parse/list-parse");
                  }
              }
          }
          return $this->redirect("/admink32/parse/parse");
    }
    public function actionParseFile() {
        $data = array();
        $post_data=Yii::$app->request->post();
        $loadParseFileForm = new LoadParseFileForm();
        if (!empty($_FILES)) {
            if ($loadParseFileForm->validate()) {
                $data = $loadParseFileForm->loadFile($_FILES,$post_data['type']);
            }
        }
        Yii::$app->response->format = 'json';
        return $data;
    }
    public function actionListParse()
    {
         $madeCompany=new MadeCompany();
         $getMadeCompany=$madeCompany->getMadeCompany();
          $sqlQueryData=new SqlQueryData;
          $madeSuplierTmp=$sqlQueryData->getMadeSuplierTmp();
          
        return $this->render('list_parse', [
            "madeCompany"=>$getMadeCompany, 
            "madeSuplierTmp"=>$madeSuplierTmp,
        ]);
    }
    public function actionCategoryTmp(){
        $data=array();
        $get_data = Yii::$app->request->get();
        $tmpProducts=new TmpProducts();
        $data['category']=$tmpProducts->getMainValueTmp(3,$get_data['suplierId']);
        $data['brand']=$tmpProducts->getMainValueTmp(1,$get_data['suplierId']);
        Yii::$app->response->format = 'json';
        return $data;
    }
    
    public function actionSearchTmp(){
        $this->layout = false;
        $resultNew=array();
        $get_data = Yii::$app->request->get();
        $sqlQueryData=new SqlQueryData;
         if($get_data['category'] && $get_data['made']){
           $data=$sqlQueryData->serachProductTmpBig($get_data);
         }else{
           $data=$sqlQueryData->serachProductTmp($get_data);
         }
         $ids='';
         foreach ($data as $key => $value) {
                    if($ids)$ids.=",";
                    $ids.=$value['articul'];
         }
         if(!empty($ids)){
            $tmpProducts=new TmpProducts();
            $data=$tmpProducts->findByIds($ids);
             foreach ($data as $key => $value) {
                $resultNew[$value['articul']][$value['typeValue']]=$value['valueProduct'];
             };
         }
        return $this->render('search_tmp', [
            "data"=>$resultNew
        ]);
    }
    
    public function actionMoveProductsTmp(){
        $this->layout = false;
        $resultNew=array();
        $dataP=array();
        $get_data = Yii::$app->request->get(); 
        $sqlQueryData=new SqlQueryData;
        $tmpProducts=new TmpProducts();
        $dataTmpProducts=$tmpProducts->findByIds($get_data['idsSet']);
        foreach ($dataTmpProducts as $key => $value) {
            $resultNew[$value['articul']][$value['typeValue']]=$value['valueProduct'];
         };
         foreach ($resultNew as $key => $value) {
          $dataP=   new \app\modules\admin\models\Pruducts();
                    $dataP->made=$get_data['made'];
                    $dataP->image=!empty($value[2])?$value[2]:"";
                    $dataP->rubricId=$get_data['rubricId'];
                    $dataP->currency=$get_data['suplierTmp'];
                    $dataP->categoryId=$get_data['category'];
                    $dataP->title=!empty($value[4])?$value[4]:"";
                    $dataP->translit=$this->setTranslit(!empty($value[4])?$value[4]:"");
                    $dataP->description=!empty($value[5])?$value[5]:"";;
                    $dataP->priceSet=!empty($value[6])?$value[6]:"";;
                    $dataP->articul=!empty($value[7])?$value[7]:"";;
           $done=   $dataP->save();
         }
         if($done){
              $sqlQueryData=new SqlQueryData();
             $sqlQueryData->setMadeCategory($get_data['rubricId'],$get_data['category'],$get_data['made']);
            $sqlQueryData->delProductsTmp($get_data['idsSet']);
             
         }
        
        
        Yii::$app->response->format = 'json';
        return $done;
    }
    
    public function actionDelProductTmp(){
        $this->layout = false;
        $get_data = Yii::$app->request->get(); 
        $sqlQueryData=new SqlQueryData;
        $ids=implode(",",$get_data['idsDel']);
        $done=$sqlQueryData->delProductsTmp($ids);
        Yii::$app->response->format = 'json';
        return $done;
    }
    
   function setTranslit($text){
        $transl=array();
        $transl['А']='a';     $transl['а']='a';
        $transl['Б']='b';     $transl['б']='b';
        $transl['В']='v';     $transl['в']='v';
        $transl['Г']='g';     $transl['г']='g';
        $transl['Д']='d';     $transl['д']='d';
        $transl['Е']='e';     $transl['е']='e';
        $transl['Ё']='yo';    $transl['ё']='yo';
        $transl['Ж']='zh';    $transl['ж']='zh';
        $transl['З']='z';     $transl['з']='z';
        $transl['И']='i';     $transl['и']='i';
        $transl['Й']='j';     $transl['й']='j';
        $transl['К']='k';     $transl['к']='k';
        $transl['Л']='l';     $transl['л']='l';
        $transl['М']='m';     $transl['м']='m';
        $transl['Н']='n';     $transl['н']='n';
        $transl['О']='o';     $transl['о']='o';
        $transl['П']='p';     $transl['п']='p';
        $transl['Р']='r';     $transl['р']='r';
        $transl['С']='s';     $transl['с']='s';
        $transl['Т']='t';     $transl['т']='t';
        $transl['У']='u';     $transl['у']='u';
        $transl['Ф']='f';     $transl['ф']='f';
        $transl['Х']='x';     $transl['х']='x';
        $transl['Ц']='c';     $transl['ц']='c';
        $transl['Ч']='ch';    $transl['ч']='ch';
        $transl['Ш']='sh';    $transl['ш']='sh';
        $transl['Щ']='shh';    $transl['щ']='shh';
        $transl['Ъ']='';     $transl['ъ']='';
        $transl['Ы']='i';    $transl['ы']='i';
        $transl['Ь']='';    $transl['ь']='';
        $transl['Э']='E';    $transl['э']='e';
        $transl['Ю']='yu';    $transl['ю']='yu';
        $transl['Я']='ya';    $transl['я']='ya';
        $transl[' ']='-';     $transl['\"']='';
        $transl['\d']='';     $transl['\'']='';
        $transl['_']='';
        $result='';
        for($i=0;$i<strlen($text);$i++) {
            if(!empty($transl[$text[$i]])) { $result.=$transl[$text[$i]]; }
            else { $result.=$text[$i]; }
        }
        return $result;
    }
    
    
    
}
