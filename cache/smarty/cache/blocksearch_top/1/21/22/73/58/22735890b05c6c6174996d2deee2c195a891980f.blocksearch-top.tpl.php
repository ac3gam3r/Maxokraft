<?php /*%%SmartyHeaderCode:164547008569352d68163f0-79682115%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '22735890b05c6c6174996d2deee2c195a891980f' => 
    array (
      0 => '/home/ac3gam3r/public_html/themes/default-bootstrap/modules/blocksearch/blocksearch-top.tpl',
      1 => 1434260437,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '164547008569352d68163f0-79682115',
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5693ba23bc7e48_95465491',
  'has_nocache_code' => false,
  'cache_lifetime' => 31536000,
),true); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5693ba23bc7e48_95465491')) {function content_5693ba23bc7e48_95465491($_smarty_tpl) {?><!-- Block search module TOP -->
<div id="search_block_top" class="col-sm-4 clearfix">
	<form id="searchbox" method="get" action="//www.maxokraft.com/search" >
		<input type="hidden" name="controller" value="search" />
		<input type="hidden" name="orderby" value="position" />
		<input type="hidden" name="orderway" value="desc" />
		<input class="search_query form-control" type="text" id="search_query_top" name="search_query" placeholder="What are you searching for..." value="" />
		<button type="submit" name="submit_search" class="btn btn-default button-search">
			<span>Search</span>
		</button>
	</form>
</div>
<!-- /Block search module TOP --><?php }} ?>
