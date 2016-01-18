$(function() {
	function select_all(el) {
        if (typeof window.getSelection != "undefined" && typeof document.createRange != "undefined") {
            var range = document.createRange();
            range.selectNodeContents(el);
            var sel = window.getSelection();
            sel.removeAllRanges();
            sel.addRange(range);
        } else if (typeof document.selection != "undefined" && typeof document.body.createTextRange != "undefined") {
            var textRange = document.body.createTextRange();
            textRange.moveToElementText(el);
            textRange.select();
        }
    }
	
	//show warning on module page
	function showWarning(id) {
		$('#'+id+' , .module_name').append('<span class="label label-warning">Da aggiornare</span>');
	}

	function reloadPage(CU) {
		window.location.href = CU;
	}
	
	window.manageAreas = function(areaData){
		var actualArea = [];
		//var areaData = {};
		
		var n = 0;
		var updating = false;
		
		function cangeTabTitles(){
			$('.areaTitle').each(function(){
				$(this).unbind('keyup');
				$(this).keyup(function(){
					var value = $(this).val();
					if (value != '')
						$('.mapsTabs:visible li[aria-selected="true"] a').text(value);
					else
						$('.mapsTabs:visible li[aria-selected="true"] a').text(tabEmptyName);
				})
				
			})
		}
		
		cangeTabTitles();
		
		$('#imgchooser img.preview').each(function(i){
				n = parseInt($(this).attr('data-areanum'));
				if (typeof(actualArea[i]) !== 'undefined') {
					actualArea[i].setOptions({disable:1});
					actualArea[i].cancelSelection();
				}
				actualArea[i] = $(this).imgAreaSelect({
					parent:$('#imgchooser'),
					handles: true,
					disable:1,
					active:n,
					resizeMargin : 10,
					instance: true,
					fadeSpeed : 150,
					onSelectEnd: function(img, selection){
						//console.log(img);
						var width = $(img).width();
						var height = $(img).height();
						// set selection values in % for responsiveness;
						var imgLang = $(img).attr('data-lang');
						if (updating === false) {
							if (typeof areaData[imgLang] == 'undefined' || !areaData[imgLang])
								areaData[imgLang] = {};
							areaData[imgLang][n] = {};
							areaData[imgLang][n].left = 100/width*selection.x1;
							areaData[imgLang][n]['top'] = 100/height*selection.y1;
							areaData[imgLang][n]['selWidth'] = 100/width*selection.width;
							areaData[imgLang][n]['selHeight'] = 100/height*selection.height;
						} else {
							var lang = updating[0];
							var num = updating[1];
							areaData[lang][num].left = 100/width*selection.x1;
							areaData[lang][num]['top'] = 100/height*selection.y1;
							areaData[lang][num]['selWidth'] = 100/width*selection.width;
							areaData[lang][num]['selHeight'] = 100/height*selection.height;
						}
					}
				});
			})
		
		$('#add_area').click(function(e){
			e.preventDefault();
			var actualPic = $('#imgchooser img.preview').filter(':visible');
			actualPic.parent('.areafixer').addClass('workingArea');
			actualPic.imgAreaSelect({enable:1});
			n = parseInt(actualPic.attr('data-areanum'));
		})
				
		var Tabs = [];
		$('.mapsTabs').each(function(i){
			Tabs[i] = $(this).tabs({
				activate: function( event, ui ) {
					var prevId = ui.newTab.attr('data-prev');
					$('.area_prev').removeClass('active');
					$('#'+prevId).addClass('active');
				}
			});
		})
		
		var areaTemplate = '<div class="area_prev" ><div class="iconA"></div></div>';
		
		$('#save_area').click(function(e){
			e.preventDefault();
			$('#imgchooser .workingArea').removeClass('workingArea');
			for (i in actualArea)
				if (typeof(actualArea[i]) !== 'undefined') {
					actualArea[i].setOptions({disable:1});
					actualArea[i].cancelSelection();
				}
			console.log(updating);
			if (updating === false) {
				var updateNumber = parseInt($('#imgchooser .workingArea img').attr('data-areanum'))+1;
				$('#imgchooser .workingArea img').attr('data-areanum', updateNumber);

				for (lang in areaData) {
					$('#area_prev_'+lang).html('');
					for (num in areaData[lang]){
						//console.log($('#area_'+num+'_l_'+lang).length);
						if ($('#area_'+num+'_l_'+lang).length < 1) { // check if tab exists
							$('#tabsLang_'+lang+' ul').append('<li class="tab" data-lang="'+lang+'" data-num="'+num+'" data-prev="prev_'+num+'_l_'+lang+'"><a href="#area_'+num+'_l_'+lang+'">'+tabEmptyName+'</a></li>');
							$('#tabsLang_'+lang).append('<div id="area_'+num+'_l_'+lang+'"><div class="textfields"><label>'+areaTitleLabel+'<input type="text" class="areaTitle" name="areas['+lang+']['+num+'][title]" value="" /></label><label>'+areaUrlLabel+'<input type="text" name="areas['+lang+']['+num+'][url]" value="" /></label><label>'+areaButtLabel+'<input type="text" name="areas['+lang+']['+num+'][button]" value="" /></label></div><div class="stylfields"></div><div class="descriptionfield" ></div><div class="hiddens"/></div>');
							
							var description = '<label>'+areaDescLabel+'<textarea class="areadesc rte" name="areas['+lang+']['+num+'][description]"></textarea></label>';
							
							var styles = '<fieldset><legend>'+areaStyleLegend+'</legend><label>'+areaStyleSimple+'<input type="radio" name="areas['+lang+']['+num+'][style]" checked="checked" value="simple" /></label><label>'+areaStyleBlock+'<input type="radio" name="areas['+lang+']['+num+'][style]" value="block" /></label></fieldset>';
							
							styles +='<fieldset><legend>'+areaColorLegend+'</legend><label>'+areaColorLight+'<input type="radio" name="areas['+lang+']['+num+'][color]" checked="checked" value="light" /></label><label>'+areaColorDark+'<input type="radio" name="areas['+lang+']['+num+'][color]" value="dark" /></label><label>'+areaColorTrans+'<input type="radio" name="areas['+lang+']['+num+'][color]" value="transparent" /></label></fieldset>';
							
							$('#area_'+num+'_l_'+lang+' .stylfields').html(styles);
							$('#area_'+num+'_l_'+lang+' .descriptionfield').html(description);
						} 
						var contents = '<input type="hidden" name="areas['+lang+']['+num+'][left]" value="'+areaData[lang][num].left+'" />';
						contents += '<input type="hidden" name="areas['+lang+']['+num+'][top]" value="'+areaData[lang][num].top+'" />';
						contents += '<input type="hidden" name="areas['+lang+']['+num+'][selWidth]" value="'+areaData[lang][num].selWidth+'" />';
						contents += '<input type="hidden" name="areas['+lang+']['+num+'][selHeight]" value="'+areaData[lang][num].selHeight+'" />';
						
						$('#area_'+num+'_l_'+lang+' .hiddens').html(contents);
						
						$('#area_prev_'+lang).append( $(areaTemplate).css({
								left : areaData[lang][num].left+'%',
								top : areaData[lang][num].top+'%',
								width : areaData[lang][num].selWidth+'%',
								height : areaData[lang][num].selHeight+'%'
							}).attr({
								'data-tab' : 'area_'+num+'_l_'+lang,
								'id' : 'prev_'+num+'_l_'+lang
							})
						);
					}
				}
			
				$('.mapsTabs').each(function(i){
					Tabs[i].tabs( "refresh" );
					Tabs[i].tabs( {active:n} );
				})
				// apply tinmce to new areas
				tinySetup({
					editor_selector :"rte",
					force_p_newlines : false,
					forced_root_block : "",
				});
				cangeTabTitles();
				has_area();
			} else {
				var lang = updating[0];
				var num = updating[1];

				var contents = '<input type="hidden" name="areas['+lang+']['+num+'][left]" value="'+areaData[lang][num].left+'" />';
				contents += '<input type="hidden" name="areas['+lang+']['+num+'][top]" value="'+areaData[lang][num].top+'" />';
				contents += '<input type="hidden" name="areas['+lang+']['+num+'][selWidth]" value="'+areaData[lang][num].selWidth+'" />';
				contents += '<input type="hidden" name="areas['+lang+']['+num+'][selHeight]" value="'+areaData[lang][num].selHeight+'" />';
				
				$('#area_'+num+'_l_'+lang+' .hiddens').html(contents);
				
				$('#area_prev_'+lang).append( $(areaTemplate).css({
						left : areaData[lang][num].left+'%',
						top : areaData[lang][num].top+'%',
						width : areaData[lang][num].selWidth+'%',
						height : areaData[lang][num].selHeight+'%'
					}).attr({
						'data-tab' : 'area_'+num+'_l_'+lang,
						'id' : 'prev_'+num+'_l_'+lang
					})
				);
				
			}
			updating = false;
			//console.log(areaData);
		})
		
		//update has_area Value
		function has_area(){
			if ($('.area_prev').length > 0)
				$('#has_area').val('1');
			else
				$('#has_area').val('0');
		}
		
		$('#removeArea').click(function(e){
			e.preventDefault();
			$('.mapsTabs').each(function(i){
				if ($(this).is(':visible')){
					var tab = $('.slideAreaTabs li[aria-selected="true"]', $(this));
					var id = tab.attr('aria-controls');
					var langId = tab.attr('data-lang');
					var areanum = tab.attr('data-num');
					$('#'+id).remove(); //remove tab content
					$('.area_prev[data-tab="'+id+'"]').remove(); //remove preview from image
					tab.remove(); //remove tab (li element)
					// need to unset data from areaData object
					delete areaData[langId][areanum];
					var tempAreas = {};
					tempAreas[langId] = {};
					var c = 0;
					for (i in areaData[langId]) {
						tempAreas[langId][c] = areaData[langId][i];
						c++;
					}
					areaData[langId] = tempAreas[langId];
				}
			})
			has_area();
		})
		
		/** EDIT AREA **/ 
		$('#editArea').click(function(e){
			e.preventDefault();
			var tab, id, langId, areanum;
			$('.mapsTabs').each(function(i){
				if ($(this).is(':visible')){
					tab = $('.slideAreaTabs li[aria-selected="true"]', $(this));
					id = tab.attr('aria-controls');
					langId = tab.attr('data-lang');
					areanum = tab.attr('data-num');
				}
			})
			var actualPic = $('#imgchooser img.preview').filter(':visible');
			actualPic.parent('.areafixer').addClass('workingArea');
			
			var width = $(actualPic).width();
			var height = $(actualPic).height();
			/* convert % in px for areaselect */
			var x1 = width/100*areaData[langId][areanum].left;
			var y1 = height/100*areaData[langId][areanum].top;
			var x2 = x1+(width/100*areaData[langId][areanum].selWidth);
			var y2 = y1+(height/100*areaData[langId][areanum].selHeight);
			
			
			actualPic.imgAreaSelect({
				enable:1,
				x1:x1,
				y1:y1,
				x2:x2,
				y2:y2
			});
			$('.area_prev[data-tab="'+id+'"]').remove(); //remove preview from image
			updating = [langId, areanum];
			console.log(updating);
		})
	}
	
	function versionCompare(actualV, newV){
		
		var result;
		actualV = actualV.split('.');
		newV = newV.split('.');
		var size = actualV.length;
		if (size > newV.length)
			size = newV.length;
				
		for (i=0;i<size;i++){
			var NV = newV[i];
			var AV = actualV[i];
			if (i>0) {
				if (NV.length > AV.length) {
					var diff = NV.length-AV.length;
					for (d=0;d < diff;d++){
						AV = AV+'0';
					}
				} else if (AV.length > NV.length) {
					var diff = AV.length-NV.length;
					for (d=0;d<diff;d++){
						NV = NV+'0';
					}
				}
			}

			if (parseInt(NV) < parseInt(AV)) {
			    //is older
				result = -1;
				break;
			} else
			if (parseInt(NV) > parseInt(AV)) {
				result = 1;
				break;
			} else
				result = 0;
		}
		
		if (result == 0) {
			if (actualV.length < newV.length)
				for (i;i<newV.length; i++)
					if (newV[i] > 0){
						result = 1;
						break;
					}
		}
		
		return result;
	}
	
	/**********************/
	/****Document Ready****/
	/**********************/
	
	$(document).ready(function(){ 
		var CU = window.location.href;
		CU = CU.replace(window.location.hash,'');
		$.ajaxSetup({
			cache: false,
			xhrFields: {
			   withCredentials: true
			},
			crossDomain: true
		});
		function checkUpdate() {
			var newVersion;
			$.ajax({
				type:     "GET",
				cache: false,
				url:      updateUrl+"?sea="+actualVersion+'&d='+window.location.hostname,
				dataType: "jsonp",
				success: function(data){ 
					newVersion = data[0].version;
					if (versionCompare(actualVersion, newVersion) > 0) {
						$.post(ajaxUrl+"&action=alertNewVersion", {params:newVersion}, function(data){
							showalert(data, function(){reloadPage(CU);});
						});
					}
				}
			}).done(function(data, message  ) {
				//console.log( "done:", data, message );
			}).fail(function(data, message) {
				console.log( "Error: Ajax request failed!", data, message );
			}).always(function(data, message) {
				//console.log( "complete:",data, message );
			});
		}
		if (typeof updateUrl !== 'undefined' && typeof actualVersion !== 'undefined'){
			setTimeout(function(){
				checkUpdate();
			},2000);
		};

		var alerts = $('<div id="alerts"><span class="fa fa-times closeme"></span><span class="wait fa fa-cog fa-spin"></span><span id="alertmsg"></span></div>');
		$('body').append(alerts);
		
		var alertTimeout;
		
		function showalert(msg, f, undo, time){
			clearTimeout(alertTimeout);
			var $al = $('#alerts');
			if (msg == '')
				msg = '...';
			$('#alertmsg').text(msg);
			$al.fadeIn('fast');
			if (typeof f == "function") {
				var alertButtons = $('<div class="alertButtons"></div>');
				var accept = $('<span class="accept fa fa-check"></span>');
				var cancel = $('<span class="cancel fa fa-times"></span>');
				$('#alertmsg').append(alertButtons);
				alertButtons.append(accept);
				if (undo){
					alertButtons.append(cancel);
				}
				accept.click(function(){
					f();
				})
				cancel.click(function(){
					hidealert();
				})
			} else {
				var delay = 1500;
				if (typeof time !== 'undefined')
					delay = time;
				alertTimeout = setTimeout(function(){hidealert()},delay)
			}
		}
					
		function hidealert(){
			$('#alerts').fadeOut('fast',function(){
				$('#alertmsg').html('');
			});
		}
		
		$('#alerts .closeme').click(function(){
			hidealert();
		})
		
		//autocomplete
		function split( val ) {
			return val.split( /,\s*/ );
		}
		function extractLast( term ) {
			return split( term ).pop();
		}
		
		$('.prod_auto').each(function(){
			var hook = $(this).data('hook');
			var $values = $(this).siblings('.prod_values');
			$values.css('borderColor','red');
			$(this).autocomplete({
				//source: ajaxUrl+"&action=autocomplete&value=products",
				source: function( request, response ) {
					console.log(request);
					$.ajax({
						url: ajaxUrl+"&action=autocomplete&value=products",
						dataType: "json",
						data: {
							s: extractLast( request.term ) 
						},
						
						success: function( data ) {
							console.log(data);
							response( data );
							//response( $.ui.autocomplete.filter(availableTags, extractLast( request.term ) ) );
						}
					});
				},
				focus: function() {
					// prevent value inserted on focus
					return false;
				},
				minLength: 3,
				select: function( event, ui ) {
					var label = ui.item.label;
					var id = ui.item.value;
					
					if ($('.prod_filter[data-id="'+id+'"]').length <= 0) {
						// add the selected item
						$values.append('<span data-id="'+id+'" class="prod_filter">'+label+' ('+id+')<i class="fa fa-close filter_remove"></i><input type="hidden" name="configs['+hook+'][filters][products][values][]" value="'+id+'" /></span>');
						activateRemovers();
					}
					this.value = ui.item.label;
					
					return false;
					console.log( ui.item ?
					"Selected: " + ui.item.value + " aka " + ui.item.id :
					"Nothing selected, input was " + this.value );
				}
			});
		})
		
		function activateRemovers(){
			$('.filter_remove').each(function(){
				$(this).unbind( "click" ).click(function(){$(this).parent().remove();});
			})
		}
		activateRemovers();
		
			
				
		//reposition
		var $mySlides = $(".slides");
		$mySlides.each(function(){
			$(this).sortable({
				placeholder: "ui-state-highlight",
				axis: "y",
				cursor: "move",
				update: function() {
					var order = $(this).sortable("serialize") ;
					var currentSlider = $(this);
					//console.log(order)
					$.post(ajaxUrl+"&action=updateSlidesPosition", order, function(data){
						showalert(data);
						//console.log($('.position_number',currentSlider));
						$('.position_number',currentSlider).each(function(i){
							$(this).fadeTo(100,0.01);
							var delay = 100+(50*i);
							var elem = $(this);
							var pos = i;
							setTimeout(function(){
								elem.text(pos+1).fadeTo(100,1);
							},delay);
						})
					});
				}
			});
		})
		$mySlides.hover(function() {
			$(this).css("cursor","move");
			},
			function() {
			$(this).css("cursor","auto");
		});
		
		var fixHelper = function(e, ui) {
			ui.children().each(function() {
				$(this).width($(this).width());
			});
			return ui;
		};
		
		if ($('table.confighooks tbody').length > 0){
			$('table.confighooks tbody').sortable({
				axis: 'y',
				helper: fixHelper,
				placeholder: "ui-state-highlight",
				handle: ".handle",
				forcePlaceholderSize: true,
				opacity: 0.6
			})
		}

		function activationSetup() {
			$('.activationForm').each(function(){
				$(this).submit(function(e){
					e.preventDefault();
					var action = $(this).attr('id');
					var message = $('.message', this).text();
					
					showalert(message,function(){
						$.post(ajaxUrl+"&action="+action, function(data){
							//console.log(data);
							showalert(data, function(){reloadPage(CU)});		
							//showalert(data);		
						})
					}, true);
				})
			})
		}

		activationSetup(); 
		
		$('#showAct').click(function(e){
			e.preventDefault();
			$('table.activations').fadeToggle();
		})
		
		$('.deleteSlidePic').click(function(e){
			e.preventDefault();
			var val = $(this).attr('href');
			showalert('Are you sure?', function(){
				reloadPage(val);
			}, 1);
		})
		
		// permissions
		$('#accessEdit input[type="radio"]').each(function(){
			$(this).change(function(){
				var data = $('#accessEdit').serialize();
				$.post(ajaxUrl+"&action=editPermissions&"+data, function(data){
					showalert(data);
					//reloadPage(CU);
				})
			})
		})
		
		$('#accessEdit').submit(function(){
			var data = $(this).serialize();
			$.post(ajaxUrl+"&action=editPermissions&"+data, function(data){
				showalert(data);
			})
			return false;
		})
				
		$('.resConf').each(function(){
			var oldVal = $(this).val();
			$(this).on('blur change', function(){
				var newVal = $(this).val();
				if (newVal != oldVal) {
					var hook = $(this).attr('data-hook');
					$('.batchResize[data-hook="'+hook+'"]').slideDown();
				}
			})
		})
		
		$(document).ajaxError(function(a,b,c){
			console.log(c);
			//showalert(a.type,'',false,10000);
		});
		// update slider Configuration
		$('#sliders_config').submit(function(e){
			e.preventDefault();
			var data = $(this).serializeArray();
			$.post(ajaxUrl+"&action=updateConfiguration&shop="+shopId, data, function(data){
				showalert(data);
			}).fail(function(a,b,x) {
				showalert(b,'',false,10000);
			})
		})
		
		//resize images
		$('.batchResize').click(function(e){
			e.preventDefault();
			var hook = $(this).attr('data-hook');
			var sendhook = {
				'hookname' : hook
			}
			var data = $('#sliders_config').serializeArray();
			$.post(ajaxUrl+"&action=updateConfiguration&shop="+shopId, data, function(data){
				showalert(data);
				$.post(ajaxUrl+"&action=resizeImages&shop="+shopId, sendhook, function(data){
					showalert(data);
					$('.batchResize[data-hook="'+hook+'"]').slideUp();
				});
			});
		})
		
		/* show mediaquery */
		
		$('.open_media').click(function(){
			$('.mediaquery').slideToggle();
		})
		
		//change status
		$('.changeStatus').each(function(){
			$(this).click(function(e){
				e.preventDefault();
				var clicked = $(this);
				var slideId = clicked.attr('data-slide-id');
				$.post(ajaxUrl+"&action=changeStatus&id_slide="+slideId, function(data){
					var response = jQuery.parseJSON(data);
					if (response.success == 1) {
						$('i.fa',clicked).toggleClass('fa-times').toggleClass('fa-check');
					}
					showalert(response.message);
				});
			})
		})
		
		// update DB
		$('#updateDb').click(function(e){
			e.preventDefault();
			$.post(ajaxUrl+"&action=updateDB", function(data){
				showalert(data, function(){reloadPage(CU);});
				
			});
		})
		// update Module	
		$('#moduleUpdate').submit(function(e){
			e.preventDefault();
			showalert('Please wait!', false, false, 60000);
			$.post(ajaxUrl+"&action=updateModule", function(data){
				showalert(data, function(){reloadPage(CU);});
			});
		})
		
		if ($('.updateFakeMessage').length > 0) {
			var updates = parseInt($('#box-update-modules .value').text());
			$('#box-update-modules .value').text(updates+1);
		}
		
		/** allow only numbers **/
		
		$(".catnumber").keydown(function (e) {
			//console.log(e.keyCode);
			if ((e.keyCode > 47 && e.keyCode < 58) //standard nums
				|| (e.keyCode > 95 && e.keyCode < 106) //block nums
				|| e.keyCode == 8 //canc
				|| e.keyCode == 46 //del
				|| (e.keyCode >36 && e.keyCode < 41)) //arrows
				return true;
			return false;
		})
		
		//select hook code with a single click
		$('.hookCode').each(function(){
			$(this).click(function(){
				select_all($(this)[0]);
			})
		})
		
		var Index, CurrentVal;
		var $catTree = $('.catTree');
		$catTree.append('<i class="smallClose fa fa-times"/>')
		var overlay = $('#overlayer');
		$('.catnumber').each(function(i){
			$(this).click(function(){
				Index = i;
				CurrentVal = $(this).val();
				overlay.append($catTree);
				$('li i', $catTree).removeClass('fa-check-circle-o').addClass('fa-circle-o');
				$('li[data-cat="'+CurrentVal+'"] i', $catTree).removeClass('fa-circle-o').addClass('fa-check-circle-o');
				$catTree.addClass('processed');
				
				overlay.fadeIn();
			})
		})
		
		$('.closeme', $catTree).click(function(){
			overlay.fadeOut();
			$('.catnumber').eq(Index).val('');
		});
		
		$('.smallClose', $catTree).click(function(){
			overlay.fadeOut();	
		});
		$('li', $catTree).click(function(){
			overlay.fadeOut();
			$('.catnumber').eq(Index).val($(this).attr('data-cat'));
		})
		
		//animation configs
		var cont = $('.slideChooserCont');
		var conf = $('.position');
		var chooseButtons = $('.slideChoose');
		var hash = window.location.hash;
		if (hash != '') {
			var realhash = hash.replace("_conf","");
			openSlideConf($('a[href="'+realhash+'"]'), hash);
		}
		
		chooseButtons.each(function(){
			$(this).click(function(e){				
				e.preventDefault();
				var Target = $(this).attr('href')+'_conf';
				openSlideConf($(this),Target)
			})
		})
		
		function openSlideConf(button, Target) {
			var id = Target.replace("_conf","");
			chooseButtons.removeClass('active');
			button.addClass('active');
			window.location = Target;
			conf.not(id).hide();
			$(id).show();
		}
		
		/**config tabs **/
		var confTabs = [];
		$('.confTabs').each(function(i){
			confTabs[i] = $(this).tabs();
		})
		
		/** media query */
		
		// Colorpicker
		$(window).load(function(){
			if ( $(".cpiker").length > 0 ) {
				$(".cpiker").spectrum({
					color: '#000000',
					flat: false,
					showInput: true,
					showInitial: false,
					allowEmpty: false,
					showAlpha: true,
					disabled: false,
					localStorageKey: 'SE.colorspicked', //string: save to local storage under that key
					showPalette: true,
					showPaletteOnly: false,
					//showSelectionPalette: true,
					showButtons: true,
					clickoutFiresChange: true,
					cancelText: " ",
					chooseText: " ",
					containerClassName: 'sp-dark',
					replacerClassName: 'sp-dark',
					//preferredFormat: [['hex'], ['rgba']],
					maxSelectionSize: 11,
					palette: [['rgba(0,0,0,0.5)', 'white', '#0090f0' , '#ffa500' , 'rgba(0,0,0,0)']], //example: [['black', 'white', 'blanchedalmond'],['rgb(255, 128, 0);', 'hsv 100 70 50', 'lightyellow'],]
					//selectionPalette: []
					//move: function(tinycolor) { },
					//show: function(tinycolor) { },
					//hide: function(tinycolor) { },
					//beforeShow: function(tinycolor) { }
				});
			}
		})
		
		
		
		
				
	}) // end doc ready
	
	
}(jQuery));
