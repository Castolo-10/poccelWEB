window.addEventListener('load', onUpdatePasswordClick);
window.addEventListener('load', validateRepassword);

function onUpdatePasswordClick() {
  let btnUpdate = document.getElementById('btn-update-password');

  let cur_pass = document.getElementById('cr_passwd');
  let new_pass = document.getElementById('nw_passwd');
  let re_pass = document.getElementById('re_passwd');

  btnUpdate.addEventListener('click', function() {
    let pwForm = document.getElementById('form-password');
    pwForm.classList.add('was-validated');

    if (pwForm.checkValidity()) {
      cur_pass.value = CryptoJS.MD5(cur_pass.value);
      new_pass.value = CryptoJS.MD5(new_pass.value);
      re_passwd.value = CryptoJS.MD5(re_pass.value);
      btnUpdate.form.submit();
    }
  });
}

function validateRepassword() {
  let new_pass = document.getElementById('nw_passwd');
  let re_pass = document.getElementById('re_passwd');

  function checkValidity() {
    if ( re_pass.value != new_pass.value ) {
      re_pass.setCustomValidity('No');
    } else {
      re_pass.setCustomValidity('');
    }
  };

  re_pass.addEventListener('input', checkValidity);
  new_pass.addEventListener('input', checkValidity);
}
