<form method="post" enctype="multipart/form-data" class="form-horizontal form-bordered form-row-stripped" id="<?php echo $_GET['action']; ?>-<?php echo strtolower($datatype); ?>">
	<div class="portlet box blue">
		<div class="portlet-body form">
			<h4>Show deleted datatypes</h4>
			<div class="form-body">
				<table class="table table-striped table-bordered table-hover dataTableInit">
					<thead>
						<tr>
							<th>DATATYPE NAME</th>
							<th>EXPORT DATE</th>
							<th>RESTORE</th>
							<th>DELETE</th>
						</tr>
					</thead>
					<tbody id="datatype-body">
						<?php
							$dir = 'scripts/datatypes/bak/';
							$dh = opendir($dir);
							while ($filename = readdir($dh)){
								if (is_file($dir."/".$filename)){
									if($filename!='.DS_Store'){ 
										$data=explode('__',$filename);
									?>
									<tr>
										<td>
											<?php echo str_replace('_',' ',strtoupper($data[0])); ?>
										</td>
										<td>
											<?php $date=explode('_',$data[1]); echo $date[0].' at '.str_replace('-',':',$date[1]); ?>
										</td>
										<td style="text-align:center; width:60px">
											<a href="/bmt/<?php echo $internal_route; ?>/<?php echo $filename; ?>/restore" class="bmt-small-button">
												<i class="fa fa-reply"></i>
											</a>
										</td>
										<td style="text-align:center; width:60px">
											<a href="javascript:validateDeleteBackup('<?php echo $filename; ?>')" class="bmt-small-button">
												<i class="fa fa-trash-o"></i>
											</a>
										</td>
									</tr>
									<?php
									}
								}
							} 	
						?>
					</tbody>
				</table>
			</div><!--form-body-->
		</div><!--portlet-body-->
	</div><!--portlet-->
	<input type="hidden" name="new<?php echo strtolower($datatype); ?>" value="yes">
</form>
