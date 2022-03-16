const navSlide = () => {
  const nav = document.querySelector('.nav__list');
  const burger = document.querySelector('.hamburger');

  burger.addEventListener('click', () => {
    nav.classList.toggle('nav-active');
    burger.classList.toggle('active');
  });
};
navSlide();
