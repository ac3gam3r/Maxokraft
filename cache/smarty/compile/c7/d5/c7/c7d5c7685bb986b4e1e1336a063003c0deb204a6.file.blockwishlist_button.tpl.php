<?php /* Smarty version Smarty-3.1.19, created on 2016-01-11 12:29:43
         compiled from "/home/ac3gam3r/public_html/themes/default-bootstrap/modules/blockwishlist/blockwishlist_button.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1045727436569352df3bd016-82526587%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c7d5c7685bb986b4e1e1336a063003c0deb204a6' => 
    array (
      0 => '/home/ac3gam3r/public_html/themes/default-bootstrap/modules/blockwishlist/blockwishlist_button.tpl',
      1 => 1434599834,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1045727436569352df3bd016-82526587',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'product' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_569352df406036_18423415',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_569352df406036_18423415')) {function content_569352df406036_18423415($_smarty_tpl) {?>

<div class="wishlist">
	<a class="addToWishlist wishlistProd_<?php echo intval($_smarty_tpl->tpl_vars['product']->value['id_product']);?>
" href="#" rel="<?php echo intval($_smarty_tpl->tpl_vars['product']->value['id_product']);?>
" onclick="WishlistCart('wishlist_block_list', 'add', '<?php echo intval($_smarty_tpl->tpl_vars['product']->value['id_product']);?>
', false, 1); return false;">
		<?php echo smartyTranslate(array('s'=>"Wish it",'mod'=>'blockwishlist'),$_smarty_tpl);?>

	</a>
</div><?php }} ?>
