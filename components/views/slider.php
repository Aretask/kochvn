<div class="row mhide" style="margin-bottom: 10px;">
<div class="col-sm-8">
<div id="jssor_1" style="position: relative; margin: 0 auto; top: 0px; left: 0px; width: 800px; height: 300px; overflow: hidden; visibility: hidden;">
        <!-- Loading Screen -->
        <div data-u="loading" style="position: absolute; top: 0px; left: 0px;">
            <div style="filter: alpha(opacity=70); opacity: 0.7; position: absolute; display: block; top: 0px; left: 0px; width: 100%; height: 100%;"></div>
            <div style="position:absolute;display:block;background:url('/images/loading.gif') no-repeat center center;top:0px;left:0px;width:100%;height:100%;"></div>
        </div>
        <div data-u="slides" style="cursor: default; position: relative; top: 0px; left: 0px; width: 800px; height: 300px; overflow: hidden;">
            <?php foreach($photo as $value) { ?>
            <div data-p="112.50" style="display: none;">
                <img data-u="image" src="<?= $value['photoUrl']; ?>" />
            </div>
             <?php };?>
        </div>
        <!-- Bullet Navigator -->
        <div data-u="navigator" class="jssorb01" style="bottom:16px;right:16px;" data-autocenter="1">
            <div data-u="prototype" style="width:12px;height:12px;"></div>
        </div>
        <!-- Arrow Navigator -->
        <span data-u="arrowleft" class="jssora13l" style="top:0px;left:30px;width:40px;height:50px;" data-autocenter="2"></span>
        <span data-u="arrowright" class="jssora13r" style="top:0px;right:30px;width:40px;height:50px;" data-autocenter="2"></span>
        <a href="http://www.jssor.com" style="display:none">Slideshow Maker</a>
    </div>
    <script>
        jssor_1_slider_init();
    </script>
</div>
<div class="col-sm-4 ">
    <div class="movieinfo">
					<h3>Качественное туристическое снаряжение для любителей и профессионалов</h3>
                                        <h3>Консультация у людей, использующих это снаряжение на практике.</h3>
   <h3>Фотографии, походы, видеообзоры и тест-драйв снаряжения можно увидеть на нашем сайте.</h3>
				</div>
   
</div>
</div>