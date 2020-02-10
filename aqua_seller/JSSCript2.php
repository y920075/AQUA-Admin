<div class="py-3 form_2">
            <form name="myForm" method="POST" action="insertDynamic.php"  enctype="multipart/form-data">
            <a name="new_data" type="submit" id="" class="btn add_row btn-warning" href="#" role="button">
                   新增多筆
                    </a>
            <button name="new_data" type="submit" id="" class="btn btn-warning" href="#" role="button">
                   提交多筆
                    </button>
         

                <table class="table table_add">
                <thead class="thead-dark table_header_Color_chin">
                        <tr>
                        <th>選擇</th>
                        <th>Id</th>
                        <th>賣場圖</th>
                        <th>賣場名</th>
                        <th>密碼</th>
                        <th>地址</th>
                        <th>電話</th>
                        <th>手機</th>
                        <th>狀態</th>
                        <th>電郵</th>
                        <th>加入時間</th>
                        </tr>
                    </thead>
                    <tbody class="append_position_c">
                     </tbody>
                </table>
            </form>
            </div>
        </div>
    </div>
    </div>
    

<script>


$(function(){

    $("body").on("click",".add_row",function(){

                    <?php
                    $check = date("Y-m");

                    $sqlTotal = "SELECT MAX(`idd`) AS `MAX`
                                FROM `basic_information`
                                WHERE DATE_FORMAT(`create_time`,'%Y-%m') = '$check'";
                    $total = $pdo->query($sqlTotal)->fetch(PDO::FETCH_NUM)[0];
                    $idd = $pdo->query($sqlTotal)->fetch(PDO::FETCH_NUM);

                    //抓出現在年月兩碼

                    $time = date("ym");

                    $total_num = str_pad((int)$total+1,4,'0',STR_PAD_LEFT);
                
                ?>

            <?php 
                
                $add = 'S'. $time . $total_num; ?>
                <?php 
                $idd_add = $idd[0];
                ?>
        $.ajax({
                            url:"idd_prod.php",
                            method:"POST",
                            data:{
                                "add":<?php echo  $add; ?>,
                                "idd_add":<?php echo $idd_add;?>
                                },
                            success:function(data){
                                let chooseTbody = $(".append_position_c");

                                let s = `
                            <tr>
                                <td>
                                <input type="submit" class="btn btn-primary remove_row"  value="remove">
                                </td>
                                <td class="">
                                    <input type="text" name="seller_id[]" id="seller_id" value="<?php echo $add;?>" maxlength="20" class="form-control" placeholder="Placeholder">
                                    <input  class="form-control" type="hidden" name="idd" value="<?php echo $idd_add;?>">                        </td>
                                <td class="">
                                    <input type="file" name="seller_img[]" />
                                </td>
                                <td class="">
                                    <input type="text" name="seller_name[]" id="seller_name" value="" maxlength="8" />
                                </td>
                                <td class="">
                                    <input type="text" name="seller_password[]" id="seller_password" value="" maxlength="10" />   
                                </td>
                                <td class="">
                                    <input type="text" name="seller_address[]" id="seller_address" value="" maxlength="30" />
                                </td>
                                <td class="">
                                    <input type="text" name="seller_phone[]" id="seller_phone" value="" maxlength="10" />
                                </td>
                                <td class="">
                                <input type="text" name="seller_mobile[]" id="seller_mobile" value="" maxlength="10" />
                                </td>
                                <td class="">
                                <select name="seller_status[]" id="seller_status">
                                    <option value="active" selected>active</option>
                                    <option value="inactive">inactive</option>
                                    <option value="suspended">suspended</option>
                                </select>
                                </td>
                                <td class="">
                                <input type="email" name="seller_email[]" id="seller_email" value="" maxlength="30" />
                                </td>
                                <td>
                                <input type="date" name="join_time[]" id="join_time" value="" />
                                </td>
                                
                            </tr>
                        
                                    `;
                                    $("body").on("click",".add_row",function(){
                                    chooseTbody.append(s);
                                                i++;
                                                return false;
                                    });
                                    //移除邏輯
                                    $(document).on('click', '.remove_row', function() {
                                        if (i >= 1) {
                                            $(this).closest('tr').remove();
                                                i--;
                                        }
                                                return false;
                                            });
                            }
                        });

    });


});
let i = $(".append_position_c tr").length + 1;

// let addTogether = "<?php echo $add;?>";
// let iddPlus = "<?php echo $idd_add;?>";




</script>