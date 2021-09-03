<form method="post" enctype="multipart/form-data" class="form-horizontal form-bordered form-row-stripped" id="<?php echo $_GET['action']; ?>-<?php echo strtolower($datatype); ?>">
	<div class="portlet box blue">
		<div class="portlet-body form">
			<div class="form-body">
				<?php 
										
					foreach ($custom_datatypes as $field){ 
						$instructions=returnFieldInstructions($field['Comment']);
						if($instructions['type']!='custom'){
							echo returnCorrectInputField($instructions['type'], $field['Field'], $instructions['required'], $instructions['specs'], '');
						}else{
							echo $customFields[$field['Field']];
						}
					} 
				?>
			</div><!--form-body-->
		</div><!--portlet-body-->
	</div><!--portlet-->
	<input type="hidden" name="new<?php echo strtolower($datatype); ?>" value="yes">
</form>
