<?php
require("check_admin_login.php");
require("connectDB.php");

$sql = "SELECT NO From Seat";
$seatList_result = mysqli_query($db_link, $sql);
$title = "reservation_management";
require("html_header.php");
?>




<?php
require("admin_nav.php");
?>

<div class="pt-5 pb-5 mt-0 align-items-center d-flex bg-dark background" >
    <div class="container-fluid ">
        <div class="row  justify-content-center align-items-center d-flex-row text-center h-100">
            <div class="col-12 col-md-4 col-lg-3 h-50">
                <div class="card shadow">
                    <div class="login-box">
                        <div class="card-body mx-auto ">
                            <h4 class="card-title mt-3 text-center">設定座位禁止時間</h4>

                            <div class="alert alert-warning" style="display: none" role="alert" id="alertBox">
                            </div>

                            <?php
                            if(isset($_GET["msg"])){
                                if ($_GET["msg"]=="success") {?>
                                    <div class="alert alert-info" role="alert">
                                        設定該不開放時間成功!!!
                                    </div>
                                <?php }else {?>
                                    <div class="alert alert-danger" role="alert">
                                        <?php if($_GET["msg"]=="failed0") { ?>
                                            所有欄位不能為空!!!
                                        <?php } elseif ($_GET["msg"]=="failed1"){?>
                                            該日期已被設定為不開放
                                        <?php }?>
                                    </div>
                                <?php } ?>
                            <?php } ?>


                            <form method="post" action="set_unavailable_date_for_seat.php">
                                <div class="form-group input-group box inputbox_top_margin">
                                    <img class="icon" src="icon\chair2.png" alt="Icon">
                                    <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" id="seatSelector"  name="seat" required>
                                        <option value="" selected disabled>選擇座位</option>
                                        <?php
                                        while ($row_result = mysqli_fetch_row($seatList_result))
                                        {
                                            echo "<option value='$row_result[0]'>$row_result[0]</option>";
                                        }
                                        ?>
                                    </select>

                                </div>

                                <input type="date" class="form-control inputbox_top_margin" id="dateSelector" name="date">

                                <div class="form-group box inputbox_top_margin">
                                    <button class="btn btn-info" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">查看編號對應</button>
                                    <button type="submit" class="btn btn-primary btn-block">送出</button>
                                </div>
                            </form>


                            <table class="table  table-info table-hover table-bordered border-dark" style="display: none; margin-top: 10px" id="unavailableDateTable">
                                <thead>
                                <tr>
                                    <th scope="col">日期</th>
                                    <th scope="col">操作者</th>
                                    <th scope="col">可使用的操作</th>
                                </tr>
                                </thead>
                                <tbody id="unavailableDateTableBody">


                                </tbody>
                            </table>


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
        $(function () {
            var date_now = new Date();
            var min_date = new Date(date_now.getTime() + 30 * 24 * 60 * 60 * 1000);
            var min_year = min_date.getFullYear();
            var min_month = min_date.getMonth() + 1;
            var min_day = min_date.getDate();


            min_month = min_month < 10 ? "0" + min_month : min_month;
            min_day = min_day < 10 ? "0" + min_day : min_day;

            $("#dateSelector").attr("min", min_year + "-" + min_month + "-" + min_day);





        });

        $("#seatSelector").on("change", function() {
            $("#seatSelector option:selected").each(function () {
                console.log($(this).val());
                check_available();
            });
        });




        function check_available() {
            $("#unavailableDateTableBody").empty();
            $.ajax({
                url: "get_unavailable_date_for_seat.php",
                data: "&seatNO="+$("#seatSelector").val(),
                type:"POST",
                dataType:'text',

                success: function(response){
                    console.log(response);
                    var result = $.parseJSON(response);
                    $("#unavailableDateTable").hide(0);

                    if (result.length>0)
                    {
                        $("#unavailableDateTable").slideDown(500);
                        $.each( result, function( i, elements ) {
                            console.log(elements["NO"]);
                            var $resultContent="";
                            $resultContent+='<tr><th scope="row">'+elements["unavailable_date"] +'</th>';
                            $resultContent+='<td>'+elements["admin_account"] +'</td>';
                            $resultContent+='<td><button type="button" class="btn btn-danger cancelBtn"  data-id ='+ elements["NO"] +' </td> cancel</button></td></tr>';
                            $("#unavailableDateTableBody").append($resultContent);


                        });
                    }



                },
                error:   function(jqXHR, textStatus, errorThrown){
                    console.log(errorThrown);
                }
            });
        };

        $(document).on('click', '.cancelBtn', function() {
            let $clickedBtn = $(this);
            $.ajax({
                url: "cancel_unavailable_date_for_seat.php",
                data: "&managementNO="+$clickedBtn.attr("data-id")+"&seatNO="+$("#seatSelector").val(),
                type:"POST",
                dataType:'text',

                success: function(response){
                    console.log(response);
                    $clickedBtn.parent().parent().remove();
                    let $response_arr = response.split(",");
                    $msg="";
                    if ($response_arr[0]=="S")
                    {
                        $msg = $response_arr[1]+"的座位"+$response_arr[2]+"的不開放已取消成功";

                    }
                    else if ($response_arr[0]=="F")
                    {
                        $msg = "取消失敗，因為系統內已經不存在該筆資料";
                    }
                    $("#alertBox").html($msg);
                    $("#alertBox").slideDown(800).delay(1500).slideUp(800);

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

