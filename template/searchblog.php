<table  class="table table-hover sortable" style="margin-bottom: 0px" id="myTable">
				<thead>
					<tr>
						<th style="width:35px">編號</th>
						<th style="width:50px">類型</th>
						<th >標題</th>
						<th>圖片</th>
						<th >內容</th>
						<th style="width:100px">新增時間</th>
						<th style="width:120px">修改時間</th>
					</tr>
				</thead>
				<tbody>
					<?php					
					if( $stmt->rowCount() > 0 ){
						$arr= $stmt->fetchAll(PDO::FETCH_ASSOC);
						for($i = 0; $i < count($arr); $i++){
					?>
					<tr>				
						<td><?php echo $arr[$i]["blogId"]?></td>
						<td><?php echo $arr[$i]["blogCategory"]?></td>
						<td><?php echo $arr[$i]["blogTitle"]?></td>
						<td><?php if($arr[$i]['blogImages'] !== NULL) { ?><img style="width:170px" src="../image/blog/<?php echo $arr[$i]['blogImages']; ?>">
						<?php } ?>
						</td>
						<td style="max-width:550px;
						line-height:32px;
						overflow:hidden;
						display: -webkit-box;
						-webkit-line-clamp: 3;
						-webkit-box-orient: vertical;
						text-overflow: ellipsis"><?php echo nl2br($arr[$i]["blogContent"])?></td>
						<td><?php echo $arr[$i]["created_at"]?></td>
						<td><?php echo $arr[$i]["updated_at"]?></td>
					</tr>
					<?php	
						}
					}
					?>
				</tbody>
				<!-- <tfoot>
					<tr>
						<td >
							<input type="submit" name="" id="" value="Delete" >
							<button type="button">Delete</button>
						</td>
					</tr>
				</tfoot> -->
			</table>