<?php 
    use yii\widgets\LinkPager;
?>
<?php if(!empty($pruducts)) :?> 
                    <div class="row products">
                         <?php foreach($pruducts as $pruduct) { ?>
                              <div class="col-md-4 col-sm-6 col-xs-12">
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
                                                            <div class="txtOver"> <?= $brands_array[$pruduct['made']]['nameCompany']." ".$pruduct['title']; ?></div>
                                                            <div class="row">
                                                                <?php if (!empty($brands_array[$pruduct['made']]['imageMade'])) : ?> 
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