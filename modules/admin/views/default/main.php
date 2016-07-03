  <?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\bootstrap\ActiveForm;

$this->title = 'Общие настройки админки';
$this->params['breadcrumbs'][] = $this->title;
//$this->params['breadcrumbs'][] = ['label' => 'Employees', 'url' => ['index']];
?>

    <?= Breadcrumbs::widget([
            'homeLink' => [ 
                      'label' => Yii::t('yii', 'Основной конфиг'),
                      'url' => '/admink32/main/',
                 ],
           'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>

 <div class="row row-offcanvas row-offcanvas-right">
<h3 id="glyphicons-glyphs">Общие настройки</h3>
      

<p class="bg-primary lab" id="bg-primary">Главная фотогалерея</p>
  <div class="form-group row">
    <?php
    $form = ActiveForm::begin([ 'method' => "post",
                'id' => 'galleryPhorm',
                'class' => "form-horizonta", 'action' => "/admink32/main/",
                'options' => [
                    'enctype' => "multipart/form-data"
                    ]]);
    ?>
    <?= Html::hiddenInput('gallery', 1) ?>
            <div class="col-xs-3">
                <label class="col-sm-2">Фото</label>
                <input  required type="file" class="form-control" name="image">
            </div>
            <div class="col-xs-3">
                <label class="col-sm-2">Ссылка</label>
                <input  required type="text" name="link" value=""   class="form-control" placeholder="http://">
            </div>
            <div class="col-xs-3">
                <label class="col-sm-2">Текст</label>
                <input   type="text" name="text" value=""   class="form-control" placeholder="Текст">
            </div>
            <div class="col-xs-3">
            <?= Html::submitButton('Сохранить Галерею', ['class' => 'btn btn-default', 'value' => 'Cохранить фото']) ?>
            </div>
    <?php ActiveForm::end(); ?>
  </div>
        <div class="row">
    <?php foreach($dataGalley as $key => $value) : ?>
        <?php if ($value['photoUrl']) { ?>
                <div class="col-xs-4">
                    <a href="javascript:void(0);" class="delgallery" delgal="<?php echo $value['id']; ?>">X</a>
                    <img style="height:115px" src="<?php echo $value['photoUrl']; ?>" title="<?php echo $value['titleName']; ?>"><br>
                    <?php echo $value['titleName']; ?>
                </div>
        <?php } ?>
    <?php endforeach; ?>
        </div>


    <hr>
    <p class="bg-primary lab">Последнее Youtube Video  </p>
     <div class="row">
     <?php $form = ActiveForm::begin([ 'method' => "post",
                'id' => 'yutobeConfig',
                'class' => "form-horizonta", 'action' => "/admink32/main/",
                ]);
    ?>
  <div class="col-xs-10">
    <input type="text" class="form-control"  name="youtube" value='<?php echo $youtube; ?>'>
  </div>
          <?= Html::submitButton('Сохранить видео', ['class' => 'btn btn-default', 'value' => 'Cохранить видео']) ?>
           <?php ActiveForm::end(); ?>
  </div>


      </div><!--/row-->