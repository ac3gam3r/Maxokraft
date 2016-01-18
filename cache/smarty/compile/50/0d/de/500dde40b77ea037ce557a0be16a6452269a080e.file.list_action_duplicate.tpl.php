<?php /* Smarty version Smarty-3.1.19, created on 2016-01-11 19:56:30
         compiled from "/home/ac3gam3r/public_html/admin1995/themes/default/template/helpers/list/list_action_duplicate.tpl" */ ?>
<?php /*%%SmartyHeaderCode:10178367345693bb967f5802-95630287%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '500dde40b77ea037ce557a0be16a6452269a080e' => 
    array (
      0 => '/home/ac3gam3r/public_html/admin1995/themes/default/template/helpers/list/list_action_duplicate.tpl',
      1 => 1425640160,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '10178367345693bb967f5802-95630287',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'action' => 0,
    'confirm' => 0,
    'location_ok' => 0,
    'location_ko' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5693bb9683a093_62674229',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5693bb9683a093_62674229')) {function content_5693bb9683a093_62674229($_smarty_tpl) {?>
<a href="#" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['action']->value, ENT_QUOTES, 'UTF-8', true);?>
" onclick="<?php if ($_smarty_tpl->tpl_vars['confirm']->value) {?>confirm_link('', '<?php echo $_smarty_tpl->tpl_vars['confirm']->value;?>
', '<?php echo smartyTranslate(array('s'=>'Yes'),$_smarty_tpl);?>
', '<?php echo smartyTranslate(array('s'=>'No'),$_smarty_tpl);?>
', '<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['location_ok']->value, ENT_QUOTES, 'UTF-8', true);?>
', '<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['location_ko']->value, ENT_QUOTES, 'UTF-8', true);?>
')<?php } else { ?>document.location = '<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['location_ko']->value, ENT_QUOTES, 'UTF-8', true);?>
'<?php }?>">
	<i class="icon-copy"></i> <?php echo $_smarty_tpl->tpl_vars['action']->value;?>

</a>
<?php }} ?>
