window.addEventListener('load', onPayClick);
window.addEventListener('load', onAmountChanged);
window.addEventListener('load', onCCInputChange);

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

function onCCInputChange() {
	let cc = document.getElementById('cc-number');

	cc.addEventListener('input', () => {
		let options = document.querySelectorAll('#credit-cards option');
		let expDates = document.getElementById('exp-dates');
		removeChilds(expDates);
		Array.prototype.map.call(options, (opt) => {
			console.log(cc.value, opt.value);
			if (cc.value.replace(/ /g, '') == opt.value) {
				let exp = document.createElement('option');
				exp.value = opt.text;
				expDates.appendChild(exp);
			}
		});
	});
}

function removeChilds(node) {
	while (node.hasChildNodes())
		node.removeChild(node.lastChild)
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
