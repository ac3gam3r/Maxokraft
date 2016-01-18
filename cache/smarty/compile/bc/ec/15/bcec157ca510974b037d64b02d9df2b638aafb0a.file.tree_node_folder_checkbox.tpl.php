<?php /* Smarty version Smarty-3.1.19, created on 2016-01-11 19:57:00
         compiled from "/home/ac3gam3r/public_html/admin1995/themes/default/template/helpers/tree/tree_node_folder_checkbox.tpl" */ ?>
<?php /*%%SmartyHeaderCode:14628194575693bbb4b5f973-11133729%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'bcec157ca510974b037d64b02d9df2b638aafb0a' => 
    array (
      0 => '/home/ac3gam3r/public_html/admin1995/themes/default/template/helpers/tree/tree_node_folder_checkbox.tpl',
      1 => 1425640160,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '14628194575693bbb4b5f973-11133729',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'node' => 0,
    'root_category' => 0,
    'input_name' => 0,
    'children' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5693bbb4bb8283_32053961',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5693bbb4bb8283_32053961')) {function content_5693bbb4bb8283_32053961($_smarty_tpl) {?>
<li class="tree-folder">
	<span class="tree-folder-name<?php if (isset($_smarty_tpl->tpl_vars['node']->value['disabled'])&&$_smarty_tpl->tpl_vars['node']->value['disabled']==true) {?> tree-folder-name-disable<?php }?>">
		<?php if ($_smarty_tpl->tpl_vars['node']->value['id_category']!=$_smarty_tpl->tpl_vars['root_category']->value) {?>
		<input type="checkbox" name="<?php echo $_smarty_tpl->tpl_vars['input_name']->value;?>
[]" value="<?php echo $_smarty_tpl->tpl_vars['node']->value['id_category'];?>
"<?php if (isset($_smarty_tpl->tpl_vars['node']->value['disabled'])&&$_smarty_tpl->tpl_vars['node']->value['disabled']==true) {?> disabled="disabled"<?php }?> />
		<?php }?>
		<i class="icon-folder-close"></i>
		<label class="tree-toggler"><?php echo $_smarty_tpl->tpl_vars['node']->value['name'];?>
<?php if (isset($_smarty_tpl->tpl_vars['node']->value['selected_childs'])&&(int)$_smarty_tpl->tpl_vars['node']->value['selected_childs']>0) {?> <?php echo smartyTranslate(array('s'=>'(%s selected)','sprintf'=>$_smarty_tpl->tpl_vars['node']->value['selected_childs']),$_smarty_tpl);?>
<?php }?></label>
	</span>
	<ul class="tree">
		<?php echo $_smarty_tpl->tpl_vars['children']->value;?>

	</ul>
</li>
<?php }} ?>
