<?php /* Smarty version Smarty-3.1.19, created on 2016-01-11 20:07:22
         compiled from "/home/ac3gam3r/public_html/modules/socialsharing/views/templates/hook/socialsharing_header.tpl" */ ?>
<?php /*%%SmartyHeaderCode:15825721465693be224beb24-24461653%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '289038917a45f8f638c3c34b5dedf91b146068e4' => 
    array (
      0 => '/home/ac3gam3r/public_html/modules/socialsharing/views/templates/hook/socialsharing_header.tpl',
      1 => 1429457076,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '15825721465693be224beb24-24461653',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'meta_title' => 0,
    'request' => 0,
    'shop_name' => 0,
    'meta_description' => 0,
    'link_rewrite' => 0,
    'cover' => 0,
    'link' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5693be2254fd21_54481921',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5693be2254fd21_54481921')) {function content_5693be2254fd21_54481921($_smarty_tpl) {?>
<meta property="og:title" content="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['meta_title']->value, ENT_QUOTES, 'UTF-8', true);?>
" />
<meta property="og:url" content="<?php echo $_smarty_tpl->tpl_vars['request']->value;?>
" />
<meta property="og:type" content="product" />
<meta property="og:site_name" content="<?php echo $_smarty_tpl->tpl_vars['shop_name']->value;?>
" />
<meta property="og:description" content="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['meta_description']->value, ENT_QUOTES, 'UTF-8', true);?>
" />
<meta property="og:email" content="" />
<meta property="og:phone_number" content="" />
<meta property="og:street-address" content="" />
<meta property="og:locality" content="" />
<meta property="og:country-name" content="" />
<meta property="og:postal-code" content="" />
<?php if (isset($_smarty_tpl->tpl_vars['link_rewrite']->value)&&isset($_smarty_tpl->tpl_vars['cover']->value)&&isset($_smarty_tpl->tpl_vars['cover']->value['id_image'])) {?>
<meta property="og:image" content="<?php echo $_smarty_tpl->tpl_vars['link']->value->getImageLink($_smarty_tpl->tpl_vars['link_rewrite']->value,$_smarty_tpl->tpl_vars['cover']->value['id_image'],'large_default');?>
" />
<?php }?>
<?php }} ?>
