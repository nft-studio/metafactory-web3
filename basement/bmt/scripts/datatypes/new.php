<form method="post" enctype="multipart/form-data" class="form-horizontal form-bordered form-row-stripped" id="<?php echo $_GET['action']; ?>-<?php echo strtolower($datatype); ?>">
	<div class="portlet box blue">
		<div class="portlet-body form">
			<h4>Create new table:<br><input required class="form-control" value="datatype_" type="text" name="datatype_name"></h4>
			<div class="form-body">
				<table class="table table-striped table-bordered table-hover dataTableInit">
					<thead>
						<tr>
							<th>ACTIVE</th>
							<th>NAME</th>
							<th>PRINT</th>
							<th>REQUIRED</th>
							<th>MULTIPLE</th>
							<th>TYPE</th>
							<th>SPECS</th>
							<th>FORMAT</th>
							<th>LENGTH</th>
							<th>ORDER</th>
							<th>DELETE</th>
						</tr>
					</thead>
					<tbody id="datatype-body">
						<?php $datatypes=0; ?>
					</tbody>
				</table>
			</div><!--form-body-->
			
			<?php include('scripts/datatypes/datatypeTemplate.php'); ?>
			<div class="btn btn-primary pull-right" onClick="addElement('datatype')">ADD COLUMN</div>
		</div><!--portlet-body-->
	</div><!--portlet-->
	<input type="hidden" name="new<?php echo strtolower($datatype); ?>" value="yes">
</form>
