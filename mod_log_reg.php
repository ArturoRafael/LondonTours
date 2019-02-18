<div class="cd-user-modal"> 
    <div class="cd-user-modal-container"> 
      <ul class="cd-switcher">
        <li><a href="#0">Login</a></li>
        <li><a href="#0">Registration</a></li>
      </ul>
<!----------------------------------- LOG IN Form --------------------------------------------->
      <div id="cd-login"> <!-- log in form -->
        <form class="cd-form" action="" method="post" id="loginform">
          <?php $_SESSION["token-login"] = md5(uniqid(mt_rand(), true)); ?>
          <input type="hidden" name="csrfl" id="csrfl" value="<?php echo $_SESSION["token-login"]; ?>">
          <p class="fieldset">
            <label class="image-replace cd-email" for="signin-email">Email</label>
            <input class="full-width has-padding has-border" id="signin-email" name="signin-email" pattern="[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*@[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{1,8}" required="" autocomplete="true" type="email" placeholder="Email" required="">
            
          </p>

          <p class="fieldset">
            <label class="image-replace cd-password" for="signin-password">Password</label>
            <input class="full-width has-padding has-border" id="signin-password" name="signin-password" pattern=".{8,32}" autocomplete="false" inputmode="verbatim" type="password" placeholder="Password" required="">
            <a href="#0" class="hide-password">Show</a>
            
          </p>

          <p class="fieldset">           
            <input class="full-width" id="form-login" type="submit" value="Login">
          </p>
        </form>
        
        <p class="cd-form-bottom-message"><a href="#0">Did you forget the password?</a></p>
        
      </div> <!-- cd-login -->


<!----------------------------------- Sign Up Form --------------------------------------------->
      <div id="cd-signup"> <!-- sign up form -->
        <form class="cd-form" action="" method="post" id="signupform">
          <?php $_SESSION["token-registry"] = md5(uniqid(mt_rand(), true)); ?>
          <input type="hidden" name="csrf" id="csrf" value="<?php echo $_SESSION["token-registry"]; ?>">
          <p class="fieldset">
            <label class="image-replace cd-username" for="signup-username">First Name</label>
            <input class="full-width has-padding has-border" name="signup-username" id="signup-username" pattern="[A-Za-z]{3,16}" autocomplete="true" required="" autofocus="true" type="text" placeholder="First Name">            
          </p>

          <p class="fieldset">
            <label class="image-replace cd-email" for="signup-email">Email</label>
            <input class="full-width has-padding has-border" id="signup-email" name="signup-email" pattern="[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*@[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{1,8}" required="" autocomplete="true" type="email" placeholder="Email">            
          </p>

          <p class="fieldset">
            <label class="image-replace cd-country" for="signup-country">City</label>
            <select class="full-width has-padding has-border" id="signup-country" name="signup-country" required="" onchange="ViewZip(this)">
              <option value="" selected="">Select City</option>             
            </select>            
          </p>

          <p class="fieldset">
            <label class="image-replace cd-zipost" for="signup-zipost">Zip postal</label> 
            <select class="full-width has-padding has-border" required="" id="signup-zipost" name="signup-zipost">
              <option value="">Select Zip postal</option>
            </select>            
          </p>

          <p class="fieldset">
            <label class="image-replace cd-road" for="signup-road">Street</label>
            <input class="full-width has-padding has-border" id="signup-road" name="signup-road" type="text" required="" autocomplete="true" placeholder="Enter street">            
          </p>

          <p class="fieldset">
            <label class="image-replace cd-tel" for="signup-telf">Phone</label>
            <input class="full-width has-padding has-border" id="signup-telf" name="signup-telf" type="tel" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" required="" autocomplete="true" placeholder="Phone with format 123-456-7890">            
          </p>

          <p class="fieldset">
            <label class="image-replace cd-password" for="signup-password">Password</label>
            <input class="full-width has-padding has-border" pattern=".{8,32}" autocomplete="false" inputmode="verbatim" id="signup-password" name="signup-password" type="password"  placeholder="Password" required="">
            <a href="#0" class="hide-password">Show</a>            
          </p>

          <p class="fieldset">
            <label class="image-replace cd-password" for="signup-password-repeat">Repeat Password</label>
            <input class="full-width has-padding has-border" pattern=".{8,32}" autocomplete="false" inputmode="verbatim" id="signup-password-repeat" name="signup-password-repeat" type="password"  placeholder="Repeat Password" required="">
            <a href="#0" class="hide-password">Show</a>            
          </p>

          <p class="fieldset">
            <input type="checkbox" id="accept-terms" name="accept-terms" required="">
            <label for="accept-terms">I accept the <a class="accept-terms" href="#0">Terms and conditions</a></label>
          </p>

          <p class="fieldset">
            <input class="full-width has-padding" id="form-registre" type="submit" value="Create Account">
          </p>
        </form>
       
      </div> <!-- cd-signup -->


<!----------------------------------- reset password form --------------------------------------------->
      <div id="cd-reset-password"> <!-- reset password form -->
        <p class="cd-form-message">Lost your password? Please enter your email address. You will receive a message with a new password.</p>

        <form class="cd-form" action="" method="post" id="resetpassword">
          <p class="fieldset">
            <label class="image-replace cd-email" for="reset-email">Email</label>
            <input class="full-width has-padding has-border" id="reset-email" name="reset-email" pattern="[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*@[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{1,8}" required="" autocomplete="false" type="email" placeholder="Email">            
          </p>

          <p class="fieldset buttonRes">
            <input class="full-width has-padding" id="form-respassword" type="submit" value="Reset password">
          </p>

          <p class="fieldset msgPass">
            <input class="full-width has-padding" id="msg-respassword" readonly="" type="text">
          </p>

        </form>

        <p class="cd-form-bottom-message"><a href="#0">Return to login</a></p>
      </div> <!-- cd-reset-password -->
      <a href="#0" class="cd-close-form">Close</a>
    </div> <!-- cd-user-modal-container -->
  </div> <!-- cd-user-modal -->

