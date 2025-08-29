// Globals
let roomToDelete = null;
const modal = document.getElementById("deleteModal");
const confirmBtn = document.getElementById("confirmDelete");
const cancelBtn = document.getElementById("cancelDelete");
const closeBtn = modal.querySelector(".close");
const tbody = document.querySelector("#rooms-table tbody");

// Show popup
function showPopup(message) {
    const popup = document.createElement('div');
    popup.className = "popup-message popup";  
    popup.innerHTML = `<p>${message}</p><span class="popup-close" onclick="this.parentElement.remove()">×</span>`;
    document.body.appendChild(popup);  
    setTimeout(() => popup.remove(), 4000);
}


// Fetch rooms
function loadRooms(hostelId){
    tbody.innerHTML = "<tr><td colspan='7'>Loading...</td></tr>";
    fetch(`../../backend/get_rooms.php?hostel_id=${hostelId}`)
        .then(res => res.json())
        .then(data => {
            if(!data || data.length === 0){
                tbody.innerHTML = "<tr><td colspan='7'>No rooms found for this hostel</td></tr>";
                return;
            }

            let rows = "";
            data.forEach(room => {
                rows += `
<tr data-id="${room.id}">
    <td>${room.id}</td>
    <td>${room.room_type}</td>
    <td><img src="../../${room.images}" style="width:60px;height:50px;" /></td>
    <td>${room.available_beds}</td>
    <td>${room.total_beds - room.available_beds}</td>
    <td>${room.price}</td>
    <td>
            <button class="btn-icon edit" onclick="window.location.href='edit-room.php?id=${room.id}'" title="Edit">
            <i class="fas fa-edit"></i>
        </button>
        <button class="btn-icon delete" onclick="deleteRoom(${room.id})" title="Delete">
            <i class="fas fa-trash-alt"></i>
        </button>
    </td>
</tr>`;
            });
            tbody.innerHTML = rows;
        })
        .catch(err => {
            console.error(err);
            tbody.innerHTML = "<tr><td colspan='7'>Error loading rooms</td></tr>";
        });
}

// Hostel select change
document.getElementById("selected-hostel").addEventListener("change", function(){
    loadRooms(this.value);
});

// Search filter
document.getElementById("searchInput").addEventListener("input", function(){
    const filter = this.value.toLowerCase();
    document.querySelectorAll("#rooms-table tbody tr").forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(filter) ? "" : "none";
    });
});

// Delete room
function deleteRoom(id){
    roomToDelete = id;
    modal.style.display = "block";
}

// Modal handlers
cancelBtn.onclick = closeBtn.onclick = () => modal.style.display = "none";
window.onclick = (e) => { if(e.target == modal) modal.style.display = "none"; }

confirmBtn.onclick = () => {
    if(!roomToDelete) return;

    fetch(`../../backend/delete_room.php`, {
        method:"POST",
        headers: { "Content-Type":"application/x-www-form-urlencoded" },
        body:`id=${roomToDelete}`
    })
    .then(res => res.json())
    .then(data => {
        if(data.success){
            showPopup(`✅ Room deleted successfully.`, "success");
            const hostelId = document.getElementById("selected-hostel").value;
            if(hostelId) loadRooms(hostelId);
        } else {
            showPopup(data.message || "Failed to delete room.", "error");
        }
    })
    .catch(err => showPopup("Error connecting to server.", "error"));

    modal.style.display = "none";
    roomToDelete = null;
}
