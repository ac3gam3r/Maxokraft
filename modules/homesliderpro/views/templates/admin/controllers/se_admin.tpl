{$settings|print_r}
<script type="text/javascript">
	var ajaxUrl = "{$ajaxUrl}";
	var shopId = "{$shopId}";
	var actualVersion = "{$actualVersion}";
	var pathCSS = "{$pathCSS}"; // for tinymce
	{if $checkUpdate}
		var updateUrl = "{$updateUrl}";
	{/if}
</script>

{if $settings['need_update']}
	{$updateMsg}
{/if}

<div id="SESlides">
	<ul class="catTree">
		{$catTree}
		<li class="closeme">{l s=('Close and remove Category')}<span class="fa fa-times"></span></li>
	</ul>
	<div id="overlayer"></div>

	{*
	{foreach from=$conf key=hook item=c}
		{$hook}
	{/foreach}*}
</div>