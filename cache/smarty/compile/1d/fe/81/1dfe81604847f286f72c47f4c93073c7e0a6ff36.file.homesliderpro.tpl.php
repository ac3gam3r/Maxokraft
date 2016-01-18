<?php /* Smarty version Smarty-3.1.19, created on 2016-01-11 19:51:23
         compiled from "/home/ac3gam3r/public_html/modules/homesliderpro/views/templates/hook/homesliderpro.tpl" */ ?>
<?php /*%%SmartyHeaderCode:13645291385693ba63c87251-20635183%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1dfe81604847f286f72c47f4c93073c7e0a6ff36' => 
    array (
      0 => '/home/ac3gam3r/public_html/modules/homesliderpro/views/templates/hook/homesliderpro.tpl',
      1 => 1430161853,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13645291385693ba63c87251-20635183',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'homeslider_slides' => 0,
    'hookid' => 0,
    'slideName' => 0,
    'configuration' => 0,
    'number' => 0,
    'slide' => 0,
    'content_dir' => 0,
    'area' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5693ba64067c16_04011758',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5693ba64067c16_04011758')) {function content_5693ba64067c16_04011758($_smarty_tpl) {?><!-- Module SlidersEverywhere -->
<?php if (isset($_smarty_tpl->tpl_vars['homeslider_slides']->value)&&count($_smarty_tpl->tpl_vars['homeslider_slides']->value)>0) {?>
	<div data-name="<?php echo $_smarty_tpl->tpl_vars['hookid']->value;?>
" class="SEslider notLoaded seslider_<?php echo $_smarty_tpl->tpl_vars['hookid']->value;?>
 <?php echo $_smarty_tpl->tpl_vars['slideName']->value;?>
 mode_<?php echo $_smarty_tpl->tpl_vars['configuration']->value['mode'];?>
 <?php if ($_smarty_tpl->tpl_vars['configuration']->value['autoControls']) {?>withControls<?php }?> sliderFigo"
		<?php if ($_smarty_tpl->tpl_vars['configuration']->value['mode']!='carousel') {?>
			style="max-width:<?php echo $_smarty_tpl->tpl_vars['configuration']->value['width'];?>
px;"
		<?php }?>>
		<ul id="SEslider_<?php echo $_smarty_tpl->tpl_vars['hookid']->value;?>
" style="margin:0;">
		<?php $_smarty_tpl->tpl_vars["number"] = new Smarty_variable("0", null, 0);?> 
		<?php  $_smarty_tpl->tpl_vars['slide'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['slide']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['homeslider_slides']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['slide']->key => $_smarty_tpl->tpl_vars['slide']->value) {
$_smarty_tpl->tpl_vars['slide']->_loop = true;
?>
			<?php $_smarty_tpl->tpl_vars['number'] = new Smarty_variable($_smarty_tpl->tpl_vars['number']->value+1, null, 0);?>
			<?php if ($_smarty_tpl->tpl_vars['slide']->value['active']&&$_smarty_tpl->tpl_vars['slide']->value['image']!='') {?>
				<li <?php if ($_smarty_tpl->tpl_vars['number']->value==1) {?>class="primo active"<?php }?> style="padding:0;" data-slide-index="<?php echo $_smarty_tpl->tpl_vars['number']->value;?>
">
					<?php if ($_smarty_tpl->tpl_vars['slide']->value['url']!='') {?>
						<a class="SElink" href="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['slide']->value['url'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" <?php if ($_smarty_tpl->tpl_vars['slide']->value['new_window']==1) {?>target="_blank"<?php }?>>
					<?php }?>
						<img class="SEimage" src="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
modules/homesliderpro/images/<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['slide']->value['image'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" alt="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['slide']->value['legend'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" height="<?php echo intval($_smarty_tpl->tpl_vars['configuration']->value['height']);?>
" width="<?php echo intval($_smarty_tpl->tpl_vars['configuration']->value['width']);?>
" />
					<?php if ($_smarty_tpl->tpl_vars['slide']->value['url']!='') {?>
						</a>
					<?php }?>
					<?php if ($_smarty_tpl->tpl_vars['slide']->value['description']!='') {?>
						<span class="slide_description"><?php echo $_smarty_tpl->tpl_vars['slide']->value['description'];?>
</span>
					<?php }?>
					<?php if ($_smarty_tpl->tpl_vars['configuration']->value['show_title']==1&&$_smarty_tpl->tpl_vars['slide']->value['title']!='') {?>
						<h2 class="slidetitle<?php if ($_smarty_tpl->tpl_vars['configuration']->value['title_pos']==1) {?> right<?php } else { ?> left<?php }?>"><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['slide']->value['title'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</h2>
					<?php }?>
					<?php if ($_smarty_tpl->tpl_vars['slide']->value['has_area']&&!empty($_smarty_tpl->tpl_vars['slide']->value['areas'])) {?>
						<?php  $_smarty_tpl->tpl_vars['area'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['area']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['slide']->value['areas']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['area']['index']=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['area']->key => $_smarty_tpl->tpl_vars['area']->value) {
$_smarty_tpl->tpl_vars['area']->_loop = true;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['area']['index']++;
?>
							<?php if ($_smarty_tpl->tpl_vars['area']->value->url&&($_smarty_tpl->tpl_vars['area']->value->button==''||(!isset($_smarty_tpl->tpl_vars['area']->value->style)||$_smarty_tpl->tpl_vars['area']->value->style=='simple'))) {?>
								<a href="<?php echo $_smarty_tpl->tpl_vars['area']->value->url;?>
" 
							<?php } else { ?>
								<span
							<?php }?> 
							data-slideindex="<?php echo $_smarty_tpl->tpl_vars['number']->value;?>
"
							data-areaindex="<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['area']['index'];?>
"
							data-color="<?php echo $_smarty_tpl->tpl_vars['area']->value->color;?>
"
							class="areaslide<?php if (isset($_smarty_tpl->tpl_vars['area']->value->style)) {?> <?php echo $_smarty_tpl->tpl_vars['area']->value->style;?>
<?php }?><?php if (isset($_smarty_tpl->tpl_vars['area']->value->color)) {?> <?php echo $_smarty_tpl->tpl_vars['area']->value->color;?>
<?php }?>" style="
							left:<?php echo $_smarty_tpl->tpl_vars['area']->value->left;?>
%;
							top:<?php echo $_smarty_tpl->tpl_vars['area']->value->top;?>
%;
							width:<?php echo $_smarty_tpl->tpl_vars['area']->value->selWidth;?>
%;
							height:<?php echo $_smarty_tpl->tpl_vars['area']->value->selHeight;?>
%;">
								<?php if ($_smarty_tpl->tpl_vars['area']->value->title!='') {?><span class="areatitle"><?php echo $_smarty_tpl->tpl_vars['area']->value->title;?>
</span><?php }?>
								<?php if ($_smarty_tpl->tpl_vars['area']->value->description!='') {?>
									<span class="areadesc" id="desc_<?php echo $_smarty_tpl->tpl_vars['hookid']->value;?>
_<?php echo $_smarty_tpl->tpl_vars['number']->value;?>
_<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['area']['index'];?>
">
										<?php echo $_smarty_tpl->tpl_vars['area']->value->description;?>

									</span>
								<?php }?>
								<?php if ($_smarty_tpl->tpl_vars['area']->value->button!=''&&(isset($_smarty_tpl->tpl_vars['area']->value->style)&&$_smarty_tpl->tpl_vars['area']->value->style!='simple')) {?>
									<span class="areabuttcont">
										<?php if ($_smarty_tpl->tpl_vars['area']->value->url) {?>
											<a href="<?php echo $_smarty_tpl->tpl_vars['area']->value->url;?>
">
										<?php }?>
										<span class="areabutt"><?php echo $_smarty_tpl->tpl_vars['area']->value->button;?>
</span>
										<?php if ($_smarty_tpl->tpl_vars['area']->value->url) {?>
										</a>
										<?php }?>
									</span>
								<?php }?>
							<?php if ($_smarty_tpl->tpl_vars['area']->value->url&&($_smarty_tpl->tpl_vars['area']->value->button==''||(!isset($_smarty_tpl->tpl_vars['area']->value->style)||$_smarty_tpl->tpl_vars['area']->value->style=='simple'))) {?></a><?php } else { ?></span><?php }?>
						<?php } ?>
					<?php }?>
				</li>
			<?php }?>
		<?php } ?>
		</ul>
	</div>
<?php }?>

<?php if (count($_smarty_tpl->tpl_vars['homeslider_slides']->value)>1) {?>
	<script type="text/javascript">
	
	function initSlide_<?php echo $_smarty_tpl->tpl_vars['hookid']->value;?>
() {
		<?php if (count($_smarty_tpl->tpl_vars['homeslider_slides']->value)>1) {?>
			var auto = <?php echo $_smarty_tpl->tpl_vars['configuration']->value['auto'];?>
,
				controls = <?php echo $_smarty_tpl->tpl_vars['configuration']->value['controls'];?>
,
				pager = <?php echo $_smarty_tpl->tpl_vars['configuration']->value['pager'];?>
;
			<?php if (isset($_smarty_tpl->tpl_vars['configuration']->value['autoControls'])&&$_smarty_tpl->tpl_vars['configuration']->value['autoControls']) {?>
				var autoControls = true,
					autoControlsCombine = true;
			<?php } else { ?>
				var autoControls = false,
					autoControlsCombine = false;
			<?php }?>
		<?php } else { ?>
			var auto = false,
				controls = false,
				pager = false;
		<?php }?>
		
		var confWidth = <?php echo $_smarty_tpl->tpl_vars['configuration']->value['width'];?>
;
		var confHeight = <?php echo $_smarty_tpl->tpl_vars['configuration']->value['height'];?>
;
		var imgnum = <?php echo count($_smarty_tpl->tpl_vars['homeslider_slides']->value);?>
;
	
	
		var $slider = $('#SEslider_<?php echo $_smarty_tpl->tpl_vars['hookid']->value;?>
'); //cache for performance
		$slider.seSlider({
			arrowClass: 'myarrow',
			nextClass: 'mynext',
			prevClass: 'myprev',
			playClass: 'fa fa-play',
			stopClass: 'fa fa-pause',
			pagerClass: 'mypager',
			infiniteLoop: <?php echo $_smarty_tpl->tpl_vars['configuration']->value['loop'];?>
,
			hideControlOnEnd: true,
			controls: controls,
			pager: pager,
			autoHover: true,
			preloadImages: 'visible',
			auto: auto,
			speed: <?php echo $_smarty_tpl->tpl_vars['configuration']->value['speed'];?>
,
			pause: <?php echo $_smarty_tpl->tpl_vars['configuration']->value['pause'];?>
,
			autoControls: autoControls,
			autoControlsCombine : autoControlsCombine,
			slideMargin: <?php echo $_smarty_tpl->tpl_vars['configuration']->value['margin'];?>
,
			mode: '<?php if ($_smarty_tpl->tpl_vars['configuration']->value['mode']!="carousel") {?><?php echo $_smarty_tpl->tpl_vars['configuration']->value['mode'];?>
<?php } else { ?>horizontal<?php }?>',
			autoDirection: '<?php echo $_smarty_tpl->tpl_vars['configuration']->value['direction'];?>
',
			onSlideBefore: function($slideElement, oldIndex, newIndex){
				$slider.find('li').removeClass('old active-slide next prev');
				if (oldIndex < newIndex || (oldIndex == $slider.find('li').length-1 && newIndex == 0) ) {
					$slider.find('li').removeClass('left');
					$slider.find('li').eq(oldIndex).addClass('old next');	
					$slideElement.addClass('active-slide next');
				} else {
					$slider.find('li').addClass('left');
					$slider.find('li').eq(oldIndex).addClass('old prev');		
					$slideElement.addClass('active-slide prev');
				}
			},
			onSlideNext: function($slideElement, oldIndex, newIndex){
			},
			onSlidePrev: function($slideElement, oldIndex, newIndex){		
			},
			onSlideAfter: function($slideElement, oldIndex, newIndex){
			},
			onSliderLoad: function (currentIndex) {
				$('.seslider_<?php echo $_smarty_tpl->tpl_vars['hookid']->value;?>
').removeClass('notLoaded');
				$slider.find('li').eq(currentIndex).addClass('active-slide');
				if ('<?php echo $_smarty_tpl->tpl_vars['configuration']->value['direction'];?>
' != 'next')
					$slider.find('li').addClass('left');
				var perspective = $slider.width()*3+'px';
				$slider.css({
					'perspective':perspective ,
					'-webkit-perspective':perspective 
				})
			}
			<?php if ($_smarty_tpl->tpl_vars['configuration']->value['mode']=='carousel') {?>,
				minSlides: <?php echo $_smarty_tpl->tpl_vars['configuration']->value['min_slides'];?>
,
				maxSlides: <?php echo $_smarty_tpl->tpl_vars['configuration']->value['max_slides'];?>
,
				moveSlides: 0,
				slideWidth:<?php echo $_smarty_tpl->tpl_vars['configuration']->value['width'];?>
/<?php echo $_smarty_tpl->tpl_vars['configuration']->value['max_slides'];?>

			<?php }?>
		});
		
		if (<?php echo $_smarty_tpl->tpl_vars['configuration']->value['restartAuto'];?>
){
			$slider.mouseleave(function(){
				$slider.startAuto();
			})
		}
		
		
	}
	
	initSlide_<?php echo $_smarty_tpl->tpl_vars['hookid']->value;?>
();
	</script>
<?php }?>
<!-- /Module SlidersEverywhere --><?php }} ?>
