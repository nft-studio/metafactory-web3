<?php if(isset($_GET['id'])){ ?>
	<script>
		function validateDelete(){
			bootbox.confirm("Sei sicuro di voler eliminare?<br><span style='color:#f00'>Ti ricordo che l'operazione è irreversibile.</span>", 
				function(result) {
					if(result===true){
						window.location='/bmt/<?php echo isset($internal_route) ? $internal_route : ''; ?>/<?php echo $_GET['id']; ?>/del';
					}
				}
			); 
		}
	</script>
<?php } ?>