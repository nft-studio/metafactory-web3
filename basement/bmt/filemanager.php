<?php 
	$permission_level=2;
	include('inc/initialize.php');
?>
<!DOCTYPE HTML>
<html>
	<?php include('layout/header.php'); ?>
	<body>
		<div class="bmt-container">
			<?php include('layout/menu.php'); ?>
			<div class="bmt-page-header">
				File manager
			</div>
			<div class="bmt-page filemanager-page">
				<iframe id="filemanager" src="/bmt/scripts/filemanager/dialog.php" width="100%" height="550" frameborder="0"></iframe>
			</div>
		</div>
	<?php include('layout/footer.php'); ?>
	<script>
		$(document).ready(function(){
			$('#filemanager').css('height',window.innerHeight);	
		});
		$(window).resize(function(){
			$('#filemanager').css('height',window.innerHeight);	
		});
	</script>
	</body>
</html>