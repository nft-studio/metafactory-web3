<div class="portlet">
	<div class="portlet-body" style="display: block;">
		<table class="table table-striped table-bordered table-hover dataTableInit" ID="dataTable">
			<thead>
				<tr>
					<?php
						foreach ($custom_datatypes as $field){ 
							$instructions=returnFieldInstructions($field['Comment']);
							if($instructions['print']=='1'){ ?>
							<th><?php echo returnFieldLabel($field['Field']); ?></th>
					<?php
							}
						}
					?>
					<th style="text-align:center"><i class="fa fa-edit"></i></th>
				</tr>
			</thead>
			<tbody>
				<?php 
					if(count($row_rs_all) > 0){
					foreach($row_rs_all as $row){ 
						$customFields['globale']=$row['globale'];
						$locales=json_decode($row['locales'],1);
						$customFields['locales']='';
						foreach($locales as $locale){
							$customFields['locales'].='['.$locale['language'].'] '.$locale['locale'].'<br>';
						}
						
					?>
				<tr>
					<?php
						foreach ($custom_datatypes as $field){ 
							$instructions=returnFieldInstructions($field['Comment']);
							if($instructions['print']=='1'){ 
								if($instructions['type']!='custom'){
									if(strpos($field['Field'], 'email')!==false){ ?>
										<td><a href="mailto:<?php echo $row[$field['Field']]; ?>"><?php echo $row[$field['Field']]; ?></a></td>
									<?php }else{ ?>
										<td><?php echo returnCorrectDatatypePrintField($instructions['type'],$row[$field['Field']],$instructions['specs'],$instructions['multiple']); ?></td>
						<?php
									}
								}else{
									?><td><?php echo $customFields[$field['Field']]; ?></td><?php
								}
							}
						}
					?>
					<td style="text-align:center; width:60px">
						<a href="/bmt/<?php echo $internal_route; ?>/<?php echo $row['id']; ?>/mod" class="bmt-small-button"><i class="fa fa-edit"></i></a>
					</td>
				</tr>
				<?php }
					}
				?>
			</tbody>
		</table>
	</div><!--portlet-body-->
</div><!--portlet-->