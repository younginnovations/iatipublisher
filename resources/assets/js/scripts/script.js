// Hamburger Menu
const navSlide = () => {
  const nav = document.querySelector('.nav__list');
  const burger = document.querySelector('.hamburger');

  burger.addEventListener('click', () => {
    nav.classList.toggle('nav-active');
    burger.classList.toggle('active');
  });
};
navSlide();

// Active
const currentLocation = location.href;
const menuItem = document.querySelectorAll('.languages a');
const menuLength = menuItem.length;

for (let i = 0; i < menuLength; i++) {
  menuItem[i].addEventListener('click', function (e) {
    for (let j = 0; j < menuLength; j++) {
      if (menuItem[i] !== menuItem[j]) {
        menuItem[j].classList.remove('nav__active');
      }
    }
    // console.log(this);
    e.preventDefault();
    this.classList.add('nav__active');
  });
}
