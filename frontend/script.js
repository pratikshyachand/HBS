const slides = document.querySelector('.slides');
const images = document.querySelectorAll('.slides img');
const prev = document.querySelector('.prev');
const next = document.querySelector('.next');
const thumbnails = document.querySelectorAll('.thumbnails img');

let index = 0;
const totalSlides = images.length;

function updateSlidePosition() {
  slides.style.transform = `translateX(-${index * 100}vw)`;
  thumbnails.forEach(thumb => thumb.classList.remove('active'));
  thumbnails[index].classList.add('active');
}

function showNextSlide() {
  index = (index + 1) % totalSlides;
  updateSlidePosition();
}

function showPrevSlide() {
  index = (index - 1 + totalSlides) % totalSlides;
  updateSlidePosition();
}

next.addEventListener('click', () => {
  showNextSlide();
  resetInterval();
});

prev.addEventListener('click', () => {
  showPrevSlide();
  resetInterval();
});

thumbnails.forEach((thumb, i) => {
  thumb.addEventListener('click', () => {
    index = i;
    updateSlidePosition();
    resetInterval();
  });
});

// Auto slide
let slideInterval = setInterval(showNextSlide, 4000);

function resetInterval() {
  clearInterval(slideInterval);
  slideInterval = setInterval(showNextSlide, 4000);
}

// Initialize first active thumb
updateSlidePosition();
