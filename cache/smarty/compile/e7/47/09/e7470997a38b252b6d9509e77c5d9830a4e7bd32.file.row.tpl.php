<?php /* Smarty version Smarty-3.1.19, created on 2016-01-11 12:29:23
         compiled from "/home/ac3gam3r/public_html/admin1995/themes/default/template/helpers/kpi/row.tpl" */ ?>
<?php /*%%SmartyHeaderCode:468429066569352cb7609d5-67535925%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e7470997a38b252b6d9509e77c5d9830a4e7bd32' => 
    array (
      0 => '/home/ac3gam3r/public_html/admin1995/themes/default/template/helpers/kpi/row.tpl',
      1 => 1425640160,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '468429066569352cb7609d5-67535925',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'kpis' => 0,
    'kpi' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_569352cb78a9f9_01864469',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_569352cb78a9f9_01864469')) {function content_569352cb78a9f9_01864469($_smarty_tpl) {?>
<div class="panel kpi-container">
	<div class="row">
		<div class="col-lg-2" style="float:right"><button class="close refresh" type="button" onclick="refresh_kpis();"><i class="process-icon-refresh" style="font-size:1em"></i></button></div>
		<?php  $_smarty_tpl->tpl_vars['kpi'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['kpi']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['kpis']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['kpi']->key => $_smarty_tpl->tpl_vars['kpi']->value) {
$_smarty_tpl->tpl_vars['kpi']->_loop = true;
?>
		<div class="col-sm-5 col-lg-2">
			<?php echo $_smarty_tpl->tpl_vars['kpi']->value;?>

		</div>			
		<?php } ?>
	</div>
</div><?php }} ?>
