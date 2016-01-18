{*
* This file is part of a NewQuest Project
*
* (c) NewQuest <contact@newquest.fr>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*}

{assign var="back_order_page" value="order.php"}

<script type="text/javascript">
// <![CDATA[

var formatedAddressFieldsValuesList = new Array();
var default_data =  {$shipto_default_delivery_address|json_encode}

{foreach from=$formatedAddressFieldsValuesList key=id_address item=type}
formatedAddressFieldsValuesList[{$id_address|intval}] =
{ldelim}
	'ordered_fields':[
		{foreach from=$type.ordered_fields key=num_field item=field_name name=inv_loop}
		{if !$smarty.foreach.inv_loop.first},{/if}{$field_name|json_encode}
		{/foreach}
	],
	'formated_fields_values':{ldelim}
	{foreach from=$type.formated_fields_values key=pattern_name item=field_name name=inv_loop}
	{if !$smarty.foreach.inv_loop.first},{/if}{$pattern_name|json_encode}:{$field_name|json_encode}
{/foreach}
{rdelim}
{rdelim}
{/foreach}

function getAddressesTitles()
{
	return {
		'invoice': "{l s='Your billing address' js=1 mod='shiptomyid'}",
		'delivery': "{l s='Your delivery temp address' js=1 mod='shiptomyid'}"
	};
}

function buildAddressBlock(id_address, address_type, dest_comp)
{
	if (isNaN(id_address))
		return;

	var adr_titles_vals = getAddressesTitles();
    if(address_type == 'delivery'){
        formatedAddressFieldsValuesList[id_address]['formated_fields_values']['address1'] = default_data['address1'];
        formatedAddressFieldsValuesList[id_address]['formated_fields_values']['address2'] = default_data['address2'];
        formatedAddressFieldsValuesList[id_address]['formated_fields_values']['city'] = default_data['city'];
        formatedAddressFieldsValuesList[id_address]['formated_fields_values']['phone'] = default_data['phone'];
        formatedAddressFieldsValuesList[id_address]['formated_fields_values']['postcode'] = default_data['postcode'];
        formatedAddressFieldsValuesList[id_address]['formated_fields_values']['Country:name'] = default_data['country'];
        formatedAddressFieldsValuesList[id_address]['formated_fields_values']['State:name'] = default_data['state'];
    }
	var li_content = formatedAddressFieldsValuesList[id_address]['formated_fields_values'];
	var ordered_fields_name = ['title'];

	ordered_fields_name = ordered_fields_name.concat(formatedAddressFieldsValuesList[id_address]['ordered_fields']);
	ordered_fields_name = ordered_fields_name.concat(['update']);

	dest_comp.html('');

	li_content['title'] = adr_titles_vals[address_type];
	//li_content['update'] = '';

	appendAddressList(dest_comp, li_content, ordered_fields_name);
}

function appendAddressList(dest_comp, values, fields_name)
{
	for (var item in fields_name)
	{
		var name = fields_name[item];
		var value = getFieldValue(name, values);
		if (value != "")
		{
			var new_li = document.createElement('li');
			new_li.className = 'address_'+ name;
			new_li.innerHTML = getFieldValue(name, values);
			dest_comp.append(new_li);
		}
	}
}

function getFieldValue(field_name, values)
{
	var reg=new RegExp("[ ]+", "g");

	var items = field_name.split(reg);
	var vals = new Array();

	for (var field_item in items)
	{
		items[field_item] = items[field_item].replace(",", "");
		vals.push(values[items[field_item]]);
	}
	return vals.join(" ");
}

//]]>
</script>




{capture name=path}{l s='Addresses' mod='shiptomyid'}{/capture}
{include file="$tpl_dir./breadcrumb.tpl"}

<h1>{l s='Addresses' mod='shiptomyid'}</h1>

{assign var='current_step' value='address'}
{include file="$tpl_dir./order-steps.tpl"}
{include file="$tpl_dir./errors.tpl"}
<form action="{$link->getPageLink($back_order_page, true)|escape:'htmlall':'UTF-8'}" method="post">

	<div class="addresses clearfix">
		<p class="address_delivery select">
			<input type="hidden" id="id_address_delivery" name="id_address_delivery" value="{$shipto_delivery_address->id|intval}" />
			<label for="id_address_invoice" class="strong">{l s='Delivery address : ' mod='shiptomyid'}</label>{$shipto_delivery_address->alias|escape:'htmlall':'UTF-8'}
		</p>

		<p id="address_invoice_form" class="select">
			<label for="id_address_invoice" class="strong">{l s='Choose a billing address:' mod='shiptomyid'}</label>
			<select name="id_address_invoice" id="id_address_invoice" class="address_select" onchange="updateAddressesDisplay();">
				{foreach from=$addresses key=k item=address}
					{if !isset($address.shipto_addr)}
						<option value="{$address.id_address|intval}" {if $address.id_address == $cart->id_address_invoice}selected="selected"{/if}>{$address.alias|escape:'htmlall':'UTF-8'}</option>
					{/if}
				{/foreach}
			</select>
		</p>

		<div class="clearfix">
			<ul class="address item" id="address_delivery">
			</ul>
			<ul class="address alternate_item {if $cart->isVirtualCart()}full_width{/if}" id="address_invoice">
			</ul>
		</div>
	</div>

	<p class="cart_navigation submit">
		<input type="hidden" class="hidden" name="step" value="2" />
		<a href="{$link->getPageLink($back_order_page, true, NULL, "step=0{if isset($back) && $back}&back={$back}{/if}")|escape:'htmlall':'UTF-8'}" title="{l s='Previous'  mod='shiptomyid'}" class="button">&laquo; {l s='Previous'  mod='shiptomyid'}</a>
		<input type="submit" name="processAddress" value="{l s='Next' mod='shiptomyid'} &raquo;" class="exclusive" />
	</p>
</form>

