<?php /*%%SmartyHeaderCode:3145274315693be22e08f67-85441552%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5109e20534fa2971f2af32c73c665443a9c8142c' => 
    array (
      0 => '/home/ac3gam3r/public_html/modules/socialsharing/views/templates/hook/socialsharing.tpl',
      1 => 1429457076,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3145274315693be22e08f67-85441552',
  'variables' => 
  array (
    'PS_SC_TWITTER' => 0,
    'PS_SC_FACEBOOK' => 0,
    'PS_SC_GOOGLE' => 0,
    'PS_SC_PINTEREST' => 0,
    'module_dir' => 0,
    'link' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5693be22eaff15_31443062',
  'cache_lifetime' => 31536000,
),true); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5693be22eaff15_31443062')) {function content_5693be22eaff15_31443062($_smarty_tpl) {?>
	<p class="socialsharing_product list-inline no-print">
					<button data-type="twitter" type="button" class="btn btn-default btn-twitter social-sharing">
				<i class="icon-twitter"></i> Tweet
				<!-- <img src="http://www.maxokraft.com/modules/socialsharing/img/twitter.gif" alt="Tweet" /> -->
			</button>
							<button data-type="facebook" type="button" class="btn btn-default btn-facebook social-sharing">
				<i class="icon-facebook"></i> Share
				<!-- <img src="http://www.maxokraft.com/modules/socialsharing/img/facebook.gif" alt="Facebook Like" /> -->
			</button>
							<button data-type="google-plus" type="button" class="btn btn-default btn-google-plus social-sharing">
				<i class="icon-google-plus"></i> Google+
				<!-- <img src="http://www.maxokraft.com/modules/socialsharing/img/google.gif" alt="Google Plus" /> -->
			</button>
							<button data-type="pinterest" type="button" class="btn btn-default btn-pinterest social-sharing">
				<i class="icon-pinterest"></i> Pinterest
				<!-- <img src="http://www.maxokraft.com/modules/socialsharing/img/pinterest.gif" alt="Pinterest" /> -->
			</button>
			</p>
<?php }} ?>
