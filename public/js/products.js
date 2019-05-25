window.addEventListener('load', toggleOrderIcon)

$('#productModal').on('show.bs.modal', (event) => {
	let it_card = $(event.relatedTarget);
	loadModalInfo(it_card[0]);
});


function loadModalInfo (node) {
	node_card = node;
	document.getElementById('pModalTitle').textContent = node.dataset.productName;
	document.getElementById('pModalPrice').textContent = node.dataset.price;
	document.getElementById('pModalDescription').textContent = node.dataset.description;
	document.getElementById('pModalImage').src = node_card.children[0].src;
	document.getElementById('dispLink').href = parseUrl(node.dataset.productId, node.dataset.productName);
}

function parseUrl (id, name) {
	return '/producto/'+id+'/'+encodeURIComponent(name.replace(/ +/g, '-'));
}

function toggleOrderIcon () {
	let tgOrder = document.getElementById('toggle-order');
	if (tgOrder) tgOrder.addEventListener('click', () => {
		let icon = tgOrder.children[1];
		icon.classList.toggle('fa-sort-amount-up');
		icon.classList.toggle('fa-sort-amount-down');
	});
}
