<script>
	var ID = [];
	ID['datatype'] = <?php if (isset($datatypes)) {
							echo $datatypes;
						} else {
							echo '0';
						} ?>;
	<?php if (isset($_GET['type'])) { ?>

		function validateDelete() {
			bootbox.confirm("Sei sicuro di voler eliminare?<br><span style='color:#f00'>Ti ricordo che l'operazione è irreversibile.</span>",
				function(result) {
					if (result === true) {
						window.location = '/bmt/<?php echo $internal_route; ?>/<?php echo $_GET['type']; ?>/del';
					}
				}
			);
		}
	<?php } ?>

	function validateDeleteBackup(filename) {
		bootbox.confirm("Sei sicuro di voler eliminare il backup: " + filename + "<br><span style='color:#f00'>Ti ricordo che l'operazione è irreversibile.</span>",
			function(result) {
				if (result === true) {
					window.location = '/bmt/<?php echo $internal_route; ?>/' + filename + '/remove';
				}
			}
		);
	}

	function deleteDatatype(id) {
		$('#datatype-' + id).css('display', 'none');
		$('#delete-' + id).val('1');
	}
</script>