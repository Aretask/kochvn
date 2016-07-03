<?php

namespace app\modules\admin\models;

use app\modules\admin\models\SqlQueryData;
use app\modules\admin\models\TmpProducts;

class LoadParseFileForm extends \yii\base\Model
{
    public $fileProduct='';
    public $made='';
    public $parseProductFile='';
    public $parseProductFileReady='';
    public $uploaddir="/home/kochevni/domains/kochevnik.com.ua/public_html/web/parsefile/";
 //   public  $uploaddir="/var/www/kochevn/web/parsefile/";


    
    public function loadFile($file_parse,$type){
        $uploadfile = $this->uploaddir.basename($file_parse['fileProduct']['name']);
        copy($file_parse['fileProduct']['tmp_name'], $uploadfile);
        if($type==1){
            $xml = simplexml_load_file($file_parse['fileProduct']['tmp_name']);
            $offers  = $xml->xpath('//offers');
            $json = json_encode($offers);
            $arrayData = json_decode($json,TRUE);
            $arrayDatas['data'] = $arrayData[0]['offer'][0];
        }else if($type==2){
            $this->parseXlsxFile($file_parse['fileProduct']['name']);
        }
        $arrayDatas['file']=$file_parse['fileProduct']['name'];
        return $arrayDatas;
    }
    
    public function saveSettings($data) {
         $sqlQueryData=new SqlQueryData;
         $data = array_diff($data, array(''));
         $sqlQueryData->setSettingsParse($data);
         return;
    }
    
    public function parseXml($data){
         $sqlQueryData=new SqlQueryData;
        $fileName=$data['parseProductFileReady'];
        $tmpSettings=new TmpSettings();
        $setingCron=$tmpSettings->getTmpSettingByFile($fileName);

   $xml = simplexml_load_file($this->uploaddir.$fileName);
   $offers  = $xml->xpath('//offers');
   $json = json_encode($offers);
   $arrayData = json_decode($json,TRUE);
    foreach ($setingCron as $typeArray) {
        $postArray['made']=$typeArray['suplier'];
        $postArray[$typeArray['value']]=$typeArray['type'];
    }
    
   foreach ($arrayData[0]['offer'] as $keyPr=>$product) {
       if(is_array($product)){
           foreach ($product as $key =>$value) {
               if(is_array($value)){
                   foreach ($value as $ky =>$valu) {
                      if(isset($postArray[$ky])){
                         $insertArray[$keyPr][$postArray[$ky]]=$valu;
                       } 
                   } 
               }else{
                 if(isset($postArray[$key])){
                     $insertArray[$keyPr][$postArray[$key]]=trim($value);
                }   
               }
           } 
       }
   }
   $data_set=array();
   $num=0;
   //  $db = mysql_connect ("localhost","root","111");
    $db = mysql_connect ("127.0.0.1","kochevni_new","polarstarkochevni109");
     mysql_set_charset('utf8',$db);
    mysql_select_db ("kochevni_new",$db);
  do{
   foreach ($data_set as $key => $value) {
      foreach ($value as $type => $val) {
      $qs="INSERT INTO kochevni_new.tmpProducts SET articul= '".($key+($num*100))."', valueProduct='".addslashes($val)."',typeValue='$type',suplierProduct=".$postArray['made'];
      $done= mysql_query($qs,$db);
      } 
   };
   $num++;
   $offset=$num*100;
   sleep(1); 
  }while($data_set=array_slice($insertArray, $offset, 100));
   

   if($done){
     $sqlQueryData->updateSettings($fileName);
     @unlink($this->uploaddir.$fileName);
   }
   return $done;
        
    }
    
    private function  parseXlsxFile($file){
        $inputFile = $this->uploaddir.$file;
        $dir = $this->uploaddir."tmp/";
// Unzip
$zip = new \ZipArchive();
$zip->open($inputFile);
$zip->extractTo($dir);
// Open up shared strings & the first worksheet
$strings = simplexml_load_file($dir . '/xl/sharedStrings.xml');

$sheet   = simplexml_load_file($dir . '/xl/worksheets/sheet1.xml');
// Parse the rows
$xlrows = $sheet->sheetData->row;
echo "<pre>";
print_r($xlrows);
echo "</pre>";
die('+++');
foreach ($xlrows as $xlrow) {
    $arr = array();
    echo "<pre>";
    print_r($xlrow);
    echo "</pre>";
    die('+++');
    // In each row, grab it's value
    foreach ($xlrow->c as $cell) {
        $v = (string) $cell->v;
        
        // If it has a "t" (type?) of "s" (string?), use the value to look up string value
        if (isset($cell['t']) && $cell['t'] == 's') {
            $s  = array();
            $si = $strings->si[(int) $v];
            
            // Register & alias the default namespace or you'll get empty results in the xpath query
            $si->registerXPathNamespace('n', 'http://schemas.openxmlformats.org/spreadsheetml/2006/main');
            // Cat together all of the 't' (text?) node values
            foreach($si->xpath('.//n:t') as $t) {
                $s[] = (string) $t;
            }
            $v = implode($s);
        }
        
        $arr[] = $v;
    }
    // Assuming the first row are headers, stick them in the headers array
    if (count($headers) == 0) {
        $headers = $arr;
    } else {
    echo "<pre>";
    print_r($arr);
    echo "</pre>";
    die('+++');
        // Combine the row with the headers - make sure we have the same column count
        $values = array_pad($arr, count($headers), '');
        $row    = array_combine($headers, $values);
        echo "<pre>";
        print_r($row);
        echo "</pre>";
        die('+++');
        /**
         * Here, do whatever you like with the [header => value] assoc array in $row.
         * It might be useful just to run this script without any code here, to watch
         * memory usage simply iterating over your spreadsheet.
         */
    }
}
@unlink($dir);
@unlink($inputFile);
    }
}
?>