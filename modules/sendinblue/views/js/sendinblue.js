/**
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
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2015 PrestaShop SA
 * @license   http://opensource.org/licenses/afl-3.0.php Academic Free License (AFL 3.0)
 * International Registered Trademark & Property of PrestaShop SA
 */

$(document).ready(
        function() {
            var token = jQuery("#customtoken").val();
			var id_shop_group = jQuery("#id_shop_group").val();
			var id_shop = jQuery("#id_shop").val();
            var iso_code = jQuery('#iso_code').val();

            if (!$('#apikeybox').is(':hidden')) {

                $('#sender_order').keyup(function() {
                    var val = $(this).val();

                    if (isInteger(val) || val.length == 0) {
                        $("#sender_order").attr('maxlength', '11');
                        $('#sender_order_text').text((11 - val.length));

                    }
                    else {
                        $("#sender_order").attr('maxlength', '11');
                        $('#sender_order_text').text((11 - val.length));

                    }
                });

                if ($('#sender_order').val() != '')
                {

                    var val = $('#sender_order').val();

                    if (isInteger(val) || val.length == 0) {
                        $("#sender_order").attr('maxlength', '11');
                        $('#sender_order_text').text((11 - val.length));

                    }
                    else {
                        $("#sender_order").attr('maxlength', '11');
                        $('#sender_order_text').text((11 - val.length));

                    }
                }

				$("#sender_order").keydown(function (event) {
					if (event.keyCode == 32) {
                    event.preventDefault();
                }
				});

                $('#sender_order_message').keyup(function() {

                    var chars = this.value.length,
                            messages = Math.ceil(chars / 160),
                            remaining = messages * 160 - (chars % (messages * 160) || messages * 160);
                    if (remaining == 0)
                    {
                        remaining = 160.
                    }

                    $('#sender_order_message_text').text(remaining);

                    $('#sender_order_message_text_count').text(messages);

                });

                if ($('#sender_order_message').val() != '')
                {


                    var chars = $('#sender_order_message').val().length,
                            messages = Math.ceil(chars / 160),
                            remaining = messages * 160 - (chars % (messages * 160) || messages * 160);

                    $('#sender_order_message_text').text(remaining);

                    $('#sender_order_message_text_count').text(messages);
                }

                $('#sender_shipment').keyup(function() {
                    var val = $(this).val();

                    if (isInteger(val) || val.length == 0) {
                        $("#sender_shipment").attr('maxlength', '11');
                        $('#sender_shipment_text').text((11 - val.length));

                    }
                    else {
                        $("#sender_shipment").attr('maxlength', '11');
                        $('#sender_shipment_text').text((11 - val.length));

                    }
                });

                if ($('#sender_shipment').val() != '')
                {

                    var val = $('#sender_shipment').val();
                    if (isInteger(val) || val.length == 0) {
                        $("#sender_shipment").attr('maxlength', '11');
                        $('#sender_shipment_text').text((11 - val.length));

                    }
                    else {
                        $("#sender_shipment").attr('maxlength', '11');
                        $('#sender_shipment_text').text((11 - val.length));

                    }
                }
				$("#sender_shipment").keydown(function (event) {
					if (event.keyCode == 32) {
                    event.preventDefault();
                }
				});

                $('#sender_shipment_message').keyup(function() {

                    var chars = this.value.length,
                            messages = Math.ceil(chars / 160),
                            remaining = messages * 160 - (chars % (messages * 160) || messages * 160);
                    if (remaining == 0)
                    {
                        remaining = 160.

                    }
                    $('#sender_shipment_message_text').text(remaining);

                    $('#sender_shipment_message_text_count').text(messages);

                });

                if ($('#sender_shipment_message').val() != '')
                {


                    var chars = $('#sender_shipment_message').val().length,
                            messages = Math.ceil(chars / 160),
                            remaining = messages * 160 - (chars % (messages * 160) || messages * 160);

                    $('#sender_shipment_message_text').text(remaining);

                    $('#sender_shipment_message_text_count').text(messages);
                }

                $('#sender_campaign').keyup(function() {
                    var val = $(this).val();

                    if (isInteger(val) || val.length == 0) {
                        $("#sender_campaign").attr('maxlength', '11');
                        $('#sender_campaign_text').text((11 - val.length));

                    }
                    else {
                        $("#sender_campaign").attr('maxlength', '11');
                        $('#sender_campaign_text').text((11 - val.length));

                    }
                });

                if ($('#sender_campaign').val() != '')
                {


                    var val = $('#sender_campaign').val();

                    if (isInteger(val) || val.length == 0) {
                        $("#sender_campaign").attr('maxlength', '11');
                        $('#sender_campaign_text').text((11 - val.length));
                    }
                    else {
                        $("#sender_campaign").attr('maxlength', '11');
                        $('#sender_campaign_text').text((11 - val.length));
                    }
                }
				$("#sender_campaign").keydown(function (event) {
					if (event.keyCode == 32) {
                    event.preventDefault();
                }
				});

                $('#sender_campaign_message').keyup(function() {

                    var chars = this.value.length,
                            messages = Math.ceil(chars / 160),
                            remaining = messages * 160 - (chars % (messages * 160) || messages * 160);
                    if (remaining == 0)
                    {
                        remaining = 160.

                    }
                    $('#sender_campaign_message_text').text(remaining);
                    $('#sender_campaign_message_text_count').text(messages);

                });

                if ($('#sender_campaign_message').val() != '')
                {


                    var chars = $('#sender_campaign_message').val().length,
                            messages = Math.ceil(chars / 160),
                            remaining = messages * 160 - (chars % (messages * 160) || messages * 160);

                    $('#sender_campaign_message_text').text(remaining);

                    $('#sender_campaign_message_text_count').text(messages);
                }

                $(".sms_order_setting").click(function() {
                    var orderSetting = jQuery(this).val();
                    var type = 'Order';
                    $.ajax({
                        type: "POST",
                        async: false,
                        url: base_url + "modules/sendinblue/ajaxOrderSetting.php",
                        data: "orderSetting=" + orderSetting + "&token=" + token + "&type=" + type + "&id_shop_group=" + id_shop_group + "&id_shop=" + id_shop,
                        beforeSend: function() {
                            $('#ajax-busy').show();
                        },
                        success: function(msg) {
                            $('#ajax-busy').hide();
                            if (orderSetting == 1) {
                                jQuery(".hideOrder").show();
                            } else {
                                jQuery(".hideOrder").hide();
                            }
                        }
                    });
                });
                $(".sms_shiping_setting").click(function() {
                    var shipingSetting = jQuery(this).val();
                    var type = 'shiping';
                    $.ajax({
                        type: "POST",
                        async: false,
                        url: base_url + "modules/sendinblue/ajaxOrderSetting.php",
                        data: "shipingSetting=" + shipingSetting + "&token=" + token + "&type=" + type + "&id_shop_group=" + id_shop_group + "&id_shop=" + id_shop,
                        beforeSend: function() {
                            $('#ajax-busy').show();
                        },
                        success: function(msg) {
                            $('#ajax-busy').hide();
                            if (shipingSetting == 1) {
                                jQuery(".hideShiping").show();
                            } else {
                                jQuery(".hideShiping").hide();
                            }
                        }
                    });

                });

                $(".sms_campaign_setting").click(function() {
                    var campaignSetting = jQuery(this).val();
                    var type = 'campaign';
                    $.ajax({
                        type: "POST",
                        async: false,
                        url: base_url + "modules/sendinblue/ajaxOrderSetting.php",
                        data: "campaignSetting=" + campaignSetting + "&token=" + token + "&type=" + type + "&id_shop_group=" + id_shop_group + "&id_shop=" + id_shop,
                        beforeSend: function() {
                            $('#ajax-busy').show();
                        },
                        success: function(msg) {
                            $('#ajax-busy').hide();
                            if (campaignSetting == 1) {
                                jQuery(".hideCampaign").show();
                            } else {
                                jQuery(".hideCampaign").hide();
                            }
                        }
                    });

                });

                if ($('input:radio[name=sms_order_setting]:checked').val() == 0)
                {
                    $('.hideOrder').hide();
                } else {
                    $('.hideOrder').show();
                }

                $(".Sendin_Sms_Choice").click(function()
                {
                    if (jQuery(this).val() == 1) {
                        jQuery(".multiplechoice").hide();
                        jQuery(".singlechoice").show();
                    } else {
                        jQuery(".multiplechoice").show();
                        jQuery(".singlechoice").hide();
                    }
                });


                if ($('input:radio[name=Sendin_Sms_Choice]:checked').val() == 2)
                {
                    jQuery(".multiplechoice").show();
                    jQuery(".singlechoice").hide();
                } else {
                    jQuery(".singlechoice").show();
                    jQuery(".multiplechoice").hide();
                }

                $(".sms_shiping_setting").click(function() {
                    if (jQuery(this).val() == 1) {

                        jQuery(".hideShiping").show();
                    } else {
                        jQuery(".hideShiping").hide();
                    }
                });
                if ($('input:radio[name=Sendin_Sms_Choice]:checked').val() == 0)
                {
                    jQuery(".multiplechoice").show();
                    jQuery(".singlechoice").hide();
                } else {
                    jQuery(".singlechoice").show();
                    jQuery(".multiplechoice").hide();
                }

                $(".sms_shiping_setting").click(function() {
                    if (jQuery(this).val() == 1) {

                        jQuery(".hideShiping").show();
                    } else {
                        jQuery(".hideShiping").hide();
                    }
                });
                jQuery('#r1_Sendin_Sms_Choice').attr('checked', true);
                if ($('input:radio[name=sms_credit]:checked').val() == 0)
                    jQuery(".hideCredit").hide();
                else
                    jQuery(".hideCredit").show();


                $(".sms_credit").click(function() {

                    var sms_credit = jQuery(this).val();
                    var type = 'sms_credit';
                    $.ajax({
                        type: "POST",
                        async: false,
                        url: base_url + "modules/sendinblue/ajaxOrderSetting.php",
                        data: "sms_credit=" + sms_credit + "&token=" + token + "&type=" + type + "&id_shop_group=" + id_shop_group + "&id_shop=" + id_shop,
                        beforeSend: function() {
                            $('#ajax-busy').show();
                        },
                        success: function(msg) {
                            $('#ajax-busy').hide();
                            if (sms_credit == 1) {
                                jQuery(".hideCredit").show();
                            } else {
                                jQuery(".hideCredit").hide();
                            }
                        }
                    });

                });

                if ($('input:radio[name=sms_shiping_setting]:checked').val() == 0) {
                    $('.hideShiping').hide();
                } else {
                    $('.hideShiping').show();
                }

                $(".sms_campaign_setting").click(function() {
                    if (jQuery(this).val() == 1) {
                        jQuery(".hideCampaign").show();
                    } else {
                        jQuery(".hideCampaign").hide();
                    }
                });

                if ($('input:radio[name=sms_campaign_setting]:checked').val() == 0) {
                    $('.hideCampaign').hide();
                } else {
                    $('.hideCampaign').show();
                }

                $("#selectSmsList").multiselect({
                    header: false,
                    checkall: false
                });

                $("#tabs li").click(function() {
                    //	First remove class "active" from currently active tab
                    $("#tabs li").removeClass('active');

                    //	Now add class "active" to the selected/clicked tab
                    $(this).addClass("active");

                    //	Hide all tab content
                    $(".tab_content").hide();

                    //	Here we get the href value of the selected tab
                    var selected_tab = $(this).find("a").attr("href");

                    //	Show the selected tab content
                    $(selected_tab).fadeIn();

                    //	At the end, we add return false so that the click on the link is not executed
                    return false;
                });

            }

            $('#showUserlist').click(function() {

                if ($('#userDetails').is(':hidden'))
                {
                    var table_data_len = $(".midleft tr").length;
                    if (table_data_len <= 0) {
                        if (loadData(1, token)) {
                            $('#Spantextless').show();
                            $('#Spantextmore').hide();
                        }
                    }
                    else {
                        $('#Spantextless').show();
                        $('#Spantextmore').hide();
                    }
                } else {
                    $('#Spantextmore').show();
                    $('#Spantextless').hide();
                }
                $('#userDetails').slideToggle();
            });

            $("#select").multiselect({
                header: false,
                checkall: false
            });

            $(".keyyes").click(function() {

                if (jQuery(this).val() == 1) {
                    jQuery("#apikeybox").show();
                    jQuery(".hidetableblock").show();
                    jQuery(".unsubscription").show();
                    jQuery(".listData").show();

                } else {
                    jQuery("#apikeybox").hide();
                    jQuery(".hidetableblock").hide();
                    jQuery(".unsubscription").hide();
                    jQuery(".listData").hide();
                }

            });



            $(".script").click(function() {
                var script = jQuery(this).val();
                $.ajax({
                    type: "POST",
                    async: false,
                    url: base_url + "modules/sendinblue/ajax.php",
                    data: {"script": script, "token": token, "id_shop_group":id_shop_group, "id_shop":id_shop},
                    beforeSend: function() {
                        $('#ajax-busy').show();
                    },
                    success: function(msg) {

                        $('#ajax-busy').hide();
                    }
                });
            });

            $(".smtptestclick").click(function() {
                var smtptest = jQuery(this).val();
                var token = jQuery("#customtoken").val();
                if (smtptest == 0) {
                    $('#smtptest').hide();
                }
                if (smtptest == 1) {
                    $('#smtptest').show();
                }
                $.ajax({
                    type: "POST",
                    async: false,
                    url: base_url + "modules/sendinblue/ajaxsmtpconfig.php",
                    data: {"smtptest": smtptest, "token": token, "id_shop_group":id_shop_group, "id_shop":id_shop},
                    beforeSend: function() {
                        $('#ajax-busy').show();
                    },
                    success: function(msg) {

                        $('#ajax-busy').hide();
                        //$('#message').html(msg);
                    }
                });
            });

            var radios = $('input:radio[name=managesubscribe]:checked').val();

            if (radios == 0) {
                $('.managesubscribeBlock').hide();
            } else {
                $('.managesubscribeBlock').show();
            }

            $(".managesubscribe").click(function() {
                var managesubscribe = jQuery(this).val();
                var token = jQuery("#customtoken").val();

                if (managesubscribe == 0) {
                    $('.managesubscribeBlock').hide();
                }
                if (managesubscribe == 1) {
                    $('.managesubscribeBlock').show();
                }
                $.ajax({
                    type: "POST",
                    async: false,
                    url: base_url + "modules/sendinblue/ajaxsubscribeconfig.php",
                    data: {"managesubscribe": managesubscribe, "token": token, "id_shop_group":id_shop_group, "id_shop":id_shop},
                    beforeSend: function() {
                        $('#ajax-busy').show();
                    },
                    success: function(msg) {
                        $('#ajax-busy').hide();
                    }
                });
            });

            var token = jQuery("#customtoken").val();

            $('<div id="ajax-busy"/> loading..')
                    .css(
                            {
                                opacity: 0.5,
                                position: 'fixed',
                                top: 0,
                                left: 0,
                                width: '100%',
                                height: $(window).height() + 'px',
                                background: 'white url(' + base_url + 'modules/sendinblue/views/img/loader.gif) no-repeat center'
                            }).hide().appendTo('body');

            $('.ajax_contacts_href').live('click', function(e) {
                /*var sBase = location.href.substr(0, location.href.lastIndexOf("/") + 1);
                 var sp = sBase.split('/');
                 var lastFolder = sp[ sp.length - 2 ];
                 var base_url = sBase.replace(lastFolder+'/', '');
                 alert(base_url);*/
                var email = $(this).attr('email');
                var status = $(this).attr('status');
                var token = jQuery("#customtoken").val();

                $.ajax({
                    type: "POST",
                    async: false,
                    url: base_url + "modules/sendinblue/ajaxcall.php",
                    data: {"email_value": email, "newsletter_value": status, "token": token, "id_shop_group":id_shop_group, "id_shop":id_shop},
                    beforeSend: function() {
                        $('#ajax-busy').show();
                    },
                    success: function(msg) {
                        $('#ajax-busy').hide();
                    }
                });

                var page_no = $('#page_no').val();
                loadData(page_no, token); // For first time page load
            });
            
            //sms subscribe and unsubscribe
            
             $('.ajax_sms_href').live('click', function(e) {
                /*var sBase = location.href.substr(0, location.href.lastIndexOf("/") + 1);
                 var sp = sBase.split('/');
                 var lastFolder = sp[ sp.length - 2 ];
                 var base_url = sBase.replace(lastFolder+'/', '');
                 alert(base_url);*/

                var email = $(this).attr('email');
                var token = jQuery("#customtoken").val();

                $.ajax({
                    type: "POST",
                    async: false,
                    url: base_url + "modules/sendinblue/ajaxSmsStatus.php",
                    data: {"email": email,"token": token, "id_shop_group": id_shop_group, "id_shop":id_shop},
                    beforeSend: function() {
                        $('#ajax-busy').show();
                    },
                    success: function(msg) {
                        $('#ajax-busy').hide();
                    }
                });

                var page_no = $('#page_no').val();
                loadData(page_no, token); // For first time page load
            });
            //select multiple list for file name
            $( "#oem_list" )
		  .change(function () {
			var str = "";
			  var count = ($( "#oem_list option:selected" ).length-1);
			$( "#oem_list option:selected" ).each(function(i,val) {

				str += $( this ).text();

				if(i<count){
					str +=',';
				}        
			});
			$( "#em_text_val" ).val( str );
		  })
		  .change();

            //hide and show order import tab
            $(".ordertracking").click(function() {
                var tracktest = jQuery(this).val();
                var token = jQuery("#customtoken").val();
                if (tracktest == 0) {
                    $('#ordertrack').hide();
                }
                if (tracktest == 1) {
                    $('#ordertrack').show();
                }
            });
            $("#importOrderTrack").click(function() {
                var importmsg = jQuery("#importmsg").val();
                var token = jQuery("#customtoken").val();

                $.ajax({
                    type: "POST",
                    async: false,
                    url: base_url + "modules/sendinblue/ajaxOrderTracking.php",
                    data: {"token": token, "id_shop_group":id_shop_group, "id_shop":id_shop},
                    beforeSend: function() {
                        $('#ajax-busy').show();
                    },
                    success: function(msg) {                        
                        $('#ajax-busy').hide();
                        $('#ordertrack').hide();
						alert(importmsg);
                    }
                });
            });


            function loadData(page, token) {
                $.ajax({
                    type: "POST",
                    async: false,
                    url: base_url
                            + "modules/sendinblue/ajaxemailresult.php",
                    data: {"page": page, "token": token, "id_shop_group": id_shop_group, "id_shop":id_shop},
                    beforeSend: function() {
                        $('#ajax-busy').show();
                    },
                    success: function(msg) {
                        $('#ajax-busy').hide();
                        $(".midleft").html(msg);
                        $(".midleft").ajaxComplete(
                                function(event, request, settings) {
                                    $(".midleft").html(msg);
                                });
                        return true;
                    }
                });
            }

            //loadData(1, token); // For first time page load
            // default
            // results

            $('.pagination li.active').livequery('click', function() {
                var page = $(this).attr('p');
                $('#page_no').val(page);
                loadData(page, token);
            });

            $('.toolTip').live('mouseover mouseout', function(e) {
                var title = $(this).attr('title');
                var offset = $(this).offset();

                if (e.type == 'mouseover') {
                    $('body').append(
                            '<div id="tipkk" style="top:'
                            + offset.top
                            + 'px; left:'
                            + offset.left
                            + 'px; ">' + title
                            + '</div>');
                    var tipContentHeight = $('#tipkk')
                            .height() + 25;
                    $('#tipkk').css(
                            'top',
                            (offset.top - tipContentHeight)
                            + 'px');
                }
                else if (e.type == 'mouseout') {
                    $('#tipkk').remove();
                }
            });

        });
 $('.testOrdersmssend').live('click', function(){
	var successmsg = $(this).attr('successmsg');
	var failmsg = $(this).attr('failmsg');

    var token = $('#customtoken').val();
    var langvalue = $('#langvalue').val();
    var sender = $('#sender_order').val();
    var message = $('#sender_order_message').val();
    var number = $('#sender_order_number').val();
	var id_shop_group = $('#id_shop_group').val();
	var id_shop = $('#id_shop').val();
    var iso_code = $('#iso_code').val();

    $.ajax({
        type: "POST",
        async: false,
        url: base_url
                + "modules/sendinblue/ajaxtestsms.php",
        data: {"sender": sender, "message": message, "number": number, "langvalue": langvalue, "token": token, "id_shop_group": id_shop_group, "id_shop":id_shop,"iso_code":iso_code},
        beforeSend: function() {
            $('#ajax-busy').show();
        },
        success: function(msg) {
            $('#ajax-busy').hide();
            var data =$.parseJSON(msg);

            if(data['result'] == true)
			{
			alert(successmsg);
			}
			else
			{
			alert(failmsg);
			}
        }
    });
    return false;
});
$('.testSmsShipped').live('click', function(){
	var successmsg = $(this).attr('successmsg');
	var failmsg = $(this).attr('failmsg');

    var token = $('#customtoken').val();
    var langvalue = $('#langvalue').val();
    var sender = $('#sender_shipment').val();
    var message = $('#sender_shipment_message').val();
    var number = $('#sender_shipment_number').val();
	var id_shop_group = $('#id_shop_group').val();
	var id_shop = $('#id_shop').val();
    var iso_code = $('#iso_code').val();

    $.ajax({
        type: "POST",
        async: false,
        url: base_url
                + "modules/sendinblue/ajaxTestSmsShipped.php",
        data: {"sender": sender, "message": message, "number": number, "langvalue": langvalue, "token": token, "id_shop_group": id_shop_group, "id_shop":id_shop, "iso_code":iso_code},
        beforeSend: function() {
            $('#ajax-busy').show();
        },
        success: function(msg) {
            $('#ajax-busy').hide();
			var data =$.parseJSON(msg);

            if(data['result'] == true)
			{
			alert(successmsg);
			}
			else
			{
			alert(failmsg);
			}
        }
    });
    return false;
});

$('.testSmsCampaignsend').live('click', function(){
	var successmsg = $(this).attr('successmsg');
	var failmsg = $(this).attr('failmsg');
	var sendererr = $(this).attr('sendererr');
	var mobileerr = $(this).attr('mobileerr');
	var messageerr = $(this).attr('messageerr');
    var token = $('#customtoken').val();
    var langvalue = $('#langvalue').val();
    var sender = $('#sender_campaign').val();
    var message = $('#sender_campaign_message').val();
    var number = $('#sender_campaign_number_test').val();
	var id_shop_group = $('#id_shop_group').val();
	var id_shop = $('#id_shop').val();
    if (sender == '')
    {
        alert(sendererr);
    }
    else if (message == '')
    {
        alert(messageerr);
    }
    else if (number == '')
    {
        alert(mobileerr);
    }
    else {
        $.ajax({
            type: "POST",
            async: false,
            url: base_url
                    + "modules/sendinblue/ajaxCampaignSmsTest.php",
            data: {"sender": sender, "message": message, "number": number, "langvalue": langvalue, "token": token, "id_shop_group":id_shop_group, "id_shop":id_shop},
            beforeSend: function() {
                $('#ajax-busy').show();
            },
            success: function(msg) {
                $('#ajax-busy').hide();

                var data =$.parseJSON(msg);

				if(data['result'] == true)
				{
				alert(successmsg);
				}
				else
				{
				alert(failmsg);
				}
            }
        });
    }
    return false;
});
$('.sender_order_save').live('click', function(){
	var senderfield = $(this).attr('senderfield');
	var messagefield = $(this).attr('messagefield');
	var sender = $('#sender_order').val();
    var message = $('#sender_order_message').val();
	if (sender == '')
    {
        alert(senderfield);
		document.getElementById('sender_order').focus(); 
        return false;
    }
    else if (message == '')
    {
        alert(messagefield);
		document.getElementById('sender_order_message').focus(); 
        return false;
    }	    
});
$('.sender_shipment_save').live('click', function(){
	var senderfield = $(this).attr('senderfield');
	var messagefield = $(this).attr('messagefield');
	var sender = $('#sender_shipment').val();
    var message = $('#sender_shipment_message').val();
	if (sender == '')
    {
        alert(senderfield);
		document.getElementById('sender_shipment').focus(); 
        return false;
    }
    else if (message == '')
    {
        alert(messagefield);
		document.getElementById('sender_shipment_message').focus(); 
        return false;
    }	    
});
$('.sender_campaign_save').live('click', function(){
	var senderfield = $(this).attr('senderfield');
	var messagefield = $(this).attr('messagefield');
	var sender = $('#sender_campaign').val();
    var message = $('#sender_campaign_message').val();
	if (sender == '')
    {
        alert(senderfield);
		document.getElementById('sender_campaign').focus(); 
        return false;
    }
    else if (message == '')
    {
        alert(messagefield);
		document.getElementById('sender_campaign_message').focus(); 
        return false;
    }	    
});
function isNormalInteger(str)
{
    return /^\+?(0|[0-9]\d*)$/.test(str);
}
function RegexEmail(email)
{

    var emailRegexStr = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
    var isvalid = emailRegexStr.test(email);
    return isvalid;
}
function validate(emailerr, limiter)
{


    if (document.notify_sms_mail_form.sendin_notify_email.value == "" || RegexEmail(document.notify_sms_mail_form.sendin_notify_email.value) == false)
    {
        alert(emailerr);
        document.notify_sms_mail_form.sendin_notify_email.focus();
        return false;
    }
    if (document.notify_sms_mail_form.sendin_notify_value.value <= 0 ||
            isNormalInteger(document.notify_sms_mail_form.sendin_notify_value.value) == false)
    {
        alert(limiter);
        document.notify_sms_mail_form.sendin_notify_value.focus();
        return false;
    }

    return(true);
}

// get site base url


function isInteger(val) {
    var numberRegex = /^[+-]?\d+(\.\d+)?([eE][+-]?\d+)?$/;
    if (numberRegex.test(val)) {
        return true
    }
    return false;
}
