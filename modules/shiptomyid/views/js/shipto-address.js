/*
 * This file is part of a NewQuest Project
 *
 * (c) NewQuest <contact@newquest.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

$(document).ready(function()
{
	if (typeof(formatedAddressFieldsValuesList) !== 'undefined')
		updateAddressesDisplay(true);
//	resizeAddressesBox();

	console.log('shipto-address loaded');
});


//update the display of the addresses
function updateAddressesDisplay(first_view)
{
	if (typeof  first_view == 'undefined') {
		first_view = false;
	}

	if (first_view) {
		updateAddressDisplay('delivery');
	}

	updateAddressDisplay('invoice');

//	if(!first_view)
		updateAddresses();
}


function updateAddressDisplay(addressType)
{
	if (formatedAddressFieldsValuesList.length <= 0)
		return false;

	var idAddress = parseInt($('#id_address_' + addressType + '').val());
	buildAddressBlock(idAddress, addressType, $('#address_' + addressType));

	// change update link
	var link = $('ul#address_' + addressType + ' li.address_update a').attr('href');
	var expression = /id_address=\d+/;
	if (link)
	{
		link = link.replace(expression, 'id_address=' + idAddress);
		$('ul#address_' + addressType + ' li.address_update a').attr('href', link);
	}
	resizeAddressesBox();
}

function updateAddresses()
{
	var idAddress_delivery = parseInt($('#id_address_delivery').val());
	var idAddress_invoice = parseInt($('#id_address_invoice').val());

	if(isNaN(idAddress_delivery) == false && isNaN(idAddress_invoice) == false)
		$.ajax({
			type: 'POST',
			headers: { "cache-control": "no-cache" },
			url: baseUri + '?rand=' + new Date().getTime(),
			async: true,
			cache: false,
			dataType : "json",
			data: {
				processAddress: true,
				step: 2,
				ajax: 'true',
				controller: 'order',
				'multi-shipping': 0,
				id_address_delivery: idAddress_delivery,
				id_address_invoice: idAddress_invoice,
				token: static_token
			},
			success: function(jsonData)
			{
				if (jsonData.hasError)
				{
					var errors = '';
					for(var error in jsonData.errors)
						//IE6 bug fix
						if(error !== 'indexOf')
							errors += $('<div />').html(jsonData.errors[error]).text() + "\n";
					alert(errors);
				}
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				if (textStatus !== 'abort')
					alert("TECHNICAL ERROR: unable to save adresses \n\nDetails:\nError thrown: " + XMLHttpRequest + "\n" + 'Text status: ' + textStatus);
			}
		});
	resizeAddressesBox();
}