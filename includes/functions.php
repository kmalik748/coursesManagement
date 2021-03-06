<?php


function signUp($courseRow){
    $courseID = $courseRow["id"];
    return '
    <div class="w-100 pe-2 mt-2 d-flex flex-column align-items-center justify-content-center">
        <div class="card mb-3">
            <div class="card-body text-dark">
                <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Create an Account</h5>
                    <p class="text-center small">Please sign up to get the course subscription...</p>
                </div>
                <form class="row g-3 needs-validation" novalidate="" method="post" action="register.php">
                    <input type="hidden" name="courseID" value="'.$courseID.'">
                    <div class="col-md-6">
                      <div class="form-floating">
                        <input type="text" class="form-control" id="floatingEmail" placeholder="Name" name="firstName">
                        <label for="floatingEmail">Your Name</label>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-floating">
                        <input type="text" class="form-control" id="floatingEmail" placeholder="Email" name="email">
                        <label for="floatingEmail">Email</label>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-floating">
                        <input type="text" class="form-control" id="floatingEmail" placeholder="Username" name="username">
                        <label for="floatingEmail">Username</label>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-floating">
                        <input type="password" class="form-control" id="floatingEmail" placeholder="Password" name="password">
                        <label for="floatingEmail">Password</label>
                      </div>
                    </div>
                    <input type="hidden" name="options" value="Student">
                    
                    <div class="col-md-6">
                        <button class="btn btn-primary w-100" type="submit" name="signUp" id="submitBtn">Create Account</button>
                    </div>
                    <div class="col-md-6 d-flex justify-content-center align-items-center">
                        <p class="small mb-0">Already have an account? <a href="./">Log in</a></p>
                    </div>
                </form>

            </div>
        </div>

    </div>
';
}

function paypal($course){
    $price = $course["price"];
    $courseID = $course["id"];
    $currency = $course["currency"];
    if(isset($_SESSION["discountAmount"])){
        $line = '<p class="text-center small text-muted" style="font-size: larger;font-weight: bolder;"><del style="text-decoration-thickness: 3px;">'.$price.'</del> '.$_SESSION["discountAmount"].' '.$currency.'</p>';
    }else{
        $line = '<p class="text-center small text-muted" style="font-size: larger;">'.$price.' '.$currency.'</p>';
    }
    $a = '
    <div class="w-100 mt-5 d-flex flex-column align-items-center justify-content-center">

    <div class="w-100 container">
    <div class="card mb-3">
            <div class="card-body text-dark">

                <div class="pt-4 pb-2">
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <h5 class="card-title text-center pb-0 fs-4">Buy This Course</h5>
                       '.$line.'
                        <form>
                                <div class="form-floating mb-3">
                                  <input type="text" class="form-control" id="PaypalEmail" placeholder="Enter your email">
                                  <label for="PaypalEmail">Enter your email</label>
                                </div>
                            <div class="col-md-12">
                                <div id="paypal-button-container"></div>
                            </div>
                        </form>
                    </div>
                </div>
                <hr>
                <span class="small mb-0 d-flex justify-content-center">Have a coupon? <button type="button" class="bg-transparent border-0 text-primary" data-bs-toggle="modal" data-bs-target="#couponModal">Apply Coupon</button></span>
                <p class="small mb-0 text-center">Already Purchased? <a href="./">Log in</a></p>

            </div>
        </div>
    </div>

        

    </div>
    
    <div class="modal fade" id="couponModal" tabindex="-1">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header bg-dark text-white">
                      <h5 class="modal-title"> Apply Coupon</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post">
                            <input type="hidden" name="courseID" value="'.$courseID.'">
                            <div class="form-floating mb-3">
                                  <input type="text" class="form-control" name="email" placeholder="Enter your email" required>
                                  <label for="PaypalEmail">Enter your email</label>
                                </div>
                            <div class="form-floating mb-3">
                              <input type="text" name="coupon" class="form-control" placeholder="Enter Coupon" required>
                              <label for="PaypalEmail">Enter Coupon</label>
                            </div>
                            <button type="submit" name="applyCoupon" class="w-100 btn btn-dark">Apply</button>
                        </form>
                    </div>
                  </div>
                </div>
              </div>
';

    return $a;
}

function PasswordProtected($courseRow){
    $price = $courseRow["price"];
    return '
    <div class="w-100 mt-5 d-flex flex-column align-items-center justify-content-center">
        <div class="card mb-3">
            <div class="card-body text-dark">
                <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">
                    <i class="bi bi-key-fill me-2"></i> Password Protected
</h5>
                    <p class="text-center small">Please enter password to unlock...</p>
                    <form action="" method="post">
                        <div class="form-floating mb-3">
                          <input type="password" class="form-control" id="floatingPassword"
                           placeholder="Password" name="coursePassValue">
                          <label for="floatingPassword">Password</label>
                        </div>
                        <div class="col-md-12">
                            <button class="btn btn-outline-dark w-100"
                            type="submit" name="unlockCourse_Pass">
                            <i class="bi bi-shield-lock me-2"></i>
                            Unlock
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
';
}

function loadPaypalScripts($courseRow){
    $api = $courseRow["paypal_client_api_key"];
    $price = $courseRow["price"];
    $courseID = $courseRow["id"];
    $currency = $courseRow["currency"];
    $a = "";
    if(isset($api) && !empty($api)){
        $a .= '<script src="https://www.paypal.com/sdk/js?client-id='.$api.'&currency='.$currency.'&disable-funding=credit,card"></script>';
    }else{
        $a .= '<script src="https://www.paypal.com/sdk/js?client-id=AUV9WUKaXyoFG7UN6rgBt-NKkSJWJHUxKSxbfq6g97mJglHj8rrOcSJJHgvGOgaVQ-dARLQOKm0cBuQ3&currency='.$currency.'&disable-funding=credit,card"></script>';
    }

    $a .= "
    ";

    return $a;
}

function limit_text($text, $limit) {
    if (str_word_count($text, 0) > $limit) {
        $words = str_word_count($text, 2);
        $pos   = array_keys($words);
        $text  = substr($text, 0, $pos[$limit]);
        $text .= '<button type="button" class="bg-transparent border-0 text-primary" data-bs-toggle="modal" data-bs-target="#aboutInstructorTextModal">....Read More</button>';
    }
    return $text;
}

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function sendMail($email, $subject, $body){
    $from = 'no-reply@teachmehow.me';

// To send HTML mail, the Content-type header must be set
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Create email headers
    $headers .= 'From: '.$from."\r\n".
        'Reply-To: '.$from."\r\n" .
        'X-Mailer: PHP/' . phpversion();

    $message = '<html><body>';
    $message .= $body;
    $message .= "<br><br>Regards,<br>TeachMeHow Team";
    $message .= '</body></html>';

// Sending email
    if(mail($email, $subject, $message, $headers)){
        return true;
    }else{
        echo 'Unable to send email. Please try again.';
        echo $email.'<br>';
        echo $subject.'<br>';
        echo $message.'<br>';
        exit();die();
    }
}

function redirect($addr){
    error_reporting(E_ALL | E_WARNING | E_NOTICE);
    ini_set('display_errors', TRUE);
    flush();

    echo '<script>window.location.replace("'.$addr.'");</script>';
    echo '<script>window.location("'.$addr.'");</script>';
}

function reformatLink($link){
    if (strpos($link, 'http://')!==false || strpos($link, 'https://')!==false) {
        return $link;
    }else{
        return 'https://'.$link;
    }
}
?>