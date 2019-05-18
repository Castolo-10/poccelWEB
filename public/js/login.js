window.addEventListener('load', onLoginClick);

function onLoginClick() {
	let btnLogin = document.getElementById('btn-login');

	btnLogin.addEventListener('click', function() {
		let pass = document.getElementById('password');
		pass.value = CryptoJS.MD5(pass.value);
		btnLogin.form.submit();
	});
}