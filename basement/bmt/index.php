<?php 
	include('inc/initialize.php');
?>
<!DOCTYPE HTML>
<html>
<?php include('layout/header.php'); ?>
<body>
	<div class="bmt-container">
		<?php include('layout/menu.php'); ?>
		<div class="bmt-page-header">
			<?php echo $bmt_locales['dashboard']['menu']; ?>
		</div>
		<div class="bmt-page" style="padding:50px 0 0 0;">
			<iframe width="100%" id="analytics" style="padding-left:250px;" height="1200" src="<?php echo datastudio_url;?>" frameborder="0" style="border:0" allowfullscreen></iframe>
		</div>
	</div>
	<?php include('layout/footer.php'); ?>

</body>
</html>