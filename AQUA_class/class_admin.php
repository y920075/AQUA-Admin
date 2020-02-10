<?php
require_once('../template/db.inc.php'); //引入資料庫連線

//選擇class_data的所有資料並加總
$sqlTotal = "SELECT count(1) FROM `class_data`";
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
$sqlCount = "SELECT count(`classId`) FROM `class_data`";
$stmtCount = $pdo->query($sqlCount)->fetch(PDO::FETCH_NUM)[0];
?>
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="../index.php">
					<em class="fa fa-home"></em>
				</a></li>
				<li class="active">課程管理首頁</li>
			</ol>
		</div>
		
		<ul class="nav nav-tabs">
			<li class="nav-item">
				<a class="nav-link text-primary" href="./addclass.php">新增課程</a>
			</li>
			<li class="nav-item">
				<a class="nav-link text-primary" href="./class-category.php">課程類別與等級管理</a>
			</li>
		</ul>

		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">課程列表
					<span>目前共有 <strong><?php echo $stmtCount; ?></strong> 門課程</span>
					</div>
					<div class="panel-body">
					<span>依類別篩選</span>
					<select name="" id="search_type">
						<option value="all">全部</option>
						<!-- 抓出class_type這張資料表中的所有類型 -->
						<?php
							$sqlGetType =  "SELECT `classTypeName`,`classTypeId`
											FROM `class_type`";
							// 執行sql語法
							$stmtGetType = $pdo->prepare($sqlGetType);
							$stmtGetType->execute();

							// 如果影響行數大於0，則表示有資料，就印出資料
							if($stmtGetType->rowCount() > 0){
								$arrGetType = $stmtGetType->fetchAll(PDO::FETCH_ASSOC);
								for($i = 0 ; $i < count($arrGetType) ; $i++){
								?>
									<option value="<?php echo $arrGetType[$i]['classTypeId']; ?>"><?php echo $arrGetType[$i]['classTypeName']; ?></option>
							<?php
								}
							}
							?>
					</select>
					<span>依開課日期篩選</span><select name="" id="search_date">
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
							<table class="table table-hover sortable">
								<thead>
								  <tr>
									<th>課程編號</th>
									<th>課程名稱</th>
									<th>課程類型</th>
									<th>課程等級</th>
									<th>賣家編號</th>
									<th>開課日期</th>
									<th>課程費用</th>
									<th>建立時間</th>
									<th>更新時間</th>
									<th>功能</th>
								  </tr>
								</thead>
								<tbody id="class_data_body">
								
								<?php
									//取得揪團資料
									$sql = "SELECT  `class_data`.`classId`,`class_data`.`className`,`class_type`.`classTypeName`,`class_level`.`classLevel`,
													`class_data`.`sellerID`,`class_data`.`classStartDate`,`class_data`.`classPrice`,
													`class_data`.`created_at`,`class_data`.`updated_at`
											FROM `class_data`
											INNER JOIN `class_type`
											ON `class_data`.`classTypeId` = `class_type`.`classTypeId`
											INNER JOIN `class_level`
											ON `class_data`.`classLevelID`= `class_level`.`classLevelId`
											ORDER BY `class_data`.`id` DESC
											LIMIT ?,? ";
									// 顯示筆數 第一個值是從"第幾筆開始" 第二個值是總共要幾筆
									// LIMIT 0,5 = 第0筆開始 抓5筆 = 索引值為 0,1,2,3,4 資料會被抓出來


									//繫結資料 第一個值對應到 lIMIT第一個值 表示從第幾筆開始 
									//計算方式 目前頁數減1 乘 一頁要幾筆 假設目前為第一頁 則 1-1 =0 , 0*5 = 0
									//第一個值就等於0 第二個值為 5 就等同於 LIMIT 0,5 將會抓取 0,1,2,3,4 五筆資料
									$arrParam = [
										($page - 1) * $numPerPage,
										$numPerPage
									];
							
									//執行查詢SQL語法
									$stmt = $pdo->prepare($sql);
									$stmt->execute($arrParam);

									//如果影響行數大於0 就印出資料
									if($stmt->rowCount() > 0){
										$arr = $stmt->fetchAll(PDO::FETCH_ASSOC);									
									//用for迴圈逐一取得資料 count()是加總陣列長度
										for($i = 0 ; $i < count($arr) ; $i++){		
								?>
											<tr id="class_Data">
												<td><?php echo $arr[$i]['classId']; ?></td>
												<td><?php echo $arr[$i]['className']; ?></td>
												<td><?php echo $arr[$i]['classTypeName']; ?></td>
												<td><?php echo $arr[$i]['classLevel'];; ?></td>
												<td><?php echo $arr[$i]['sellerID']; ?></td>
												<td><?php echo $arr[$i]['classStartDate']; ?></td>
												<td><?php echo $arr[$i]['classPrice']; ?></td>
												<td><?php echo $arr[$i]['created_at']; ?></td>
												<td><?php echo $arr[$i]['updated_at']; ?></td>
												<td>
													<a class="btn btn-primary" href="./edit_class.php?editclassId=<?php echo $arr[$i]['classId']; ?>">查看</a>
													<a onclick="return confirm('確認是否要刪除?')" class="btn btn-secondary" href="./delete_class.php?deleteclassId=<?php echo $arr[$i]['classId']; ?>">刪除</a>
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
											for ($i = 1 ; $i <= $totalPages ; $i++){
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
