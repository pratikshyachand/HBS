
  window.addEventListener("DOMContentLoaded", () => {
    const popup = document.getElementById("popup");
    popup.style.display = "block";   // show popup
    setTimeout(() => {
      popup.style.display = "none";  // hide after 5s
    }, 5000);
  });
