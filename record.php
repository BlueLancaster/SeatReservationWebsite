<?php

require("check_normal_login.php");
require("connectDB.php");
require("period_module.php");
$index  = 1;

$sql1 = "SELECT * From Reservation WHERE user_account = '".$_SESSION["account"]."' AND  ( date <= CURRENT_DATE() OR status != 'reserved' ) ORDER BY date DESC";
$pre_recordList_result = mysqli_query($db_link, $sql1);


$sql2 = "SELECT * From Reservation WHERE user_account = '".$_SESSION["account"]."' AND  ( date > CURRENT_DATE() AND status = 'reserved' ) ORDER BY date DESC";
$future_recordList_result = mysqli_query($db_link, $sql2);



$title = "record";
require("html_header.php");
?>



<body>

<?php
require("member_nav.php");
?>

<div class="pt-5 pb-5 mt-0 align-items-center d-flex bg-dark background">


    <div class="container-fluid ">
        <div class="row  justify-content-center align-items-center d-flex-row text-center h-100">
            <div class="col-12 col-md-7 col-lg-6 h-50">
                <div class="card shadow">
                    <div class="login-box">
                        <div class="card-body mx-auto ">
                            <h4 class="card-title mt-3 text-center">預約紀錄</h4>

                            <div class="alert alert-warning" style="display: none" role="alert" id="alertBox">
                            </div>

                            <table class="table  table-info table-hover table-bordered border-dark">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">日期</th>
                                    <th scope="col">時段</th>
                                    <th scope="col">座位</th>
                                    <th scope="col">狀態</th>
                                    <th scope="col">可使用的操作</th>
                                </tr>
                                </thead>
                                <tbody>


                                <?php
                                while ($row_result = mysqli_fetch_assoc($future_recordList_result))
                                {
                                ?>
                                    <tr class="table-active">
                                        <th scope="row"><?php echo $index; $index+=1; ?></th>
                                        <td><?php echo $row_result["date"];?></td>
                                        <td><?php echo $periodTranslator[$row_result["period"]];?></td>
                                        <td><?php echo $row_result["seat_NO"];?></td>
                                        <td><?php echo $row_result["status"];?></td>
                                        <td><button type="button" class="btn btn-danger cancelBtn"  data-id = <?php echo $row_result["NO"];?> </td> cancel</button></td>
                                    </tr>
                                <?php
                                }
                                ?>

                                <?php
                                while ($row_result = mysqli_fetch_assoc($pre_recordList_result))
                                {
                                    ?>
                                    <tr>
                                        <th scope="row"><?php echo $index; $index+=1; ?></th>
                                        <td><?php echo $row_result["date"];?></td>
                                        <td><?php echo $periodTranslator[$row_result["period"]];?></td>
                                        <td><?php echo $row_result["seat_NO"];?></td>
                                        <td><?php echo $row_result["status"];?></td>
                                        <td></td>
                                    </tr>
                                    <?php
                                }
                                ?>


                                </tbody>
                            </table>
                            <div class="form-group box">
                                <button class="btn btn-info" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">查看編號對應</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>



<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasRightLabel">座位和時段之編號對應表</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">

        <img src="image\seat_layout_numbered.jpg" style="min-width: 60%; height: auto">


        <table class="table table-success table-striped" style="margin-top: 20px">
            <thead>
            <tr>
                <th scope="col">編號</th>
                <th scope="col">對應時間</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <th scope="row">A</th>
                <td>08:00~09:00</td>
            </tr>
            <tr>
                <th scope="row">B</th>
                <td>09:00~10:00</td>
            </tr>
            <tr>
                <th scope="row">C</th>
                <td>10:00~11:00</td>
            </tr>
            <tr>
                <th scope="row">D</th>
                <td>11:00~12:00</td>
            </tr>
            <tr>
                <th scope="row">E</th>
                <td>12:00~13:00</td>
            </tr>
            <tr>
                <th scope="row">F</th>
                <td>13:00~14:00</td>
            </tr>
            <tr>
                <th scope="row">G</th>
                <td>14:00~15:00</td>
            </tr>
            <tr>
                <th scope="row">H</th>
                <td>15:00~16:00</td>
            </tr>
            <tr>
                <th scope="row">I</th>
                <td>16:00~17:00</td>
            </tr>
            <tr>
                <th scope="row">J</th>
                <td>17:00~18:00</td>
            </tr>
            <tr>
                <th scope="row">K</th>
                <td>18:00~19:00</td>
            </tr>
            <tr>
                <th scope="row">L</th>
                <td>19:00~20:00</td>
            </tr>
            <tr>
                <th scope="row">M</th>
                <td>20:00~21:00</td>
            </tr>

            </tbody>
        </table>
    </div>
</div>

<script>
    $(document).ready(function () {
        $(".cancelBtn").click(function () {
            console.log($(this).attr("data-id"));
            let $clickedBtn = $(this);
            $.ajax({
                url: "cancel_reservation.php",
                data: "&reservationNO="+$(this).attr("data-id"),
                type:"POST",
                dataType:'text',
                success: function(response){
                    console.log(response);
                    var $response_arr = response.split(',');
                    var $msg = "";

                    if ($response_arr[0]=="S")
                    {
                        $clickedBtn.parent().parent().remove();
                        $msg = "取消成功! "+$response_arr[1]+"的"+$response_arr[2]+"時段的座位"+$response_arr[3]+"已被取消";
                    }
                    else
                    {
                        $msg = "取消失敗，因為系統內已經不存在該筆預約";
                    }

                    $("#alertBox").html($msg);
                    //$("#alertBox").show().delay(5000).hide(0);
                    $("#alertBox").slideDown(800).delay(1000).slideUp(800);
                },
                error:   function(jqXHR, textStatus, errorThrown){
                    console.log(errorThrown);
                }
            });
        });
    });

</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>
</body>
</html>
