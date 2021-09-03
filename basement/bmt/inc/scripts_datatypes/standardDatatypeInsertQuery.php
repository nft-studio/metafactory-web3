<?php
//standard fields
$insertSQL = "INSERT INTO " . $datatype . " (";
$i = 0;
foreach ($custom_datatypes as $field) {
	if ($i != 0) {
		$insertSQL .= ', ';
	}
	$insertSQL .= '`' . $field['Field'] . '`';
	$i++;
}

$insertSQL .= ") VALUES (";

$i = 0;
foreach ($custom_datatypes as $field) {
	if ($i != 0) {
		$insertSQL .= ', ';
	}
	$instructions = returnFieldInstructions($field['Comment']);
	if ($instructions['type'] != 'custom' && $instructions['type'] != 'file') {
		$insertSQL .= returnCorrectPostDatatype($_POST[$field['Field']], $instructions['type'], $instructions['multiple']);
	} elseif ($instructions['type'] == 'file') {

		if ($_FILES[$field['Field']]['name'] != '') {
			$path_parts = pathinfo($_FILES[$field['Field']]['name']);

			if (strtolower($path_parts['extension']) == 'png' || strtolower($path_parts['extension']) == 'zip' || strtolower($path_parts['extension']) == 'jpeg' || strtolower($path_parts['extension']) == 'gif' || strtolower($path_parts['extension']) == 'jpg' || strtolower($path_parts['extension']) == 'mp4' || strtolower($path_parts['extension']) == 'mov' || strtolower($path_parts['extension']) == 'avi' ||  strtolower($path_parts['extension']) == 'doc' || strtolower($path_parts['extension']) == 'docx' || strtolower($path_parts['extension']) == 'pdf' || strtolower($path_parts['extension']) == 'xls' || strtolower($path_parts['extension']) == 'xlsx') {

				$filename = date('dmyHis') . toAscii(sanitize(substr(str_replace(' ', '', trim(basename($path_parts['basename']))), 0, 5))) . '.' . strtolower($path_parts['extension']);

				if (!file_exists($subroot . 'contents/' . $instructions['specs'])) {
					mkdir($subroot . 'contents/' . $instructions['specs'], 0755, true);
				}

				$target = $subroot . 'contents/' . $instructions['specs'] . '/' . $filename;
				move_uploaded_file($_FILES[$field['Field']]['tmp_name'], $target);
				$insertSQL .= "'" . $filename . "'";
			} else {
				$updateSQL .= $field['Field'] . '=' . "''";
			}
		} else {
			$insertSQL .= 'NULL';
		}
	} else {
		$insertSQL .= $toStore[$field['Field']];
	}
	$i++;
}
$insertSQL .= ")";
//standard fields
runDBQuery($insertSQL);
$_SESSION['success_message'] = $bmt_locales[$route]['single'] . ' ' . $bmt_locales[$bmt_locales[$route]['gender']]['created'] . '.';

if (!isset($noRedirect)) { ?>
	<script type="text/javascript">
		window.location = "<?php echo '/bmt/' . $internal_route; ?>";
	</script>
<?php } ?>