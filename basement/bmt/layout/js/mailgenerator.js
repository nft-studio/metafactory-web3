function loadImageTile(element){
  image= $('#popoverImage').val();
  caption= $('#popoverText').val();
  $('#caricamento').html('Caricamento in corso');
    var formData = new FormData($('#popoverForm')[0]);
    $.ajax({
          url: subdomain+'/bmt/inc/tileTool.php', 
          type: 'POST',
          xhr: function() {  // custom xhr
            myXhr = $.ajaxSettings.xhr();
            if(myXhr.upload){ // check if upload property exists
               myXhr.upload.addEventListener('progress',progressHandlingFunction, false); // for handling the progress of the upload
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
	    parts=msg.split('][][');
	    $('#'+parts[0].trim()).append('<div class="wrap-image"><div class="remove-big-image" onClick="removeImage(this)"><i class="remove-image-icon icon-trash"></i></div><img src="'+siteurl+'/'+parts[1].trim()+'" width="100%"></div>');
	    $('.add-picture').popover('hide');
	    
});	
}
function checkScheda(){
		sel = document.getElementById('optionScheda');
		if(sel.options[sel.selectedIndex].value==0){
			$('#scheda_cliente').fadeOut('fast');	
		}else{
			$('#scheda_cliente').fadeIn('fast');	
		}
	}
	
	function addLink(element){
		ClickedTile= $(element).parent().find('input[name="idTile"]').val();
		LinkTo= $(element).parent().find('input[name="linkToTxt"]').val();
		$('#'+ClickedTile).wrap('<a target="_blank" class="href-tile" href="'+LinkTo+'">');
		$('#'+ClickedTile).addClass('hasLink');
		$('.add-link').popover('hide');
		$('.href-tile').click(function(e){
			 e.preventDefault(); 
			 return false;
		});
	}
	
	function toggleTile(element){
		if($(element).parent().hasClass('hide-tile')){
			$(element).parent().removeClass('hide-tile');
		}else{
			$(element).parent().addClass('hide-tile');
		}
	}
	
	function removeLink(element){
		ClickedTile= $(element).parent().find('input[name="idTile"]').val();
		if($('#'+ClickedTile).hasClass('hasLink')){
		$('#'+ClickedTile).parent().attr('href','javascript:return(void);');
		$('#'+ClickedTile).unwrap('.href-tile');		
		$('#'+ClickedTile).removeClass('hasLink');
		$('.add-link').popover('hide');
		}
	}
	
	function insertHtml(element){
		ClickedTile= $(element).parent().find('input[name="idTile"]').val();
		insertedCode= $(element).parent().find('input[name="code"]').val().replace(/\'/g,'"');
		$('#'+ClickedTile).find('.injected-code').remove();
		$('#'+ClickedTile).append('<div class="injected-code">'+insertedCode+'</div>');
		$('.add-code').popover('hide');
	}
	function removeHtml(element){
		ClickedTile= $(element).parent().find('input[name="idTile"]').val();
		$('#'+ClickedTile).find('.injected-code').remove();
	}
	
	function expandThis(element){
		if($(element).parent().hasClass('big-tile')){
			$(element).parent().removeClass('big-tile');
		}else{
			$(element).parent().addClass('big-tile');
		}
	}
	function removeThis(element){
		$(element).parent().remove();
	}
	function deleteRow(deleter, element){
		bootbox.confirm("Eliminare la riga?", function(result) {
		  if(result==true){
			  $('#'+element).remove();
			  $(deleter).remove();
		  }
		});
	}
	function addTextLink(e){
		LinkTo= $(e).parent().find('input[name="linkToTxt"]').val();
		$(e).parent().parent().parent().parent().wrap('<a target="_blank" class="href-tile" href="'+LinkTo+'">');
		$('.add-text-link').popover('hide');
		$('.href-tile').click(function(e){
			 e.preventDefault(); 
			 return false;
		});
	}
	function addText(element){
		$(document).find('.text-control').css('display','none');
			$(element).parent().append('<div class="in-mail-tile"><div class="text-control"><i class="icon-text-height adjust-size"></i><i rel="popover" data-content="<input type=\'text\' style=\'width:230px;\' placeholder=\'http://www.medit.co.it\' name=\'linkToTxt\'><div style=\'margin-top:10px; padding-bottom:-50px;\' onClick=\'addTextLink(this)\' class=\'btn\'>Aggiungi</div>" data-original-title="Aggiungi link" class="icon-link add-text-link"></i><i class="hide-bar icon-remove" onClick=\'hideBar(this)\' style="float:right;"></i><i class="close-bar icon-trash" onClick=\'deleteText(this)\' style="float:right;"></i></div><div contenteditable class="mod-tile"></div></div>');
			$(".add-text-link").popover({html:true, placement:"right"});
			
			$('.mod-tile').click(function(){
				if($(this).parent().find('.text-control').css('display')=='none'){
					$(this).parent().find('.text-control').fadeIn('fast');
				}
			});
			$('.adjust-size').click(function(){
				if($(this).parent().parent().hasClass('font-mid')){
					$(this).parent().parent().removeClass('font-mid');
					$(this).parent().parent().addClass('font-big');
				}else{
					if($(this).parent().parent().hasClass('font-big')){
						$(this).parent().parent().removeClass('font-big');
					}else{
						$(this).parent().parent().addClass('font-mid');
					}
				}
				
			});
		
	}
	
	function deleteText(e){
		$(e).parent().parent().remove();
	}
	function hideBar(e){
		$(e).parent().fadeOut('fast');
	}
	
	function removeImage(e){
		$(e).parent().remove();
	}
	
	var rowNumber=1;
		
	function selectMailLayout(layout){
		found=0;
		
		while(found==0){
		if($('#row-'+rowNumber).length > 0){
			rowNumber++;
		}else{
			found=1;			
		}}

		columns= layout.split('-');
			$('#wrap-tiles').append('<div onClick="deleteRow(this,'+"'"+'row-'+rowNumber+"'"+')" class="delete-row"><i class="icon-remove-sign icon-2x"></i> </div><table border="0" align="center" cellpadding="0" cellspacing="0" class="container"><tr id="row-'+rowNumber+'"></tr></table>');
			i=0;
			
		columns.forEach(function(){
			$('#row-'+rowNumber).append('<td valign="top" class="mail-col grid-'+columns[i]+'" id="'+rowNumber+'-'+i+'"><div class="mail-tile" id="'+rowNumber+'-'+i+'-0"><i rel="popover" data-content="<form method=\'post\' style=\'margin-top:20px;\' id=\'popoverForm\' enctype=\'multipart/form-data\'><div id=\'caricamento\'></div><input name=\'popoverImage[]\' id=\'popoverImage\' class=\'popoverImage\' type=\'file\'><input type=\'hidden\' value=\'contents/datatype_tiles/\' name=\'target\'><input type=\'hidden\' value=\''+rowNumber+'-'+i+'-0\' name=\'idTile\'><input type=\'hidden\' value=\'add\' name=\'galleryAdd\'><div style=\'padding-bottom:-50px; margin:0;\' onClick=\'loadImageTile()\' class=\'btn\'>Upload</div></form>" data-original-title="Scegli l\'immagine da caricare" class="icon-camera-retro add-picture"></i><i onClick="addText(this)" class="icon-font add-text"></i><i rel="popover" data-content="<input type=\'text\' class=\'popover-input\' placeholder=\'http://www.medit.co.it\' name=\'linkToTxt\'><input type=\'hidden\' value=\''+rowNumber+'-'+i+'-0\' name=\'idTile\'><div style=\'padding-bottom:-50px;\' onClick=\'addLink(this)\' class=\'btn\'>Aggiungi</div><div style=\'padding-bottom:-50px; margin:0 0 0 5px;\' onClick=\'removeLink(this)\' class=\'btn\'>Rimuovi</div>" data-original-title="Aggiungi link" class="icon-link add-link"></i><i onClick="toggleTile(this)" class="icon-eye-open toggle-tile"></i><i rel="popover" data-content="<input type=\'text\' class=\'popover-input\' name=\'code\'><input type=\'hidden\' value=\''+rowNumber+'-'+i+'-0\' name=\'idTile\'><div style=\'padding-bottom:-50px;\' onClick=\'insertHtml(this)\' class=\'btn\'>Aggiungi</div><div style=\'padding-bottom:-50px; margin:0 0 0 5px;\' onClick=\'removeHtml(this)\' class=\'btn\'>Rimuovi</div>" data-original-title="Aggiungi codice HTML" class="icon-code add-code"></i></div></td>');
			i++;
		});
		rowNumber++;	
		$(".add-picture").popover({html:true, placement:"right"});
		$(".add-link").popover({html:true, placement:"right"});
		$(".add-code").popover({html:true, placement:"right"});
	}
	
	$(document).keyup(function(e) {
	  $('.project-name').html($('input[name="nome_cliente"]').val());
	  $('.project-tag').html('#'+$('input[name="hashtag"]').val().replace(/\,/g,' #'));
	  $('.project-description').html($('#editor').html());
	});
