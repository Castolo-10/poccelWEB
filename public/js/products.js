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
}
