<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta id="token" name="token" value="{{ csrf_token() }}">
	<title>Total - Catch Me If You Can</title>
	<link rel="stylesheet" type="text/css" href="css/app.css">
  <link rel="stylesheet" type="text/css" href="css/main.css">
</head>

<body>
  <div class="container">
    <div id="app">
      <login-register-modal :show.sync="showLoginRegisterModal">
      </login-register-modal>

      <register-modal :show.sync="showRegisterModal">
      </register-modal>
    </div>
  </div>

  <!-- scripts for modal page -->
  <script type="x/template" id="login-register-modal-template">
    <div class="modal-mask" v-show="show" transition="modal">
      <div class="modal-wrapper">
        <div class="modal-container">

          <div class="modal-header">
            <slot name="header">
              Login / Register
            </slot>
          </div>
          
          <div class="modal-body">
            <slot name="body">
              <div class="container">
                <div class="form-group">
                  <label for="email">Email</label>
                  <input type="email" placeholder="Enter your email address" v-model="email">
                </div>
                <div class="form-group">
                  <label for="password">Password</label>
                  <input type="password" placeholder="Enter your password" v-model="password">
                </div>
              </div>
            </slot>
          </div>

          <div class="modal-footer">
            <slot name="footer">
              <fb:login-button scope="public_profile,email," onlogin="checkLoginState();">
              </fb:login-button>
              <button class="modal-default-button" v-on:click="loginUser()">
                Login
              </button>
              <button class="modal-default-button" v-on:click="registerUser()">
                New User
              </button>
              <button class="modal-default-button" v-on:click="show = false">
                Cancel
              </button>
            </slot>
          </div>
        </div>
      </div>
    </div>
  </script>

  <script type="x/template" id="register-modal-template">
    <div class="modal-mask" v-show="show" transition="modal">
      <div class="modal-wrapper">
        <div class="modal-container">

          <div class="modal-header">
            <slot name="header">
              Register
            </slot>
          </div>
          <div class="modal-body">
            <slot name="body">
              <div class="container">
                <div class="form-group">
                  <label for="username">Username</label>
                  <input type="text" placeholder="Enter your user name" v-model="username">
                </div>
                <div class="form-group">
                  <label for="email">Email</label>
                  <input type="email" placeholder="Enter your email address" v-model="email">
                </div>
                <div class="form-group">
                  <label for="password">Password</label>
                  <input type="password" placeholder="Enter your password" v-model="password">
                </div>
                <div class="form-group">
                  <label for="confirmPassword">Confirm Password</label>
                  <input type="password" placeholder="Re-enter your password" v-model="confirmPassword">
                </div>
                <div class="form-group">
                  <label for="icno">Identification Number</label>
                  <input type="text" placeholder="Enter your Identification number" v-model="icno">
                </div>
                <div class="form-group">
                  <label for="mobile">Mobile Number</label>
                  <input type="phone" placeholder="Enter your mobile number" v-model="mobile">
                </div>
              </div>
            </slot>
          </div>

          <div class="modal-footer">
            <slot name="footer">
              <button class="modal-default-button" v-on:click="registerUser()">
                Register
              </button>
              <button class="modal-default-button" v-on:click="show = false">
                Cancel
              </button>
            </slot>
          </div>
        </div>
      </div>
    </div>
  </script>
    
  <script src="js/vendor.js"></script>
	<script src="js/appV2.js"></script>
  <script>
    // This is called with the results from from FB.getLoginStatus().
    function statusChangeCallback(response) {
      console.log('statusChangeCallback');
      console.log(response);
      // The response object is returned with a status field that lets the
      // app know the current login status of the person.
      // Full docs on the response object can be found in the documentation
      // for FB.getLoginStatus().
      if (response.status === 'connected') {
        // Logged into your app and Facebook.
        testAPI();
      } else if (response.status === 'not_authorized') {
        // The person is logged into Facebook, but not your app.
        document.getElementById('status').innerHTML = 'Please log ' +
          'into this app.';
      } else {
        // The person is not logged into Facebook, so we're not sure if
        // they are logged into this app or not.
        document.getElementById('status').innerHTML = 'Please log ' +
          'into Facebook.';
      }
    }

    // This function is called when someone finishes with the Login
    // Button.  See the onlogin handler attached to it in the sample
    // code below.
    function checkLoginState() {
      FB.getLoginStatus(function(response) {
        statusChangeCallback(response);
      });
    }

    window.fbAsyncInit = function() {
    FB.init({
      appId      : '669731976502831',
      cookie     : true,  // enable cookies to allow the server to access 
                          // the session
      xfbml      : true,  // parse social plugins on this page
      version    : 'v2.2' // use version 2.2
    });

    // Now that we've initialized the JavaScript SDK, we call 
    // FB.getLoginStatus().  This function gets the state of the
    // person visiting this page and can return one of three states to
    // the callback you provide.  They can be:
    //
    // 1. Logged into your app ('connected')
    // 2. Logged into Facebook, but not your app ('not_authorized')
    // 3. Not logged into Facebook and can't tell if they are logged into
    //    your app or not.
    //
    // These three cases are handled in the callback function.

    FB.getLoginStatus(function(response) {
      statusChangeCallback(response);
    });

    };

    // Load the SDK asynchronously
    (function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/en_US/sdk.js";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

    // Here we run a very simple test of the Graph API after login is
    // successful.  See statusChangeCallback() for when this call is made.
    function testAPI() {
      console.log('Welcome!  Fetching your information.... ');
      FB.api('/me?fields=name,email,id', function(response) {
        console.log('Successful login for: ' + response.name);
        console.log(JSON.stringify(response));
        document.getElementById('status').innerHTML =
          'Thanks for logging in, ' + response.name + '!';
      });
    }
  </script>

<!--
  Below we include the Login Button social plugin. This button uses
  the JavaScript SDK to present a graphical Login button that triggers
  the FB.login() function when clicked.
-->



<div id="status">
</div>
</body>
</html>