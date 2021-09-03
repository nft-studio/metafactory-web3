<?php if($route!='login'){ ?>  
	<script src="<?php echo $subdomain; ?>/bmt/layout/vendors/jquery-ui/jquery-ui-1.11.4/jquery-ui.min.js"></script>
	<script src="<?php echo $subdomain; ?>/bmt/layout/vendors/jquery-ui/jquery-ui-1.11.4/jquery.ui.datepicker-it.js"></script>
    <script src="<?php echo $subdomain; ?>/bmt/layout/vendors/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo $subdomain; ?>/bmt/layout/vendors/nanoscroller/nanoscroller.min.js"></script>
    <script src="<?php echo $subdomain; ?>/bmt/layout/vendors/boostrap-select/bootstrap-select.js"></script>
    <script src="<?php echo $subdomain; ?>/bmt/layout/vendors/boostrap-switch/bootstrap-switch.js"></script>
    <script src="<?php echo $subdomain; ?>/bmt/layout/vendors/bootstrap-notify/bootstrap-notify.js"></script>
    <script src="<?php echo $subdomain; ?>/bmt/layout/vendors/bootstrap-tagsinput/bootstrap-tagsinput.js"></script>
    <script src="<?php echo $subdomain; ?>/bmt/layout/vendors/bootstrap-bootbox/bootbox.min.js"></script>
    <script src="<?php echo $subdomain; ?>/bmt/layout/vendors/jquery-datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo $subdomain; ?>/bmt/layout/js/layout.js"></script>
    <script src="<?php echo $subdomain; ?>/bmt/layout/js/functions.js"></script>
    <script src="<?php echo $subdomain; ?>/bmt/layout/vendors/select-chosen/chosen.jquery.min.js"></script>
    <script src="<?php echo $subdomain; ?>/bmt/layout/vendors/timepicker/timepicker.js"></script>
    <script src="<?php echo $subdomain; ?>/bmt/layout/vendors/tinymce/tinymce.min.js"></script>
    <div class="notifications top-right"></div>
    <?php if($permissionsErrors!=''){ 
	    $errors=explode('<br>',$permissionsErrors);
	    
	    foreach ($errors as $notify){
	    	if($notify!=''){
    ?>
    	<script>
    		  $('.top-right').notify({
			    message: { text: '<?php echo $notify; ?>' },
			    fadeOut: { enabled: true, delay:6000 }
			  }).show();
    	</script>
    <?php }}} ?>
    <?php if((isset($success_notice))&&($success_notice!='')){ ?>
   		<script>
    		  $('.top-right').notify({
			    message: { text: '<?php echo $success_notice; ?>' },
			    fadeOut: { enabled: true, delay:6000 }
			  }).show();
    	</script>
    <?php } ?>
    <?php if((isset($error_notice))&&($error_notice!='')){ ?>
   		<script>
    		  $('.top-right').notify({
			    message: { text: '<?php echo $error_notice; ?>' },
			    type: 'error',
			    fadeOut: { enabled: true, delay:6000 }
			  }).show();
    	</script>
    <?php } ?>
     <script type="text/javascript">
		tinymce.init({
		    selector: ".textarea-control", theme: "modern", height:300,
		    plugins: [
		         "advlist autolink link image lists charmap print preview hr anchor pagebreak",
		         "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking spellchecker",
		         "table contextmenu directionality emoticons paste textcolor responsivefilemanager"
		   ],
		   toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect",
		   toolbar2: "| responsivefilemanager | link unlink anchor | image media | forecolor backcolor  | print preview code ",
		   image_advtab: true,
		   relative_urls: false,
		   external_filemanager_path:"/bmt/scripts/filemanager/",
		   filemanager_title:"File manager" ,
		   external_plugins: { "filemanager" : "/bmt/scripts/filemanager/plugin.min.js"}
	  });
	</script>
	<script>
	  $(function() {
	    $( ".date-picker" ).datepicker();
	    $( ".select-chosen" ).chosen({'width':'100%'});
	    $(".tagsinput").tagsinput();
	  });
	</script>
<?php } ?>