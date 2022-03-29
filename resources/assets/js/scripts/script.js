// Hamburger menu
const burger = document.getElementById('hamburger');
const nav = document.getElementById('nav-list');

burger.addEventListener('click', () => {
  nav.classList.toggle('nav-active');
  burger.classList.toggle('active');
  document.body.classList.toggle('overflow-hidden');
});

// close the navMenu by clicking outside
document.addEventListener('click', (e) => {
  if (e.target.id !== 'nav-list' && e.target.id !== 'hamburger') {
    nav.classList.remove('nav-active');
    burger.classList.remove('active');
    document.body.classList.remove('overflow-hidden');
  }
});

// Active class
const menuItem = document.querySelectorAll('.languages a');
const menuLength = menuItem.length;

for (let i = 0; i < menuLength; i += 1) {
  menuItem[i].addEventListener('click', (e) => {
    for (let j = 0; j < menuLength; j += 1) {
      if (menuItem[i] !== menuItem[j]) {
        menuItem[j].classList.remove('nav__active');
        menuItem[j].classList.remove('links__active');
      }
    }
    e.stopPropagation();
    e.currentTarget.classList.add('nav__active');
    e.currentTarget.classList.add('links__active');
  });
}

// Form validation
const submitButton = document.getElementById('btn');
const username = document.querySelector('.username');
const password = document.querySelector('.password');

function nameValidation() {
  if (!username.value) {
    username.style.border = '1.5px solid crimson';
  }
}
function passwordValidation() {
  if (!password.value) {
    password.style.border = '1.5px solid crimson';
  }
}

submitButton.addEventListener('click', (e) => {
  e.preventDefault();
  nameValidation();
  passwordValidation();
});
