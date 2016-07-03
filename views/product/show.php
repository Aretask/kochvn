<?php

use yii\widgets\LinkPager;
use app\components\LeftMenuWidget;

$count_photo = 0;
?>
<div class="container"style="margin-top: 15px;">
    <div class="row">

        <div class="col-md-12">
            <ul class="breadcrumb">
                <li>
                    <a href="/">Главная</a>
                </li>
                <li>
                    <a href="/<?= $product['rub_eng']; ?>"><?= $product['rub_name']; ?></a>
                </li>
                <li>
                    <a href="/<?= $product['rub_eng']; ?>/<?= $product['cat_eng']; ?>"><?= $product['cat_name']; ?></a>
                </li>
                <li><?= $product['nameCompany']." ".$product['title']; ?></li>
            </ul>
        </div>
<?= LeftMenuWidget::widget(['rub' => $product['rubricId'], 'cat' => $product['categoryId']]) ?>
        <div class="col-sm-9 padding-right">
            <div class="product-details"><!--product-details-->
                <div class="col-sm-6">
                                                                <div id="similar-product" class="carousel slide" data-ride="carousel">
                    <?php if (!empty($photo_product)): ?>
                            <!-- Wrapper for slides -->
                            <div class="carousel-inner" id="carousel-inner">
                                <div class="item active">
                                        <?php foreach ($photo_product as $value) : ?>
                                            <?php if ($count_photo != 0 && $count_photo % 3 == 0): ?>
                                            <div class="item">
                                            <?php endif; ?>
                                            <img src="<?= $value['thumb'] ?>" alt="">
                                        <?php $count_photo++; ?>
                                        <?php if ($count_photo && $count_photo % 3 == 0): ?>
                                            </div>
                                        <?php endif; ?>
                                <?php endforeach; ?>
                                <?php if ($count_photo && $count_photo % 3 != 0): ?>
                                    </div>
    <?php endif; ?>
                            </div>
                            <!-- Controls -->
                            <a class="left item-control" href="#similar-product" data-slide="prev">
                                <i class="fa fa-angle-left"></i>
                            </a>
                            <a class="right item-control" href="#similar-product" data-slide="next">
                                <i class="fa fa-angle-right"></i>
                            </a>
<?php endif; ?>
                    </div>
                    <div class="view-product text-center">
                        <div style="margin: auto 0px">
                            <img id="main_photo" src="<?php echo!empty($product['image']) ? $product['image'] : "/images/nopoto.gif" ?>" alt="">
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="product-information"><!--/product-information-->
                        <h2><?= $product['nameCompany']." ".$product['title']; ?></h2>
                        <form id="form_order">
                            <span>
                                <?php if(!empty($product['priceAction'])) :?> 
                                <del><?= $product['price']; ?> грн</del>
                                <span><?= $product['priceAction']; ?> грн</span>
                                 <?php else: ?>
                                <span><?= $product['price']; ?> грн</span>
                                 <?php endif; ?>
                                <button id="order_button" type="submit" class="btn btn-success">
                                    <i class="fa fa-shopping-cart"></i>
                                    В корзину
                                </button>
                            </span>
                            <input type="hidden" value="<?= $product['productId']; ?>" name="productId">
                            <?php if (!empty($product_filter)): ?>
                                <?php foreach ($product_filter as $filter) : ?>
                                    <div><strong><?= $filter['name'] ?></strong></div>
                                    <?php foreach ($filter['filter'] as $key => $filt) : ?>
                                        <label class="checkbox-inline"><input name="filter[]" type="checkbox" value="<?= $key ?>"><?= $filt ?></label>
                                    <?php endforeach; ?>
    <?php endforeach; ?>
<?php endif; ?>



                        </form> 
                        <br>
                        <script type="text/javascript">(function() {
                            if (window.pluso)if (typeof window.pluso.start == "function") return;
                            if (window.ifpluso==undefined) { window.ifpluso = 1;
                                var d = document, s = d.createElement('script'), g = 'getElementsByTagName';
                                s.type = 'text/javascript'; s.charset='UTF-8'; s.async = true;
                                s.src = ('https:' == window.location.protocol ? 'https' : 'http')  + '://share.pluso.ru/pluso-like.js';
                                var h=d[g]('body')[0];
                                h.appendChild(s);
                                                                    }})();</script>
                        <div class="pluso" data-background="transparent" data-options="medium,square,line,horizontal,nocounter,theme=04" data-services="vkontakte,facebook,twitter,google"></div>
                    </div><!--/product-information-->
                </div>
            </div><!--/product-details-->

            <div class="category-tab shop-details-tab"><!--category-tab-->
                <div class="col-sm-12">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#details" data-toggle="tab">Описание</a></li>
                         <?php if (!empty($specification_product)): ?>
                            <li class=""><a href="#specification" data-toggle="tab">Характеристики</a></li>
                         <?php endif; ?>
                    </ul>
                </div>
                <div class="tab-content">
                    <div class="tab-pane fade active in" id="details">
                         <?php if (!empty($product['description'])): ?>
                            <?= $product['description']; ?>
                        <?php else: ?>
                           Пока описания нету
                        <?php endif; ?>
                    </div>

                    <div class="tab-pane fade " id="specification">
                                <?php if (!empty($specification_product)): ?>
                            <table class="table table-hover">
                                <tbody>
                                <?php foreach ($specification_product as $spec) : ?>
                                            <tr>
                                                <td><?= $spec['nameSpecifications'] ?></td>
                                                <td><?= $spec['valueSpecifications'] ?></td>
                                            </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                                <?php endif; ?>
                    </div>

                </div>
            </div><!--/category-tab-->
 <?php if (!empty($special_product)): ?>
            <div class="recommended_items"><!--recommended_items-->
                <h2 class="title text-center">Рекомендуем посмотреть</h2>

                <div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <?php foreach ($special_product as $key => $pruduct) { ?>
                            <?php if ($key == 0 || $key % 4 == 0) { ?><div class="item <?php if ($key == 0) { ?>active<?php } ?>"><?php } ?>
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
                                                     <?php if (!empty($brands_array)) : ?> 
                                                           <?= $brands_array[$pruduct['made']]['nameCompany']." ".$pruduct['title']; ?>
                                                       <?php endif; ?>
                                                    </div>
                                                <a  href="/item/<?= $pruduct['translit']; ?>_<?= $pruduct['productId']; ?>.html" class="btn btn-success buttonmerg">Смотреть</a>
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
            </div><!--/recommended_items-->
  <?php endif; ?>
        </div>
        <!--        
        <!-- /.container -->
    </div>
</div>