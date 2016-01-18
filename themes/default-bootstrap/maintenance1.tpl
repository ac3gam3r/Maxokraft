{*
* 2007-2015 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2015 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

<!DOCTYPE html>
<html lang="{$language_code|escape:'html':'UTF-8'}">
<head>
	<meta charset="utf-8">
	<title>{$meta_title|escape:'html':'UTF-8'}</title>	
{if isset($meta_description)}
	<meta name="description" content="{$meta_description|escape:'html':'UTF-8'}">
{/if}
{if isset($meta_keywords)}
	<meta name="keywords" content="{$meta_keywords|escape:'html':'UTF-8'}">
{/if}
	<meta name="robots" content="{if isset($nobots)}no{/if}index,follow">
	<link rel="shortcut icon" href="{$favicon_url}">
       	<link href="{$css_dir}maintenance.css" rel="stylesheet">
       	<link href='//fonts.googleapis.com/css?family=Open+Sans:600' rel='stylesheet'>
		<link rel="shortcut icon" href="favicon.ico" />
	
	<link rel="apple-touch-icon" href="images/favicon.png" />

		
		<link rel="stylesheet" href="{$css_dir}maximage.css" type="text/css" media="screen" charset="utf-8" />
		<link rel="stylesheet" href="{$css_dir}stylestemp.css" type="text/css" media="screen" charset="utf-8" />
		
		<!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
		
		<!--[if IE 6]>
			<style type="text/css" media="screen">
				.gradient {display:none;}
			</style>
		<![endif]-->
	<script src='http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.js'></script>
		<script src="js/jquery.easing.min.js" type="text/javascript" charset="utf-8"></script>
		<script src="js/jquery.cycle.all.js" type="text/javascript" charset="utf-8"></script>
		<script src="js/jquery.maximage.js" type="text/javascript" charset="utf-8"></script>
		<script src="js/jquery.fullscreen.js" type="text/javascript" charset="utf-8"></script>
		<script src="js/jquery.ba-hashchange.js" type="text/javascript" charset="utf-8"></script>
		<script src="js/main.js" type="text/javascript" charset="utf-8"></script>
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
		<a href="" id="arrow_left"><img src="images/arrow-left.png" alt="Slide Left" /></a>
		<a href="" id="arrow_right"><img src="images/arrow-right.png" alt="Slide Right" /></a>

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
				<img src="images/backgrounds/1.jpg" alt="" />
				<img class="gradient" src="images/backgrounds/gradient.png" alt="" />
			</div>
			<div>
				<img src="images/backgrounds/2.jpg" alt="" />
				<img class="gradient" src="images/backgrounds/gradient.png" alt="" />
			</div>
			<div>
				<img src="images/backgrounds/3.jpg" alt="" />
				<img class="gradient" src="images/backgrounds/gradient.png" alt="" />
			</div>
		</div>
		
		
		
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
  </body>
</html>
