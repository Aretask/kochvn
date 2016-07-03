<div class="container"style="margin-top: 15px;">
    <div class="row">
        <?php if(!empty($orders)) :?> 
<div class="table-responsive cart_info">
        <div id="goodOrder" class="hide alert alert-info">
            <p>Спасибо, ваш заказ принят. Наш менеджер свяжется с вами в ближайшее время.</p>
        </div>
    <form id="formOrderUser" method="post">
				<table class="table table-condensed" id="ordersTable">
					<thead>
						<tr class="cart_menu">
                                                    <td class="image"> <div type="button" class="pull-left" check="0" id="checkAll"></div>&nbsp;&nbsp;&nbsp;Товар</td>
							<td class="description"></td>
							<td class="price">Цена</td>
							<td class="quantity">Количество</td>
							<td class="total">Всего</td>
							<td></td>
						</tr>
					</thead>
					<tbody>
                                              <?php foreach($orders as $order) { ?>
						<tr id="order_<?=$order['orderId'] ?>">
							<td class="cart_product">
                                                                 <input type="checkbox" class="order_id" name="orderId[<?=$order['orderId'] ?>]" value="<?=$order['productId'] ?>">
                                                                 <input type="hidden"  name="filters[<?=$order['orderId'] ?>]" value="<?=$order['filterOrder'] ?>">
								<a href="/item/<?= $order['translit']; ?>_<?= $order['productId']; ?>.html">
                                                                    <img style="height:100px"src="<?php echo !empty($order['image'])? $order['image']:"/images/nopoto.gif" ?>" alt="">
                                                                </a>
							</td>
							<td class="cart_description">
								<h4><a href="/item/<?= $order['translit']; ?>_<?= $order['productId']; ?>.html"><?=$order['title'] ?></a></h4>
                                                                <?php if(!empty($order['filter'])) {?>
                                                                     <?php foreach($order['filter'] as $filter) { ?>
                                                                         <strong><?= $filter['nameFilter']; ?>:</strong> <?= $filter['nameItem']; ?><br>
                                                                    <?php };?>
                                                                <?php };?>
							</td>
							<td class="cart_price">
								<p><span><?=$order['price'] ?></span> грн</p>
							</td>
							<td class="cart_quantity">
								<div class="cart_quantity_button">
									<a class="cart_quantity_up number" href="javascript:void(0);"> + </a>
									<input class="cart_quantity_input" type="text" name="quantity[<?=$order['orderId'] ?>]" value="1" autocomplete="off" size="2">
									<a class="cart_quantity_down number" href="javascript:void(0);"> - </a>
								</div>
							</td>
							<td class="cart_total">
								<p class="cart_total_price"><span><?=$order['price'] ?></span>грн</p>
							</td>
							<td class="cart_delete">
								<a  itemdel="<?=$order['orderId'] ?>" class="cart_quantity_delete" href="javascript:void(0);"><i itemdel="<?=$order['orderId'] ?>"  class="fa fa-times"></i></a>
							</td>
						</tr>
                                        <?php };?>
						
					</tbody>
				</table>
        
        
        <div id="order"> 
        <div class="heading">
				<h3>Отправить заказ</h3>
				<p>Заполните пожалуйста форму. После отпарвки заказа, с вами свяжется менеджер для уточнения данных, в течении дня.</p>
			</div>
        <div class="row">
				<div class="col-sm-6">
                                    <div class="total_area">
						<ul>
							<li>Всего к оплате,  <span id="total_sum">0</span> грн</li>
                                                        <li>
								<label>Имя:</label>
								<input required  id="userName"style="margin-left: 6%;" name="nameBuyer" type="text">
							</li>
							<li>
								<label>Телефон:</label>
								<input required id="phoneNumber" name="phoneBuyer" type="text">
							</li>
							<li>
								<label>Email:</label>
								<input required id="email" name="mailBuyer"style="margin-left: 5%;"type="text">
							</li>
						</ul>
						<button  type="submit"class=" btn btn-success  pull-right" href="">Отправить заказ</button>
					</div>
				</div>
			</div>
    </form>
			</div>
			</div>
         <?php else: ?>
        <div class="message">
            К сожалению ваша корзина пуста, добавьте товар! 
        </div>
          
         <?php endif; ?>
    </div>
    </div>
