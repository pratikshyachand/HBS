function showPopup(message) {
  const popup = document.getElementById("popupMessage");
  const popupText = document.getElementById("popupText");

  popupText.innerText = message;


  popup.style.display = "block";

  setTimeout(() => {
    popup.style.display = "none";
  }, 3000);
}


// Check if hostel is selected before opening Add
  function checkAndOpenAdd() {
    let hostelId = document.getElementById("selected-hostel").value;
    if (!hostelId) {
    showPopup("⚠️ Please select a hostel first");     
      return;
    }
    openModalAdd();
  }

  // Check if hostel is selected before opening Edit
  function checkAndOpenEdit() {
    let hostelId = document.getElementById("selected-hostel").value;
    if (!hostelId) {
    showPopup("⚠️ Please select a hostel first");  
        return;
    }
    openModalEdit();
  }

  function openModalAdd() {
     let hostelId = document.getElementById('selected-hostel').value;
  document.getElementById("selectedHostelAdd").value = hostelId;
  document.getElementById("amenityAddModal").style.display = "block";
  }

   function openModalEdit() {
    document.getElementById("amenityEditModal").style.display = "block";
  }
  
  function closeAddModal() {
    document.getElementById("amenityAddModal").style.display = "none";
  }

    function closeEditModal() {
    document.getElementById("amenityEditModal").style.display = "none";
  }

  window.onclick = function(event) {
    const modal = document.getElementById("amenityModal");
    if (event.target == modal) {
      modal.style.display = "none";
    }
  }