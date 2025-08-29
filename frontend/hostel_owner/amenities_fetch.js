// Globals
let amenityToDelete = null;
const modalDelete = document.getElementById("deleteModal");
const confirmDeleteBtn = document.getElementById("confirmDelete");
const cancelDeleteBtn = document.getElementById("cancelDelete");
const closeDeleteBtn = modalDelete?.querySelector(".close");
const tbody = document.querySelector("#amenities-body");

// Modal for Add/Edit
const modalAdd = document.getElementById("addAmenityModal");
const btnAdd = document.getElementById("btnAddAmenity");
const closeAddBtn = modalAdd.querySelector(".close");
const saveBtn = document.getElementById("saveAmenity");
const amenityNameInput = document.getElementById("amenityName");
let editingId = null;

// Show popup
function showPopup(message) {
    const popup = document.createElement("div");
    popup.className = "popup-message popup";
    popup.innerHTML = `<p>${message}</p><span class="popup-close" onclick="this.parentElement.remove()">×</span>`;
    document.body.appendChild(popup);
       // Force positioning above everything
    popup.style.position = "fixed";
    popup.style.backgroundColor = "#fff"; 
    popup.style.zIndex = 999999;
    popup.style.boxShadow = "0 4px 12px rgba(0,0,0,0.2)";
    popup.style.padding = "15px 20px";
    popup.style.borderRadius = "8px";
    setTimeout(() => popup.remove(), 4000);
}

// Load amenities
function loadAmenities() {
    tbody.innerHTML = "<tr><td colspan='3'>Loading...</td></tr>";
    fetch(`../../backend/amenities_crud.php`, {
        method: "POST",
        headers: { "Content-Type":"application/json" },
        body: JSON.stringify({ action: "list" })
    })
    .then(res => res.json())
    .then(data => {
        if(!data || data.length === 0){
            tbody.innerHTML = "<tr><td colspan='3'>No amenities added</td></tr>";
            return;
        }

        tbody.innerHTML = "";
        data.forEach(a => {
            const tr = document.createElement("tr");
            tr.dataset.id = a.id;
            tr.innerHTML = `
                <td>${a.id}</td>
                <td>${a.name}</td>
                <td> 
                    <button class="btns btn-secondary editAmenity" data-id="${a.id}" data-name="${a.name}"><i class="fas fa-edit"></i></button>
                    <button class="btns btn-danger deleteAmenity" data-id="${a.id}"> 
                    <i class="fas fa-trash-alt"></i>
                    </button>
                </td>
            `;
            tbody.appendChild(tr);
        });

        // Attach edit/delete handlers
        document.querySelectorAll(".editAmenity").forEach(btn => {
            btn.onclick = () => {
                editingId = btn.dataset.id;
                amenityNameInput.value = btn.dataset.name;
                modalAdd.style.display = "block";
            };
        });

        document.querySelectorAll(".deleteAmenity").forEach(btn => {
            btn.onclick = () => {
                amenityToDelete = btn.dataset.id;
                modalDelete.style.display = "block";
            };
        });
    })
    .catch(err => {
        console.error(err);
        tbody.innerHTML = "<tr><td colspan='3'>Error loading amenities</td></tr>";
    });
}

// Add/Edit modal handlers
btnAdd.onclick = () => {
    editingId = null;
    amenityNameInput.value = "";
    modalAdd.style.display = "block";
};
closeAddBtn.onclick = () => modalAdd.style.display = "none";
window.onclick = e => { if(e.target === modalAdd) modalAdd.style.display = "none"; }

// Save amenity
saveBtn.onclick = () => {
    const name = amenityNameInput.value.trim();
    if(!name) return showPopup("⚠️ Amenity name required");

    fetch("../../backend/amenities_crud.php", {
        method: "POST",
        headers: { "Content-Type":"application/json" },
        body: JSON.stringify({ action: editingId ? "update" : "add", id: editingId, name })
    })
    .then(res => res.json())
    .then(resp => {
        if(resp.success){
            showPopup("✅ Amenity saved successfully!");
            modalAdd.style.display = "none";
            loadAmenities();
        } else {
            showPopup(resp.message || "Failed to save amenity");
        }
    });
};

// Delete modal handlers
confirmDeleteBtn.onclick = () => {
    if(!amenityToDelete) return;

    fetch("../../backend/amenities_crud.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ action: "delete", id: amenityToDelete })
    })
    .then(res => res.json())
    .then(resp => {
        if(resp.success) {
            showPopup("✅ Amenity deleted successfully!");
            loadAmenities();
        } else {
            showPopup(resp.message || "Failed to delete amenity");
        }
    })
    .catch(err => {
        console.error(err);
        showPopup("Error connecting to server");
    });

    modalDelete.style.display = "none";
    amenityToDelete = null;
};


// Search filter
document.getElementById("searchInput").addEventListener("input", function(){
    const filter = this.value.toLowerCase();
    document.querySelectorAll("#amenities-body tr").forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(filter) ? "" : "none";
    });
});

// Initial load
loadAmenities();
