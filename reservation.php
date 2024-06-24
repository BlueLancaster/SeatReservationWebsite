<?php
require("check_normal_login.php");
require("connectDB.php");
$sql = "SELECT NO From Seat";
$seatList_result = mysqli_query($db_link, $sql);

$title = "reservation";
require("html_header.php");
?>



<body>

<?php
require("member_nav.php");
?>

<div class="pt-5 pb-5 mt-0 align-items-center d-flex bg-dark background">


    <div class="container-fluid ">
        <div class="row  justify-content-center align-items-center d-flex-row text-center h-100">
            <div class="col-12 col-md-4 col-lg-3 h-50">
                <div class="card shadow">
                    <div class="login-box">
                        <div class="card-body mx-auto ">
                            <h4 class="card-title mt-3 text-center">預約座位</h4>

                            <?php
                            if(isset($_GET["msg"])){
                                if ($_GET["msg"]=="success") {?>
                                    <div class="alert alert-success" role="alert"  id="notifyBox">
                                        預約成功!!!
                                    </div>
                                <?php }else {?>
                                    <div class="alert alert-danger" role="alert"  id="notifyBox">
                                        <?php if($_GET["msg"]=="failed0") { ?>
                                            所有欄位不能為空!!!
                                        <?php } elseif ($_GET["msg"]=="failed1"){?>
                                            同一時段不能預約一個以上位置
                                    <?php } elseif ($_GET["msg"]=="failed2"){?>
                                            該位置該時段已被他人搶先了!
                                    <?php } elseif ($_GET["msg"]=="failed3"){?>
                                            該位置該日期不開放!
                                    <?php } ?>
                                    </div>
                                <?php } ?>
                            <?php } ?>

                            <form method="post" action="make_reservation.php">
                                <div class="form-group input-group box">
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
                                    <button class="btn btn-outline-secondary" type="button" id="randomBtn">Random</button>
                                </div>

                                <input type="date" class="form-control inputbox_top_margin" id="dateSelector" name="date" required disabled>

                                <div class="form-group input-group box" style="margin-top: 10px">

                                    <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" id="periodSelector"  name="period" required disabled>
                                        <option value="" selected disabled>選擇時段</option>
                                        <option value="A">08:00~09:00</option>
                                        <option value="B">09:00~10:00</option>
                                        <option value="C">10:00~11:00</option>
                                        <option value="D">11:00~12:00</option>
                                        <option value="E">12:00~13:00</option>
                                        <option value="F">13:00~14:00</option>
                                        <option value="G">14:00~15:00</option>
                                        <option value="H">15:00~16:00</option>
                                        <option value="I">16:00~17:00</option>
                                        <option value="J">17:00~18:00</option>
                                        <option value="K">18:00~19:00</option>
                                        <option value="L">19:00~20:00</option>
                                        <option value="M">20:00~21:00</option>
                                    </select>

                                </div>

                                <div class="form-group box">
                                    <button class="btn btn-info" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">查看編號對應</button>
                                    <button type="submit" class="btn btn-primary btn-block">送出</button>
                                </div>
                            </form>
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
        $("#randomBtn").click(function () {
            randomChoose();
        });

        function randomChoose() {
            var upperBound = $("#seatSelector").children().length-1
            var number = 1 + Math.floor(Math.random() * upperBound);
            $("#seatSelector").val(number);
            console.log(number);
        };

        $("#seatSelector").on("change", function() {
            $("#seatSelector option:selected").each(function () {
                console.log($(this).val());
                $("#dateSelector").attr("disabled", false);
                if($("#dateSelector").val() != "")
                    check_available();
            });
        });


        $("#dateSelector").on("change", function() {
            console.log($(this).val());
            check_available();

        });

        function check_available() {
            reset_period_option();

            $.ajax({
                url: "get_available_period_for_seat.php",
                data: "&seatNO="+$("#seatSelector").val()+"&date="+$("#dateSelector").val(),
                type:"POST",
                dataType:'text',

                success: function(response){
                    console.log(response);
                    var $response_arr = response.split(',');
                    console.log($response_arr);
                    if ($response_arr[0] == "F")
                    {
                        $("#periodSelector").prop('selectedIndex', 0);
                        $("#periodSelector").children("option:selected").html("該座位於該日期不開放");
                        $("#periodSelector").attr("disabled", true);
                    }
                    else if ($response_arr[0] == "S")
                    {
                        $("#periodSelector").prop('selectedIndex', 0);
                        $("#periodSelector").children("option:selected").html("選擇時段");
                        $("#periodSelector").attr("disabled", false);
                        $("#periodSelector option:first").attr("disabled", "disabled");

                        for (var i=1;i<$response_arr.length-1;i++)
                        {
                            $("#periodSelector option[value =" + $response_arr[i] + "]").attr("disabled", true);
                        }
                    }
                },
                error:   function(jqXHR, textStatus, errorThrown){
                    console.log(errorThrown);
                }
            });
        };

        function reset_period_option() {
            $("#periodSelector").children("option").attr("disabled", false);
        };



        $(function () {
            var date_now = new Date();


            var min_date = new Date(date_now.getTime() + 24 * 60 * 60 * 1000);
            var min_year = min_date.getFullYear();
            var min_month = min_date.getMonth() + 1;
            var min_day = min_date.getDate();


            min_month = min_month < 10 ? "0" + min_month : min_month;
            min_day = min_day < 10 ? "0" + min_day : min_day;


            $("#dateSelector").attr("min", min_year + "-" + min_month + "-" + min_day);


            var max_date = new Date(date_now.getTime() + 30 * 24 * 60 * 60 * 1000);
            var max_year = max_date.getFullYear();
            var max_month = max_date.getMonth() + 1;
            var max_day = max_date.getDate();


            max_month = max_month < 10 ? "0" + max_month : max_month;
            max_day = max_day < 10 ? "0" + max_day : max_day;


            $("#dateSelector").attr("max", max_year + "-" + max_month + "-" + max_day);

            if ($('#notifyBox').length > 0) {
                console.log("here");
                $('#notifyBox').delay(1000).slideUp(800);
            }

        });



    });



</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>
</body>
</html>