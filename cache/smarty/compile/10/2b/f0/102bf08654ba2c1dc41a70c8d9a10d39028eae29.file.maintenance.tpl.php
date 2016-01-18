<?php /* Smarty version Smarty-3.1.19, created on 2016-01-11 12:46:34
         compiled from "/home/ac3gam3r/public_html/themes/default-bootstrap/maintenance.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1047162914569356d25f7193-41484080%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '102bf08654ba2c1dc41a70c8d9a10d39028eae29' => 
    array (
      0 => '/home/ac3gam3r/public_html/themes/default-bootstrap/maintenance.tpl',
      1 => 1445401363,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1047162914569356d25f7193-41484080',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'language_code' => 0,
    'css_dir' => 0,
    'js_dir' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_569356d26db799_03120912',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_569356d26db799_03120912')) {function content_569356d26db799_03120912($_smarty_tpl) {?>

<!DOCTYPE html>
<html lang="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['language_code']->value, ENT_QUOTES, 'UTF-8', true);?>
">
	
	<head>
		<meta charset='utf-8' />
		<meta content='IE=edge,chrome=1' http-equiv='X-UA-Compatible' />
		<title>Maxokraft - Coming Soon</title>			
		<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['css_dir']->value;?>
maximage.css" type="text/css" media="screen" charset="utf-8" />
		<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['css_dir']->value;?>
stylestemp.css" type="text/css" media="screen" charset="utf-8" />
		
		
<script src='http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.js'></script>
		<script src="<?php echo $_smarty_tpl->tpl_vars['js_dir']->value;?>
jquery.easing.min.js" type="text/javascript" charset="utf-8"></script>
		<script src="<?php echo $_smarty_tpl->tpl_vars['js_dir']->value;?>
jquery.cycle.all.js" type="text/javascript" charset="utf-8"></script>
		<script src="<?php echo $_smarty_tpl->tpl_vars['js_dir']->value;?>
jquery.maximage.js" type="text/javascript" charset="utf-8"></script>
		<script src="<?php echo $_smarty_tpl->tpl_vars['js_dir']->value;?>
jquery.fullscreen.js" type="text/javascript" charset="utf-8"></script>
		<script src="<?php echo $_smarty_tpl->tpl_vars['js_dir']->value;?>
jquery.ba-hashchange.js" type="text/javascript" charset="utf-8"></script>
		<script src="<?php echo $_smarty_tpl->tpl_vars['js_dir']->value;?>
main.js" type="text/javascript" charset="utf-8"></script>
		
		<script type="text/javascript" charset="utf-8">
			$(function(){
				$('#maximage').maximage({
					cycleOptions: {
						fx: 'fade',
						speed: 1000, // Has to match the speed for CSS transitions in jQuery.maximage.css (lines 30 - 33)
						timeout: 5000,
						prev: '#arrow_left',
						next: '#arrow_right',
						pause: 0,
						before: function(last,current){
							if(!$.browser.msie){
								// Start HTML5 video when you arrive
								if($(current).find('video').length > 0) $(current).find('video')[0].play();
							}
						},
						after: function(last,current){
							if(!$.browser.msie){
								// Pauses HTML5 video when you leave it
								if($(last).find('video').length > 0) $(last).find('video')[0].pause();
							}
						}
					},
					onFirstImageLoaded: function(){
						jQuery('#cycle-loader').hide();
						jQuery('#maximage').fadeIn('fast');
					}
				});
	
				// Helper function to Fill and Center the HTML5 Video
				jQuery('video,object').maximage('maxcover');
	
			});
		</script>
	</head>
	<body>

	

		<!-- Site Logo -->
		<div id="logo">Maxokraft</div>

		<!-- Main Navigation -->
		<nav class="main-nav">
			<ul>
				<li><a href="#home" class="active">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Home</a></li>
				<li><a href="#about">About</a></li>
				<li><a href="#contact">Contact</a></li>
			</ul>
		</nav>

		<!-- Slider Controls -->
		<a href="" id="arrow_left"><img src="http://www.maxokraft.com/themes/default-bootstrap/images/arrow-left.png" alt="Slide Left" /></a>
		<a href="" id="arrow_right"><img src="http://www.maxokraft.com/themes/default-bootstrap/images/arrow-right.png" alt="Slide Right" /></a>

		<!-- Home Page -->
		<section class="content show" id="home">
			<h1>Welcome</h1>
			<h5>Maxokraft is coming soon to your favorite browser near you !</h5>
			<p></p>
			<p><a href="#about">More info &#187;</a></p>
		</section>

		<!-- About Page -->
		<section class="content hide" id="about">
			<h1>About</h1>
			<h5>Here's a little about what we're up to.</h5>
			<p>We are a team of individuals providing solutions to everyday business owners. </p>
		</section>

		<!-- Contact Page -->
		<section class="content hide" id="contact">
			<h1>Contact</h1>
			<h5>Get in touch.</h5>
			<p>Email: <a href="#">contact@maxokraft.com</a><br />
				Phone: 0674-2475293<br /></p>
			<p> Bhubaneswar<br />
				Odisha,India</p>
		</section>
		
		<!-- Background Slides -->
		<div id="maximage">
			<div>
				<img src="http://www.maxokraft.com/themes/default-bootstrap/images/1.jpg" alt="" />
				<img class="gradient" src="http://www.maxokraft.com/themes/default-bootstrap/images/gradient.png" alt="" />
			</div>
			<div>
				<img src="http://www.maxokraft.com/themes/default-bootstrap/images/2.jpg" alt="" />
				<img class="gradient" src="http://www.maxokraft.com/themes/default-bootstrap/images/gradient.png" alt="" />
			</div>
			<div>
				<img src="http://www.maxokraft.com/themes/default-bootstrap/images/3.jpg" alt="" />
				<img class="gradient" src="http://www.maxokraft.com/themes/default-bootstrap/images/gradient.png" alt="" />
			</div>
		</div>
		
		
  </body>
</html>
<?php }} ?>
