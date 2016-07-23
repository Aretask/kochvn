<?php
namespace app\modules\admin\models;

use app\managers\QueryManager;
use \yii\base\Model;

Class SqlQueryData extends \yii\base\Model{
    
   public function getFilterProduct($id){
        $queryManager=new QueryManager;
      $query="SELECT * FROM kochevni_new.filterProduct as fp
             INNER JOIN kochevni_new.filterItem as fi ON fp.filter=fi.idItem
             INNER JOIN kochevni_new.filter as f ON fi.filterId=f.filterId
             WHERE fp.productId =".$id;
          return $queryManager->getSqlFullData($query); 
   }
   
   public function getOrderProducts(){
       $queryManager=new QueryManager;
          $qs=" SELECT p.*,b.*,o.*, DATE_FORMAT(o.addDate,'%Y-%m-%d %H:%i:%s') as dateOrder" .
            " FROM kochevni_new.orders as o".
            " LEFT JOIN kochevni_new.pruducts as p ON o.productId=p.productId".
            " LEFT JOIN kochevni_new.buyers as b ON o.idBuyer=b.idBuyer".
            " WHERE  o.status=1 ORDER BY o.addDate DESC ";
      return $queryManager->getSqlFullData($qs);
   }
   public function getFilterItem($filter){
        $queryManager=new QueryManager;
        $qs="SELECT * FROM kochevni_new.filterItem WHERE idItem IN ('".$filter."')";
         return $queryManager->getSqlFullData($qs);
       
   }
   public function updateOrderStatus($idbuyer){
        $queryManager=new QueryManager;
         $qs='UPDATE kochevni_new.orders SET status=2  WHERE status=1 AND idBuyer='.$idbuyer;
         return $queryManager->updateSqlData($qs);
       
   }
   public function searchProduct($data){
        $queryManager=new QueryManager;
        $result=array();
        $field=array(
            'suplier'=>'currency',
            'category'=>'categoryId',
            'productId'=>'productId'
        );
        $where="";
        foreach ($field as $key => $value) {
           if($data[$key]){
                if($where) $where.=" AND ";
                $where.="p.".$value."=".$data[$key];
            }  
        };
        $page=(int) $data['page'];
        if($page<2){
            $page=0;
        }else{
            $page--;
        };
        $page=$page*10;
        $result['page']=$page;
        $limit=' LIMIT '.$page.', 10';
        $qs='SELECT p.productId,p.title ,p.price,p.priceSet, p.status, m.nameSuplier,
            m.curenccy,c.name,GROUP_CONCAT(fi.nameItem) as filter' .
            ' FROM kochevni_new.pruducts as p '.
            ' LEFT JOIN kochevni_new.filterProduct as fp ON p.productId=fp.productId '.
        ' LEFT JOIN kochevni_new.filterItem as fi ON fp.filter=fi.idItem '.
        ' INNER JOIN kochevni_new.madeSuplier as m ON p.currency=m.idSuplier '.
        ' INNER JOIN kochevni_new.categories as c ON p.categoryId=c.categoryId '.
        ' WHERE '.$where.' GROUP BY p.productId ORDER BY p.dateAdd DESC '.$limit;
        $result['data']=$queryManager->getSqlFullData($qs);
        $qscount='SELECT count(p.productId) as count' .
                    ' FROM kochevni_new.pruducts as p '.
                    ' WHERE '.$where ;
        $result['total']=$queryManager->getSqlFullData($qscount);
        return $result;
       
   }
   
   public function  getSuplierCurrency($idsSet) {
        $queryManager=new QueryManager;
        $qs="SELECT m.idSuplier,m.curenccy FROM kochevni_new.pruducts as p" .
            " INNER JOIN kochevni_new.madeSuplier as m ON p.currency=m.idSuplier" .
            " WHERE p.productId IN(".$idsSet.") GROUP BY m.idSuplier ";
        return $queryManager->getSqlFullData($qs);
   }
   
   public function delProductsTable($ids){
       $ids=implode(",",$ids);
        $queryManager=new QueryManager;
          $table=['pruducts','photoProducts','productSpecifications','filterProduct'];
          foreach ($table as $value) {
           $qs='DELETE FROM  kochevni_new.'.$value.'  WHERE productId IN('.$ids.')';
           $queryManager->updateSqlData($qs);
        
          }
          return true;
   }
   
   public function setSettingsParse($data){
       if(!empty($data)){
            $queryManager=new QueryManager;
             foreach ($data as $key => $type) {
                if ($key != 'parseProductFile' && $key != 'made') {
                    $qs = "INSERT INTO kochevni_new.tmpSettings SET addDate=now(),fileName='" .
                            $data['parseProductFile'] . "',suplier='" . $data['made'] . "',
                 value='$key', type='$type'";
                    $queryManager->updateSqlData($qs);
                }
            }
            return true;
           }
           return false;
       
   }
   
   public function updateSettings($file_name){
       if(!empty($file_name)){
            $queryManager = new QueryManager;
            $qs = "UPDATE  kochevni_new.tmpSettings SET status=1 WHERE fileName='$file_name'";
            $queryManager->updateSqlData($qs);
       }
   }
   
   public function getMadeSuplierTmp(){
         $queryManager = new QueryManager;
         $qs="SELECT ts.* FROM kochevni_new.madeSuplier  as ts
            INNER JOIN  kochevni_new.tmpProducts as ms ON ts.idSuplier=ms.suplierProduct
            GROUP BY ms.suplierProduct";
         return $queryManager->getSqlFullData($qs);
       
   }
   
   public function serachProductTmpBig($data){
        $queryManager = new QueryManager;
         $qs="SELECT p.articul,count(p.articul) as d".
        " FROM kochevni_new.tmpProducts as p".
        " WHERE p.suplierProduct=".$data['suplier']."  AND valueProduct IN ('".$data['category']."','".$data['made']."')".
        " GROUP BY p.articul  HAVING d>1 LIMIT 30"; 
        return $queryManager->getSqlFullData($qs);
   }
   public function serachProductTmp($data){
        $queryManager = new QueryManager;
         $field=[
            'suplier'=>'suplierProduct',
            'category'=>'valueProduct',
            'made'=>'valueProduct'
        ];
        $where="";
        foreach($field as $key=>$value){
            if(!empty($data[$key])){
                if(!empty($where)) $where.=" AND ";
                $where.="p.".$value."='".$data[$key]."'";
            }
        };
        $qs="SELECT p.articul ".
        " FROM kochevni_new.tmpProducts as p".
        " WHERE ".$where." GROUP BY p.articul  LIMIT 30";
        return $queryManager->getSqlFullData($qs);
   }
   
   public function delProductsTmp($ids){
       $queryManager = new QueryManager;
          $qs="DELETE  FROM kochevni_new.tmpProducts ".
            " WHERE articul IN (".$ids.")";
       return  $queryManager->updateSqlData($qs);
   }
   
   public function recountPrice($data){
       if(!empty($data)){
            $queryManager = new QueryManager;
        $qs="UPDATE kochevni_new.pruducts SET price=priceSet*".$data['curenccy']
                .", priceAction=actionPriceSet*".$data['curenccy']." WHERE currency=".$data['idSuplier']; 
        return  $queryManager->updateSqlData($qs); 
           
       }
   }
   
   public function setMadeCategory($rub,$cat,$made){
        $queryManager = new QueryManager;
       $qs="INSERT IGNORE INTO kochevni_new.madeCategory SET rubricId={$rub},categoryId={$cat},idCompany={$made}";
       return  $queryManager->updateSqlData($qs); 
   }
   
   

 
}
