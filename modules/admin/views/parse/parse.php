
<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\bootstrap\ActiveForm;

$cur = 0;

$this->title = 'Распарсить фаил';
$this->params['breadcrumbs'][] = ['label' => 'Список товара', 'url' => ['/admin/products/list/']];
$this->params['breadcrumbs'][] = ['label' => 'Список распаресенного товара', 'url' => ['/admin/parse/list-parse/']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?=
Breadcrumbs::widget([
    'homeLink' => [
        'label' => Yii::t('yii', 'Добавление/Редактирование товара'),
        'url' => '/admink32/products/add/',
    ],
    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
])
?>

<div class="row row-offcanvas row-offcanvas-right">
    <img id="spiner"class="spinner hide" src="/images/spinner.gif"/>
    <h3 id="glyphicons-glyphs">Добавления товара из файла</h3>
      <?php  $form = ActiveForm::begin([
                    'id' => 'parseFile',
                    'options' => ["enctype" => "multipart/form-data", 'class' => 'form-horizontal'],
                ])
        ?>
    
<div class="row">
       <label class="col-sm-1">Фаил</label>
  <div class="col-xs-2">
      <?= Html::activeFileInput($model_file_parse, "fileProduct", ["id"=>"fileProduct","class" => "form-control"]) ?>
  </div>
  <div class="col-xs-2">
      <select id="typeFile" class="form-control" >
          <option value="1">Arnika</option>
          <!--<option value="2">SportTop</option>-->
      </select>
  </div>
 <?= Html::submitButton('Загрузить', ['class' => 'btn btn-default add']) ?>
     </div>
</form>
      <br>
            <?php  $form = ActiveForm::begin([
                    'id' => 'createFile',
                    'action' =>"/admink32/parse/parse",
                    'method' => "post",
                    'options' => ['class' => 'form-horizontal hide'],
                ])
        ?>
      <?= Html::activeHiddenInput($model_file_parse, 'parseProductFile',['id'=>"parseProductFile"]) ?>
              <div class="row">
            <label class="col-sm-1">Поставщики:</label>
                        <div class="col-sm-2">
                            <select required  id="suplier"class="form-control" name="LoadParseFileForm[made]" >
                                <option value="">Выбрать</option>
                                <?php
                                foreach ($madeSuplier as $key => $value) {
                                    echo '<option cur="' . $value['curenccy'] . '" value="' . $value['idSuplier'] . '">' . $value['nameSuplier'] . ' </option>';
                                }
                                ?>
                            </select>
                           
                        </div>
            <div class="col-sm-2">
                <a target="_blank"href="/admin/different/course"> 
        <button style="margin-left:400px" type="button" class="btn btn-default add">Добавить Поставщика</button>
    </a></div><br>

</div>
          
      <div id="parseProduct">
  
      </div>
           <?= Html::submitButton('Создать', ['class' => 'btn btn-default']) ?>
      </form>
      
      
                  <div class="col-xs-4 hide"  id="cloneSelect">
                  <select class="form-control  selectType">
                      <option value="">Ничего</option>
                       <?php
                                foreach ($xmlFileds as $key => $value) {
                                    echo '<option  value="' . $value['id'] . '">' . $value['name'] . ' </option>';
                                }
                                ?>
                  </select>
          </div> 
       <?php foreach ($tmpSet as $key => $value) { ?>
      <div class="row">
          <form id="parseReady">
              <input type="hidden" name="parseProductFileReady" value="<?php echo $value->fileName ?>" >
          <div class="col-sm-2"><?php echo $value->fileName ?></div>
          <div class="col-sm-2"><?php echo $value->addDate ?></div>
          <div class="col-sm-2">
              <button type="submit">Распарсить</button>
          </div>
          </form>
      </div>
      <?php }?>
</div>
   