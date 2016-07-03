<?php 
    use yii\widgets\LinkPager;
    use app\components\LeftMenuWidget;
?>
<div class="container"style="margin-top: 15px;">
    <div class="row">
                 <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li>
                            <a href="/">Главная</a>
                        </li>
                         <?php if(!empty($brand_params['name'])) :?> 
                            <?php if(!empty($rubric_params['eng'])) :?> 
                               <li>
                                 <a href="/<?=$rubric_params['eng'];?>"><?=$rubric_params['name'];?></a>
                               </li>
                            <?php endif; ?>
                           <li><?=$brand_params['name'];?></li>
                         <?php else: ?>
                            <li><?=$rubric_params['name'];?></li>
                         <?php endif; ?>
                    </ul>
                </div> 
           <?= LeftMenuWidget::widget(['rub' => $rubric_params['id'],'rub_eng' => $rubric_params['eng'],'brand'=>$brand_params['eng']]) ?>
        <div class="col-sm-9 padding-right">
                 <?php if(!empty($pruducts)) :?> 
                    <div class="row products">
                         <?php foreach($pruducts as $pruduct) { ?>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                   <?php if(!empty($pruduct['priceAction'])) :?> 
                                       <div class="ribbon">
                                            <div class="theribbon">Акция</div>
                                        </div>
                                      <?php endif; ?>
                                    <div class="product-image-wrapper">
                                            <div class="single-products">
                                                    <div class="productinfo text-center">
                                                        <div class="img_hiegth">
                                                            <a title="<?= $pruduct['title']; ?>" href="/item/<?= $pruduct['translit']; ?>_<?= $pruduct['productId']; ?>.html">
                                                                <img src="<?php echo $pruduct['image']? $pruduct['image']:"/images/nopoto.gif" ?>" alt="" />
                                                            </a>
                                                        </div>
                                                            <div class="txtOver"><?= $brands_array[$pruduct['made']]['nameCompany']." ".$pruduct['title']; ?></div>
                                                            <div class="row" style="min-height: 60px;">
                                                                <?php if(!empty($brands_array[$pruduct['made']]['imageMade'])) :?> 
                                                                    <img  style="width:78px;height:60px;margin:0 auto;" src="<?php echo $brands_array[$pruduct['made']]['imageMade']; ?>" alt="" class="img-responsive">
                                                                <?php else: ?>
                                                                   <strong> <?php echo $brands_array[$pruduct['made']]['nameCompany']; ?></strong>
                                                                <?php endif; ?>
                                                            </div>
                                                            <div class="row">
                                                                <div class="price">
                                                                   <?php if(!empty($pruduct['priceAction'])) :?> 
                                                                    <del><?= $pruduct['price']; ?> грн</del>
                                                                    <?= $pruduct['priceAction']; ?> грн
                                                                    <?php else: ?>
                                                                    <?= $pruduct['price']; ?> грн
                                                                    <?php endif; ?>
                                                                    </div>
                                                                    </div>
                                                            <a title="<?= $pruduct['title']; ?>" href="/item/<?= $pruduct['translit']; ?>_<?= $pruduct['productId']; ?>.html" class="btn btn-success buttonmerg">Смотреть >></a>
                                                    </div>

                                            </div>
                                    </div>
                            </div>

      
                        <?php };?>
                    </div>
                     <?php else: ?>
                    <div class="message">
                      К сожалению товара по даному запросу нету.
                    </div>
                     <?php endif; ?>
                    <!-- /.products -->
                    <?php if(!empty($pages)) :?> 
                    <div class="pages">
                            <?php
                            echo LinkPager::widget([
                                'pagination' => $pages,
                            ]);
                            ?>
                    </div>
   
                    <?php endif; ?>
        </div>
    </div>
</div>
