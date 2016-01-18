<?php /* Smarty version Smarty-3.1.19, created on 2016-01-11 12:29:24
         compiled from "/home/ac3gam3r/public_html/admin1995/themes/default/template/content.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1287000411569352cc51c638-81109281%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '810099cb2bcfe1a375b5a32f8e2b6f7e4a777d4b' => 
    array (
      0 => '/home/ac3gam3r/public_html/admin1995/themes/default/template/content.tpl',
      1 => 1425640160,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1287000411569352cc51c638-81109281',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'content' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_569352cc53aff0_30060175',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_569352cc53aff0_30060175')) {function content_569352cc53aff0_30060175($_smarty_tpl) {?>
<div id="ajax_confirmation" class="alert alert-success hide"></div>

<div id="ajaxBox" style="display:none"></div>


<div class="row">
	<div class="col-lg-12">
		<?php if (isset($_smarty_tpl->tpl_vars['content']->value)) {?>
			<?php echo $_smarty_tpl->tpl_vars['content']->value;?>

		<?php }?>
	</div>
</div><?php }} ?>
