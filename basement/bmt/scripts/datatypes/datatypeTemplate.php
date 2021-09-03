			<!--TABLE TEMPLATE-->
			<div class="hidden" template="datatype">
				{{tr id="{{variable}}-{{ID}}"}}
					{{td style="width:20px; text-align:center"}}
						{{input type="checkbox" value="1" style="font-size:10px" name="active[]"}}
					{{/td}}
					{{td style="width:150px"}}
						{{input class="form-control formInput" required style="font-size:10px" type="text" name="name[]"}}
					{{/td}}
					{{td class="text-center" style="width:20px"}}
						{{input type="checkbox" style="font-size:10px" value="1" name="print[]"}}
					{{/td}}
					{{td class="text-center" style="width:20px"}}
						{{input type="checkbox" style="font-size:10px" value="required" name="required[]"}}
					{{/td}}
					{{td class="text-center" style="width:20px"}}
						{{input type="checkbox" style="font-size:10px" value="multiple" name="multiple[]"}}
					{{/td}}
					{{td style="width:100px"}}
						{{select style="font-size:10px" class="form-control select-chosen formInput" name="type[]"}}
							{{option value="text"}}TEXT{{/option}}
							{{option value="email"}}EMAIL{{/option}}
							{{option value="money"}}MONEY{{/option}}
							{{option value="tag"}}TAG{{/option}}
							{{option value="textarea"}}TEXTAREA{{/option}}
							{{option value="date"}}DATE{{/option}}
							{{option value="datetime"}}DATETIME{{/option}}
							{{option value="select"}}SELECT{{/option}}
							{{option value="password"}}PASSWORD{{/option}}
							{{option value="file"}}FILE{{/option}}
							{{option value="custom"}}CUSTOM{{/option}}
							{{option value="checkbox"}}CHECKBOX{{/option}}
							{{option value="option"}}OPTION{{/option}}
						{{/select}}
					{{/td}}
					{{td}}
						{{input class="form-control formInput" style="font-size:10px" type="text" name="specs[]"}}
					{{/td}}
					{{td style="width:100px"}}
						{{select style="font-size:10px" class="form-control select-chosen formInput" name="format[]"}}
							{{option value="int"}}INT{{/option}}
							{{option value="float"}}FLOAT{{/option}}
							{{option value="date"}}DATE{{/option}}
							{{option value="datetime"}}DATETIME{{/option}}
							{{option value="varchar"}}VARCHAR{{/option}}
							{{option value="text"}}TEXT{{/option}}
							{{option value="longtext"}}LONGTEXT{{/option}}
						{{/select}}
					{{/td}}
					{{td style="width:20px"}}
						{{input class="form-control formInput" style="font-size:10px" type="text" name="length[]"}}
					{{/td}}
					{{td style="width:20px"}}
						{{input class="form-control formInput" style="font-size:10px" type="text" name="order[]"}}
					{{/td}}
					{{td class="text-center" style="width:20px"}}
						{{a href="javascript:deleteElement('{{variable}}',{{ID}});" class="bmt-small-button"}}
							{{i class="fa fa-trash-o"}}{{/i}}
						{{/a}}
						{{input type="hidden" style="font-size:10px" id="delete-{{ID}}" 
							value="" name="delete[]"}}
					{{/td}}
				{{/tr}}
			</div>
			<!--TABLE TEMPLATE-->