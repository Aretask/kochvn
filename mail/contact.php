<h2>Заказчик:</h2>
<strong>Имя:</strong><?= $user_data['nameBuyer'];?><br>
<strong>Телефон:</strong><?= $user_data['phoneBuyerf'];?><br>
<strong>Email:</strong><?= $user_data['mailBuyer'];?><br>
<strong>Всего к оплате:</strong><?= $user_data['total'];?> грн<br>
<table style="width:100%">
					<thead>
						<tr class="cart_menu">
                                                    <td class="image"><strong>Товар</strong></td>
							<td class="description"><strong>Описание</strong></td>
							<td class="price"><strong>Цена</strong></td>
							<td class="quantity"><strong>Количество</strong></td>
							<td class="total"><strong>Всего</strong></td>
						</tr>
					</thead>
					<tbody>
                                              <?php foreach($orders as $order) { ?>
						<tr>
							<td style="width:20%">
								<a href="http://kochevnik.com.ua/item/<?= $order['translit']; ?>_<?= $order['productId']; ?>.html">
                                                                    <img class="img" src="http://kochevnik.com.ua<?php echo !empty($order['image'])? $order['image']:"/images/nopoto.gif" ?>" alt="">
                                                                </a>
							</td>
							<td style="width:60%">
								<h4><a href="http://kochevnik.com.ua/item/<?= $order['translit']; ?>_<?= $order['productId']; ?>.html"><?=$order['title'] ?></a></h4>
                                                                <?php if(!empty($order['filter'])) {?>
                                                                     <?php foreach($order['filter'] as $filter) { ?>
                                                                         <strong><?= $filter['nameFilter']; ?>:</strong> <?= $filter['nameItem']; ?><br>
                                                                    <?php };?>
                                                                <?php };?>
							</td>
							<td style="width:5%">
								<p><span><?=$order['price'] ?></span> грн</p>
							</td>
							<td style="width:5%">
								<div class="cart_quantity_button">
                                                                    <?=$order['count'] ?>
								</div>
							</td>
							<td style="width:5%">
								<p class="cart_total_price"><span><?=$order['price_total'] ?></span>грн</p>
							</td>
						</tr>
                                        <?php };?>
						
					</tbody>
				</table>
        