
<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\bootstrap\ActiveForm;

$cur = 0;

$this->title = 'Список товара';
$this->params['breadcrumbs'][] = ['label' => 'Распарсить фаил', 'url' => ['/admin/parse/parse/']];
$this->params['breadcrumbs'][] = ['label' => 'Список распаресенного товара', 'url' => ['/admin/parse/list-parse/']];
$this->params['breadcrumbs'][] = $this->title;
//$this->params['breadcrumbs'][] = ['label' => 'Employees', 'url' => ['index']];
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
    <div class="form-group">
        <input type="text" class="form-control" id="search_word" style="width: 200px">
    </div>
        <form method="GET" id="searchProduct">
            <div class="row">
                 <div class="col-md-3">
                            <label >Поставщик:</label>
        <select  class="form-control " name="suplier" >
            <option value="">Выбрать</option>
                    <?php
                                foreach ($madeSuplier as $key => $value) {
                                       echo '<option value="' . $value['idSuplier'] . '">' . $value['nameSuplier'] . ' </option>';
                                    
                                }
                                ?>
            </select>
                 </div>
                 <div class="col-md-3">
                    <label >Категория:</label>
        <select  class="form-control " name="category" >
            <option value="">Выбрать</option>
                               <?php
                                foreach ($categoriesInfo as $key => $value) {
                                       echo '<option value="' . $value['categoryId'] . '">' . $value['name'] . ' </option>';
                                    
                                }
                                ?>
            </select>
                 </div>
                              <div  class="col-md-2">
                                   <label >ID товара:</label>
            <input type="text" name="productId">
            </div>
                       <div  class="col-md-2">
                           <br>
            <button  type="submit"  class="btn btn-default " >Поиск</button>
            </div>
                       <div  class="col-md-2">
                           <br>
            <button  type="button" id="dellPoductsAll"  class="btn btn-default delProduct " >Удалить выбранные товары</button>
            </div>
            </div>
     
        </form>
              <div class="row">
          <form id="setChangeProducts">
              <div  class="col-md-6">
                   <h3 id="glyphicons-glyphs">Изменить цену выбранному товару</h3>
                   <br>
                   <div class="col-md-4">
                <select required class="form-control " name="operation" >
                    <option value="1">Установить</option>
                    <option value="+">Увеличить на</option>
                    <option value="*">Увеличить в</option>
                    <option value="-">Уменшить на</option>
                    <option value="/">Уменшить в</option>
                </select>
              </div>
                  <div class="col-md-5">
                      <input type="text" name="number" />  <label >раз</label>
                  </div>
                  <div class="col-md-2">
                        <button  type="submit"  class="btn btn-default " >Применить</button> 
                  </div>
              </div>
           </form>
                  <form id="setChangeProductsFilter">
                  <div  class="col-md-6">
                      <h3 id="glyphicons-glyphs">Установить фильтр выбранному товару</h3>
                      <div class="col-md-5">
                          <label >Фильтр:</label>
                          <select required class="form-control" id="filter"  onchange="changeFilter(this)"  >
                              <option value="">Выбрать</option>
                              <?php
                              foreach ($filter as $key => $value) {
                                  echo '<option value="' . $value['filterId'] . '">' . $value['nameFilter'] . '</option>';
                              }
                              ?>
                          </select>
                      </div>
                      <div class="col-md-4">
                          <label >Название:</label>
                          <select required  id="filter_item" multiple="multiple" class="form-control " name="filter[]" >
                              <option value="">Выбрать</option>
                          </select>
                      </div>
        
                      <div class="col-md-2">
                          <br>
                          <button  type="submit"  class="btn btn-default " >Применить</button> 
                      </div>
                  </div>
            </form>
              </div>
              <hr>
        <table class="table table-hover">
      <thead>
        <tr>
          <th><input type="checkbox"  id="allInput" onclick="allInput(this)" /><br>Все</th>
          <th>ID</th>
          <th>Товар</th>
          <th>Цена<br>(установлена)</th>
          <th>Поставщик<br>(курс)</th>
          <th>Цена на сайте (грн)</th>
          <th>Категория</th>
          <th>Фильтр</th>
          <th></th>
        </tr>
      </thead>
      <tbody id="containerProducts">
      </tbody>
    </table>
</div>
    <script>
        function changeFilter(elem){
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
        function allInput(elem){
            if($(elem).is( ":checked" ) ){
              $('#containerProducts').find('input[type=checkbox]').attr('checked','checked');  
            }
            else{
              $('#containerProducts').find('input[type=checkbox]').attr('checked',null);  
            }
        }
    </script>