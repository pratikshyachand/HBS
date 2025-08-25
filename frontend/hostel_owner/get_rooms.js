document.getElementById("selected-hostel").addEventListener("change", function() {
    let hostelId = this.value;
    let tbody = document.querySelector("#rooms-table tbody");
    tbody.innerHTML = "<tr><td colspan='7'>Loading...</td></tr>";

    fetch(`../../backend/get_rooms.php?hostel_id=${hostelId}`)
        .then(res => res.json())
        .then(data => {
            if(data.length === 0){
                tbody.innerHTML = "<tr><td colspan='7'>No rooms found for this hostel</td></tr>";
                return;
            }

            let rows = "";
            data.forEach(room => {
                rows += `<tr>
                    <td>${room.id}</td>
                    <td>${room.room_type}</td>
                    <td><img src="../../${room.images}" alt="Room Image" style="width:60px;height:50px;"></td>
                    <td>${room.available_beds}</td>
                    <td>${room.total_beds - room.available_beds}</td>
                    <td>${room.price}</td>
                    <td>
                         <button class="btn-icon edit" onclick="editRoom(${room.id})" title="Edit">
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
});





