<?php /* Smarty version Smarty-3.1.19, created on 2016-01-11 12:29:42
         compiled from "/home/ac3gam3r/public_html/themes/default-bootstrap/product-sort.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1627023483569352de7ce769-42013731%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '658e5808ea48b37d96e750691be7d77f474a5e4a' => 
    array (
      0 => '/home/ac3gam3r/public_html/themes/default-bootstrap/product-sort.tpl',
      1 => 1425640160,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1627023483569352de7ce769-42013731',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'orderby' => 0,
    'orderway' => 0,
    'request' => 0,
    'category' => 0,
    'link' => 0,
    'manufacturer' => 0,
    'supplier' => 0,
    'page_name' => 0,
    'paginationId' => 0,
    'orderbydefault' => 0,
    'orderwaydefault' => 0,
    'PS_CATALOG_MODE' => 0,
    'PS_STOCK_MANAGEMENT' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_569352de8dcb81_51111461',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_569352de8dcb81_51111461')) {function content_569352de8dcb81_51111461($_smarty_tpl) {?>
<?php if (isset($_smarty_tpl->tpl_vars['orderby']->value)&&isset($_smarty_tpl->tpl_vars['orderway']->value)) {?>
<ul class="display hidden-xs">
	<li class="display-title"><?php echo smartyTranslate(array('s'=>'View:'),$_smarty_tpl);?>
</li>
    <li id="grid"><a rel="nofollow" href="#" title="<?php echo smartyTranslate(array('s'=>'Grid'),$_smarty_tpl);?>
"><i class="icon-th-large"></i><?php echo smartyTranslate(array('s'=>'Grid'),$_smarty_tpl);?>
</a></li>
    <li id="list"><a rel="nofollow" href="#" title="<?php echo smartyTranslate(array('s'=>'List'),$_smarty_tpl);?>
"><i class="icon-th-list"></i><?php echo smartyTranslate(array('s'=>'List'),$_smarty_tpl);?>
</a></li>
</ul>

<?php if (!isset($_smarty_tpl->tpl_vars['request']->value)) {?>
	<!-- Sort products -->
	<?php if (isset($_GET['id_category'])&&$_GET['id_category']) {?>
		<?php $_smarty_tpl->tpl_vars['request'] = new Smarty_variable($_smarty_tpl->tpl_vars['link']->value->getPaginationLink('category',$_smarty_tpl->tpl_vars['category']->value,false,true), null, 0);?>
	<?php } elseif (isset($_GET['id_manufacturer'])&&$_GET['id_manufacturer']) {?>
		<?php $_smarty_tpl->tpl_vars['request'] = new Smarty_variable($_smarty_tpl->tpl_vars['link']->value->getPaginationLink('manufacturer',$_smarty_tpl->tpl_vars['manufacturer']->value,false,true), null, 0);?>
	<?php } elseif (isset($_GET['id_supplier'])&&$_GET['id_supplier']) {?>
		<?php $_smarty_tpl->tpl_vars['request'] = new Smarty_variable($_smarty_tpl->tpl_vars['link']->value->getPaginationLink('supplier',$_smarty_tpl->tpl_vars['supplier']->value,false,true), null, 0);?>
	<?php } else { ?>
		<?php $_smarty_tpl->tpl_vars['request'] = new Smarty_variable($_smarty_tpl->tpl_vars['link']->value->getPaginationLink(false,false,false,true), null, 0);?>
	<?php }?>
<?php }?>
<?php if ($_smarty_tpl->tpl_vars['page_name']->value=='best-sales'&&(!isset($_GET['orderby'])||empty($_GET['orderby']))) {?><?php $_smarty_tpl->tpl_vars['orderby'] = new Smarty_variable('', null, 0);?><?php $_smarty_tpl->tpl_vars['orderbydefault'] = new Smarty_variable('', null, 0);?><?php }?>
<form id="productsSortForm<?php if (isset($_smarty_tpl->tpl_vars['paginationId']->value)) {?>_<?php echo $_smarty_tpl->tpl_vars['paginationId']->value;?>
<?php }?>" action="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['request']->value, ENT_QUOTES, 'UTF-8', true);?>
" class="productsSortForm">
	<div class="select selector1">
		<label for="selectProductSort<?php if (isset($_smarty_tpl->tpl_vars['paginationId']->value)) {?>_<?php echo $_smarty_tpl->tpl_vars['paginationId']->value;?>
<?php }?>"><?php echo smartyTranslate(array('s'=>'Sort by'),$_smarty_tpl);?>
</label>
		<select id="selectProductSort<?php if (isset($_smarty_tpl->tpl_vars['paginationId']->value)) {?>_<?php echo $_smarty_tpl->tpl_vars['paginationId']->value;?>
<?php }?>" class="selectProductSort form-control">
			<option value="<?php if ($_smarty_tpl->tpl_vars['page_name']->value!='best-sales') {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['orderbydefault']->value, ENT_QUOTES, 'UTF-8', true);?>
:<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['orderwaydefault']->value, ENT_QUOTES, 'UTF-8', true);?>
<?php }?>"<?php if ($_smarty_tpl->tpl_vars['orderby']->value==$_smarty_tpl->tpl_vars['orderbydefault']->value) {?> selected="selected"<?php }?>>--</option>
			<?php if (!$_smarty_tpl->tpl_vars['PS_CATALOG_MODE']->value) {?>
				<option value="price:asc"<?php if ($_smarty_tpl->tpl_vars['orderby']->value=='price'&&$_smarty_tpl->tpl_vars['orderway']->value=='asc') {?> selected="selected"<?php }?>><?php echo smartyTranslate(array('s'=>'Price: Lowest first'),$_smarty_tpl);?>
</option>
				<option value="price:desc"<?php if ($_smarty_tpl->tpl_vars['orderby']->value=='price'&&$_smarty_tpl->tpl_vars['orderway']->value=='desc') {?> selected="selected"<?php }?>><?php echo smartyTranslate(array('s'=>'Price: Highest first'),$_smarty_tpl);?>
</option>
			<?php }?>
			<option value="name:asc"<?php if ($_smarty_tpl->tpl_vars['orderby']->value=='name'&&$_smarty_tpl->tpl_vars['orderway']->value=='asc') {?> selected="selected"<?php }?>><?php echo smartyTranslate(array('s'=>'Product Name: A to Z'),$_smarty_tpl);?>
</option>
			<option value="name:desc"<?php if ($_smarty_tpl->tpl_vars['orderby']->value=='name'&&$_smarty_tpl->tpl_vars['orderway']->value=='desc') {?> selected="selected"<?php }?>><?php echo smartyTranslate(array('s'=>'Product Name: Z to A'),$_smarty_tpl);?>
</option>
			<?php if ($_smarty_tpl->tpl_vars['PS_STOCK_MANAGEMENT']->value&&!$_smarty_tpl->tpl_vars['PS_CATALOG_MODE']->value) {?>
				<option value="quantity:desc"<?php if ($_smarty_tpl->tpl_vars['orderby']->value=='quantity'&&$_smarty_tpl->tpl_vars['orderway']->value=='desc') {?> selected="selected"<?php }?>><?php echo smartyTranslate(array('s'=>'In stock'),$_smarty_tpl);?>
</option>
			<?php }?>
			<option value="reference:asc"<?php if ($_smarty_tpl->tpl_vars['orderby']->value=='reference'&&$_smarty_tpl->tpl_vars['orderway']->value=='asc') {?> selected="selected"<?php }?>><?php echo smartyTranslate(array('s'=>'Reference: Lowest first'),$_smarty_tpl);?>
</option>
			<option value="reference:desc"<?php if ($_smarty_tpl->tpl_vars['orderby']->value=='reference'&&$_smarty_tpl->tpl_vars['orderway']->value=='desc') {?> selected="selected"<?php }?>><?php echo smartyTranslate(array('s'=>'Reference: Highest first'),$_smarty_tpl);?>
</option>
		</select>
	</div>
</form>
<!-- /Sort products -->
	<?php if (!isset($_smarty_tpl->tpl_vars['paginationId']->value)||$_smarty_tpl->tpl_vars['paginationId']->value=='') {?>
		<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['addJsDef'][0][0]->addJsDef(array('request'=>$_smarty_tpl->tpl_vars['request']->value),$_smarty_tpl);?>

	<?php }?>
<?php }?>
<?php }} ?>
