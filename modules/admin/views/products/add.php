<style>
    .copy{
        margin-left:5px;
    }
</style>
<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\bootstrap\ActiveForm;

$cur = 0;

$this->title = 'Добавление/Редактирование товара';
$this->params['breadcrumbs'][] = ['label' => 'Распарсить фаил', 'url' => ['/admin/parse/parse/']];
$this->params['breadcrumbs'][] = ['label' => 'Список распаресенного товара', 'url' => ['/admin/parse/list-parse/']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?=
Breadcrumbs::widget([
    'homeLink' => [
        'label' => Yii::t('yii', 'Список товара'),
        'url' => '/admin/products/list/',
    ],
    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
])
?>
<?php if (!empty($error)) { ?>
<div class="alert alert-warning" role="alert">К сожалению, такого товара еще не создали.</div>
<?php }else{?>
<?php if (!empty($pruductInfo->status) && $pruductInfo->status==1) { ?>
<div class="alert alert-info" role="alert">Внимание! Создана копия товара<br>
    Для отображения на сайте нажмите кнопку схранить
</div>
<?php }?>
<div class="row row-offcanvas row-offcanvas-right">
    <h3 id="glyphicons-glyphs">Добавление/Редактирование товара
                      <?php
              if (!empty($_GET['err'])) {
                      echo '<div style="margin-top:20px"class="alert alert-danger" role="alert">Гдето ошибка, данніе не сохранились </div>';
              }
          ?>
        <a href="/admink32/products/add/"> 
            <button  style="margin-left:25%" type="button"  class="btn btn-default add" >Добавить товар</button>
        </a>
<?php if (!empty($pruductInfo->productId)) { ?>
            <a target="_blank"href="http://kochevnik.com.ua/item/<?php echo $pruductInfo->translit; ?>_<?php echo $pruductInfo->productId; ?>.html"> 
                <button  type="button"  class="btn btn-default add" >Посмотреть на сайте</button>
            </a>
    <?php }; ?>
    </h3>
    <?php if (!empty($pruductInfo->articul)) { ?> Артикул  <?= $pruductInfo->articul; ?><?php }; ?>
    <?php
    $form = ActiveForm::begin([
                'id' => 'login-form',
                'method' => "post",
                "action" => "/admink32/products/add",
                'options' => ["enctype" => "multipart/form-data", 'class' => 'form-horizontal'],
            ])
    ?>
<?= Html::activeHiddenInput($model, 'productId') ?>
    <div class="row">
        <div class="col-xs-2">
            <label class="col-sm-2">Фото</label>
        <?= Html::activeFileInput($model, 'image', ["class" => "form-control"]) ?>
        </div>
        <?= Html::activeHiddenInput($model, 'image') ?>
<?php if (!empty($pruductInfo->image)) { ?>
            <div class="col-xs-3">
                <img style="height:115px" src="<?php echo $pruductInfo->image; ?>" title="">
            </div>
<?php }; ?>
        <div class="col-xs-7">
            <label class="col-sm-6">Название товара</label>
            <?= Html::activeTextInput($model, 'title', ["required" => "required", "id" => "title", "class" => "form-control", "onblur" => "translitText(this,$('#translit'));"]) ?>
            <label class="col-sm-6">Транслит </label>
<?= Html::activeTextInput($model, 'translit', ["required" => "required", "id" => "translit", "class" => "form-control"]) ?>
        </div>

    </div>
    <div class="row">
        <div class="col-md-9">

            <label >Описание:</label>
<?= Html::activeTextarea($model, 'description', ["required" => "required", "id" => "description", "class" => "form-control", "cols" => "100", "rows" => "6"]) ?>
        </div>
        <div class="col-md-3">
            <label >Поставщик: <a target="_blank"href="/admink32/different/course/">Изменить курс</a></label>
            <select  required id="currency"class="form-control" name="AddProductsForm[currency]" onchange="setTruePrice()" >
                <option cur="0" value="">Выбрать</option>
                <?php
                foreach ($madeSuplier as $key => $value) {
                    if ($model->currency == $value['idSuplier']) {
                        $cur = $value['curenccy'];
                        echo '<option selected cur="' . $value['curenccy'] . '" value="' . $value['idSuplier'] . '">' . $value['nameSuplier'] . ' </option>';
                    } else {
                        echo '<option cur="' . $value['curenccy'] . '" value="' . $value['idSuplier'] . '">' . $value['nameSuplier'] . ' </option>';
                    }
                }
                ?>
            </select>
            <div id="cur"class="input-group-addon"><?php echo $cur; ?></div>
            <label>Цена,$</label>
            <?= Html::activeTextInput($model, 'priceSet', ["id" => "priceSet", "class" => "form-control", "onblur" => "countRealPrice(this)"]) ?>
            <label>Цена на сайте</label>
            <?= Html::activeHiddenInput($model, 'price', ["id" => "price"]) ?>
            <div  class="input-group-addon"><span id="setPrice" ><?php echo $model->price; ?></span>грн</div>
            <label>Акционная цена,$</label>
            <?= Html::activeTextInput($model, 'actionPriceSet', ["id" => "actionPriceSet", "class" => "form-control", "onblur" => "countRealPriceAction(this)"]) ?>
            <label>Цена акции на сайте</label>
            <?= Html::activeHiddenInput($model, 'priceAction', ["id" => "priceAction"]) ?>
            <div  class="input-group-addon"><span id="setPriceAction" ><?php echo $model->priceAction; ?></span>грн</div>
            <label >Рубрика:</label>
            <?= Html::activeDropDownList($model, 'rubricId', ["1" => "Велотуризм",
                "2" => "Туризм", "3" => "Одется", "4" => "Альпинизм"], ["id" => "rubric", "class" => "form-control"])
            ?>
            <label >Категория:</label>
            <select required id="category" class="form-control " name="AddProductsForm[categoryId]" >
                <option value="">Выбрать</option>
                <?php
                foreach ($categoriesInfo as $key => $value) {
                    if ($model->categoryId == $value['categoryId']) {
                        echo '<option selected  value="' . $value['categoryId'] . '">' . $value['name'] . ' </option>';
                    } else {
                        echo '<option value="' . $value['categoryId'] . '">' . $value['name'] . ' </option>';
                    }
                }
                ?>
            </select>
            <label >Бренд:</label>
            <select required class="form-control " name="AddProductsForm[made]" >
                <option value="">Выбрать</option>
                <?php
                foreach ($madeCompany as $key => $value) {
                    if ($model->made == $value['idCompany']) {
                        echo '<option  selected value="' . $value['idCompany'] . '">' . $value['nameCompany'] . ' </option>';
                    } else {
                        echo '<option value="' . $value['idCompany'] . '">' . $value['nameCompany'] . ' </option>';
                    }
                }
                ?>
            </select>
        </div>
    </div>

    <div class="row">
        <div style="margin: 4% 40%;">
<?= Html::submitButton('Сохранить', ['class' => 'btn btn-default add']) ?>
<?= Html::submitButton('Создать копию', ['value'=>'1','name'=>'copy','class' => 'btn btn-default copy']) ?>
        </div>
    </div>
<?php ActiveForm::end() ?>
    <h2>Добавление фильтра к товару</h2>
    <a  href="/admink32/different/filter/"target="_blank">Добавить/изменить фильтр</a>
    <div class="row">
        <form  id="filterAdd">
            <input type="hidden" value="<?php echo $model->made; ?>" name="made">
            <input type="hidden" value="<?php echo $model->productId; ?>" name="productId">
            <input type="hidden" value="<?php echo $model->categoryId; ?>" name="categoryId">
            <div class="col-md-3">
                <label >Фильтр:</label>
                <select required class="form-control" id="filter"  onchange="changeFilter(this)" >
                    <option value="">Выбрать</option>
                    <?php
                    foreach ($filter as $key => $value) {
                        echo '<option value="' . $value['filterId'] . '">' . $value['nameFilter'] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-3">
                <label >Название:</label>
                <select required id="filter_item" class="form-control " name="filter" >
                    <option value="">Выбрать</option>
                </select>
            </div>
            <div class="col-sm-2">
                <br>
                <button type="submit"   class="btn btn-default add" >Добавить</button>
            </div>
        </form>
    </div>
    <br>
    <nav class="navbar navbar-default" id="filterView">
        <?php
        foreach ($filtersArray as $kye => $value) {
            echo '<h4>' . $value['name'] . '------------<span id="filter' . $kye . '">';
            foreach ($value['filter'] as $key => $item) {
                echo '<span class="label label-primary">' . $item . ' </span>
             <a   class="delfilter" title="Удалить ' . $item . '" href="javascript:void(0);" filterIdDel=' . $key . '>--x&nbsp;&nbsp;&nbsp;</a>';
            }
            echo '</span></h4>';
        }
        ?>
    </nav> 

    <h2>Добавление характеристик</h2>
    <div class="row">
        <form  id="modeficationAdd">
            <input type="hidden" value="<?php echo $model->productId; ?>" name="productId">
            <div class="col-md-3">
                <label >Название характеристики:</label>
                <input id="nameSpecifications" required name="nameSpecifications" >
            </div>
            <div class="col-md-3">
                <label >Значение характиристики:</label>
                <input id="valueSpecifications" required  name="valueSpecifications" >
            </div>
            <div class="col-sm-2">
                <br>
                <button type="submit" class="btn btn-default add" >Добавить</button>
            </div>
        </form>
    </div>

    <nav class="navbar navbar-default" id="modeficationView">

        <?php
        foreach ($modificationArray as $kye => $value) {
            echo '<div class="row"><div class="col-sm-3"><b>' . $value['nameSpecifications'] . '</b></div>
               <div class="col-sm-7">' . $value['valueSpecifications'] . '</div>
                   <div class="col-sm-2"><a  class="delMod" delMod="' . $value['id'] .
            '" title="Удалить опцию" href="javascript:void(0);">DEL</a></div></div>';
        }
        ?>

    </nav> 
    <h2>Добавление фотогалереи</h2>
    <div class="row">
        <?php 
        $form = ActiveForm::begin([
                    'id' => 'photoGalleryAdd',
                    'options' => ["enctype" => "multipart/form-data", 'class' => 'form-horizontal'],
                ])
        ?>
        <input type="hidden"  value="<?php echo $model->productId; ?>" name="AddProductsGalleryForm[productId]">
        <div class="col-xs-4">
            <label>Фото для галереи</label>
<?= Html::activeFileInput($model_photo, "image", ["id"=>"imageGallery","class" => "form-control"]) ?>
        </div>
        <div class="col-sm-2">
            <br>
        </div>
        <?= Html::submitButton('Добавить', ['class' => 'btn btn-default add']) ?>
        </form>
    </div>
    <div class="row" id="galerryView">
        <?php
        foreach ($galleryArray as $kye => $value) {
            echo ' <div class="col-xs-3">
            <img  style="height:115px"src="' . $value['medium'] . '" alt="" class="img-thumbnail">
            <span><a href="javascript:void(0);" photoImageDel="' . $value['idPhoto'] . '" class="photoDel">X</a></span>
             </div>';
        }
        ?>

    </div>

</div><!--/row-->
<?php }?>
<script>
    function changeFilter(elem){
        if($(elem).val()){
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
        }else{
            $('#filter_item').empty();
            $('#filter_item').append("<option value=''>Выбрать</option>");
        }
    }
    
</script>

