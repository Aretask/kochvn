<?php

namespace app\modules\admin\models;

use app\modules\admin\models\MadeCompany;
use app\modules\admin\models\MadeSuplier;
use app\modules\admin\managers\ResizeCrop;
use app\modules\admin\models\SqlQueryData;

class AddMadeForm extends \yii\base\Model
{
    public $madeBrend='';
    public $imageMade='';
    public $made='';
    public $curenccy='';
    public $nameSuplier='';
    public $recount='';
    public $idSuplier='';

    public function rules()
    {
        return [

        ];
    }
    
    public function saveMade($data){
     $imageMade = $_FILES['AddMadeForm'];
     if(!empty($data['madeBrend']) && $data['madeBrend']!=0){
        $company=  MadeCompany::findOne($data['madeBrend']);
        $company->nameCompany=$data['made']['nameCompany'];
        $company->eng=$data['made']['eng'];
        $company->update();
     }else{
        $company=new MadeCompany();
        $company->nameCompany=$data['made']['nameCompany'];
        $company->eng=$data['made']['eng'];
        $company->save();
        $data['madeBrend'] = \Yii::$app->db->getLastInsertID();
     }
     
      if($imageMade['size']['imageMade']!=0){
          $photoSet='';
          $uploaddir = '/home/kochevni/domains/kochevnik.com.ua/public_html/web/images/brand/';
          $uploadfile = $uploaddir . basename($imageMade['name']['imageMade']);
          $photoUrl = '/images/brand/' . basename($imageMade['name']['imageMade']);
          $resizeCrop=new ResizeCrop();
          $resizeCrop->resize($imageMade['tmp_name']['imageMade'], $uploadfile, 78, null);
          $company=  MadeCompany::findOne($data['madeBrend']);
          $company->imageMade=$photoUrl;
          $company->update();
      }
       
        return true;
    }
    
    public function saveBrend($data) {
        if ($data['idSuplier'] != 0) {
            $suplier = MadeSuplier::findOne($data['idSuplier']);
            $suplier->dateEdit = date('Y-m-d');
            $suplier->nameSuplier = $data['nameSuplier'];
            $suplier->curenccy = $data['curenccy'];
            $suplier->update();
            $done = 1;
            if (!empty($data['recount']) && $data['recount'] == 1) {
                $recount = new SqlQueryData();
                $recount->recountPrice($data);
                $done = 2;
            }
        } else {
            $made_suplier = new MadeSuplier();
            $made_suplier->nameSuplier = $data['nameSuplier'];
            $made_suplier->curenccy = $data['curenccy'];
            $made_suplier->save();
             $done = 1;
        }
        return $done;
    }
    
 
    
}
