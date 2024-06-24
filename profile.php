<?php
require("check_normal_login.php");
require("connectDB.php");

$sql = "SELECT * From User where account = '".$_SESSION["account"]."'";
$result = mysqli_query($db_link, $sql);
$item = mysqli_fetch_assoc($result);

$title = "profile";
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
                            <h4 class="card-title mt-3 text-center">My Profile</h4>

                            <?php
                            if(isset($_GET["msg"])){
                                if ($_GET["msg"]=="success") {?>
                                    <div class="alert alert-success" role="alert" id="notifyBox">
                                        修改成功!!!
                                    </div>
                                <?php }else if($_GET["msg"]=="failed"){?>
                                    <div class="alert alert-danger" role="alert" id="notifyBox">
                                        名字和email欄位不能為空!!!
                                    </div>
                                <?php }
                            }?>

                            <form method="POST" action="update_profile.php">
                                <div class="form-group input-group box">
                                    <img class="icon" src="icon\user.png" alt="Icon">
                                    <input name="account" class="form-control" placeholder="account" type="text" value= "<?php echo $_SESSION["account"] ?>" required disabled>
                                </div>
                                <div class="form-group input-group box inputbox_top_margin">
                                    <img class="icon" src="icon\password.png" alt="Icon">
                                    <input name="password" class="form-control" placeholder="password" type="text" id="passwordInput" value= "" required disabled>
                                    <button class="btn btn-danger" type="button" id="editButton">Edit</button>
                                </div>
                                <div class="form-group input-group box inputbox_top_margin">
                                    <img class="icon" src="icon\name.png" alt="Icon">
                                    <input name="name" class="form-control" placeholder="name" type="text" value= "<?php echo $item["name"] ?>" required>
                                </div>
                                <div class="form-group input-group box inputbox_top_margin">
                                    <img class="icon" src="icon\email.png" alt="Icon">
                                    <input name="email" class="form-control" placeholder="email" type="email" value= "<?php echo $item["email"] ?>" required>
                                </div>
                                <div class="form-group box">
                                    <button type="submit" class="btn btn-primary btn-block">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    $(document).ready(function () {
        $("#editButton").click(function () {
            $("#passwordInput").attr("disabled", false);
            $("#passwordInput").attr("type", "text");
            $("#editButton").attr("disabled", true);
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
