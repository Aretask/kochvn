
<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\bootstrap\ActiveForm;

$cur = 0;

$this->title = 'Список распаресенного товара';
$this->params['breadcrumbs'][] = ['label' => 'Список товара', 'url' => ['/admin/products/list/']];
$this->params['breadcrumbs'][] = ['label' => 'Распарсить фаил', 'url' => ['/admin/parse/parse/']];
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
     <h3 id="glyphicons-glyphs">Поиск товара</h3>
        <form method="GET" id="searchProductTmp">
           
            <div class="row">
                 <div class="col-md-3">
                            <label >Поставщик:</label>
        <select id="suplierTmp" class="form-control " name="suplier" >
            <option value="">Выбрать</option>
                    <?php
                                foreach ($madeSuplierTmp as $key => $value) {
                                       echo '<option value="' . $value['idSuplier'] . '">' . $value['nameSuplier'] . ' </option>';
                                    
                                }
                                ?>
            </select>
                 </div>
                                 <div class="col-md-3">
                    <label >Бренд:</label>
        <select  class="form-control " id="madeTmp" name="made" >
            <option value="">Выбрать</option>
            </select>
                 </div>
                 <div class="col-md-3">
                    <label >Категория:</label>
        <select  class="form-control " id="categoryTmp" name="category" >
            <option value="">Выбрать</option>
            </select>
                 </div>

                       <div  class="col-md-2">
                           <br>
            <button  type="submit"  class="btn btn-default " >Поиск</button>
            </div>
                            </div>
                            <div class="row">
                       <div  class="col-md-6">
                                
            </div>
                       <div  class="col-md-6">
            <button  type="button" id="dellPoductsAll"  class="btn btn-default delProductTmp " >Удалить выбранные товары</button>
            </div>
            </div>
     
        </form>
          <form id="moveProductsTmp">
               <input type="hidden" name="suplierTmp" value='' id="suplierValue">
                   <h3 id="glyphicons-glyphs">Установить выбраному товару</h3>
              <div class="row">
     <div class="col-md-3">
                    <label>Бренд:</label>
        <select  required class="form-control " name="made">
            <option value="">Выбрать</option>
               <?php
                                foreach ($madeCompany as $key => $value) {
                                       echo '<option value="' . $value['idCompany'] . '">' . $value['nameCompany'] . ' </option>';
                                    
                                }
                                ?>
                 </select>
              </div>
                          <div class="col-md-3">
                    
                 <label >Рубрика:</label>
        <select required id="rubric"class="form-control " name="rubricId" >
            <option value="">Выбрать</option>
            <option value="1">Велотуризм</option>
            <option value="2">Туризм</option>
            <option value="3">Одется</option>
            <option value="4">Альпинизм</option>
            </select>
                </div>
     <div class="col-md-3">
                    <label>Категорию:</label>
        <select  id="category"required class="form-control " name="category">
            <option value="">Выбрать</option>
        
                 </select>
              </div>
                  <div class="col-md-3"><br>
           <button  type="submit" id="dellPoductsAll"  class="btn btn-default addProductTmp " >Добавить выбранные товары</button>
                      
                  </div>
              </div>
               </form>
              <hr>
        <table class="table table-hover">
      <thead>
        <tr>
          <th><input type="checkbox"  id="allInput" onclick="allInput(this)" /><br>Все</th>
          <th>ID</th>
          <th>Название Товара</th>
          <th>Бренд</th>
          <th>Категория</th>
          <th>Цена</th>
          <th>Артикул</th>
          <th>Описание</th>
          <th>Изображение</th>
          <th></th>
        </tr>
      </thead>
      <tbody id="containerProducts">
      </tbody>
    </table>
 
</div>
       <script>
        function allInput(elem){
            if($(elem).is( ":checked" ) ){
              $('#containerProducts').find('input[type=checkbox]').attr('checked','checked');  
            }
            else{
              $('#containerProducts').find('input[type=checkbox]').attr('checked',null);  
            }
        }
    </script>