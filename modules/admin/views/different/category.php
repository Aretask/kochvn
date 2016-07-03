
<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\bootstrap\ActiveForm;

$this->title = 'Настройка категорий';
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
     <h3 id="glyphicons-glyphs">Настройка категорий</h3>
                <div class="form-group">
                <form class="form-inline" method="get" action="/admink32/different/category">
                    <input type="hidden" value="1" name="rubricId">
                    <div class="row">
                        <label class="col-sm-2">Рубрика Велотуризм:</label>
                        <div class="col-sm-3">
                            <select class="form-control " name="categoryId">
                                <option value="0">Выбрать</option>
                                <?php
                                foreach ($arryCat[1] as $key => $value) {
                                    echo '<option eng="'.$value["eng"].'"  order="'. $value["orderCat"].'"value="' . $key . '">' . $value['name'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <input required type="text"  onblur="checkAllow(this,'category');" class="form-control " placeholder="Название рубрики"  name="name">
                            <input required type="text" class="form-control "  id="category_eng" placeholder="Транслит"  name="eng">
                        </div>
                        <div class="col-sm-1">
                            <input  type="text" class="form-control  " style="width: 60px;" placeholder="№п/п"  name="orderCat">
                        </div>
                        <div class="col-sm-2">
                            <button type="submit" disabled name="redug" value="1" class="btn btn-default redug">Редактировать</button>
                        </div>
                        <div class="col-sm-2">
                            <button type="submit" name="add" value="1" class="btn btn-default add">Добавить</button>
                        </div>
                    </div>
                </form>

            </div>
            <div class="form-group">
                <form class="form-inline" method="get" action="/admink32/different/category">
                    <input type="hidden" value="2" name="rubricId">
                    <div class="row">
                        <label class="col-sm-2">Рубрика Туризм:</label>
                        <div class="col-sm-3">

                            <select class="form-control" name="categoryId">
                                <option value="0">Выбрать</option>
                                <?php
                                foreach ($arryCat[2] as $key => $value) {
                                   echo '<option  eng="'.$value["eng"].'" order="'. $value["orderCat"].'"value="' . $key . '">' . $value['name'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <input required onblur="checkAllow(this,'category');" type="text" class="form-control col-sm-5 " placeholder="Название рубрики"  name="name">
                             <input required type="text" class="form-control " placeholder="Транслит"  name="eng">
                        </div>
                        <div class="col-sm-1">
                            <input  type="text" class="form-control  " style="width: 60px;" placeholder="№п/п"  name="orderCat">
                        </div>
                        <div class="col-sm-2">
                            <button type="submit" disabled  name="redug" value="1" class="btn btn-default redug">Редактировать</button>
                        </div>
                        <div class="col-sm-2">
                            <button type="submit" name="add" value="1" class="btn btn-default add">Добавить</button>
                        </div>
                    </div>
                </form>

            </div> <div class="form-group">
                <form class="form-inline" method="get" action="/admink32/different/category">
                    <input type="hidden" value="3" name="rubricId">
                    <div class="row">
                        <label class="col-sm-2">Рубрика Одется:</label>
                        <div class="col-sm-3">

                            <select class="form-control " name="categoryId">
                                <option value="0">Выбрать</option>
                                <?php
                                foreach ($arryCat[3] as $key => $value) {
                                   echo '<option  eng="'.$value["eng"].'" order="'. $value["orderCat"].'"value="' . $key . '">' . $value['name'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <input required type="text" onblur="checkAllow(this,'category');" class="form-control col-sm-5 " placeholder="Название рубрики"  name="name">
                             <input required type="text" class="form-control " placeholder="Транслит"  name="eng">
                        </div>
                        <div class="col-sm-1">
                            <input  type="text" class="form-control  " style="width: 60px;" placeholder="№п/п"  name="orderCat">
                        </div>
                        <div class="col-sm-2">
                            <button type="submit" disabled name="redug" value="1" class="btn btn-default redug">Редактировать</button>
                        </div>
                        <div class="col-sm-2">
                            <button type="submit" name="add" value="1" class="btn btn-default add">Добавить</button>
                        </div>
                    </div>
                </form>

            </div> <div class="form-group">
                <form class="form-inline" method="get" action="/admink32/different/category">
                    <input type="hidden" value="4" name="rubricId">
                    <div class="row">
                        <label class="col-sm-2">Рубрика Альпинизм:</label>
                        <div class="col-sm-3">

                            <select class="form-control" name="categoryId">
                                <option value="0">Выбрать</option>
                                <?php
                                foreach ($arryCat[4] as $key => $value) {
                                   echo '<option eng="'.$value["eng"].'" order="'. $value["orderCat"].'"value="' . $key . '">' . $value['name'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <input required type="text" onblur="checkAllow(this,'category');" class="form-control col-sm-5 " placeholder="Название рубрики"  name="name">
                             <input required type="text" class="form-control " placeholder="Транслит"  name="eng">
                        </div>
                        <div class="col-sm-1">
                            <input  type="text" class="form-control  " style="width: 60px;" placeholder="№п/п"  name="orderCat">
                        </div>
                        <div class="col-sm-2">
                            <button type="submit" disabled name="redug" value="1" class="btn btn-default redug">Редактировать</button>
                        </div>
                        <div class="col-sm-2">
                            <button type="submit" name="add" value="1" class="btn btn-default add">Добавить</button><br>
                        </ div>
                    </div>
                </form>

            </div>

  </div>
