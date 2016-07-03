<?php
namespace app\managers;

use Yii;
use \yii\db\ActiveRecord;
use \yii\db\Connection;

Class QueryManager extends ActiveRecord{
    private $connection='';
      
public function init(){
    $this->connection=  new \yii\db\Connection([
      'dsn' => 'mysql:host=localhost;dbname=kochevni_new',
  //    'username' => 'kochevni_new',
  //    'password' => 'polarstarkochevni109',
      'username' => 'root',
      'password' => '111',
      'charset' => 'utf8'
  ]);
  $this->connection->open();
}    

    public function getSqlFullData($qs){
        $data=$this->connection->createCommand($qs)->queryAll();
        $this->connection->close();
         return $data;
    }
    public function updateSqlData($qs){
        $data=$this->connection->createCommand($qs)->execute();
        $this->connection->close();
         return $data;
    }

}
