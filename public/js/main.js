window.addEventListener('load', focusSearchOnClick)

function focusSearchOnClick() {
	let btnSearchBar = document.getElementById('show-search-bar');

	btnSearchBar.addEventListener('click', function() {
		setTimeout(function(){
			document.getElementById('txt-search').focus();
		},333);
	});
}