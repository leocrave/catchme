Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('value');

new Vue({
  el: '#app',
  ready: function() {
  	this.checkUserSession();
  	this.checkUserRegistrationStatus();
  	this.checkUserUploadPhotoStatus();
  },
  data: {
    message: '',
    registration: {
    	showRegistrationForm: false,
    	showRegisterButton: false,
    	showSocialButton: false,
    	isRegistered: false,
    }
  },
  methods: {
  	checkUserSession: function() {

  		this.$http.get('http://localhost/totalmy/public/catchme/user/existence').then(function(response) {
  			var social_id = response.data.social_id;
  			if (social_id != null) {
  				this.registration.showSocialButton = false;
  			} else {
  				this.registration.showSocialButton = true;
  			}
  		}, function(response) {
  			console.log('Invalid url...');
  		});
  	},
  	checkUserRegistrationStatus: function() {
  		var data = {
  			'social_id': 'h323bf2r2448yvf3'
  		}

  		this.$http.post('http://localhost/totalmy/public/catchme/user/isRegistered', data).then(function(response) {
  			if (response.data.isRegistered) {
  				this.registration.showRegisterButton = false;
  				this.registration.isRegistered = true;
  			} else {
  				this.registration.showRegisterButton = true;
  				this.registration.isRegistered = false;
  			}
  		}, function(response) {
  			console.log('Invalid url...');
  		});
  	},
  	checkUserUploadPhotoStatus: function() {
  		var data = {
  			'social_id': 'h323bf2r2448yvf3'
  		}

  		this.$http.post('http://localhost/totalmy/public/catchme/user/isUploaded', data).then(function(response) {
  			console.log(response.data.message);
  			if (!response.data.isUploaded) {
  				alert('Please upload your photo');
  			}
  		}, function(response) {
  			console.log('Invalid url...');
  		});
  	},
		insertParticipantSocialInfo: function() {
			var data = {
				'social_id': 'h323bf2r2448yvf3',
				'email': 'leo@gmail.com',
				'username': 'Leo Boey',
				'question_id': '1'
			}
			this.$http.post('http://localhost/totalmy/public/catchme', data).then(function(response) {
				this.message = response.data.message;
				this.registration.showSocialButton = false;
			}, function(response) {
				console.log(response.data);
			});
		},
		checkInstagramLogin: function() {
			this.$http.get('https://api.instagram.com/oauth/authorize/?client_id=c3891c4210f040dea6b40b5e8d2800eb&redirect_uri=http://wearecrave.com/wip/catchmeifyoucan/index.html&response_type=code')
		},
		clearSession: function() {
			this.$http.get('http://localhost/totalmy/public/catchme/clear_session').then(function(response) {
				console.log(response.data.message);
			}, function(response) {
				console.log('Invalid url...');
			});
		},
		registerUser: function() {
			var data = {
				'social_id': 'h323bf2r2448yvf3',
				'icno': this.icno, 
				'mobile': this.mobile,
				'photo': this.imageFile.files
			}

			this.$http.post('http://localhost/totalmy/public/catchme/user/register', data).then(function(response) {
				this.registration.showRegisterButton = false;
				this.registration.showRegistrationForm = false;
			}, function(response) {
				console.log('Invalid url...');
			});
		},
		previewFile: function() {
      var preview = document.querySelector('img');
      this.imageFile = document.querySelector('input[type=file]').files[0];
    }
	}
})