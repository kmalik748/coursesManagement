<?php

require_once "includes/app.php";
require_once "includes/functions.php";
$path = ROOT_DIR;
if(isset($_POST["login"])){
    $email = sanitizeParam($_POST["username"]);
    $pass = md5(sanitizeParam($_POST["password"]));
    $s = "SELECT * FROM users WHERE (email='$email' OR username='$email') AND password='$pass'";
//    echo $s; exit(); die();
    $qry = mysqli_query($con, $s);
    if(mysqli_num_rows($qry)>0){
        $email = sanitizeParam($_POST["username"]);
        $row = mysqli_fetch_array($qry);

        if($row["verified"]==0){
            redirect('index.php?notVerified=failed');
        }

        $_SESSION["userID"] = $row["id"];
        $_SESSION["firstName"] = $row["firstname"];
        $_SESSION["fullName"] = $row["firstname"].' '.$row["lastname"];
        $_SESSION["role"] = $row["type"];
        $_SESSION["email"] = $row["email"];
        if($row["type"]=="Admin"){
            redirect('adminDashboard.php');
        }
        if($row["type"]=="Instructor"){
            redirect('instructorDashboard.php');
        }
        if($row["type"]=="Student"){
            redirect('studentDashboard.php');
        }
//        header('Location: instructorDashboard.php');
    }else{
        redirect('index.php?login=failed');
    }

}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $title = "Login"." | TeachMe How";
    require "includes/head.inc.php";
    ?>
</head>

<body>

  <main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                <?php if(isset($_GET["accountCreated"])){ ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <h4 class="alert-heading">Account Created</h4>
                            <p>Your account was created successfully. To begin using the platform, please check your email for further instructions. If the email is not in your inbox, check the spam/junk folders.</p>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                <?php } ?>
                <?php if(isset($_GET["verified"])){ ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <h4 class="alert-heading">Account Verified!</h4>
                            <p>Congratulations! Your account was verified successfully! Please login to continue..</p>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                <?php } ?>
                <?php if(isset($_GET["reset"])){ ?>
                    <div class="alert alert-success d-flex align-items-center" role="alert">
                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"></use></svg>
                        <div>
                            <b>Welcome Back!</b> Your password was reset successfully!
                        </div>
                    </div>
                <?php } ?>
                <?php if(isset($_GET["sessionOut"])){ ?>
                    <div class="alert alert-warning d-flex align-items-center" role="alert">
                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"></use></svg>
                        <div>
                            <b>Session Out!</b> Plese login again to continue..!
                        </div>
                    </div>
                <?php } ?>
                <?php if(isset($_GET["login"]) && $_GET["login"]=="failed"){ ?>
                    <div class="alert alert-danger d-flex align-items-center" role="alert">
                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"></use></svg>
                        <div>
                            <b>Login Failed!</b> Invalid email or password! Please try again.
                        </div>
                    </div>
                <?php } ?>
                <?php if(isset($_GET["notVerified"])){ ?>
                    <div class="alert alert-warning d-flex align-items-center" role="alert">
                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"></use></svg>
                        <div>
                            <b>Verification Required!</b> You need to verify your account in order to proceed. Please check your mailbox.
                        </div>
                    </div>
                <?php } ?>

              <div class="d-flex justify-content-center">
                <a href="<?=$path?>" class="logo d-flex align-items-center w-auto">
                  <img src="assets/img/logo_top.png" alt="" style="max-height: 80px;">
                  <span class="d-none d-lg-block fw-bolder d-flex align-items-center justify-content-center flex-column">
                      <p>Teach me</p>
                      <p >How</p>
                  </span>
                </a>
              </div><!-- End Logo -->

              <div class="card mb-3">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
                    <p class="text-center small">Enter your username & password to login</p>
                  </div>

                  <form class="row g-3 needs-validation1" novalidate action="" method="post">

                    <div class="col-12">
                      <label for="yourUsername" class="form-label">Email/Username</label>
                      <div class="input-group has-validation">
                        <span class="input-group-text" id="inputGroupPrepend">@</span>
                        <input type="text" name="username" class="form-control" id="yourUsername" required>
                        <div class="invalid-feedback">Please enter your username.</div>
                      </div>
                    </div>

                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Password</label>
                      <input type="password" name="password" class="form-control" id="yourPassword" required>
                      <div class="invalid-feedback">Please enter your password!</div>
                    </div>

                    <div class="col-12">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" value="true" id="rememberMe">
                        <label class="form-check-label" for="rememberMe">Remember me</label>
                      </div>
                    </div>
                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit" id="submitBtn1" name="login">Login</button>
                    </div>
                    <div class="col-12">
                      <p class="small mb-0">Don't have account? <a href="register.php">Create an account</a></p>
                      <p class="small mb-0">Forgot Password? <a href="forgetPass.php">Reset Your Password Now</a></p>
                    </div>
                  </form>

                </div>
              </div>

            </div>
          </div>
        </div>

      </section>

    </div>
  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/quill/quill.min.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/chart.js/chart.min.js"></script>
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>
  <script src="assets/vendor/jquery/jquery.min.js"></script>


  <script>
      var needsValidation = document.querySelectorAll('.needs-validation1')

      Array.prototype.slice.call(needsValidation)
          .forEach(function(form) {
              form.addEventListener('submit', function(event) {
                  if (!form.checkValidity()) {
                      event.preventDefault()
                      event.stopPropagation()
                      $('#submitBtn1').text("Login");
                  }

                  form.classList.add('was-validated')
              }, false)
          })

      $('#submitBtn1').on('click', function() {
          var $this = $(this);
          var loadingText = '<div class="spinner-border text-light" role="status"></div>';
          if ($(this).html() !== loadingText) {
              $this.data('original-text', $(this).html());
              $this.html(loadingText);
          }
      });
  </script>

</body>

</html>