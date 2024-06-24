<?php
require("check_admin_login.php");

$title = "home";
require("html_header.php");
?>

<body>

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
                            <h4 class="card-title mt-3 text-center"> <?php echo $_SESSION["account"] ?>  </h4>
                            <h4 class="card-title mt-3 text-center">歡迎回來!</h4>
                            <h4 class="card-title mt-3 text-center">親愛的管理員!</h4>
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
