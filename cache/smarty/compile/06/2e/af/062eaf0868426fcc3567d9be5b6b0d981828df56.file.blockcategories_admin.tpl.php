<?php /* Smarty version Smarty-3.1.19, created on 2016-01-11 19:54:16
         compiled from "/home/ac3gam3r/public_html/modules/blockcategories/views/blockcategories_admin.tpl" */ ?>
<?php /*%%SmartyHeaderCode:19324322705693bb108f53d3-76069301%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '062eaf0868426fcc3567d9be5b6b0d981828df56' => 
    array (
      0 => '/home/ac3gam3r/public_html/modules/blockcategories/views/blockcategories_admin.tpl',
      1 => 1429457054,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '19324322705693bb108f53d3-76069301',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'helper' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5693bb10920e77_41128453',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5693bb10920e77_41128453')) {function content_5693bb10920e77_41128453($_smarty_tpl) {?>
<div class="form-group">
	<label class="control-label col-lg-3">
		<span class="label-tooltip" data-toggle="tooltip" data-html="true" title="" data-original-title="<?php echo smartyTranslate(array('s'=>'You can upload a maximum of 3 images.','mod'=>'blockcategories'),$_smarty_tpl);?>
">
			<?php echo smartyTranslate(array('s'=>'Thumbnails','mod'=>'blockcategories'),$_smarty_tpl);?>

		</span>
	</label>
	<div class="col-lg-4">
		<?php echo $_smarty_tpl->tpl_vars['helper']->value;?>

	</div>
</div>
<?php }} ?>
