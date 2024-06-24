<?php
require("check_admin_login.php");
require("connectDB.php");
require("period_module.php");
$index  = 1;


$sql1 = "SELECT *, User.name as name From Reservation, User WHERE account = user_account  AND (  date <= CURRENT_DATE() OR status != 'reserved' ) ORDER BY date DESC";
$pre_recordList_result = mysqli_query($db_link, $sql1);

$sql2 = "SELECT *, User.name as name From Reservation, User  WHERE account = user_account  AND ( date > CURRENT_DATE() AND status = 'reserved' ) ORDER BY date DESC";
$future_recordList_result = mysqli_query($db_link, $sql2);


$title = "record_management";
require("html_header.php");
?>

<body>

<?php
require("admin_nav.php");
?>

<div class="pt-5 pb-5 mt-0 align-items-center d-flex bg-dark background" >


    <div class="container-fluid ">
        <div class="row  justify-content-center align-items-center d-flex-row text-center h-100">
            <div class="col-12 col-md-8 col-lg-7 h-50">
                <div class="card shadow">
                    <div class="login-box">
                        <div class="card-body mx-auto ">
                            <h4 class="card-title mt-3 text-center">管理座位</h4>
                            <table class="table table-striped  table-info table-hover table-bordered border-dark">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">日期</th>
                                    <th scope="col">時段</th>
                                    <th scope="col">帳號</th>
                                    <th scope="col">座位</th>
                                    <th scope="col">租借人姓名</th>
                                    <th scope="col">狀態</th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php
                                while ($row_result = mysqli_fetch_assoc($future_recordList_result))
                                {
                                    ?>
                                    <tr>
                                        <th scope="row"><?php echo $index; $index+=1; ?></th>
                                        <td><?php echo $row_result["date"];?></td>
                                        <td><?php echo $periodTranslator[$row_result["period"]];?></td>
                                        <td><?php echo $row_result["account"];?></td>
                                        <td><?php echo $row_result["seat_NO"];?></td>
                                        <td><?php echo $row_result["name"];?></td>
                                        <td><?php echo $row_result["status"];?></td>
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
                                        <td><?php echo $row_result["account"];?></td>
                                        <td><?php echo $row_result["seat_NO"];?></td>
                                        <td><?php echo $row_result["name"];?></td>
                                        <td><?php echo $row_result["status"];?></td>

                                    </tr>
                                    <?php
                                }
                                ?>





                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>
</body>
</html>
