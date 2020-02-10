<?php
require_once('../template/db.inc.php'); //引入資料庫連線

//選擇event_data的所有資料並加總
$sqlTotal = "SELECT count(1) FROM `event_data`";
$total = $pdo->query($sqlTotal)->fetch(PDO::FETCH_NUM)[0];
//每頁要多少筆資料
$numPerPage = 10;
$totalPages = ceil($total/$numPerPage); //ceil是無條件進位  1.4 = 2
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1 ; //三元運算子
$page = $page < 1 ? 1 : $page; 

require_once('./html_title.php'); //引入html head資訊
?>


<body>
<?php
require_once('../template/header.php'); //引入頭部導航列
require_once('../template/sidebar.php'); //引入側欄
$sqlCount = "SELECT count(`eventId`) FROM `event_data`";
$stmtCount = $pdo->query($sqlCount)->fetch(PDO::FETCH_NUM)[0];

?>
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="../index.php">
					<em class="fa fa-home"></em>
				</a></li>
				<li class="active">揪團管理首頁</li>
			</ol>
		</div>
		
		<ul class="nav nav-tabs">
			<li class="nav-item">
				<a class="nav-link text-primary" href="./addevent.php">新增揪團</a>
			</li>
			<li class="nav-item">
				<a class="nav-link text-primary" href="./event-category.php">揪團類別管理</a>
			</li>
		</ul>

		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">揪團列表
					<span>目前共有 <strong><?php echo $stmtCount; ?></strong> 筆揪團</span>
					</div>
					<div class="panel-body">
					<span>依類別篩選</span>
					<select name="" id="search_type">
						<option value="all">全部</option>
						<!-- 抓出event_type這張資料表中的所有類型 -->
						<?php
							$sqlGetType =  "SELECT `eventTypeName`,`eventTypeId`
											FROM `event_type`";
							// 執行sql語法
							$stmtGetType = $pdo->prepare($sqlGetType);
							$stmtGetType->execute();

							// 如果影響行數大於0，則表示有資料，就印出資料
							if($stmtGetType->rowCount() > 0){
								$arrGetType = $stmtGetType->fetchAll(PDO::FETCH_ASSOC);
								for($i = 0 ; $i < count($arrGetType) ; $i++){
								?>
									<option value="<?php echo $arrGetType[$i]['eventTypeId']; ?>"><?php echo $arrGetType[$i]['eventTypeName']; ?></option>
							<?php
								}
							}
							?>
					</select>
					<span>依日期篩選</span><select name="" id="search_date">
						<option value="all">全部時間</option>
						<option value="3day">最近三天內</option>
						<option value="7day">最近一週內</option>
						<option value="30day">最近一個月內</option>
					</select>
					<form style="display:inline-block;" >
						<label>關鍵字搜索</label><input type="text" id="search_keyword">
						<button type="button" id="search_btn">搜索</button>
					</form>
						<div class="col-md-12">
							<table id="" class="table table-hover">
								<thead>
								  <tr>
									<th>揪團編號</th>
									<th>揪團主題</th>
									<th>揪團類型</th>
									<th>揪團地點</th>
									<th>主揪者</th>
									<th>活動日期</th>
									<th>報名截止日期</th>
									<th>建立時間</th>
									<th>更新時間</th>
									<th>功能</th>
								  </tr>
								</thead>
								<tbody id="class_data_body">
								
								<?php

									//取得揪團資料
									$sql = "SELECT `eventId`,`eventName`,`eventTypeId`,`eventLocal`,`eventSponsor`,`eventStartDate`,`eventEndDate`,`created_at`,`updated_at` 
											FROM `event_data`
											ORDER BY `id` DESC
											LIMIT ?,? ";
															
									// 顯示筆數 第一個值是從"第幾筆開始" 第二個值是總共要幾筆
									// LIMIT 0,5 = 第0筆開始 抓5筆 = 索引值為 0,1,2,3,4 資料會被抓出來

									// //取得揪團類型資料
									$sql_Type = "SELECT `event_data`.`eventId`,`event_type`.`eventTypeName` 
												FROM `event_data` 
												INNER JOIN `event_type` 
												ON `event_data`.`eventTypeId` = `event_type`.`eventTypeId`";

									// //取得地點資料
									$sql_Local = "SELECT `event_data`.`eventId`,`location`.`LocationID`,`location`.`LocationName`
									FROM `location` 
									INNER JOIN `event_data`
									ON `location`.`LocationID` = `event_data`.`eventLocal`";

									// 繫結資料 第一個值對應到 lIMIT第一個值 表示從第幾筆開始 
									// 計算方式 目前頁數減1 乘 一頁要幾筆 假設目前為第一頁 則 1-1 =0 , 0*5 = 0
									// 第一個值就等於0 第二個值為 5 就等同於 LIMIT 0,5 將會抓取 0,1,2,3,4 五筆資料
									$arrParam = [
										($page - 1) * $numPerPage,
										$numPerPage
									];

									// //執行地點SQL語法
									$stmt_Local = $pdo->prepare($sql_Local);
									$stmt_Local->execute();

									// //執行揪團類型SQL語法
									$stmt_Type = $pdo->prepare($sql_Type);
									$stmt_Type->execute();
									
									//執行查詢SQL語法
									$stmt = $pdo->prepare($sql);
									$stmt->execute($arrParam);

									//如果影響行數大於0 就印出資料
									if($stmt->rowCount() > 0){
										$arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
										$arr_type = $stmt_Type->fetchAll(PDO::FETCH_ASSOC);
										$arr_Local = $stmt_Local->fetchAll(PDO::FETCH_ASSOC);
										
										// //用for迴圈逐一取得資料 count()是加總陣列長度
										for($i = 0 ; $i < count($arr) ; $i++){
										// 	//用for迴圈逐一比對揪團編號，如果一致就把揪團類型名稱賦值給$type並離開迴圈印出資料
										// 	//如果比對不成功則賦值null
											if ($stmt_Type->rowCount() > 0) {
												for( $j = 0 ; $j < count($arr_type) ; $j++){
													if ($arr[$i]['eventId'] == $arr_type[$j]['eventId']) {
														$type = $arr_type[$j]['eventTypeName'];
														break;
													} else {
														$type = 'null';
													};
												}
											} else {
												$type = 'null';
											};
										// 	//用for迴圈逐一比對揪團編號，如果一致就把地點賦值給$Local並離開迴圈印出資料
										// 	//如果比對不成功則依照資料庫內的值給值
											if ($stmt_Local->rowCount() > 0) { 
												for( $k = 0 ; $k < count($arr_Local) ; $k++){
													if ($arr[$i]['eventId'] == $arr_Local[$k]['eventId']) {
														$Local = $arr_Local[$k]['LocationName'];
														break;
													} else {
														$Local = $arr[$i]['eventLocal'];
													};
												};
											} else {
												$Local = $arr[$i]['eventLocal'];
											}
								?>
								<tr>
									<td><?php echo $arr[$i]['eventId']; ?></td>
									<td><?php echo $arr[$i]['eventName']; ?></td>
									<td><?php echo $type ?></td>
									<td><?php echo $Local; ?></td>
									<td><?php echo $arr[$i]['eventSponsor']; ?></td>
									<td><?php echo $arr[$i]['eventStartDate']; ?></td>
									<td><?php echo $arr[$i]['eventEndDate']; ?></td>
									<td><?php echo $arr[$i]['created_at']; ?></td>
									<td><?php echo $arr[$i]['updated_at']; ?></td>
									<td>
										<a class="btn btn-primary" href="./edit_event.php?editeventId=<?php echo $arr[$i]['eventId']; ?>">查看</a>
										<a class="btn btn-secondary" href="./delete_event.php?deleteeventId=<?php echo $arr[$i]['eventId']; ?>">刪除</a>
									</td>
								</tr> 
								<?php
										};
									};
								?>
								</tbody>
								<tfoot>
									<tr>
										<td colspan="12" id="pagebar">
										<?php
										for($i = 1; $i <= $totalPages; $i++){
											$order = isset($_GET['order']) ? "order={$_GET['order']}" : '' 
										?>
										<button class="page-btn" onclick="pageChange(this)" value="<?php echo $i ;?>"><?php echo $i ;?></button>
										<?php
										}
										?>
										</td>
									</tr>
								</tfoot>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
<?php
require_once('../template/footer.php'); //引入尾部
require_once('./JS_script.php'); //引入js
require_once('./JS_search.php'); //引入js
?>
</body>
</html>
