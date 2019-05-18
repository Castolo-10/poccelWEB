window.addEventListener('load', onPayClick);
window.addEventListener('load', onAmountChanged);

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

function onAmountChanged() {
  let amount = document.getElementById('cc-pay');

  amount.addEventListener('input', function() {
    if (amount.value <= 0) {
      amount.setCustomValidity('No');
    } else {
      amount.setCustomValidity('');
    }
  });
}