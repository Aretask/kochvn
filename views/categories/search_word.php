 <?php if(!empty($pruducts)) :?>
    <ul class="media-list" style="text-align: center">
      <?php foreach($pruducts as $pruduct) { ?>
          <li class="media">
              <a title="<?= $pruduct['title']; ?>" href="/item/<?= $pruduct['translit']; ?>_<?= $pruduct['productId']; ?>.html">
                  <img src="<?php echo $pruduct['image']? $pruduct['image']:"/images/nopoto.gif" ?>" alt="" />
              </a>
              <div class="media-body">
                  <a title="<?= $brands_array[$pruduct['made']]['nameCompany']." ".$pruduct['title']; ?>"
                     href="/item/<?= $pruduct['translit']; ?>_<?= $pruduct['productId']; ?>.html">
                      <h4 class="media-heading" >
                          <?= $brands_array[$pruduct['made']]['nameCompany']." ".$pruduct['title']; ?>
                      </h4>
                  </a>
              </div>
          </li>
         <?php };?>
        <div id="search_more">
            <a class="btn btn-success" href="/search/?search_word=<?= $search_word; ?>">Все товары</a>
        </div>
    </ul> 
 <?php endif; ?>