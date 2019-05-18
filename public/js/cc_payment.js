window.addEventListener('load', onPayClick);

$('#payModal').on('show.bs.modal', (event) => {
	let accountId = $(event.relatedTarget)[0].dataset.account;
	document.getElementById('acc-id').value = accountId;
});

function onPayClick() {
  let btnUpdate = document.getElementById('btn-pay');

  btnUpdate.addEventListener('click', function() {
    let pForm = document.getElementById('form-payment');
    pForm.classList.add('was-validated');

    if (pForm.checkValidity()) {
      btnUpdate.form.submit();
    }
  });
}
