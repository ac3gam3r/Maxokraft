{*
* This file is part of a NewQuest Project
*
* (c) NewQuest <contact@newquest.fr>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*}

<br/>
<fieldset>
	<legend><img src="../img/admin/cart.gif" alt="{l s='Ship2MyId delivery informations' mod='shiptomyid'}" />{l s='Ship2MyId delivery informations' mod='shiptomyid'}</legend>

	{if $shipto_order->state_address}

		<h4>{l s='Delivery address' mod='shiptomyid'}</h4>
		<ul>
			<li><strong>{l s='Lastname' mod='shiptomyid'} : </strong>{$shipto_order->lastname|escape:'htmlall':'UTF-8'}</li>
			<li><strong>{l s='Firstname' mod='shiptomyid'} : </strong>{$shipto_order->firstname|escape:'htmlall':'UTF-8'}</li>
			<li><strong>{l s='Address 1' mod='shiptomyid'} : </strong>{$shipto_order->address1|escape:'htmlall':'UTF-8'}</li>
			<li><strong>{l s='Address 2' mod='shiptomyid'} : </strong>{$shipto_order->address2|escape:'htmlall':'UTF-8'}</li>
			<li><strong>{l s='Postcode' mod='shiptomyid'} : </strong>{$shipto_order->postcode|escape:'htmlall':'UTF-8'}</li>
			<li><strong>{l s='City' mod='shiptomyid'} : </strong>{$shipto_order->city|escape:'htmlall':'UTF-8'}</li>
			<li><strong>{l s='Country' mod='shiptomyid'} : </strong>{$shipto_order->country_name|escape:'htmlall':'UTF-8'}</li>
			{if $shipto_order->id_state}
				<li><strong>{l s='State' mod='shiptomyid'} : </strong>{$shipto_order->state_name|escape:'htmlall':'UTF-8'}</li>
			{/if}
			<li><strong>{l s='Phone' mod='shiptomyid'} : </strong>{$shipto_order->phone|escape:'htmlall':'UTF-8'}</li>
		</ul>

	{else}

		<h4>{l s='Waiting address...' mod='shiptomyid'}</h4>
		<p>-</p>

	{/if}


</fieldset>