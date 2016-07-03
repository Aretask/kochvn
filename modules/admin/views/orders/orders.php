  <?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\bootstrap\ActiveForm;

$this->title = 'Cписок заказов';
$this->params['breadcrumbs'][] = $this->title;
//$this->params['breadcrumbs'][] = ['label' => 'Employees', 'url' => ['index']];
?>

    <?= Breadcrumbs::widget([
            'homeLink' => [ 
                      'label' => Yii::t('yii', 'Список покупателей'),
                      'url' => '/admink32/orders/buyers/',
                 ],
           'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>

 <div class="row row-offcanvas row-offcanvas-right">
           <div id="good" style="margin-top:20px"class="alert alert-success hide" role="alert">Заказ помечен как обработанный</div>
           <h3 id="glyphicons-glyphs">Cписок заказов</h3>
      
   <table class="table table-hover">
          <thead>
            <tr>
              <th>#</th>
              <th>Товары</th>
              <th>Заказчик</th>
              <th>Статус</th>
            </tr>
          </thead>
          <tbody>
              <?php foreach($data_item as $index =>$prod) {;?>
            <tr>
              <th scope="row"><?= $index; ?></th>
              <td> 
                   <?php foreach($prod as $product) {;?>
              <div class="row">
              <div class="col-md-8">
                  <a target="_blank" href="/item/<?= $product['translit'] ;?>_<?= $product['productId'];?>.html" >
                                                          <?= $product['title'];?>
                  </a>
                  <div class="row">
                    <div class="col-md-8">.<img  style="height:70px" src="<?php if($product['image']){ ;?><?= $product['image'];?><?php }else{ ;?>/images/nopoto.gif<?php };?>"  title="<?= $product['title'];?>"/></div>
                    <div class="col-md-4"><p>Количество:<?= $product['countItem']; ?><br>Цена:<?= $product['price'];?> <br> Всего:<?= $product['priceTottal'];?></p></div>
                  </div>


             </div>
                <div class="col-md-4">
                    <?php if(!empty($product['filter'])) {?>
                     <?php foreach($product['filter'] as $filter) {;?>
                                     <label class="checkbox  filter">
                                        <?= $filter['nameItem']; ?>
                                     </label>
                                     <?php };?>
                                     <?php };?>
                </div>

                </div>
                <hr>
                            <?php };?></td>
              <td>
              <p> <strong>Имя:</strong><?= $data_item[$index][0]['name'] ;?></p>
                         <strong>Телефон:</strong>  <?= $data_item[$index][0]['phone'];?><br>
                       <strong>Почта:</strong>    <?= $data_item[$index][0]['email'];?><br>
                        <?php if($data_item[$index][0]['statusBuyer'] ==1){ ?>
                           <br><storng style="color:red">Осторожно в черном списке</strong>
                        <?php };?>
                           </td>
              <td>
             <strong> Дата заказа:</strong><br> <?= $data_item[$index][0]['dateOrder'];?><br>
              <?php if($data_item[$index][0]['status'] ==1){ ?>
                                             <storng style="color:red">Нужна обработка</strong><br>
                                              <div  idBuyer="<?= $index;?>" class="btn btn-primary completeorder">Готово</div>
                                             <?php }else if ($data_item[$index][0]['status'] ==2){ ?>
<br><storng style="color:green">Обработано</strong>
                                             <?php } ;?>

                                             </td>
            </tr>
 <?php };?>
          </tbody>
        </table>

      </div><!--/row-->
      
 