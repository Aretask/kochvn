
<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\bootstrap\ActiveForm;

$this->title = 'Настройка брендов  и поставщиков';
$this->params['breadcrumbs'][] = $this->title;
?>
    <?= Breadcrumbs::widget([
            'homeLink' => [ 
                      'label' => Yii::t('yii', 'Основной конфиг'),
                      'url' => '/admink32/main/',
                 ],
           'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>

<div class="row row-offcanvas row-offcanvas-right">
     <h3 id="glyphicons-glyphs">Настройка брендов</h3>
              <?php
              if (!empty($_GET['done'])) {
                  if ($_GET['done'] == 1)
                      echo '<div style="margin-top:20px"class="alert alert-success" role="alert">Все успешно сохранилось</div>';
                  if ($_GET['done'] == 2)
                      echo '<div style="margin-top:20px"class="alert alert-success" role="alert">Все успешно сохранилось и пересчиталось</div>';
                  if ($_GET['done'] == 'err')
                      echo '<div style="margin-top:20px"class="alert alert-danger" role="alert">При добавлении бренда фото обязательно</div>';
              }
          ?>
     <div class="row">
             <?php
    $form = ActiveForm::begin([
                'id' => 'madeForm',
                'method' => "post",
                "action" => "/admink32/different/course",
                'options' => ["enctype" => "multipart/form-data", 'class' => 'form-horizontal'],
            ])
    ?>
   <?= Html::activeHiddenInput($model, 'madeBrend',["id"=>"madeBrend"]) ?>
    <div class="row">
  <div class="col-xs-2">
       <label class="col-sm-12">Фото (78x45)</label>
    <?= Html::activeFileInput($model, 'imageMade', ["class" => "form-control"]) ?>
  </div>
  <div class="col-xs-2">
       <label class="col-sm-2">Название</label>
         <?= Html::activeTextInput($model, 'made[nameCompany]', ["required" => "required","placeholder"=>"Маде", "id" => "nameCompany", "class" => "form-control", "onblur" => "checkAllow(this,'brand')"]) ?>
  </div>
  <div class="col-xs-2">
        <label class="col-sm-2">Транслит</label>
      <?= Html::activeTextInput($model, 'made[eng]', ["required" => "required","placeholder"=>"made", "id" => "eng", "class" => "form-control"]) ?>
  </div>
  </div>
       
  <div class="col-xs-1" >
            <br>
            <?= Html::submitButton('Добавить', ['class' => 'btn btn-default',"id"=>"company_add"]) ?>
</div>
</div><br>
<?php ActiveForm::end() ?>
  </div>
<br>
<div class="row">
            <label class="col-sm-1">Бренд:</label>
                        <div class="col-sm-2">
                            <select  id="made"class="form-control" name="made" onchange="showImg(this)">
                                <option value="0">Выбрать</option>
                                <?php
                                                     
                                foreach ($madeCompany as $key => $value) {
                                    echo '<option ig="'.$value['imageMade'].'" eng="'.$value['eng'].'" value="' . $value['idCompany'] . '">' . $value['nameCompany'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
    <div class="col-xs-1">
        <img id="imageBrend"style="height:45px" src="" >
    </div>
   
    <div class="col-xs-1">
        <button type="button" id="editMade" disabled  class="btn btn-default">Редактировать</button>
    </div>
</div>

    <hr>
    <h3 id="glyphicons-glyphs">Добавление/Редактирование поставщиков</h3>
     <div class="row">
   <?php          $form1 = ActiveForm::begin([
                'id' => 'brandForm',
                'method' => "post",
                "action" => "/admink32/different/course",
                'options' => ['class' => 'form-horizontal']
            ]);
    ?>
                <?= Html::activeHiddenInput($model, 'idSuplier',["id"=>"idSuplier"]) ?>
  <div class="col-xs-4">
       <label id="catBrend">Название поставщика</label>
          <?= Html::activeTextInput($model, 'nameSuplier', ["required"=>"required","class" => "form-control","id"=>"nameSuplier"]) ?>
  </div>
               
  <div class="col-xs-4">
       <label id="catBrend">Курс</label>
       <?= Html::activeTextInput($model, 'curenccy', ["required"=>"required","class" => "form-control","id"=>"curenccy"]) ?>
  </div>
              <div class="col-xs-1">
                  <br>
             <?= Html::submitButton('Добавить', ['class' => 'btn btn-default',"id"=>"addSuplier"]) ?>
              </div>
              <div class="col-xs-2">
                  <br>
                   <?= Html::submitButton('Сохранить/Пересчитать', ["name"=>"AddMadeForm[recount]",'class' => 'btn btn-default',"value"=>"1","id"=>"recountPrice","disabled"=>"disabled"]) ?>
              </div>
          <?php  ActiveForm::end() ?>
  </div><br>
    <div class="row">
            <label class="col-sm-1">Поставщики:</label>
                        <div class="col-sm-2">
                            <select   id="suplier"class="form-control" name="made" onchange="editSuplier(this)">
                                <option value="0">Выбрать</option>
                                <?php
                                                     
                                foreach ($madeSuplier as $key => $value) {
                                    echo '<option cur="' . $value['curenccy'] . '" value="' . $value['idSuplier'] . '">' . $value['nameSuplier'] . ' </option>';
                                }
                                ?>
                            </select>
                           
                        </div>

</div>
  </div>

    <script>
        function showImg(elem){
            if($(elem).val()!=0){
                $('#editMade').attr('disabled',null); 
                var select=$(elem).find('option:selected');
                var img= select.attr('ig');
                var name= select.attr('nm');
                $('#imageBrend').attr('src','http://kochevn'+img); 
            }else{
                $('#company_add').text('Добавить');
                $('#imageBrend').attr('src',''); 
                $('#madeBrend').val(0); 
                $('#editMade').attr('disabled','disabled');  
            }
            
        }
        function editSuplier(elem){
         if($(elem).val()!=0){
            $('#recountPrice').attr('disabled',null);    
            $('#addSuplier').attr('disabled','disabled');    
            $('#editSuplier').attr('disabled',null); 
            $('#idSuplier').val($('#suplier').val());
            var select=$('#suplier option:selected' );
            $('#nameSuplier').val(select.text());
            $('#curenccy').val(select.attr('cur'));
        }else{
            $('#recountPrice').attr('disabled','disabled'); 
            $('#addSuplier').attr('disabled',null); 
            $('#nameSuplier').val('');
            $('#curenccy').val('');
            $('#idSuplier').val('');
            $('#editSuplier').attr('disabled','disabled');  
        }
        }
      
    </script>