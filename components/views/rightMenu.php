<div class="col-md-2">        
       <?php if(!empty($filters)) :?> 
                        <a style="margin-left: 55%;"id="clear_filter" class="btn btn-xs btn-danger" href="javascript:void(0)"><i class="fa fa-times-circle"></i>Очистить</a>
                            <form id="filters">
                               <?php foreach($filters as $filter) { ?>
                                 <div class="panel panel-default sidebar-menu">
                                   <div class="panel-heading">
                                  <h3 class="panel-title"><?= $filter['name'];?></h3>
                                  </div>
                                <div class="form-group" style="margin-left: 5px;">
                                      <?php foreach($filter['filters'] as $key=>$item) { ?>
                                    <div class="checkbox">
                                        <label>
                                            <input <?php if(in_array($key, $filter_ids)) echo 'checked'; ?> type="checkbox" name="filter[]" value="<?=$key;?>">
                                            <span class="colour white"></span>
                                            <?= $item;?>
                                        </label>
                                    </div>
                                     <?php };?>
                                </div>
                                </div>
                                <?php };?>
                            </form>
  <?php endif; ?>
                    <!-- *** MENUS AND FILTERS END *** -->

 </div>
