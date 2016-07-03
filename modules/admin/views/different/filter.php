
<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\bootstrap\ActiveForm;

$this->title = 'Настройка фильтров';
$this->params['breadcrumbs'][] = $this->title;
?>
    <?= Breadcrumbs::widget([
            'homeLink' => [ 
                      'label' => Yii::t('yii', 'Основной конфиг'),
                      'url' => '/admink32/main/',
                 ],
           'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>

<div class="row row-offcanvas row-offcanvas-right" id="categoryChange">
     <h3 id="glyphicons-glyphs">Настройка фильтров</h3>
                  <?php
              if (!empty($_GET['done'])) {
                  if ($_GET['done'])
                      echo '<div style="margin-top:20px"class="alert alert-success" role="alert">Все успешно сохранилось</div>';
              }
          ?>
 <div class="form-group">
        <?php   $form = ActiveForm::begin([
                'id' => 'formFilter',
                'method' => "post",
                "action" => "/admink32/different/filter",
                'options' => ['class' => 'form-horizontal'],
            ])
          ?>
                    <div class="row">
                        <label class="col-sm-1">Фильтр:</label>
                        <div class="col-sm-2">
                            <select class="form-control " name="AddFilterForm[filter]" onchange="showText(this,'')">
                                <option value="">Выбрать</option>
                                <?php
                                foreach ($filters as $key => $value) {
                                    echo '<option value="' . $value['filterId'] . '">' . $value['nameFilter'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <?= Html::activeTextInput($model, 'filter_name', ["class" => "form-control","required"=>"required"]) ?>
                        </div>
                        <div class="col-sm-2">
                            <?= Html::submitButton('Редактировать', ['class' => 'btn btn-default redug',
                                "disabled"=>"disabled","name"=>"AddFilterForm[redug]","value"=>"1"]) ?>
                        </div>
                        <div class="col-sm-2">
                                <?= Html::submitButton('Добавить', ['class' => 'btn btn-default add',
                                "name"=>"AddFilterForm[add]","value"=>"1"]) ?>
                        </div>
                    </div>
               <?php ActiveForm::end() ?>
            </div>
           
            <div class="form-group">
                      <?php   $form = ActiveForm::begin([
                'id' => 'formFilterItem',
                'method' => "post",
                "action" => "/admink32/different/filter",
                'options' => ['class' => 'form-horizontal'],
            ])
          ?>
                   <?= Html::activeHiddenInput($model, 'filterItem',["id"=>"filterItem"]) ?>
                    <div class="row">
                        <label class="col-sm-1">Параметры фильтра:</label>
                        <div class="col-sm-2">
                            <select class="form-control " id="filter_item" name="AddFilterForm[filter_item]" onchange="showText(this,'item_')">>
                                <option value="">Выбрать</option>
                            </select>
                        </div>
                        <div class="col-sm-2">
                             <?= Html::activeTextInput($model, 'filter_item_name', ["class" => "form-control","required"=>"required"]) ?>
                        </div>
                        <div class="col-sm-2">
                                <?= Html::submitButton('Редактировать', ['class' => 'btn btn-default redug',
                                "disabled"=>"disabled","name"=>"AddFilterForm[redug]","value"=>"2"]) ?>
                        </div>
                        <div class="col-sm-2">
                             <?= Html::submitButton('Добавить', ['class' => 'btn btn-default add',
                                "name"=>"AddFilterForm[add]","value"=>"2"]) ?>
                        </div>
                    </div>
                    <?php ActiveForm::end() ?>

            </div>
           

  </div>
    <script>
      function showText(elem,item){
        var parent=$(elem).parent().parent();
        if($(elem).val()){
          var text=$(elem).find('option:selected').text();
          parent.find('[name="AddFilterForm[filter_'+item+'name]"]').val(text);  
          parent.find('.redug').attr('disabled',null);  
          parent.find('.add').attr('disabled','disabled');  
        }else{
          parent.find('[name="AddFilterForm[filter_name]"]').val(''); 
          parent.find('.redug').attr('disabled','disabled');  
          parent.find('.add').attr('disabled',null);  
          $('#formFilterItem').find('[name="AddFilterForm[filter_item_name]"]').val(''); 
          $('#formFilterItem').find('.redug').attr('disabled','disabled'); 
          $('#formFilterItem').find('.add').attr('disabled',null);
        }
        if(!item && $(elem).val()){
             $.ajax({
            method: "GET",
            url: "/admink32/products/get-filter",
            data: {filter:$(elem).val()},
            dataType: "json"
        })
            .done(function(response) {
                $('#filter_item').empty();
                $('#filter_item').append("<option value=''>Выбрать</option>");
                response.forEach(function(item){
                $('#filter_item').append("<option value='"+item.idItem+"'>"+item.nameItem+"</option>");
                })
                $('#filterItem').val($(elem).val());
            });
        }
        if(!$(elem).val()){
                $('#filter_item').empty();
                $('#filter_item').append("<option value=''>Выбрать</option>");
                $('#filterItem').val("");
        }
      }
    </script>