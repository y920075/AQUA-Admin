<table class="table sortable" id="myTable">
    <thead class="thead-dark changecolor">
        <tr>
        <th>會員編號</th>
        <th>會員帳號</th>
        <!-- <th>會員密碼</th> -->
        <!-- <th class="sorttable_nosort">會員頭像</th> -->
        <th>會員姓名</th>
        <th>會員性別</th>
        <th>會員生日</th>
        <th>電子郵件</th>
        <th>手機號碼</th>
        <!-- <th>會員地址</th> -->
        <!-- <th>加入日期</th> -->
        <th>狀態</th>
        </tr>
    </thead>
    <tbody>
    <?php
        if($stmt->rowCount() > 0){
            $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
            for($i = 0; $i < count($arr); $i++){
    ?>
    <tr>
        <td><?php echo $arr[$i]['memberId'] ?></td>
        <td><?php echo $arr[$i]['loginId'] ?></td>
        <!-- <td><?php echo $arr[$i]['loginPwd'] ?></td> -->
        <!-- <td><?php if ($arr[$i]['avatar'] !== NULL){ ?>
            <img src="./Img/<?php echo $arr[$i]['avatar'] ?>">
        </td>					
        <?php } ?> -->
        <td><?php echo $arr[$i]['fullName'] ?></td>
        <td><?php echo $arr[$i]['gender'] ?></td>
        <td><?php echo $arr[$i]['birthDate'] ?></td>
        <td><?php echo $arr[$i]['email'] ?></td>
        <td><?php echo $arr[$i]['mobileNumber'] ?></td>
        <!-- <td><?php echo $arr[$i]['address'] ?></td>
        <td><?php echo $arr[$i]['joinDate'] ?></td> -->
        <td><?php echo $arr[$i]['currentStatus'] ?></td>
        <!-- <td><?php echo $arr[$i]['created_at'] ?></td>
        <td><?php echo $arr[$i]['updated_at'] ?></td> -->
    </tr>
    <?php
            }
        }
    ?>
    </tbody>
    <!-- <tfoot>
        <tr>
            <td class="border" colspan="9">
                <?php for($i = 1; $i <= $totalPages; $i++){ ?>
                <a href="?page=<?= $i ?>"><?= $i ?></a>
                <?php } ?>
            </td>
        </tr>
    </tfoot> -->
</table>