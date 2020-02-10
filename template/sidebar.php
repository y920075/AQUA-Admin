<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
		<div class="profile-sidebar">
			<div class="profile-userpic">
				<img src="../image/logo-19.png" class="img-responsive" alt="">
			</div>
			<div class="profile-usertitle">
				<div class="profile-usertitle-name">AQUA-ADMIN</div>
				<div class="profile-usertitle-status"><span class="indicator label-success"></span>Online</div>
			</div>
			<div class="clear"></div>
		</div>
        <div class="divider"></div>
		<!-- 搜尋引擎-->
		<form role="search" method="POST" action="../template/search.php" enctype="multipart/form-data">
			<div class="form-group">
                <select name="class" id="" class="form-control">
                    <option value="items">商品名稱</option>
                    <option value="my_member">會員編號</option>
					<option value="basic_information">廠商名稱</option>
					<option value="orders">訂單編號</option>
					<option value="event_data">活動名稱</option>
                    <option value="class_data">課程名稱</option>
                    <option value="blog">部落格(文章標題)</option>
                    <option value="location">潛點名稱</option>
				</select>
                <input type="text" class="form-control" placeholder="Search" name="search">
                <button type="submit" class="btn btn-primary form-control">搜尋資料庫</button>
			</div>
		</form>
		<ul class="nav menu">
			<li><a href="../dashboard\dashboard.php"><em class="fa fa-tachometer">&nbsp;</em> AQUA</a></li>
			<li><a href="../items\items.php"><em class="fa fa-shopping-bag">&nbsp;</em> 商品資料管理</a></li>
			<li><a href="../member/member.php"><em class="fa fa fa-users">&nbsp;</em> 會員資料管理</a></li>
            <li><a href="../aqua_seller/seller.php"><em class="fa fa-industry">&nbsp;</em> 廠商資料管理</a></li>
            <li><a href="../orders/orders.php"><em class="fa fa-shopping-cart">&nbsp;</em> 訂單資料管理</a></li>
			<li><a href="../AQUA_event\event-admin.php"><em class="fa fa-futbol-o">&nbsp;</em> 活動資料管理</a></li>
			<li><a href="../AQUA_class\class_admin.php"><em class="fa fa-university">&nbsp;</em> 課程資料管理</a></li>
			<li><a href="../blog/blog.php"><em class="fa fa-book">&nbsp;</em> 部落格資料管理</a></li>
			<li><a href="../location/location.php"><em class="fa fa-map-marker">&nbsp;</em> 潛點資料管理</a></li>
			<li><a href="../template/logout.php?logout=1"><em class="fa fa-power-off">&nbsp;</em> 登出</a></li>
		</ul>
	</div><!--/.sidebar-->