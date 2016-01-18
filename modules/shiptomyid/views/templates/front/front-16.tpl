{*
* 2007-2015 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2015 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}
{assign var='current_step' value='address'}
{capture name=path}{l s='Addresses' mod='shiptomyid'}{/capture}
{assign var="back_order_page" value="order.php"}
<h1 class="page-heading">{l s='Addresses' mod='shiptomyid'}</h1>
{include file="$tpl_dir./order-steps.tpl"}
{include file="$tpl_dir./errors.tpl"}
<form action="{$link->getPageLink($back_order_page, true)|escape:'html':'UTF-8'}" method="post">
	<div class="addresses clearfix">
		<div class="row" style="margin-bottom: 10px;">
			<div class="col-xs-12 col-sm-6">
				<div class="address_delivery select form-group selector1">
					<label for="id_address_delivery">{l s='Delivery address : ' mod='shiptomyid'}</label> <span> {$shipto_delivery_address->alias|escape:'htmlall':'UTF-8'}</span>
					<input type="hidden" id="id_address_delivery" name="id_address_delivery" value="{$shipto_delivery_address->id|intval}" />
				</div>
			</div>
			<div class="col-xs-12 col-sm-6">
				<div id="address_invoice_form" class="select form-group selector1"{if $cart->id_address_invoice == $cart->id_address_delivery} style="display: none;"{/if}>
					<label for="id_address_invoice" class="strong">{l s='Choose a billing address:' mod='shiptomyid'}</label>
					<select name="id_address_invoice" id="id_address_invoice" class="address_select form-control">
						{section loop=$addresses step=-1 name=address}
							{if !isset($addresses[address].shipto_addr)}
								<option value="{$addresses[address].id_address|intval}"{if $addresses[address].id_address == $cart->id_address_invoice && $cart->id_address_delivery != $cart->id_address_invoice} selected="selected"{/if}>
									{$addresses[address].alias|escape:'html':'UTF-8'}
								</option>
							{/if}
						{/section}
					</select><span class="waitimage"></span>
				</div>
			</div>
		</div> <!-- end row -->
		<div class="row">
			<div class="col-xs-12 col-sm-6">
				<ul class="address item box" id="address_delivery">
				</ul>
			</div>
			<div class="col-xs-12 col-sm-6">
				<ul class="address alternate_item box" id="address_invoice">
				</ul>
			</div>
		</div> <!-- end row -->
	</div> <!-- end addresses -->

	<p class="cart_navigation clearfix">
		<input type="hidden" class="hidden" name="step" value="2" />
		<input type="hidden" name="back" value="{if isset($back) AND $back}{$back}{/if}" />
		<a href="{$link->getPageLink($back_order_page, true, NULL, "{if isset($back) AND $back}back={$back}{/if}")|escape:'html':'UTF-8'}" title="{l s='Previous' mod='shiptomyid'}" class="button-exclusive btn btn-default">
			<i class="icon-chevron-left"></i>
			{l s='Continue Shopping' mod='shiptomyid'}
		</a>
		<button type="submit" name="processAddress" class="button btn btn-default button-medium">
			<span>{l s='Proceed to checkout' mod='shiptomyid'}<i class="icon-chevron-right right"></i></span>
		</button>
	</p>
</form>

{strip}
	{addJsDef default_data=$shipto_default_delivery_address}

	{addJsDef orderProcess='order'}
	{addJsDef currencySign=$currencySign|html_entity_decode:2:"UTF-8"}
	{addJsDef currencyRate=$currencyRate|floatval}
	{addJsDef currencyFormat=$currencyFormat|intval}
	{addJsDef currencyBlank=$currencyBlank|intval}
	{addJsDefL name=txtProduct}{l s='product' js=1  mod='shiptomyid'}{/addJsDefL}
	{addJsDefL name=txtProducts}{l s='products' js=1  mod='shiptomyid'}{/addJsDefL}
	{addJsDefL name=CloseTxt}{l s='Submit' js=1  mod='shiptomyid'}{/addJsDefL}
	{capture}{if isset($back) AND $back}&mod={$back|urlencode}{/if}{/capture}
	{capture name=addressUrl}{$link->getPageLink('address', true, NULL, 'back='|cat:$back_order_page|cat:'?step=1'|cat:$smarty.capture.default)|escape:'quotes':'UTF-8'}{/capture}
	{addJsDef addressUrl=$smarty.capture.addressUrl}
	{capture}{'&multi-shipping=1'|urlencode}{/capture}
	{addJsDef addressMultishippingUrl=$smarty.capture.addressUrl|cat:$smarty.capture.default}
	{capture name=addressUrlAdd}{$smarty.capture.addressUrl|cat:'&id_address='}{/capture}
	{addJsDef addressUrlAdd=$smarty.capture.addressUrlAdd}
	{addJsDef formatedAddressFieldsValuesList=$formatedAddressFieldsValuesList}
	{addJsDef opc=$opc|boolval}
	{capture}<h3 class="page-subheading">{l s='Your billing address' js=1 mod='shiptomyid'}</h3>{/capture}
	{addJsDefL name=titleInvoice}{$smarty.capture.default|@addcslashes:'\''}{/addJsDefL}
	{capture}<h3 class="page-subheading">{l s='Your delivery address' js=1 mod='shiptomyid'}</h3>{/capture}
	{addJsDefL name=titleDelivery}{$smarty.capture.default|@addcslashes:'\''}{/addJsDefL}
	{capture}<a class="button button-small btn btn-default" href="{$smarty.capture.addressUrlAdd}" title="{l s='Update' js=1 mod='shiptomyid'}"><span>{l s='Update' js=1 mod='shiptomyid'}<i class="icon-chevron-right right"></i></span></a>{/capture}
	{addJsDefL name=liUpdate}{$smarty.capture.default|@addcslashes:'\''}{/addJsDefL}
{/strip}