Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('value');

/*Login or register modal component*/
Vue.component('login-register-modal', {
	template: '#login-register-modal-template',
	props: {
		show: {
			type: Boolean,
			required: true,
			twoWay: true
		}
	},
	data: {
		email: '',
		password: ''
	},
	methods: {
		/*Pass email and password from modal to parent scope*/
		loginUser: function() {
			var data = {
				email: this.email,
				password: this.password
			}

			this.$dispatch('passCredentials', data);
			this.password = '';
		},
		/*Hide login/register modal and show register form modal*/
		showRegisterUserModal: function() {
			this.show = false;
			this.$dispatch('showRegisterUserModal');
		}
	}
})

/*Register form modal*/
Vue.component('register-modal', {
	template: '#register-modal-template',
	props: {
		show: {
			type: Boolean,
			required: true,
			twoWay: true
		}
	},
	data: {
		username: '',
		email: '',
		password: '',
		confirmPassword: '',
		icno: '',
		mobile: ''
	},
	methods: {
		/*Pass registration data to parent scope*/
		registerUser: function() {
			var data = {
				username: this.username,
				email: this.email,
				password: this.password,
				confirmPassword: this.confirmPassword,
				icno: this.icno,
				mobile: this.mobile
			}

			this.show = false;
			this.$dispatch('registerUser', data);
		}
	}
})

new Vue({
	el: '#app',
	data: {
		envSettings: {
			environment: 'dev',
			constInvalidUrl: 'Invalid url...',
		},
		url: {
			checkUserRegStatusUrl: '',
			userLoginUrl: '',
			userRegistrationUrl: '',
		},

		userStatus: {
			sessionExist: false,
			isRegistered: false,
			isFirstTimeUser: false
		},
		modal: {
			showLoginRegisterModal: false,
			showRegisterModal: false,
		}
	},
	ready: function() {
		this.initializeEnv();
		this.checkUserRegistrationStatus();
	},
	methods: {
		initializeEnv: function() {
			if (this.envSettings.environment == 'dev') {
				this.url.checkUserRegStatusUrl = 'http://localhost/totalmy/public/catchme/user/reg_status';
				this.url.userLoginUrl = 'http://localhost/totalmy/public/catchme/user/login';
				this.url.userRegistrationUrl = 'http://localhost/totalmy/public/catchme/user/register';
				this.url.generateRandomInstantRewardUrl = 'http://localhost/totalmy/public/catchme/random_instant_reward';
			} else {
				this.url.checkUserRegStatusUrl = 'http://wearecrave.com/catchme/user/reg_status';
			}
		},
		checkUserRegistrationStatus: function() {
			this.$http.get(this.url.checkUserRegStatusUrl).then(function(response) {
				if (response.data.sessionExist) {
					this.userStatus.sessionExist = true;

					if (response.data.isRegistered) {
						this.userStatus.isRegistered = true;

						if (response.data.isFirstTimeUser) {
							this.userStatus.isFirstTimeUser = true;
						}
					} else {
						this.modal.showRegisterModal = true;	
					}
				} else {
					this.modal.showLoginRegisterModal = true;
				}

				console.log(response.data.message);
			}, function(response) {
				console.log(this.constInvalidUrl);
			});
		},
		userLogin: function(loginData) {
			this.$http.post(this.url.userLoginUrl, loginData).then(function(response) {
				this.checkUserRegistrationStatus();
				console.log(response.data.message);
			}, function(response) {
				console.log(this.constInvalidUrl);
			});
		},
		userRegister: function(regData) {
			this.$http.post(this.url.userRegistrationUrl, regData).then(function(response) {
				this.checkUserRegistrationStatus();
				console.log(response.data.message);
			}, function(response) {

			});
		},
		clearSession: function() {
			this.$http.get('http://localhost/totalmy/public/catchme/clearSession').then(function(response) {
				console.log(response.data.message);
			}, function(response) {
				console.log(this.constInvalidUrl);
			});
		},
		generateRandomInstantReward: function() {
			this.$http.get()
		}
	},
	events: {
		'passCredentials': function(data) {
			var loginData = {
				'email': data.email,
				'password': data.password
			}

			this.userLogin(loginData);
		},
		'registerUser': function(data) {
			var regData = {
				'username': data.username,
				'email': data.email,
				'password': data.password,
				'icno': data.icno,
				'mobile': data.mobile,
			}

			this.userRegister(regData);
		},
		'showRegisterUserModal': function() {
			this.modal.showRegisterModal = true;
		}
	}
})