// Hamburger menu
const burger = document.getElementById('hamburger');
const nav = document.getElementById('nav-list');

burger.addEventListener('click', (e) => {
  nav.classList.toggle('nav-active');
  burger.classList.toggle('active');
});

document.addEventListener('click', (e) => {
  if (e.target.id !== 'nav-list' && e.target.id !== 'hamburger') {
    nav.classList.remove('nav-active');
    burger.classList.remove('active');
  }
});

// Active class
const menuItem = document.querySelectorAll('.languages a');
const menuLength = menuItem.length;

for (let i = 0; i < menuLength; i++) {
  menuItem[i].addEventListener('click', function (e) {
    for (let j = 0; j < menuLength; j++) {
      if (menuItem[i] !== menuItem[j]) {
        menuItem[j].classList.remove('nav__active');
        menuItem[j].classList.remove('links__active');
      }
    }
    e.stopPropagation();
    // e.preventDefault();
    this.classList.add('nav__active');
    this.classList.add('links__active');
  });
}
