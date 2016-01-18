{*
* 2007-2014 PrestaShop
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
*  @copyright  2007-2014 PrestaShop SA
*  @version  Release: $Revision: 15821 $
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

{if $payment_status == 'SUCCESSFUL'}
	<p>
		{l s='Your order on' mod='ccavenue'} 
		<span class="bold">{$shop_name}</span>
		{l s='is complete.' mod='ccavenue'}
			<br /><br /><span class="bold">{l s='Your order will be shipped as soon as possible.' mod='ccavenue'}</span>
			<br /><br />{l s='For any questions or for further information, please contact our' mod='ccavenue'} <a href="{$link->getPageLink('contact-form.php', true)}">{l s='customer support' mod='ccavenue'}</a>.
	</p>
{else}
	{if $payment_status == 'PENDING'}
		<p>
			{l s='Your order on' mod='ccavenue'} 
			<span class="bold">{$shop_name}</span> 
			{l s='is PENDING.' mod='ccavenue'}
				<br /><br /><span class="bold">{l s='Your order will be shipped as soon as we receive your ccavenue payment.' mod='ccavenue'}</span>
				<br /><br />{l s='For any questions or for further information, please contact our' mod='ccavenue'} <a href="{$link->getPageLink('contact-form.php', true)}">{l s='customer support' mod='ccavenue'}</a>.
		</p>
	{else}
		<p class="ERROR">
			{l s='Your order has been cancelled. If you think this is an error, you can contact our' mod='ccavenue'} 
			<a href="{$link->getPageLink('contact-form.php', true)}">{l s='customer support' mod='ccavenue'}</a>.
		</p>
	{/if}
{/if}
 