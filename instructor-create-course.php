<?php
    require_once "includes/app.php";
validateSession();
    require_once "includes/functions.php";
    $path = ROOT_DIR;
    if(isset($_POST["createCourse"])){
        $course_title = sanitizeParam($_POST["course_title"]);
        $courseID = sanitizeParam($_POST["courseID"]);
        $access_type = sanitizeParam($_POST["access_type"]);
        $timeLimit = sanitizeParam($_POST["timeLimit"]);
        $timeLimitValue = sanitizeParam($_POST["timeLimitValue"]);
        $reg_req_email = isset($_POST["reg_req_email"]) ? 1 : 0;
        $reg_req_phone = isset($_POST["reg_req_phone"]) ? 1 : 0;
        $reg_req_address = isset($_POST["reg_req_address"]) ? 1 : 0;
        $reg_req_tos = isset($_POST["reg_req_tos"]) ? 1 : 0;
        $price = sanitizeParam($_POST["price"]);
        $paypal_email = sanitizeParam($_POST["paypal_email"]);
        $instructor_name = sanitizeParam($_POST["instructor_name"]);
        $course_description = sanitizeParam($_POST["course_description"]);
        $aboutInstructor = sanitizeParam($_POST["aboutInstructor"]);
        $fancy_title = sanitizeParam($_POST["fancy_title"]);
        $currency = sanitizeParam($_POST["currency"]);
        $coursePassword = $_POST["coursePassword"]=="" ? null : $_POST["coursePassword"];
//        echo json_encode($_POST); exit(); die();
        $instructorPicture = "default.jpg";

        $website = sanitizeParam($_POST["website"]);
        $facebook = sanitizeParam($_POST["facebook"]);
        $insta = sanitizeParam($_POST["insta"]);
        $linkedin = sanitizeParam($_POST["linkedin"]);

        $sql = mysqli_query($con,"SELECT * FROM courses WHERE courseID='$courseID'");
        $sql = mysqli_fetch_assoc($sql);
        if  (mysqli_num_rows($sql)) {
            echo '<script>alert("Course Link Already Exists!")';
            redirect('instructor-create-course.php');
        }

        if($access_type=="Free"){
            $timeLimitValue = $timeLimitValue = $reg_req_tos = $reg_req_address = $reg_req_phone = $reg_req_email = $paypal_email = 0;
            $price = 0;
        }
        if($access_type=="Registration"){
            $paypal_email = 0;
            $price = 0;
        }
        if($access_type=="Paid"){
            $timeLimitValue = $timeLimitValue = $reg_req_tos = $reg_req_address = $reg_req_phone = $reg_req_email = 0;
        }

        if (empty($_FILES['instructorPictureUpload']['name'])) {
        }
        else{
            $target_dir = "assets/img/instructorPic/";
            $target_file = $target_dir . basename($_FILES["instructorPictureUpload"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            // Check file size
            if ($_FILES["bottomLogo"]["size"] > 10000000) {
                $uploadErrMsg = "Sorry, your file is too large.";
                $uploadOk = 0;
            }
            if (strtolower($imageFileType) == "php" || strtolower($imageFileType) == "php5" ||
                strtolower($imageFileType) == "shtml" || strtolower($imageFileType) == "php3"
                || strtolower($imageFileType) == "php4" || strtolower($imageFileType) == "php5") {
                $uploadErrMsg = "Sorry, this file extension could not be uploaded!.";
                $uploadOk = 0;
            }

            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                echo "<script>alert('".$uploadErrMsg."');</script>";
            } else {
                if (move_uploaded_file($_FILES["instructorPictureUpload"]["tmp_name"], $target_file)) {
                    $instructorPicture = $_FILES["instructorPictureUpload"]["name"];
                } else {
                    echo "<script>alert('Sorry, there was an error uploading your file.');</script>";
                }
            }
        }

        $instructorID = $_SESSION["userID"];

        $s = "INSERT INTO courses (instructor_id, title, fancy_title, access, description, courseID,timeLimitType, timeLimitValue, registration_required_email,registration_required_phone,
                     registration_required_address,registration_required_tos, price, paypal_email,instructor_name, coursePassword, aboutInstructor, instructorPicture,
                     instructur_website, instructur_insta, instructur_facebook, instructur_linkedin, currency)
             VALUES
            ($instructorID, '$course_title', '$fancy_title', '$access_type', '$course_description','$courseID', '$timeLimit', $timeLimitValue, $reg_req_email, $reg_req_phone,$reg_req_address,
             $reg_req_tos, $price, '$paypal_email', '$instructor_name', '$coursePassword', '$aboutInstructor', '$instructorPicture', '$website', '$insta', '$facebook', '$linkedin', '$currency')";

//        echo $s; exit(); die();
        if(!mysqli_query($con, $s)){
            echo mysqli_error($con); exit(); die();
        }
        $newID = mysqli_insert_id($con);
        header('Location: instructor-view-course.php?courseID='.$newID);
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $title = "Create Course"." | TeachMe How";
        require "includes/head.inc.php";
    ?>
</head>

<body>

  <!-- ======= Header ======= -->
    <?=require_once "includes/header.inc.php";?>
  <!-- End Header -->

  <?php
  if($_SESSION["role"]=="Admin"){
      require_once "includes/adminSideBar.inc.php";
  }
  if($_SESSION["role"]=="Instructor"){
      require_once "includes/instructorSideBar.inc.php";
  }
  if($_SESSION["role"]=="Student"){
      require_once "includes/studentSideBar.inc.php";
  }
  ?>

  <main id="main" class="main">

      <div class="pagetitle">
          <h1>Create New Course</h1>
          <nav>
              <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="<?=ROOT_DIR?>instructorDashboard.php">Dashboard</a></li>
                  <li class="breadcrumb-item">Create New Course</li>
              </ol>
          </nav>
      </div><!-- End Page Title -->

      <section class="section">
          <div class="row justify-content-center">
              <div class="col-lg-12">

                  <div class="card">
                      <div class="card-body">
                          <h5 class="card-title">Enrolling a new course</h5>

                          <!-- Floating Labels Form -->
                          <form class="row g-3" action="" method="post" enctype="multipart/form-data">
                              <div class="col-md-6">
                                  <label for="courseTitle" class="form-label">Course Title</label>
                                  <input type="text" class="form-control" id="courseTitle" name="course_title" required>
                              </div>
                                <div class="col-md-12 mt-3">
                                    <label for="inputNanme4" class="form-label">Customize your title here</label>
                                    <textarea class="tinymce-editor-small" style="height: 20px;" name="fancy_title" id="fancyTitle">
                                      <h3><strong><em>Course Description here....</em></strong></h3>
                                    </textarea>
                                </div>
                              <div class="col-md-6">
                                  <label for="inputNanme4" class="form-label">Link to the course publication</label>
                                  <div class="input-group mb-3">
                                      <span class="input-group-text" id="basic-addon3">https://teachmehow.me/course-</span>
                                      <input type="text" name="courseID" class="form-control" value="<?=rand()?>">
                                  </div>
                              </div>
                              <h5 class="card-title">Payment Settings</h5>
                              <div class="col-md-12 d-flex align-items-center">
                                  <p class="mb-0 me-2">Payment Settings And Course Access</p>

                                  <input type="radio" class="btn-check" name="access_type" id="option1" autocomplete="off" checked value="Free">
                                  <label class="btn btn-outline-success me-2" for="option1">
                                      <i class="ri-book-open-line me-2"></i>Free
                                  </label>

                                  <input type="radio" class="btn-check" name="access_type" id="option2" autocomplete="off" value="Registration">
                                  <label class="btn btn-outline-success me-2" for="option2">
                                      <i class="ri-login-box-fill me-2"></i>Registration
                                  </label>

                                  <input type="radio" class="btn-check" name="access_type" id="option3" autocomplete="off" value="Paid">
                                  <label class="btn btn-outline-success me-2" for="option3">
                                      <i class="ri-paypal-fill me-2"></i>Paid
                                  </label>

                                  <input type="radio" class="btn-check" name="access_type" id="option4" autocomplete="off" value="Password">
                                  <label class="btn btn-outline-success me-2" for="option4">
                                      <i class="ri-key-2-fill me-2"></i>Password
                                  </label>
                              </div>
                              <div id="registration" class="row">
                                  <div class="col-md-4 mt-2">
                                      <p>Time Limit for students</p>
                                      <div class="input-group mb-3">
                                          <select class="form-select" id="selectTimeLimitFactor" name="timeLimit">
                                              <option value="Without Time Limit" selected>Without Time Limit</option>
                                              <option value="Days">Days</option>
                                              <option value="Months">Months</option>
                                              <option value="Years">Years</option>
                                          </select>
                                          <input type="text" class="form-control" id="timeLimitValueId" value="0" name="timeLimitValue">
                                      </div>
                                  </div>
                                  <div class="col-md-9">
                                      <div class="row mb-3">
                                          <legend class="col-form-label col-sm-2 pt-0">Registration form fields</legend>
                                          <div class="col-sm-8">

                                              <div class="form-check">
                                                  <input name="reg_req_email" class="form-check-input" type="checkbox" id="gridCheck1" checked="">
                                                  <label class="form-check-label" for="gridCheck1">
                                                      Email
                                                  </label>
                                              </div>

                                              <div class="form-check">
                                                  <input name="reg_req_phone" class="form-check-input" type="checkbox" id="gridCheck2" checked="">
                                                  <label class="form-check-label" for="gridCheck2">
                                                      Phone Number
                                                  </label>
                                              </div>

                                              <div class="form-check">
                                                  <input name="reg_req_address" class="form-check-input" type="checkbox" id="gridCheck2" checked="">
                                                  <label class="form-check-label" for="gridCheck2">
                                                      Address
                                                  </label>
                                              </div>

                                              <div class="form-check">
                                                  <input name="reg_req_tos" class="form-check-input" type="checkbox" id="gridCheck2" checked="">
                                                  <label class="form-check-label" for="gridCheck2">
                                                      Terms of use and services
                                                  </label>
                                              </div>

                                          </div>
                                      </div>
                                  </div>
                              </div>
                              <div id="paid" class="row mt-2">
                                  <div class="col-md-4">
                                      <label for="inputNanme4" class="form-label">Price</label>
                                      <input type="number" class="form-control" id="inputNanme4" name="price" value="0">
                                  </div>
                                  <div class="col-md-4">
                                      <label for="inputNanme4" class="form-label">Paypal Client ID</label>
                                      <input type="text" class="form-control" id="inputNanme4" name="paypal_email" value="AUV9WUKaXyoFG7UN6rgBt-NKkSJWJHUxKSxbfq6g97mJglHj8rrOcSJJHgvGOgaVQ-dARLQOKm0cBuQ3">
                                  </div>
                                  <div class="col-md-4">
                                      <label for="validationTooltip04" class="form-label">Currency</label>
                                      <select class="form-select" id="validationTooltip04" name="currency">
                                          <option value="USD" selected>United States dollar</option>
                                          <option value="AUD">Australian dollar</option>
                                          <option value="BRL">Brazilian real</option>
                                          <option value="CAD">Canadian dollar</option>
                                          <option value="CNY">Chinese Renmenbi</option>
                                          <option value="DKK">Danish krone</option>
                                          <option value="EUR">Euro</option>
                                          <option value="JPY">Japanese yen</option>
                                          <option value="MYR">Malaysian ringgit</option>
                                          <option value="MXN">Mexican peso</option>
                                          <option value="TWD">New Taiwan dollar</option>
                                          <option value="NZD">New Zealand dollar</option>
                                          <option value="PHP">Philippine peso</option>
                                          <option value="GBP">Pound sterling</option>
                                          <option value="RUB">Russian ruble</option>
                                          <option value="SGD">Singapore dollar</option>
                                          <option value="SEK">Swedish krona</option>
                                      </select>
                                      <div class="invalid-tooltip">
                                          Please select a valid state.
                                      </div>
                                  </div>
                              </div>
                              <div id="Password" class="row mt-2">
                                  <div class="col-md-12">
                                      <label for="inputNanme4" class="form-label">Course Password</label>
                                      <input type="password" name="coursePassword" class="form-control w-50" id="inputNanme4">
                                  </div>
                              </div>


                              <h5 class="card-title">About Course</h5>
                              <div class="col-md-6">
                                  <label for="inputNanme4" class="form-label">Instructor Name</label>
                                  <input type="text" name="instructor_name" class="form-control" id="inputNanme4" value="<?=$_SESSION["fullName"]?>">
                              </div>
                              <div class="col-md-6">
                                  <div class="row mb-3">
                                      <label for="inputNumber" class="">Instructor Picture</label>
                                      <div class="col-sm-10">
                                          <input class="form-control" type="file" id="formFile" name="instructorPictureUpload">
                                      </div>
                                  </div>
                              </div>
                              <div class="col-sm-12 col-md-6">
                                  <label for="inputAddress5" class="form-label">About Instructor <i>(40 words)</i></label>
                                  <textarea class="form-control w-100" rows="3" name="aboutInstructor"></textarea>
                              </div>


                              <input type="hidden" name="course_description" value="">
<!--                              <div class="col-md-12 mt-3">-->
<!--                                  <textarea class="tinymce-editor" name="course_description">-->
<!--                                    <h3><strong><em>Course Description here....</em></strong></h3>-->
<!--                                  </textarea>-->
<!--                              </div>-->

                              <h5 class="card-title">Social Media Links</h5>
                              <div class="row">
                                  <div class="col-md-6">
                                      <label for="inputNanme4" class="form-label">Instructor' Website</label>
                                      <input type="text" name="website" class="form-control" id="inputNanme4">
                                  </div>
                                  <div class="col-md-6">
                                      <label for="inputNanme4" class="form-label">Instructor' Facebook</label>
                                      <input type="text" name="facebook" class="form-control" id="inputNanme4">
                                  </div>
                                  <div class="col-md-6">
                                      <label for="inputNanme4" class="form-label">Instructor' Instagram</label>
                                      <input type="text" name="insta" class="form-control" id="inputNanme4">
                                  </div>
                                  <div class="col-md-6">
                                      <label for="inputNanme4" class="form-label">Instructor' LinkedIn</label>
                                      <input type="text" name="linkedin" class="form-control" id="inputNanme4">
                                  </div>
                              </div>


                              <div class="row justify-content-center">
                                  <div class="col-md-6">
                                      <button name="createCourse" type="submit" class="btn btn-primary w-100 mt-3 rounded-pill" id="submitBtn">
                                          <i class="bi bi-plus-circle-fill mr-2"></i>
                                          Create Course
                                      </button>
                                  </div>
                              </div>
                          </form>

                      </div>
                  </div>

              </div>
          </div>
      </section>
  </main><!-- End #main -->


  <?=require_once "includes/footer.inc.php";?>


  <script src="assets/vendor/jquery/jquery.min.js"></script>
  <script>
      $('#courseTitle').on('input',function(e){

          tinymce.activeEditor.setContent($('#courseTitle').val());
      });
      $("#registration").hide();
      $("#paid").hide();
      $("#Password").hide();
      $("input#timeLimitValueId").hide();
      $('input[type=radio][name=access_type]').change(function() {
          if (this.value == 'Free') {
              $("#registration").hide();
              $("#paid").hide();
          }
          else if (this.value == 'Registration') {
              $("#registration").show();
              $("#paid").hide();
          }
          else if (this.value == 'Paid') {
              $("#registration").hide();
              $("#paid").show();
          }
          else if (this.value == 'Password') {
              $("#registration").hide();
              $("#paid").hide();
              $("#Password").show();
          }
      });
      $('#selectTimeLimitFactor').change(function() {
          if($(this).val()==="Days" || $(this).val()==="Months" || $(this).val()==="Years"){
              $("input#timeLimitValueId").show();
          }else{
              $("input#timeLimitValueId").hide();
          }
      });

      $('#submitBtn').on('click', function() {
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