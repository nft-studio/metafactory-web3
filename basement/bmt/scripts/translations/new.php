<form method="post" enctype="multipart/form-data" class="form-horizontal form-bordered form-row-stripped" id="<?php echo $_GET['action']; ?>-<?php echo strtolower($datatype); ?>">
	<div class="portlet box blue">
		<div class="portlet-body form">
			<div class="form-body">
				<div class="row">
					<div class="col-sm-4">
						<?php echo $customFields['globale']='
						<div class="control-group">
							<label class="control-label">Globale</label>
							<div class="controls">
								<input required id="globale" onkeydown="isWriting()" onkeyup="notWriting(\'globale\')" type="text" name="globale" class="form-control formInput">
								<div class="cleaningSpinner">Sto ripulendo il permalink..</div>
							</div>
						</div>'; ?>
					</div>
					<div class="col-sm-4">
						<?php echo $inputFields['is_html']['input']; ?>
					</div>
					<div class="col-sm-4">
						<?php echo $inputFields['is_js']['input']; ?>
					</div>
					<?php foreach($languages as $language){ ?>
						<div class="col-xs-12">
							<h4>Write content for: <strong><?php echo strtoupper($language['output_name']); ?></strong></h4>
							<textarea name="locales[]" class="textarea-control"></textarea>							
						</div>
					<?php } ?>					
				</div>
			</div><!--form-body-->
		</div><!--portlet-body-->
	</div><!--portlet-->
	<input type="hidden" name="new<?php echo strtolower($datatype); ?>" value="yes">
</form>
