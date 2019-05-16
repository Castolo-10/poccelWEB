$('#payModal').on('show.bs.modal', (event) => {
	let accountId = $(event.relatedTarget)[0].dataset.account;
	document.getElementById('acc-id').value = accountId;
});
