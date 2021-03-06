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
      <div class="button-group">
        <div>
          {{ message }}
        </div>
        <div class="form-group" v-if="registration.showSocialButton">
          <button class="btn btn-primary" id="fbLogin" v-on:click="insertParticipantSocialInfo">
            Facebook Log In
          </button>  
        </div>  
        <div class="form-group" v-if="registration.showRegisterButton" v-on:click="registration.showRegistrationForm = true">
          <button class="btn btn-primary" id="register">
            Register here
          </button>
        </div>

        <div v-if="registration.showSocialButton" class="form-group">
          <fb:login-button scope="public_profile,email," onlogin="checkLoginState();">
          </fb:login-button>
        </div>
      </div>
      <div v-if="registration.showRegistrationForm">
        <h3>Registration form</h3>
        <form v-on:submit="registerUser()">
          <div class="form-group">
            <label for="icno">IC Number</label>
            <input class="form-control" placeholder="Please enter your ic number" v-model="icno">
          </div>

          <div class="form-group">
            <label for="mobile">Mobile Phone Number</label>
            <input class="form-control" placeholder="Your mobile number" v-model="mobile">
          </div>

          <div class="form-group">
            <label for="uploadPhoto">Upload Photo</label>
            <input type="file" accept="image/*">
          </div>

          <div class="form-group">
            <img src="">
          </div>

          <div class="form-group">
            <button class="btn btn-primary" type="submit">Register</button>  
          </div>
        </form>
      </div>

      <div class="form-group">
        <button class="btn btn-secondary" v-on:click="clearSession()">
          Clear Session(Testing Purpose)
        </button>
      </div>
    </div>
  </div>
    
  <script src="js/vendor.js"></script>
	<script src="js/app.js"></script>
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