function UsernameisWriting() {
	writing = 1;
}

function UsernamenotWriting() {
	clearTimeout(timer);
	timer = setTimeout(function() {
		writing = 0;
		cleanUsername();
	}, 500);
}
var unsaved;

function doLogin() {
	unsaved = false;
	$('#login-form').submit();
}

function unsetSaved() {
	unsaved = false;
}

function cleanUsername() {
	if ($('#login').val() != '') {
		if (writing != 1) {
			$.ajax({
				type: "POST",
				url: subdomain + '/bmt/inc/cleanUserName.php',
				data: {
					toClean: $('#login').val()
				}
			}).done(function(msg) {
				$('#login').val(msg);
			});
		}
	}
}

function deleteElement(id, table) {
	bootbox.confirm("Sicuro di voler eliminare l'elemento?", function(result) {
		if (result == true) {
			$.ajax({
				type: "POST",
				url: subdomain + '/bmt/inc/deleteTool.php',
				data: {
					del_id: id,
					table: table
				}
			}).done(function(msg) {
				var oTable = $('#dataTable').dataTable();
				// Immediately remove the first row
				deleteIndex = oTable.fnGetPosition(document.getElementById(id));
				oTable.fnDeleteRow(deleteIndex);
			});
		}
	});
}

function deactivateElement(id, table) {
	bootbox.confirm("Sicuro di voler eliminare l'elemento?", function(result) {
		if (result == true) {
			$.ajax({
				type: "POST",
				url: subdomain + '/bmt/inc/deactivateTool.php',
				data: {
					del_id: id,
					table: table
				}
			}).done(function(msg) {
				var oTable = $('#dataTable').dataTable();
				// Immediately remove the first row
				deleteIndex = oTable.fnGetPosition(document.getElementById(id));
				oTable.fnDeleteRow(deleteIndex);
			});
		}
	});
}

function openSubmenu(id) {
	var subNumber = 0;
	if ($('#' + id).css('height') == '0px') {
		$('#' + id + ' .bmt-menu-button').each(function() {
			subNumber++;
		});
		h = subNumber * 55;
		$('#' + id).css('height', h + 'px');
	} else {
		$('#' + id).css('height', '0px');
	}
}

function viewAndEnable() {
	value = $('#password').val();
	$.ajax({
		type: "POST",
		url: subdomain + '/bmt/inc/decrypt.php',
		data: {
			decrypt: value
		}
	}).done(function(msg) {
		$('#password').val(msg);
		$('#crypted').val('no');
		$('#password').attr('type', 'text');
		$('#password').removeAttr('disabled');
	});
}

function validateForm(formID) {
	errors = 'no';
	unsaved = false;
	$('#' + formID).find('.form-control').each(function() {
		attr = $(this).attr('required');
		name = $(this).attr('name');
		if ($(this).is('select') === true) {
			if (typeof attr !== typeof undefined && attr !== false) {
				attr = $(this).attr('multiple');
				if (typeof attr !== typeof undefined && attr !== false) {
					value = $(this).val().trim();
				} else {
					value = $(this).find("option:selected").val().trim();
				}
				if (value == '') {
					errors = 'si';
					console.log('ERRORE: ' + name);
					if ($(this).hasClass('select-chosen')) {
						$(this).next(".chosen-container").find('.chosen-single').addClass('has-error');
						$(this).addClass('has-error');
					} else {
						$(this).addClass('has-error');
					}
				} else {
					if ($(this).hasClass('select-chosen')) {
						$(this).next(".chosen-container").find('.chosen-single').removeClass('has-error');
					} else {
						$(this).removeClass('has-error');
					}
				}
			}
		} else {
			if ($(this).hasClass('textarea-control')) {
				var editorContent = tinyMCE.get($(this).attr('id')).getContent();
				if (editorContent == '') {
					// Editor empty
				}
			} else {
				value = $(this).val().trim();
				if (typeof attr !== typeof undefined && attr !== false) {
					if (value == '') {
						errors = 'si';
						console.log('ERRORE: ' + name);
						$(this).addClass('has-error');
					} else {
						$(this).removeClass('has-error');
					}
				}
			}
		}
	});
	if (errors == 'no') {
		unsaved = false;
		$('#' + formID).submit();
	} else {
		$('.top-right').notify({
			message: {
				text: 'Uno o più campi devono essere compilati.'
			},
			type: 'error',
			fadeOut: {
				enabled: true,
				delay: 6000
			}
		}).show();
	}
}
$(document).ready(function() {
	unsaved = false;
	$("input:not(#searchBar)").change(function() { //trigers change in all input fields including text type
		unsaved = true;
	});

	function unloadPage() {
		if (unsaved) {
			return "Ci sono delle modifiche non salvate nel database, sicuro di voler cambiare pagina?";
		}
	}
	window.onbeforeunload = unloadPage;
});

var writing = 0;
var timer = null;

function isWriting() {
	writing = 1;
}

function notWriting(what) {
	clearTimeout(timer);
	timer = setTimeout(function() {
		writing = 0;
		switch(what){
			case "permalink":
				cleanPermalink();
			break;
			case "globale":
				cleanGlobale();
			break;
		}
	}, 500);
}

function cleanPermalink() {
	if ($('#permalink').val() != '') {
		if (writing != 1) {
			$('.cleaningSpinner').css('color', '#f00');
			$('.cleaningSpinner').html('Sto ripulendo il permalink...');
			$('.cleaningSpinner').css('display', 'block');
			var e = document.getElementById("language");
			var lnSelected = e.options[e.selectedIndex].value;
			$.ajax({
				type: "POST",
				url: subdomain + '/bmt/scripts/pages/cleanName.php',
				data: {
					toClean: $('#permalink').val(),
					language: lnSelected
				}
			}).done(function(msg) {
				if (msg != 'false') {
					$('.cleaningSpinner').css('color', '#00CC00');
					$('.cleaningSpinner').html('Fatto!');
					$('#permalink').val(msg);
					setTimeout(function() {
						setTimeout(function() {
							$('.cleaningSpinner').css('display', 'none');
						}, 1000);
					}, 1000);
				} else {
					$('.cleaningSpinner').html('&Eacute; già presente una pagina con questo permalink.');
				}
			});
		}
	}
}

function cleanGlobale() {
	if ($('#permalink').val() != '') {
		if (writing != 1) {
			$('.cleaningSpinner').css('color', '#f00');
			$('.cleaningSpinner').html('Sto ripulendo il permalink...');
			$('.cleaningSpinner').css('display', 'block');
			
			$.ajax({
				type: "POST",
				url: subdomain + '/bmt/scripts/translations/cleanName.php',
				data: {
					toClean: $('#globale').val()
				}
			}).done(function(msg) {
				$('.cleaningSpinner').css('color', '#00CC00');
				$('.cleaningSpinner').html('Fatto!');
				$('#globale').val(msg);
				setTimeout(function() {
					setTimeout(function() {
						$('.cleaningSpinner').css('display', 'none');
					}, 1000);
				}, 1000);
			});
		}
	}
}

function autoDBBak() {
	$.ajax({
		type: "POST",
		url: subdomain + '/bmt/inc/makeDbBackup.php'
	}).done(function(msg) {
		console.log('Backup done.');
	});
}

function makeDbBackup() {
	bootbox.prompt("Inserisci un nome per il file", function(result) {
		if (result != null) {
			$.ajax({
				type: "POST",
				url: subdomain + '/bmt/inc/makeDbBackup.php',
				data: {
					name: result
				}
			}).done(function(msg) {
				$('.top-right').notify({
					message: {
						text: 'Backup effettuato correttamente'
					},
					fadeOut: {
						enabled: true,
						delay: 3000
					}
				}).show();
			});
		}
	});
} /* GALLERIA*/
$(function() {
	$("#addGallery").popover({
		html: true,
		placement: "top"
	});
	$(".add-picture").popover({
		html: true,
		placement: "right"
	});
	$(".add-link").popover({
		html: true,
		placement: "right"
	});
	$(".add-code").popover({
		html: true,
		placement: "right"
	});
	$('.mod-tile').click(function() {
		if ($(this).parent().find('.text-control').css('display') == 'none') {
			$(this).parent().find('.text-control').fadeIn('fast');
		}
	});
	$('.adjust-size').click(function() {
		if ($(this).parent().parent().hasClass('font-mid')) {
			$(this).parent().parent().removeClass('font-mid');
			$(this).parent().parent().addClass('font-big');
		} else {
			if ($(this).parent().parent().hasClass('font-big')) {
				$(this).parent().parent().removeClass('font-big');
			} else {
				$(this).parent().parent().addClass('font-mid');
			}
		}
	});
	$('.close-bar').click(function() {
		$(this).parent().fadeOut('fast');
	});
});

function loadImageGallery() {
	image = $('#popoverImage').val();
	caption = $('#popoverText').val();
	$('#caricamento').html('Caricamento in corso');
	var formData = new FormData($('#popoverForm')[0]);
	$.ajax({
		url: subdomain + '/bmt/inc/galleryTool.php',
		type: 'POST',
		xhr: function() { // custom xhr
			myXhr = $.ajaxSettings.xhr();
			if (myXhr.upload) { // check if upload property exists
				myXhr.upload.addEventListener('progress', progressHandlingFunction, false); // for handling the progress of the upload
			}
			return myXhr;
		},
		data: formData,
		//Options to tell JQuery not to process data or worry about content-type
		cache: false,
		contentType: false,
		processData: false
	}).done(function(msg) {
		$('#caricamento').html('');
		$('#galleryUploaded').append(msg);
		$('#addGallery').popover('hide');
	});
}

function removeUploadedImage(url) {
	$('.uploadedImage[url="' + url + '"]').fadeOut('fast');
	$('.uploadedImage[url="' + url + '"]').html('');
}

function moveForward(url) {
	selected = parseInt($('.uploadedImage[url="' + url + '"]').index());
	next = selected + 1;
	$('.uploadedImage[url="' + url + '"]').insertAfter($('.uploadedImage:eq(' + next + ')'));
}

function moveBackward(url) {
	selected = parseInt($('.uploadedImage[url="' + url + '"]').index());
	if (selected != 0) {
		previous = selected - 1;
		$($('.uploadedImage:eq(' + previous + ')')).insertAfter('.uploadedImage[url="' + url + '"]');
	}
}

function progressHandlingFunction(e) {
	if (e.lengthComputable) {
		//$('#caricamento').html({value:e.loaded,max:e.total});
		percent = (e.loaded / e.total) * 100;
		$('#caricamento').html('Caricamento: ' + percent.toFixed(0) + '%');
	}
} /*FINE GALLERIA*/
/*NEWSLETTER*/

function validateAndSave(goToInput) {
	$('.popover').remove();
	$('.text-control').css('display', 'none');
	$('#tiles-input').attr('value', $('#wrap-tiles').html());
	$('#locationInput').val(goToInput);
	$('#Form').submit();
}

function validateAndSend(goToInput) {
	$('.popover').remove();
	$('.text-control').css('display', 'none');
	testo = $('#wrap-tiles').html();
	if ($('#wrap-tiles')) {
		$('#tiles-input').attr('value', testo);
	}
	$('#locationInput').val(goToInput);
	$('#locationInput').attr('name', 'MM_send');
	$('#Form').submit();
}

function updateAndSend(goToInput) {
	$('.popover').remove();
	$('.text-control').css('display', 'none');
	testo = $('#wrap-tiles').html();
	if ($('#wrap-tiles')) {
		$('#tiles-input').attr('value', testo);
	}
	$('#locationInput').val('sendCampaign');
	$('#Form').submit();
}

function cleanNewsletter() {
	$('#wrap-tiles').find('i').remove();
	$('#wrap-tiles').find('.text-control').remove();
	$('#wrap-tiles').find('.popover').remove();
	$('#wrap-tiles').find('.delete-row').remove();
	$('#wrap-tiles').find('.remove-big-image').remove();
	$('#wrap-tiles').fadeIn('fast');
}
var newsletterSent = 0;

function confirmSendCampaign(id) {
	bootbox.confirm("Sicuro di voler inviare la campagna?", function(result) {
		if (result == true) {
			var length = sendToUsers.length;
			for (var i = 0; i < length; i++) {
				$.ajax({
					type: "POST",
					url: subdomain + '/bmt/newsletter.php',
					data: {
						sendCampaign: id,
						id_user: sendToUsers[i],
						corpo: $('#wrap-tiles').html()
					}
				}).done(function(msg) {
					console.log(msg);
					newsletterSent++;
					$('#resultSent').html(newsletterSent);
				}); //ajax
			} //each
		}
	});
} 
/*FINE NEWSLETTER*/

/*TEMPLATE FORM*/
/*******************
		TEMPLATE EXAMPLE
	
		<div class="hidden" template="template_name">
			{{tr id="{{variable}}-{{ID}}"}}
				{{td style="width:20%"}}
					<input type="text" class="form-control" required name="zona_listino[]">
				{{/td}}
				{{td style="width:20%"}}
					<input type="text" class="form-control" required name="pesovolume_listino[]">
				{{/td}}
				{{td style="width:20%"}}
					<input type="text" class="form-control" required name="prezzo_listino[]">
				{{/td}}
				{{td class="text-center" style="width:20%"}}
					<div class="btn red" onClick="deleteElement('{{variable}}','{{ID}}')">Elimina</div>
				{{/td}}
			{{/tr}}
		</div>	

	*********************/
function addElement(variable) {
	ID[variable] = ID[variable] + 1;
	template = $('[template="' + variable + '"]').html().replace(/\{{variable}}/g, variable).replace(/\{{ID}}/g, ID[variable]).replace(/\{{/g, '<').replace(/\}}/g, '>');
	$('#' + variable + '-body').append(template);
}

function deleteElement(variable, id) {
	$('#' + variable + '-' + id).remove();
} 
/*TEMPLATE FORM*/

$(window).ready(function(){
	autoDBBak();
});