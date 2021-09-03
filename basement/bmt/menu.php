<?php 
	$permission_level=2;
	include('inc/initialize.php');
	$internal_route='menu';
	$datatype='menu';
	$subroot='../';
?>
<!DOCTYPE HTML>
<html>
	<?php include('layout/header.php'); ?>
	<body>
		<div class="bmt-container">
			<?php include('layout/menu.php'); ?>
			<div class="bmt-page-header">
				<?php if(isset($_GET['action'])){ ?>
					<a href="<?php echo $subdomain; ?>/bmt/<?php echo $internal_route; ?>" class="bmt-small-button">
						<li><i class="fa fa-chevron-left"></i></li>
					</a>
				<?php } ?>
				<?php echo $bmt_locales[$internal_route]['manage']; ?>
				<ul class="bmt-header-toolbar">
					<?php if(!isset($_GET['action'])){ ?>
						<a href="<?php echo $subdomain; ?>/bmt/<?php echo $internal_route; ?>/new" class="bmt-header-button">
							<li><i class="fa fa-plus"></i></li>
						</a>
					<?php }else{ ?>
						<a href="javascript:validateForm('<?php echo $_GET['action']; ?>-<?php echo strtolower($datatype); ?>');" class="bmt-header-button">
							<li><i class="fa fa-save"></i></li>
						</a>
						<?php if($_GET['action']=='mod'){ ?>
							<a href="javascript:validateDelete();" class="bmt-header-button">
								<li><i class="fa fa-trash-o"></i></li>
							</a>
						<?php } ?>
					<?php } ?>	
				</ul>
			</div>
			<div class="bmt-page">
				<div class="row">
					<div class="col-xs-12">
						<div class="pad20">
							<?php 
								include('scripts/'.$datatype.'/init.php'); 
							?>
						</div><!--content-->
					</div><!--span10-->
				</div><!--row-fluid-->
			</div>
		</div>
	<?php include('layout/footer.php'); ?>
	
	</body>
</html>