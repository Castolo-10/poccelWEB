window.addEventListener('load', focusSearchOnClick);
window.addEventListener('load', hideSearchOnLostFocus);

function focusSearchOnClick() {
	let btnSearchBar = document.getElementById('show-search-bar');

	btnSearchBar.addEventListener('click', function() {
		setTimeout(function(){
			document.getElementById('txt-search').focus();
		},333);
	});
}

function hideSearchOnLostFocus() {
	let searchBar = document.getElementById('txt-search');

	searchBar.addEventListener('blur', function() {
		document.getElementById('hide-search-bar').click();
	})
}
