$(document).ready(function() {
	$('[data-title="Inserisci"]').click(function(){
		 unsaved=false;
	});
	$('[data-toggle="tooltip"]').tooltip();
	$('#dataTable').dataTable( {
		"sDom": "<'row'<'col-sm-8'l><'col-sm-4 text-right'f>r>t<'row'<'col-sm-8'i><'col-sm-4 text-right'p>>",
		"iDisplayLength": 50,
	    "aaSorting": [],
		"oLanguage": {
	        "sLengthMenu": "Show _MENU_ records per page",
	        "sZeroRecords": "No records",
		    "sInfo": "_START_ - _END_ // Max: _TOTAL_",
		    "sSearch": "",
		    "oPaginate": {
		    "sNext": "Next",
		    "sPrevious": "Previous",
		 },
		 "sInfoEmpty": "No records",
		 "sInfoFiltered": "(filtered from _MAX_ records)"
	     }
	});
	$('.bmt-menu-toggle').on('click',function(){
		if($('.bmt-sidebar').css('left')=='-250px'){
			$('.bmt-sidebar').css('left','0');
			$('.bmt-menu-toggle').css('left','263px');
			$('.bmt-page-header').addClass('bmt-page-header-on');
		}else{
			$('.bmt-sidebar').css('left','-250px');
			$('.bmt-menu-toggle').css('left','12px');
			$('.bmt-page-header').removeClass('bmt-page-header-on');
		}
	})
});
$(window).load(function(){
	$(".nano").nanoScroller({iOSNativeScrolling: true, preventPageScrolling: true});
});