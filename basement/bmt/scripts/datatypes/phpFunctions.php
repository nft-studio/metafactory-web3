<?php

if (isset($_GET['type'])) {
	$datatypeSelect = strip_tags(str_replace('-', '_', $_GET['type']));
	$columns = list_columns($datatypeSelect);
}

if (isset($_POST['new' . $datatype])) {

	runDBQuery("CREATE TABLE `" . $_POST['datatype_name'] . "` (
			id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY
		)");

	$datatypeSelect = $_POST['datatype_name'];

	$i = 0;
	foreach ($_POST['active'] as $active) {
		if ($active != 1) {
			$commentString = "'no'";
		} else {
			if(!isset($_POST['print'][$i])){
				$_POST['print'][$i] = '1';
			}

			if(!isset($_POST['order'][$i])){
				$_POST['order'][$i] = '';
			}

			if(!isset($_POST['type'][$i])){
				$_POST['type'][$i] = 'text';
			}

			if(!isset($_POST['specs'][$i])){
				$_POST['specs'][$i] = '';
			}

			if(!isset($_POST['multiple'][$i])){
				$_POST['multiple'][$i] = '';
			}

			if(!isset($_POST['required'][$i])){
				$_POST['required'][$i] = '';
			}

			$commentString = "'print=>" . $_POST['print'][$i] . ";";
			$commentString .= "order=>" . $_POST['order'][$i] . ";";
			$commentString .= "type=>" . $_POST['type'][$i] . ";";
			$commentString .= "specs=>" . $_POST['specs'][$i] . ";";
			$commentString .= "multiple=>" . $_POST['multiple'][$i] . ";";
			$commentString .= "required=>" . $_POST['required'][$i] . "'";

			if ($_POST['length'][$i] != '') {
				$length = "( " . $_POST['length'][$i] . " )";
			} else {
				$length = '';
			}
		}
		runDBQuery("ALTER TABLE " . $datatypeSelect . " ADD COLUMN `" . $_POST['name'][$i] . "` " . $_POST['format'][$i] . " " . $length . " COMMENT " . $commentString);
		$i++;
	}

	$_SESSION['success_message'] = ucfirst($datatypeSelect) . ' ' . $labels['creato'] . ' correttamente.';
?>
	<script type="text/javascript">
		window.location = "<?php echo '/bmt/' . $internal_route; ?>";
	</script>
<?php
}

if (isset($_POST['mod' . $datatype])) {
	$datatypeSelect = strip_tags(str_replace('-', '_', $_GET['type']));
	$columns = list_columns($datatypeSelect);
	backupDB(array($datatypeSelect), 'scripts/datatypes/bak/' . $datatypeSelect . '__' . date('d-m-Y_H-i-s') . '.sql');
	if (count($columns) > 0) {
		foreach ($columns as $row) {
			if ($row['Field'] != 'id') {
				if ($_POST['delete-' . toAscii($row['Field'])] != 1) {
					if ($_POST['active-' . toAscii($row['Field'])] != 1) {
						$commentString = "'no'";
					} else {
						$commentString = "'print=>" . $_POST['print-' . toAscii($row['Field'])] . ";";
						$commentString .= "order=>" . $_POST['order-' . toAscii($row['Field'])] . ";";
						$commentString .= "type=>" . $_POST['type-' . toAscii($row['Field'])] . ";";
						$commentString .= "specs=>" . $_POST['specs-' . toAscii($row['Field'])] . ";";

						if (isset($_POST['multiple-' . toAscii($row['Field'])])) {
							$commentString .= 'multiple=>multiple;';
						} else {
							$commentString .= 'multiple=>;';
						}

						if (isset($_POST['required-' . toAscii($row['Field'])])) {
							$commentString .= 'required=>required;' . "'";
						} else {
							$commentString .= 'required=>;' . "'";
						}

						if ($_POST['length-' . toAscii($row['Field'])] != '') {
							$length = "( " . $_POST['length-' . toAscii($row['Field'])] . " )";
						} else {
							$length = '';
						}
					}
					runDBQuery("ALTER TABLE " . $datatypeSelect . " CHANGE `" . $row['Field'] . "` `" . $_POST['name-' . toAscii($row['Field'])] . "` " . $_POST['format-' . toAscii($row['Field'])] . " " . $length . " COMMENT " . $commentString);
				} else {
					runDBQuery("ALTER TABLE " . $datatypeSelect . " DROP COLUMN `" . $row['Field'] . "`");
				}
			}
		}
	}

	$i = 0;
	if (isset($_POST['active'])) {
		foreach ($_POST['active'] as $active) {
			if ($active != 1) {
				$commentString = "'no'";
			} else {
				$commentString = "'print=>" . $_POST['print'][$i] . ";";
				$commentString .= "order=>" . $_POST['order'][$i] . ";";
				$commentString .= "type=>" . $_POST['type'][$i] . ";";
				$commentString .= "specs=>" . $_POST['specs'][$i] . ";";
				$commentString .= "multiple=>" . $_POST['multiple'][$i] . ";";
				$commentString .= "required=>" . $_POST['required'][$i] . "'";

				if ($_POST['length'][$i] != '') {
					$length = "( " . $_POST['length'][$i] . " )";
				} else {
					$length = '';
				}
			}
			backupDB(array($datatypeSelect), 'scripts/datatypes/bak/' . $datatypeSelect . '__' . date('d-m-Y_H-i-s') . '.sql');
			runDBQuery("ALTER TABLE " . $datatypeSelect . " ADD COLUMN `" . $_POST['name'][$i] . "` " . $_POST['format'][$i] . " " . $length . " COMMENT " . $commentString);
			$i++;
		}
	}

	$_SESSION['success_message'] = ucfirst($datatypeSelect) . ' ' . $labels['modificato'] . ' correttamente.';
?>
	<script type="text/javascript">
		window.location = "<?php echo '/bmt/' . $internal_route; ?>";
	</script>
<?php
}

if (isset($_GET['delete'])) {

	$datatypeSelect = strip_tags(str_replace('-', '_', $_GET['type']));
	backupDB(array($datatypeSelect), 'scripts/datatypes/bak/' . $datatypeSelect . '__' . date('d-m-Y_H-i-s') . '.sql');
	runDBQuery("DROP TABLE " . $datatypeSelect, array());

	$_SESSION['success_message'] = $labels['datatype_name'] . ' ' . $labels['eliminato'] . ' correttamente, è stato effettuato un backup della tabella.';

?>
	<script type="text/javascript">
		window.location = "<?php echo '/bmt/' . $internal_route; ?>";
	</script>
<?php
}

if (isset($_GET['restore'])) {

	importDB('scripts/datatypes/bak/' . $_GET['restore']);
	$_SESSION['success_message'] = $labels['datatype_name'] . ' ripristinato correttamente';
?>
	<script type="text/javascript">
		window.location = "<?php echo '/bmt/' . $internal_route; ?>";
	</script>
<?php
}

if (isset($_GET['remove'])) {
	unlink('scripts/datatypes/bak/' . $_GET['remove']);
	$_SESSION['success_message'] = $labels['datatype_name'] . ' eliminato definitivamente.';
?>
	<script type="text/javascript">
		window.location = "<?php echo '/bmt/' . $internal_route; ?>/backups";
	</script>
<?php
}
?>