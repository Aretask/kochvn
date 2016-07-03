<?php foreach ($data as $key => $value) { ?>
          <tr id="item<?= $key; ?>" >
              <td><input type="checkbox"  value="<?= $key; ?>" /></td>
              <td><?= $key; ?></td>
              <td> <?= !empty($value[4])?$value[4]:""; ?></td>
              <td> <?= !empty($value[1])?$value[1]:""; ?></td>
              <td> <?= !empty($value[3])?$value[3]:""; ?></td>
              <td> <?= !empty($value[6])?$value[6]:""; ?></td>
              <td> <?= !empty($value[7])?$value[7]:""; ?></td>
              <td> <?= !empty($value[5])?$value[5]:""; ?></td>
              <td> <?= !empty($value[2])?$value[2]:""; ?></td>
          </tr>
<?php };?>