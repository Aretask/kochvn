<?php use yii\widgets\LinkPager;?>
<?php if(!empty($data)) :?>  
 <?php foreach ($data as $key=>$value): ?>
          <tr id="item<?= $value['productId'] ?>" >
              <td><input type="checkbox"  value="<?= $value['productId'] ?>" /></td>
              <td><?= $value['productId'] ?></td>
              <td><?= $value['title'] ?> </td>
              <td><?= $value['priceSet'] ?></td>
              <td><?= $value['nameSuplier'] ?><br>(<?= $value['curenccy'] ?>)</td>
              <td><?= $value['price'] ?></td>
              <td><?= $value['name'] ?></td>
              <td><?= $value['filter'] ?></td>
              <td>
                 <a  target="_blank" href="/admin/products/add?id=<?= $value['productId'] ?>"><div class="btn btn-primary completeorder">Редактировать</div></a>
                 <?php if($value['status']==1){?><br>Не активно<?php }?>
              </td>
          </tr>
          <?php endforeach; ?>
          <?php if(!empty($pages)) :?> 
          <tr>
            <td colspan=9 id="pagination">
       <?php  echo LinkPager::widget([
    'pagination' => $pages,
]);?>
                  <script>
                      $('#pagination').find('a').on('click',function(e){
                          e.preventDefault();
                          var page=$(e.target).attr('data-page');
                          page=Number(page)+1;
                          $('#searchProduct').trigger('submit',page);
                      })
              </script>
             </td>
          </tr>
          <?php endif; ?>
          <tr>
              <td>
                    Всего: <?= $total ?>
              </td>
          </tr>
<?php endif; ?>