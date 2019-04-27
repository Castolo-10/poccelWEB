window.addEventListener('load', main);

function main() {
  let sToggle = document.getElementById('search-toggle');
  sToggle.addEventListener('click', () => {
    document.querySelector('main').classList.toggle('extended');
  });
}
