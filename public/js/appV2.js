Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('value');

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
		loginUser: function() {
			var data = {
				email: this.email,
				password: this.password
			}

			this.$dispatch('passCredentials', data);
			this.email = '';
		},
		registerUser: function() {
			this.show = false;
			this.$dispatch('showRegisterModal');
		}
	}
})

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

	}
})

new Vue({
	el: '#app',
	data: {
		showLoginRegisterModal: false,
		showRegisterModal: false,
		userStatus: {
			sessionExist: false,
			isRegistered: false,
			isFirstTimeUser: false
		},
		userCredential: {
			email: ''
		}
	},
	ready: function() {
		this.checkUserRegistrationStatus();
	},
	methods: {
		checkUserRegistrationStatus: function() {
			this.$http.get('http://localhost/totalmy/public/catchme/user_reg_status').then(function(response) {
				if (response.data.sessionExist) {
					this.userStatus.sessionExist = true;

					if (response.data.isRegistered) {
						this.userStatus.isRegistered = true;

						if (response.data.isFirstTimeUser) {
							this.userStatus.isFirstTimeUser = true;
						}
					}
				} else {
					this.showLoginRegisterModal = true;	
				}
				this.showLoginRegisterModal = true;	

				console.log(response.data.message);
			}, function(response) {
				console.log('Invalid url...');
			});
		}
	},
	events: {
		'passCredentials': function(data) {
			this.userCredential.email = data.email;
			this.userCredential.password = data.password;
		},
		'showRegisterModal': function() {
			this.showRegisterModal = true;
		}
	}
})