<?php /* Smarty version Smarty-3.1.19, created on 2016-01-11 12:29:36
         compiled from "/home/ac3gam3r/public_html/themes/default-bootstrap/modules/blockcontactinfos/blockcontactinfos.tpl" */ ?>
<?php /*%%SmartyHeaderCode:643667271569352d830e026-45538049%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '18f92900c3b59e5dc3e2282482ae1105e1f07ea3' => 
    array (
      0 => '/home/ac3gam3r/public_html/themes/default-bootstrap/modules/blockcontactinfos/blockcontactinfos.tpl',
      1 => 1425640160,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '643667271569352d830e026-45538049',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'blockcontactinfos_company' => 0,
    'blockcontactinfos_address' => 0,
    'blockcontactinfos_phone' => 0,
    'blockcontactinfos_email' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_569352d838e0b2_03629801',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_569352d838e0b2_03629801')) {function content_569352d838e0b2_03629801($_smarty_tpl) {?><?php if (!is_callable('smarty_function_mailto')) include '/home/ac3gam3r/public_html/tools/smarty/plugins/function.mailto.php';
?>

<!-- MODULE Block contact infos -->
<section id="block_contact_infos" class="footer-block col-xs-12 col-sm-4">
	<div>
        <h4><?php echo smartyTranslate(array('s'=>'Store Information','mod'=>'blockcontactinfos'),$_smarty_tpl);?>
</h4>
        <ul class="toggle-footer">
            <?php if ($_smarty_tpl->tpl_vars['blockcontactinfos_company']->value!='') {?>
            	<li>
            		<i class="icon-map-marker"></i><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['blockcontactinfos_company']->value, ENT_QUOTES, 'UTF-8', true);?>
<?php if ($_smarty_tpl->tpl_vars['blockcontactinfos_address']->value!='') {?>, <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['blockcontactinfos_address']->value, ENT_QUOTES, 'UTF-8', true);?>
<?php }?>
            	</li>
            <?php }?>
            <?php if ($_smarty_tpl->tpl_vars['blockcontactinfos_phone']->value!='') {?>
            	<li>
            		<i class="icon-phone"></i><?php echo smartyTranslate(array('s'=>'Call us now:','mod'=>'blockcontactinfos'),$_smarty_tpl);?>
 
            		<span><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['blockcontactinfos_phone']->value, ENT_QUOTES, 'UTF-8', true);?>
</span>
            	</li>
            <?php }?>
            <?php if ($_smarty_tpl->tpl_vars['blockcontactinfos_email']->value!='') {?>
            	<li>
            		<i class="icon-envelope-alt"></i><?php echo smartyTranslate(array('s'=>'Email:','mod'=>'blockcontactinfos'),$_smarty_tpl);?>
 
            		<span><?php echo smarty_function_mailto(array('address'=>htmlspecialchars($_smarty_tpl->tpl_vars['blockcontactinfos_email']->value, ENT_QUOTES, 'UTF-8', true),'encode'=>"hex"),$_smarty_tpl);?>
</span>
            	</li>
            <?php }?>
        </ul>
    </div>
</section>
<!-- /MODULE Block contact infos -->
<?php }} ?>
