<div class="col-sm-3">
    <div class="left-sidebar">
        <div class="brands_products"><!--brands_products-->
            <h2>Поиск</h2>
            <div class="panel-body">
                <input type="search"  class="form-control" id="search">
                <span id="search_error" style="font-style: italic;"></span>
            </div>
            <div id="search_result" class="poup_serach hide">
            </div>
        </div>
          <?php if(!empty($companies)) :?> 
        <div class="brands_products"><!--brands_products-->
            <h2>Бренды</h2>
                 <div class="panel-body">
                            <select id="madel" class="selectpickerl" data-size="auto" data-live-search="true">
                                <option value="0">Все</option>
                                 <?php foreach($companies as $brand) { ?>
                                      <option <?php if($brand['eng']==$active['brand_act']) echo 'selected'; ?> value="<?= $brand['eng'];?>"><?= $brand['nameCompany'];?></option>
                                  <?php };?>
                            </select>
                            <div class="btn-group bootstrap-select"></div>
                         </div>

        </div>
         <?php endif; ?>
         <?php if(!empty($menu_date)) :?> 
        <h2>Категории</h2>
        <div class="panel-group category-products" id="accordian"><!--category-productsr-->
            <?php foreach ($menu_date as $rub => $menu) { ?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a  data-toggle="collapse" data-parent="#accordian" href="#<?= $menu['eng_rubric'] ?>">
                                <span class="badge pull-right"><i class="fa fa-plus"></i></span>
                                <?= $menu['rubric'] ?>
                            </a>
                        </h4>
                    </div>
                    <div id="<?= $menu['eng_rubric'] ?>" class="panel-collapse collapse <?php if ($active['rub'] == $rub) echo 'in'; ?>">
                        <div class="panel-body">
                            <ul>
                                <?php foreach ($menu['category'] as $menu_item) { ?>
                                    <li <?php if ($active['cat'] == $menu_item['categoryId']) echo 'class="active_border"'; ?>>
                                        <a href="/<?= $menu['eng_rubric'] ?>/<?= $menu_item['eng'] ?><?php if (!empty($active['brand'])) echo $active['brand']; ?>"><?= $menu_item['category'] ?></a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div><!--/category-products-->
        <?php endif; ?>
         <?php if(!empty($video)) :?> 
        <div style="text-align: center" class="mhide"><!--brands_products-->
            <h2>Интересное видео</h2>
               <?=$video ?>
        </div>
         <?php endif; ?>

    </div>
</div>   

