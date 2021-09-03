<div class="portlet box blue">
	<div class="portlet-body" style="display: block;">
		<table class="table table-striped table-bordered table-hover dataTableInit">
			<thead>
				<tr>
					<th>Table name</th>
					<th>N. Fields</th>
					<th style="text-align:center; width:20px"><i class="fa fa-edit"></i></th>
				</tr>
			</thead>
			<tbody>
				<?php
					$tables = list_tables();
					
					$exclude=array("db_backup","tracking","locales","newsletter_sent","newsletter_tracking","newsletter_users");
					
				    foreach($tables as $table){
				     	if(!in_array($table, $exclude) && substr( $table[0], 0, 3 ) !== "pma"){
				     		$columns = list_columns($table);
							?>
							<tr style="width:20px">
								<td><?php echo strtoupper($table); ?></td>
								<td><?php echo count($columns); ?></td>
								<td><a href="/bmt/<?php echo $internal_route; ?>/<?php echo toAscii($table); ?>/mod" class="bmt-small-button">
									<i class="fa fa-edit"></i></a></td>
							</tr>
				<?php 
						}
				    }
				?>
			</tbody>
		</table>
	</div><!--portlet-body-->
</div><!--portlet-->