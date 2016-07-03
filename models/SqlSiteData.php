<?php
namespace app\models;

use app\managers\QueryManager;

Class SqlSiteData extends \yii\base\Model{
    
    public function getMenu(){
       $queryManager=new QueryManager;
       $qs="SELECT kr.rubricId,kr.eng as engr, kc.eng, kr.name as rubric, kc.name as category,kc.categoryId".
               " FROM kochevni_new.categories as kc".
               " LEFT JOIN kochevni_new.rubrics as kr ON kc.rubricId=kr.rubricId ORDER BY kc.orderCat";
          return $queryManager->getSqlFullData($qs); 
        
    }
    public function getMadeCategory($rubric,$category=0){
       $queryManager=new QueryManager;
       $where='';
       if(!empty($rubric)){
         $where='WHERE mc.rubricId = '.$rubric;
       }
       if(!empty($category)){
           $where.=' AND mc.categoryId='.$category;
       }
       $qs="SELECT mk.* ".
               " FROM kochevni_new.madeCategory as mc".
               " INNER JOIN kochevni_new.madeCompany as mk ON mc.idCompany=mk.idCompany".
               " {$where} GROUP BY mk.idCompany ORDER BY mk.nameCompany";
               return $queryManager->getSqlFullData($qs); 
        
    }
    
      public function getFilterCategory($category,$made=0){
       $queryManager=new QueryManager;
       $where=' p.categoryId = '.$category;
       if(!empty($made)){
           $where.=' AND p.made='.$made;
       }
       $qs="SELECT fi.*,f.nameFilter FROM kochevni_new.filterProduct as p
            INNER JOIN kochevni_new.filterItem as fi ON p.filter=fi.idItem
            INNER JOIN kochevni_new.filter as f ON fi.filterId=f.filterId
            where {$where}";
          return $queryManager->getSqlFullData($qs); 
        
    }
    
    public function getProductInfo($product_id){
        if(!empty($product_id)){
              $queryManager=new QueryManager;
             $qs="SELECT p.*,c.name as cat_name,c.eng as cat_eng,
                  r.name as rub_name,r.eng as rub_eng,m.* 
                  FROM kochevni_new.pruducts as p
                  INNER JOIN kochevni_new.categories as c ON p.categoryId=c.categoryId
                  INNER JOIN kochevni_new.rubrics as r ON p.rubricId=r.rubricId 
                  INNER JOIN kochevni_new.madeCompany as m ON p.made=m.idCompany 
                  WHERE p.productId={$product_id}";
          return $queryManager->getSqlFullData($qs);  
        }else{
            return array();
        }
        
    }
    
    public function getProductFilter($product_id){
        if(!empty($product_id)){
            $queryManager=new QueryManager;
            $qs="SELECT fi.*,f.* FROM kochevni_new.filterProduct as fp
                INNER JOIN kochevni_new.filterItem as fi ON fp.filter=fi.idItem
                INNER JOIN kochevni_new.filter as f ON fi.filterId=f.filterId
                WHERE fp.productId={$product_id}";
           return $queryManager->getSqlFullData($qs);  
        }else{
           return array(); 
        }
        
    }
    
    public function getOrdersUser($indent) {
        if (!empty($indent)) {
            $queryManager = new QueryManager;
            $qs = " SELECT p.*,o.filterOrder,o.orderId,o.indent,o.countItem" .
                    " FROM kochevni_new.orders as o" .
                    " LEFT JOIN kochevni_new.pruducts as p ON o.productId=p.productId" .
                    " WHERE o.indent=" . $indent . " AND o.status=0";
             return $queryManager->getSqlFullData($qs); 
        } else {
            return array();
        }
    }
    
        public function getFilterNamesByIds($item_ids){
        if(!empty($item_ids)){
            $queryManager=new QueryManager;
            $qs="SELECT fi.*,f.* FROM  kochevni_new.filterItem as fi 
                INNER JOIN kochevni_new.filter as f ON fi.filterId=f.filterId
                WHERE fi.idItem IN ({$item_ids})";
           return $queryManager->getSqlFullData($qs);  
        }else{
           return array(); 
        }
        
    }
    
    public function setUserData($user_data){
        if(!empty($user_data)){
            $queryManager=new QueryManager;
            $qs="INSERT  INTO  kochevni_new.buyers  SET name='".$user_data['nameBuyer']."',
             phone=".$user_data['phoneBuyer'].", email='".$user_data['mailBuyer']."',
             fPhone='".$user_data['phoneBuyerf']."',addDate=now() ON DUPLICATE KEY UPDATE ".
            " name='".$user_data['nameBuyer']."', email='".$user_data['mailBuyer']."',addDate=now()";
            $queryManager->updateSqlData($qs);  
            $qs_get="SELECT idBuyer FROM kochevni_new.buyers WHERE phone=".$user_data['phoneBuyer'];
            return  $queryManager->getSqlFullData($qs_get);  
        }else{
           return array(); 
        }
    }
    
    public function getProductsFilter($data_search,$count,$limit,$page){
        $gallery_date=array();
        $queryManager=new QueryManager;
         $from=$page*$limit;
         $limit_sql=" ORDER BY p.dateAdd DESC LIMIT ".$from.",".$limit;
         $qs="SELECT SQL_CALC_FOUND_ROWS fp.filter,p.*,count(p.productId) as c, mc.imageMade".
            " FROM kochevni_new.pruducts as p ".
            " INNER JOIN kochevni_new.madeCompany as mc ON p.made=mc.idCompany".
            " INNER JOIN kochevni_new.filterProduct as fp ON p.productId=fp.productId".
            " WHERE p.categoryId =".$data_search['category'].
                    (!empty($data_search['brand_id'])?" AND p.made='".$data_search['brand_id']."'":"").
            " AND  fp.filter IN (".$data_search['filters'].")".
            " GROUP BY p.productId HAVING c=".$count.$limit_sql;
        $data= $queryManager->getSqlFullData($qs); 
        $count= count($queryManager->getSqlFullData($qs));
        $made = '';
        if($count!=0){
            foreach ($data as $key => $value) {
                $gallery_date[$key]['title'] = $value['title'];
                $gallery_date[$key]['image'] = $value['image'];
                $gallery_date[$key]['price'] = $value['price'];
                $gallery_date[$key]['priceAction'] = $value['priceAction'];
                $gallery_date[$key]['translit'] = $value['translit'];
                $gallery_date[$key]['productId'] = $value['productId'];
                $gallery_date[$key]['made'] = $value['made'];
                if ($made)
                    $made.=",";
                $made.=$value['made'];
            }
        }
        return array('data'=>$gallery_date,'total'=>$count,'made'=>$made);
    }

    
} 
