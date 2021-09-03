<form method="post" enctype="multipart/form-data" class="form-horizontal form-bordered form-row-stripped" id="mod-<?php echo strtolower($datatype); ?>">
	<div class="portlet box blue">
		<div class="portlet-body form">
			<h4>You're managing: <?php echo str_replace('-','_',$_GET['type']); ?></h4>
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
						<?php
							$datatypes=0;
							if (count($columns) > 0) {
							    foreach($columns as $row) {
									if($row['Field']!='id'){ 
										$instructions=returnFieldInstructions($row['Comment']);
										$typeArr=explode('(',$row['Type']);
										$type=$typeArr[0];
										if($type != 'longtext'){
											$length = 255;
										}else{
											$length = "";
										}
										if(isset($typeArr[1])){ 
											$length=str_replace(')','',$typeArr[1]); 
										}else{
											if($type === 'timestamp'){
												$length = 11;
											}
										}
									?>
										<tr id="datatype-<?php echo $datatypes; ?>">
											<td class="text-center" style="width:20px">
												<input type="checkbox" value="1" style="font-size:10px" <?php if($row['Comment']!='no'){echo 'checked';} ?> name="active-<?php echo toAscii($row['Field']); ?>">
											</td>
											<td style="width:150px">
												<input required class="form-control formInput" style="font-size:10px" type="text" value='<?php echo $row['Field']; ?>' name="name-<?php echo toAscii($row['Field']); ?>">
											</td>
											<td class="text-center" style="width:20px">
												<input type="checkbox" style="font-size:10px" value="1" <?php if($instructions['print']==1){echo 'checked';} ?> name="print-<?php echo toAscii($row['Field']); ?>">
											</td>
											<td class="text-center" style="width:20px">
												<input type="checkbox" style="font-size:10px" value="required" <?php if($instructions['required']=='required'){echo 'checked';} ?> name="required-<?php echo toAscii($row['Field']); ?>">
											</td>
											<td class="text-center" style="width:20px">
												<input type="checkbox" style="font-size:10px" value="multiple" <?php if($instructions['multiple']=='multiple'){echo 'checked';} ?> name="multiple-<?php echo toAscii($row['Field']); ?>">
											</td>
											<td style="width:100px">
												<select style="font-size:10px" class="form-control select-chosen formInput" name="type-<?php echo toAscii($row['Field']); ?>">
													<option <?php if($instructions['type']=='text'){echo 'selected';} ?> value="text">TEXT</option>
													<option <?php if($instructions['type']=='email'){echo 'selected';} ?> value="email">EMAIL</option>
													<option <?php if($instructions['type']=='money'){echo 'selected';} ?>  value="money">MONEY</option>
													<option <?php if($instructions['type']=='tag'){echo 'selected';} ?>  value="tag">TAG</option>
													<option <?php if($instructions['type']=='textarea'){echo 'selected';} ?>  value="textarea">TEXTAREA</option>
													<option <?php if($instructions['type']=='date'){echo 'selected';} ?>  value="date">DATE</option>
													<option <?php if($instructions['type']=='datetime'){echo 'selected';} ?>  value="datetime">DATETIME</option>
													<option <?php if($instructions['type']=='select'){echo 'selected';} ?>  value="select">SELECT</option>
													<option <?php if($instructions['type']=='password'){echo 'selected';} ?>  value="password">PASSWORD</option>
													<option <?php if($instructions['type']=='file'){echo 'selected';} ?>  value="file">FILE</option>
													<option <?php if($instructions['type']=='custom'){echo 'selected';} ?>  value="custom">CUSTOM</option>
													<option <?php if($instructions['type']=='checkbox'){echo 'selected';} ?>  value="checkbox">CHECKBOX</option>
													<option <?php if($instructions['type']=='option'){echo 'selected';} ?>  value="option">OPTION</option>
												</select>
											</td>
											<td>
												<input class="form-control formInput" style="font-size:10px" type="text" value='<?php echo str_replace("'","\'",$instructions['specs']); ?>' name="specs-<?php echo toAscii($row['Field']); ?>">
											</td>
											<td style="width:100px">
												<select style="font-size:10px" class="form-control select-chosen formInput" name="format-<?php echo toAscii($row['Field']); ?>">
													<option <?php if($type=='int'){echo 'selected';} ?>  value="int">INT</option>
													<option <?php if($type=='float'){echo 'selected';} ?>  value="float">FLOAT</option>
													<option <?php if($type=='date'){echo 'selected';} ?>  value="date">DATE</option>
													<option <?php if($type=='datetime'){echo 'selected';} ?>  value="datetime">DATETIME</option>
													<option <?php if($type=='varchar'){echo 'selected';} ?>  value="varchar">VARCHAR</option>
													<option <?php if($type=='text'){echo 'selected';} ?>  value="text">TEXT</option>
													<option <?php if($type=='longtext'){echo 'selected';} ?>  value="longtext">LONGTEXT</option>
												</select>
											</td>
											<td style="width:20px">
												<input class="form-control formInput" style="font-size:10px" type="text" value='<?php echo $length; ?>' name="length-<?php echo toAscii($row['Field']); ?>">
											</td>
											<td style="width:20px">
												<input class="form-control formInput" style="font-size:10px" type="text" value="<?php echo $instructions['order']; ?>" name="order-<?php echo toAscii($row['Field']); ?>">
											</td>
											<td class="text-center" style="width:20px">
												<a href="javascript:deleteDatatype(<?php echo $datatypes; ?>);" class="bmt-small-button">
													<i class="fa fa-trash-o"></i>
												</a>
												<input type="hidden" style="font-size:10px" id="delete-<?php echo $datatypes; ?>" 
													value="" name="delete-<?php echo toAscii($row['Field']); ?>">
											</td>
										</tr>
									<?php
										$datatypes++;   
									}
								}
							}
						?>
					</tbody>
				</table>
			</div><!--form-body-->
			
			<?php include('scripts/datatypes/datatypeTemplate.php'); ?>
			<div class="btn btn-primary pull-right" onClick="addElement('datatype')">ADD COLUMN</div>
		</div><!--portlet-body-->
	</div><!--portlet-->
	<input type="hidden" name="mod<?php echo strtolower($datatype); ?>" value="<?php echo $_GET['type']; ?>">
</form>
