<?php


function signUp(){
    return '
    <div class="w-100 pe-2 mt-2 d-flex flex-column align-items-center justify-content-center">


        <div class="card mb-3">

            <div class="card-body text-dark">

                <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Create an Account</h5>
                    <p class="text-center small">Please sign up to get the course subscription...</p>
                </div>

                <form class="row g-3 needs-validation" novalidate="" method="post" action="">

                    <div class="col-md-6">
                        <label for="firstName" class="form-label">First Name</label>
                        <input type="text" name="firstName" class="form-control" id="firstName" required="">
                        <div class="invalid-feedback">Please, enter your first name!</div>
                    </div>

                    <div class="col-md-6">
                        <label for="lastName" class="form-label">Last Name</label>
                        <input type="text" name="lastName" class="form-control" id="lastName" required="">
                        <div class="invalid-feedback">Please, enter your last name!</div>
                    </div>

                    <div class="col-md-6">
                        <label for="yourEmail" class="form-label">Your Email</label>
                        <input type="email" name="email" class="form-control" id="yourEmail" required="">
                        <div class="invalid-feedback">Please enter a valid Email address!</div>
                    </div>

                    <div class="col-md-6">
                        <label for="yourUsername" class="form-label">Username</label>
                        <div class="input-group has-validation">
                            <span class="input-group-text" id="inputGroupPrepend">@</span>
                            <input type="text" name="username" class="form-control" id="yourUsername" required="">
                            <div class="invalid-feedback">Please choose a username.</div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="yourPassword" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" id="yourPassword" required="">
                        <div class="invalid-feedback">Please enter your password!</div>
                    </div>

                    <div class="col-md-6">
                        <label for="confirmPassword" class="form-label">Confirm Password</label>
                        <input type="password" name="confirmPassword" class="form-control" id="confirmPassword" required="">
                        <div class="invalid-feedback">Renter the same password!</div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-check">
                            <input class="form-check-input" name="terms" type="checkbox" value="" id="acceptTerms" required="">
                            <label class="form-check-label" for="acceptTerms">I agree and accept the <a href="#">terms and conditions</a></label>
                            <div class="invalid-feedback">You must agree before submitting.</div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <button class="btn btn-primary w-100" type="submit">Create Account</button>
                    </div>
                    <div class="col-md-12">
                        <p class="small mb-0">Already have an account? <a href="./">Log in</a></p>
                    </div>
                </form>

            </div>
        </div>

    </div>
';
}

function paypal(){
    return '
    <div class="w-100 mt-5 d-flex flex-column align-items-center justify-content-center">


        <div class="card mb-3">

            <div class="card-body text-dark">

                <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Buy Course</h5>
                    <p class="text-center small">Please buy this course to proceed...</p>
                </div>

                <form >
                    <div class="col-md-12">
                        <button class="btn btn-warning w-100 ">
                        <i class="ri-paypal-fill"></i>
                        Buy Now
                        </button>
                    </div>
                </form>

            </div>
        </div>

    </div>
';
}

function PasswordProtected(){
    return '
    <div class="w-100 mt-5 d-flex flex-column align-items-center justify-content-center">
        <div class="card mb-3">
            <div class="card-body text-dark">
                <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">
                    <i class="bi bi-key-fill me-2"></i> Password Protected
</h5>
                    <p class="text-center small">Please enter password to unlock...</p>
                    <form action="">
                        <div class="form-floating mb-3">
                          <input type="password" class="form-control" id="floatingPassword" placeholder="Password">
                          <label for="floatingPassword">Password</label>
                        </div>
                        <div class="col-md-12">
                            <button class="btn btn-outline-dark w-100 ">
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
?>