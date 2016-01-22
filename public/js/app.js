Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('value');

new Vue({
  el: '#app',
  data: {
    fbLogin: 'Facebook Log In',
    igLogin: 'Instagram Log In',
    registerMsg: 'Register here',
    message: '',
    showRegister: false,
  },
  methods: {
		insertParticipantSocialInfo: function() {
			console.log(document.querySelector('#token').getAttribute('value'));
			var data = {
				'social_id': 'h323bf2r2448yvf3',
				'email': 'leo@gmail.com',
				'username': 'Leo Boey',
				'question_id': '1'
			}
			this.$http.post('http://localhost/totalmy/public/catchme', data).then(function(response) {
				console.log(response.data.message);
				this.message = response.data.message;
			}, function(response) {
				console.log(response.data);
			});
		},
		checkInstagramLogin: function() {
			this.$http.get('https://api.instagram.com/oauth/authorize/?client_id=c3891c4210f040dea6b40b5e8d2800eb&redirect_uri=http://wearecrave.com/wip/catchmeifyoucan/index.html&response_type=code')
		}
	}
})