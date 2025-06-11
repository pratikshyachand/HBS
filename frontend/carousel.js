const images = [
  "img1.jpg",
  "img2.jpg",
  "img3.jpg",
  "img4.jpg"
];

let currentIndex = 0;

function showSlide(index) {
  currentIndex = index;
  document.getElementById("mainImage").src = images[index];

  // highlight active thumbnail
  const thumbs = document.querySelectorAll(".thumbnails img");
  thumbs.forEach((img, i) => {
    img.classList.toggle("active", i === index);
  });
}

function changeSlide(step) {
  currentIndex = (currentIndex + step + images.length) % images.length;
  showSlide(currentIndex);
}

// initialize
window.onload = () => showSlide(0);
