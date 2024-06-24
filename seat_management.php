<?php
require("check_admin_login.php");
require("connectDB.php");
$sql = "SELECT NO From Seat";
$seatList_result = mysqli_query($db_link, $sql);

$title = "seat_management";
require("html_header.php");
?>


<body>

<?php
require("admin_nav.php");
?>

<div class="pt-5 pb-5 mt-0 align-items-center d-flex bg-dark background">
    <div class="container-fluid ">
        <div class="row  justify-content-center align-items-center d-flex-row text-center h-100">
            <div class="col-12 col-md-4 col-lg-3 h-50">
                <div class="card shadow">
                    <div class="login-box">
                        <div class="card-body mx-auto ">
                            <h4 class="card-title mt-3 text-center">管理座位資訊</h4>

                            <?php
                            if(isset($_GET["msg"])){
                                if ($_GET["msg"]=="success") {?>
                                    <div class="alert alert-success" role="alert" id="notifyBox">
                                        修改座位資訊成功!!!
                                    </div>
                                <?php }else {?>
                                    <div class="alert alert-danger" role="alert" id="notifyBox">
                                        <?php if($_GET["msg"]=="failed0") { ?>
                                            所有欄位不能為空!!!
                                        <?php } elseif ($_GET["msg"]=="failed1"){?>
                                            修改失敗，該座位不存在!
                                        <?php } ?>
                                    </div>
                                <?php } ?>
                            <?php } ?>

                            <form method="post" action="update_info_for_seat.php">
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


                                <div class="form-group input-group box inputbox_top_margin" style="margin-top: 10px">
                                    <h5 style="display: flex; align-items: center; margin-right: 5px; ">是否有插座:</h5>
                                    <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" style="margin-top: 6px" id="socketSelector" name="having_socket" required>
                                        <option value="" selected disabled >未知</option>
                                        <option value="1" >是</option>
                                        <option value="0" >否</option>
                                    </select>
                                </div>

                                <div class="form-group input-group box inputbox_top_margin" style="margin-top: 10px" >
                                    <h5 style="display: flex; align-items: center; margin-right: 5px; ">是否有電腦:</h5>
                                    <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" style="margin-top: 6px" id="computerSelector" name="having_computer" required>
                                        <option value="" selected disabled>未知</option>
                                        <option value="1">是</option>
                                        <option value="0">否</option>
                                    </select>
                                </div>

                                <div class="form-group input-group box inputbox_top_margin" style="margin-top: 10px">
                                    <h5 style="display: flex; align-items: center; margin-right: 5px; ">是否有檯燈:</h5>
                                    <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" style="margin-top: 6px id=" id="lampSelector" name="having_lamp" required>
                                        <option value="" selected disabled>未知</option>
                                        <option value="1">是</option>
                                        <option value="0">否</option>
                                    </select>
                                </div>


                                <div class="form-group box inputbox_top_margin">
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
        <h5 id="offcanvasRightLabel">座位編號對應表</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <img src="image\seat_layout_numbered.jpg" style="min-width: 60%; height: auto">
    </div>
</div>

<script>
    $(document).ready(function () {

        $("#seatSelector").on("change", function() {
            $("#seatSelector option:selected").each(function () {
                console.log($(this).val());
                $.ajax({
                    url: "get_seat_info.php",
                    data: "&seatNO="+$("#seatSelector").val(),
                    type:"POST",
                    dataType:'text',

                    success: function(response){
                        console.log(response);
                        let $response_arr = response.split(",");
                        if ($response_arr[0]==="S")
                        {
                            $("#socketSelector").val($response_arr[1]);
                            $("#computerSelector").val($response_arr[2]);
                            $("#lampSelector").val($response_arr[3]);
                        }
                        else ($response_arr[0]==="F")
                        {
                            console.log($response_arr[0]);
                        }


                    },
                    error:   function(jqXHR, textStatus, errorThrown){
                        console.log(errorThrown);
                    }
                });
            });
        });

        $(function () {
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