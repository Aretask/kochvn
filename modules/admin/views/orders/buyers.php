
<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\bootstrap\ActiveForm;

$this->title = 'Список покупателей';
$this->params['breadcrumbs'][] = $this->title;
//$this->params['breadcrumbs'][] = ['label' => 'Employees', 'url' => ['index']];
?>

<?=
Breadcrumbs::widget([
    'homeLink' => [
        'label' => Yii::t('yii', 'Cписок заказов'),
        'url' => '/admink32/orders/orders/',
    ],
    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
])
?>

<div class="row row-offcanvas row-offcanvas-right">
    <h3 id="glyphicons-glyphs">Список покупателей</h3>

    <table class="table table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>Имя</th>
                <th>Телефон</th>
                <th>E-mail</th>
                <th>Черный список</th>
            </tr>
        </thead>
        <tbody>

            <?php
            foreach ($buyers as $key => $value) {
                if ($value['statusBuyer'] == 1) {
                    echo '<tr class="black">';
                } else {
                    echo '<tr>';
                }
                echo '<th scope="row">' . $value['idBuyer'] . '</th><td>' . $value['name'] .
                '</td><td>' . $value['fPhone'] . '</td><td>' . $value['email'] .
                '</td>';
                if ($value['statusBuyer'] == 1) {
                    echo '<td> <div  idBuyer="' . $value['idBuyer'] .
                    '"  style="background-color:#3BB733" class="btn btn-primary dellBlack">Забрать</div> <div  idBuyer="' .
                    $value['idBuyer'] . '" disabled style="background-color:#0F0703"class="btn btn-primary addBlack">Добавить</div></td></tr>';
                } else {
                    echo '<td> <div  disabled idBuyer="' . $value['idBuyer'] .
                    '"style="background-color:#3BB733"  class="btn btn-primary dellBlack">Забрать</div> <div  idBuyer="' .
                    $value['idBuyer'] . '"  style="background-color:#0F0703"class="btn btn-primary addBlack">Добавить</div></td></tr>';
                }
            }
            ?>
        </tbody>
    </table>

</div><!--/row-->

