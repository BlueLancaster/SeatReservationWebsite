<?php
session_start();
if(isset($_SESSION["role"]))
{
    if ($_SESSION["role"]=="normal")
        header('location: home_for_normal.php');
    else if ($_SESSION["role"]=="admin")
        header('location: home_for_admin.php');
}
$title = "login";
require("html_header.php");
?>



<body>
	<section class="pt-5 pb-5 mt-0 align-items-center d-flex bg-dark background">
	    <div class="container-fluid ">
	    	<img src="icon\logo.png" alt="Image" class="top-right-image">
	      	<div class="row  justify-content-center align-items-center d-flex-row text-center h-100">
		        <div class="col-12 col-md-4 col-lg-3 h-50">
					<div class="card shadow">
						<div class="login-box">
							<div class="card-body mx-auto ">
								<h4 class="card-title mt-3 text-center">登入系統</h4>

                                <?php
                                if(isset($_GET["error"])){
                                    if ($_GET["error"]=="1") {?>
                                    <div class="alert alert-danger" role="alert">
                                        密碼錯誤，請檢查!!!
                                    </div>
                                <?php }else if($_GET["error"]=="2"){?>
                                    <div class="alert alert-danger" role="alert">
                                        此帳號不存在，請檢查!!!
                                    </div>


                                    <?php }
                                }?>

								<form method="POST" action="logging.php">
									<div class="form-group input-group box">
									  <img class="icon" src="icon\user.png" alt="Icon">
									  <input name="account" class="form-control" placeholder="account" type="text">
									</div>
									<div class="form-group input-group box">
									  <img class="icon" src="icon\password.png" alt="Icon">
									  <input name="password" class="form-control" placeholder="password" type="password">
									</div>
									<div class="form-group box">
									  <button type="submit" class="btn btn-primary btn-block">Login</button>
									</div>

								</form>
							</div>
						</div>
					</div>
		        </div>
	      	</div>
	    </div>
	</section>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>
</body>
</html>
