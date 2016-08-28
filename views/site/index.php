
<?php

 use app\components\SliderWidget; ?>
    <?php

 use app\components\LeftMenuWidget; ?>

<div class="container"style="margin-top: 15px;">
<?= SliderWidget::widget([]) ?>
    <div class="row">
<?= LeftMenuWidget::widget([]) ?>


        <div class="col-sm-9 padding-right">
            <div class="category-tab"><!--category-tab-->
                <div class="col-sm-12">
                    <ul class="nav nav-tabs"id="check_rubrik">
                        <li class="active"><a link="ride" href="#rides" data-toggle="tab">Велотуризм</a></li>
                        <li><a link="clothes" href="#clothess" data-toggle="tab">Одежда</a></li>
                        <li><a link="walk"href="#walkk" data-toggle="tab">Туризм</a></li>
                        <li><a link="climbing"href="#climmbing" data-toggle="tab">Альпинизм</a></li>
                    </ul>
                </div>
                <div class="tab-content">
                    <div class="tab-pane fade active in" id="rides" >
                        <?php if (!empty($pruducts_rub[1])) : ?>  
                            <?php foreach ($pruducts_rub[1] as $pruductr) { ?>
                                <div class="col-sm-3">
                                    <div class="product-image-wrapper">
                                        <div class="single-products">
                                            <div class="productinfo text-center">
                                               <div class="img_hiegth">
                                                    <a title="<?= $pruductr['title']; ?>" href="/item/<?= $pruductr['translit']; ?>_<?= $pruductr['productId']; ?>.html">	
                                                        <img src="<?php echo $pruductr['image'] ? $pruductr['image'] : "/images/nopoto.gif" ?>" alt="" />
                                                    </a>
                                                </div>
                                                <div class="row">
                                                    <div class="price">
                                                        <?php if (!empty($pruductr['priceAction'])) : ?> 
                                                            <del><?= $pruductr['price']; ?> грн</del>
                                                            <?= $pruductr['priceAction']; ?> грн
                                                        <?php else: ?>
                                                            <?= $pruductr['price']; ?> грн
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                                <div class="txtOver"> <?= $brands_array[$pruductr['made']]['nameCompany']." ".$pruductr['title']; ?></div>
                                                <a href="/item/<?= $pruductr['translit']; ?>_<?= $pruductr['productId']; ?>.html" class="btn btn-success buttonmerg">Смотреть</a>
                                            </div>
                                                
                                        </div>
                                    </div>
                                </div>
                            <?php }; ?>
                            <div class="pull-right">
                                <a  style="color:#000;"href="/ride"id="view_more" >Смотреть больше>></a>
                            </div>
                        <?php else: ?>
                            Нету товара по даной катогрии
                        <?php endif; ?>
                    </div>

                    <div class="tab-pane fade" id="clothess" >
                        <?php if (!empty($pruducts_rub[3])) : ?>  
                            <?php foreach ($pruducts_rub[3] as $pruductr) { ?>
                                <div class="col-sm-3">
                                    <div class="product-image-wrapper">
                                        <div class="single-products">
                                            <div class="productinfo text-center">
                                               <div class="img_hiegth">
                                                    <a title="<?= $pruductr['title']; ?>" href="/item/<?= $pruductr['translit']; ?>_<?= $pruductr['productId']; ?>.html">	
                                                        <img src="<?php echo $pruductr['image'] ? $pruductr['image'] : "/images/nopoto.gif" ?>" alt="" />
                                                    </a>
                                                </div>
                                                <div class="row">
                                                    <div class="price">
                                                        <?php if (!empty($pruductr['priceAction'])) : ?> 
                                                            <del><?= $pruductr['price']; ?> грн</del>
                                                            <?= $pruductr['priceAction']; ?> грн
                                                        <?php else: ?>
                                                            <?= $pruductr['price']; ?> грн
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                                <div class="txtOver"><?= $brands_array[$pruductr['made']]['nameCompany']." ".$pruductr['title']; ?></div>
                                                <a href="/item/<?= $pruductr['translit']; ?>_<?= $pruductr['productId']; ?>.html" class="btn btn-success buttonmerg">Смотреть</a>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            <?php }; ?>
                            <div class="pull-right">
                                <a  style="color:#000;"href="/clothes"id="view_more" >Смотреть больше>></a>
                            </div>
                        <?php else: ?>
                            Нету товара по даной катогрии
                        <?php endif; ?>
                    </div>

                    <div class="tab-pane fade" id="walkk" >
                        <?php if (!empty($pruducts_rub[2])) : ?>  
                            <?php foreach ($pruducts_rub[2] as $pruductr) { ?>
                                <div class="col-sm-3">
                                    <div class="product-image-wrapper">
                                        <div class="single-products">
                                            <div class="productinfo text-center">
                                                <div class="img_hiegth">
                                                    <a title="<?= $pruductr['title']; ?>" href="/item/<?= $pruductr['translit']; ?>_<?= $pruductr['productId']; ?>.html">	
                                                        <img src="<?php echo $pruductr['image'] ? $pruductr['image'] : "/images/nopoto.gif" ?>" alt="" />
                                                    </a>
                                                </div>
                                                <div clheightass="row">
                                                    <div class="price">
                                                        <?php if (!empty($pruductr['priceAction'])) : ?> 
                                                            <del><?= $pruductr['price']; ?> грн</del>
                                                            <?= $pruductr['priceAction']; ?> грн
                                                        <?php else: ?>
                                                            <?= $pruductr['price']; ?> грн
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                                <div class="txtOver"> <?= $brands_array[$pruductr['made']]['nameCompany']." ".$pruductr['title']; ?></div>
                                                <a href="/item/<?= $pruductr['translit']; ?>_<?= $pruductr['productId']; ?>.html" class="btn btn-success buttonmerg">Смотреть</a>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            <?php }; ?>
                            <div class="pull-right">
                                <a  style="color:#000;"href="/walk"id="view_more" >Смотреть больше>></a>
                            </div>
                        <?php else: ?>
                            Нету товара по даной катогрии
                        <?php endif; ?>
                    </div>

                    <div class="tab-pane fade" id="climmbing" >
                        <?php if (!empty($pruducts_rub[4])) : ?>  
                            <?php foreach ($pruducts_rub[4] as $pruductr) { ?>
                                <div class="col-sm-3">
                                    <div class="product-image-wrapper">
                                        <div class="single-products">
                                            <div class="productinfo text-center">
                                              <div class="img_hiegth">
                                                    <a title="<?= $pruductr['title']; ?>" href="/item/<?= $pruductr['translit']; ?>_<?= $pruductr['productId']; ?>.html">	
                                                        <img src="<?php echo $pruductr['image'] ? $pruductr['image'] : "/images/nopoto.gif" ?>" alt="" />
                                                    </a>
                                                </div>
                                                <div class="row">
                                                    <div class="price">
                                                        <?php if (!empty($pruductr['priceAction'])) : ?> 
                                                            <del><?= $pruductr['price']; ?> грн</del>
                                                            <?= $pruductr['priceAction']; ?> грн
                                                        <?php else: ?>
                                                            <?= $pruductr['price']; ?> грн
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                                <div class="txtOver"> <?= $brands_array[$pruductr['made']]['nameCompany']." ".$pruductr['title']; ?></div>
                                                <a href="/item/<?= $pruductr['translit']; ?>_<?= $pruductr['productId']; ?>.html" class="btn btn-success buttonmerg">Смотреть</a>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            <?php }; ?>
                           <div class="pull-right">
                                <a  style="color:#000;"href="/climbing"id="view_more" >Смотреть больше>></a>
                            </div>
                        <?php else: ?>
                            Нету товара по даной катогрии
                        <?php endif; ?>
                    </div>
                </div>
            </div><!--/category-tab-->
             <?php if (!empty($pruducts)) : ?>                       
                <div class="recommended_items"><!--features_items-->
                    <h2 class="title text-center">Популярные товары</h2>
                    <div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                    <?php foreach ($pruducts as $key => $pruduct) { ?>
                        <?php if ($key == 0 || $key % 4 == 0) { ?>
                            <div class="item <?php if ($key == 0) { ?>active<?php } ?>"><?php } ?>
                                    <div class="col-sm-3">
                                        <div class="product-image-wrapper">
                                            <div class="single-products">
                                                <div class="productinfo text-center">
                                                    <div class="img_hiegth">
                                                        <a title="<?= $pruduct['title']; ?>" href="/item/<?= $pruduct['translit']; ?>_<?= $pruduct['productId']; ?>.html">
                                                            <img  src="<?php echo $pruduct['image'] ? $pruduct['image'] : "/images/nopoto.gif" ?>" alt="" />
                                                        </a>
                                                    </div>
                                                    <div class="row">
                                                                <div class="price">
                                                                    <?php if (!empty($pruduct['priceAction'])) : ?> 
                                                                        <del><?= $pruduct['price']; ?> грн</del>
                                                                        <?= $pruduct['priceAction']; ?> грн
                                                                    <?php else: ?>
                                                                        <?= $pruduct['price']; ?> грн
                                                                    <?php endif; ?>
                                                                </div>
                                                            </div>
                                                    <div class="txtOver">
                                                           <?= $brands_array[$pruduct['made']]['nameCompany']." ".$pruduct['title']; ?>
                                                    </div>
                                                    <a href="/item/<?= $pruduct['translit']; ?>_<?= $pruduct['productId']; ?>.html" class="btn btn-success buttonmerg">Смотреть</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                  <?php if (($key + 1) % 4 == 0) { ?></div><?php } ?>
                                <?php }; ?>
                        </div>
                        <a class="left recommended-item-control" href="#recommended-item-carousel" data-slide="prev">
                            <i class="fa fa-angle-left"></i>
                        </a>
                        <a class="right recommended-item-control" href="#recommended-item-carousel" data-slide="next">
                            <i class="fa fa-angle-right"></i>
                        </a>			
                    </div>
                </div>
             <?php endif; ?>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-lg-4 col-md-6 text-center">
            <div class="service-box">
                <h3>Ремонт велосипедов</h3>
                <p class="text-muted">У нас Вы можете отремонтировать или запгрейдить любой велосипед.</p>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 text-center">
            <div class="service-box">
                <h3>Снаряжение напрокат</h3>
                <p class="text-muted">Идете первый раз в поход? 
                    Нету времени и денег на покупку? 
                    Возьмите снаряжение на прокат и попробуйте.</p>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 text-center">
            <div class="service-box">
                <h3>100% гарантия качества</h3>
                <p class="text-muted">Наш товар   отличается  высоким качеством продукции, 
                    которая будет вам служить долго и надежно</p>
            </div>
        </div>
    </div>
</div>
<div class="container" style="  margin-bottom: 15px;">
    <div class="col-md-12">
        <div style="margin-left:25%" class="mhide" >
            <div id="vk_groups" ></div>
        </div>
        <script type="text/javascript">
            VK.Widgets.Group("vk_groups", {mode: 2, width: "620", height: "400",
                color1:"fff",color2:"333",color3:"E31E24"},31697024);
        </script>
    </div>
</div>
