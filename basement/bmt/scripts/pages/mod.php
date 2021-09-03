<form method="post" enctype="multipart/form-data" class="form-horizontal form-bordered form-row-stripped" id="<?php echo $_GET['action']; ?>-<?php echo strtolower($datatype); ?>">
	<div class="portlet box blue">
		<div class="portlet-body form">
			<div class="form-body">
				<?php 
					$customFields['permalink']='
						<div class="control-group">
							<label class="control-label">Permalink</label>
							<div class="controls">
								<input required id="permalink" onkeydown="isWriting()" value="'.$row_rs_single['permalink'].'" onkeyup="notWriting(\'permalink\')" type="text" name="permalink" class="form-control formInput">
								<div class="cleaningSpinner">Sto ripulendo il permalink..</div>
							</div>
						</div>';	
					$customFields['ref_page']='
						<div class="control-group">
							<label class="control-label">Base page</label>
							<div class="controls">
								<select required class="select-chosen form-control" name="ref_page">
									<option value="">Scegli la pagina</option>';
					$dir = '../pages/';
					$dh = opendir($dir);
					while ($filename = readdir($dh)){
						if (is_file($dir."/".$filename)){
							if($filename!='.DS_Store'){
								$selected='';
								if($filename==$row_rs_single['ref_page']){
									$selected='selected';
								}
								$customFields['ref_page'].='<option '.$selected.' value="'.$filename.'">'.$filename.'</option>';
							}
						}
					} 
					$customFields['ref_page'].='</select>
									</div>
								</div>';		
										
					/*foreach ($custom_datatypes as $field){ 
						$instructions=returnFieldInstructions($field['Comment']);
						if($instructions['type']!='custom'){
							echo returnCorrectInputField($instructions['type'], $field['Field'], $instructions['required'], $instructions['specs'], '');
						}else{
							echo $customFields[$field['Field']];
						}
					} */
				?>
				<div class="row">
					<div class="col-xs-12">
						<h4 class="datatype-region first-region">Base settings</h4>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<?php echo $customFields['ref_page']; ?>
					</div>
					<div class="col-sm-3">
						<?php echo $inputFields['title']['input']; ?>
					</div>
					<div class="col-sm-3">
						<?php echo $customFields['permalink']; ?>
					</div>
					<div class="col-sm-3">
						<?php echo $inputFields['language']['input']; ?>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12">
						<h4 class="datatype-region">Optional settings</h4>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<?php echo $inputFields['subtitle']['input']; ?>
					</div>
					<div class="col-sm-6">
						<?php echo $inputFields['cover_image']['input']; ?>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12">
						<h4 class="datatype-region">Page content</h4>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12">
						<?php echo $inputFields['content']['input']; ?>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12">
						<h4 class="datatype-region">SEO tools</h4>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-6">
						<?php echo $inputFields['meta_description']['input']; ?>
					</div>
					<div class="col-xs-6">
						<?php echo $inputFields['meta_keywords']['input']; ?>
						<?php echo $inputFields['change_freq']['input']; ?>
						<?php echo $inputFields['priority']['input']; ?>
					</div>
				</div>
			</div><!--form-body-->
		</div><!--portlet-body-->
	</div><!--portlet-->
	<input type="hidden" name="mod<?php echo strtolower($datatype); ?>" value="<?php echo $row_rs_single['id']; ?>">
</form>
