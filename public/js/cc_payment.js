window.addEventListener('load', onPayClick);
window.addEventListener('load', onAmountChanged);
window.addEventListener('load', onCreditCardClicked);

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
			let cc = document.getElementById('cc-number');
			cc.value = cc.value.replace(/ /g, '');
			this.form.submit();
		}
	});
}

function onCreditCardClicked() {
	let cc = document.getElementById('cc-number');
	let exp = document.getElementById('cc-exp');
	let btnCC = document.querySelector('#cc-options').children;
	
	Array.prototype.map.call(btnCC, (opt) => {
		opt.addEventListener('click', function() {
			cc.value = this.dataset.cc;
		exp.value = this.dataset.exp;
		});
	});
}

function onAmountChanged() {
	let amount = document.getElementById('cc-pay');

	amount.addEventListener('input', function() {
		if (this.value <= 0) {
			this.setCustomValidity('No');
		} else {
			this.setCustomValidity('');
		}
	});
}
