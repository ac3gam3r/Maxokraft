{if $payment_status == 'ERROR'}
<div class="error">
	<p>
		{$message}
		<br /><br />{l s='For any questions or for further information, please contact our' mod='ccavenue'} <a href="{$link->getPageLink('contact-form.php', true)}">{l s='customer support' mod='ccavenue'}</a>.
	</p>
</div>
{/if}

<form action="{$ccavenueUrl}" method="post" id="ccavenuepay_standard_checkout" name="redirect">
	<input type="hidden" name="encRequest" id="encRequest" value="{$encRequest}" />
	<input type="hidden" name="access_code" id="access_code" value="{$access_code}" />
</form>
<p class="payment_module">
	<a href="javascript:document.redirect.submit();" title="{$ccavenue_title}" >
		<img src="{$module_template_dir}ccavenue.gif" alt="{$ccavenue_title}"/>
		{$ccavenue_title}
	</a>	
</p>