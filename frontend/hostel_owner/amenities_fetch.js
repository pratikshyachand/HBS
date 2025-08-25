selectedHostel = document.getElementById('selected-hostel');

selectedHostel.addEventListener('change', () => {

    hostelid = selectedHostel.value;

        let amenitiesData = [];
        const hostelData = {
            hostelID: hostelid
        };

        fetch('/backend/api/get_hostel_amenities.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json' // Crucial: Tells the server we're sending JSON
            },
            body: JSON.stringify(hostelData) // Convert JavaScript object to JSON string
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }
                return response.json(); // Assuming server responds with JSON
            })
            .then(data => {
                amenitiesData = data.amenities;

                const amenitiesTableBody = document.querySelector("#amenities-table tbody");
                amenitiesTableBody.innerHTML = ''; // Clear existing table rows

                let innerTag = '';
                let count = 0;
                // Loop through the aminities data and populate the table
                amenitiesData.forEach((record, index) => {
                    ++count;
                    innerTag += `<tr>
                <td>${count}</td>
                <td>${record.name}</td>
                <td><a onClick='remove_amenity(${count})'> <i class="fas fa-trash"></i></a></td>
                </tr>`;
                });

                amenitiesTableBody.innerHTML = innerTag;
            })
            .catch(error => {
                console.error('Error during fetch:', error);
            });
    });

function remove_amenity(id){
/* this
    is
    not
    working 
    well
    ....slow
    and 
    lag 
    find anothr
    later


        const amenityData = {
            amenityID: id 
        };

        fetch('/backend/api/remove_hostel_amenities.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json' // Crucial: Tells the server we're sending JSON
            },
            body: JSON.stringify(amenityData) // Convert JavaScript object to JSON string
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }
                return response.json(); // Assuming server responds with JSON
            })
            .then(data => {
                if (data.success) {
// RE-DRAW THE AMENITY TABLE I AM USING <SELECT> , REDIRECTING REINITIALIZES THE <SELECT> ELEMENT


    hostelid = selectedHostel.value;

        let amenitiesData = [];
        const hostelData = {
            hostelID: hostelid
        };

        fetch('/backend/api/get_hostel_amenities.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json' // Crucial: Tells the server we're sending JSON
            },
            body: JSON.stringify(hostelData) // Convert JavaScript object to JSON string
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }
                return response.json(); // Assuming server responds with JSON
            })
            .then(data => {
                amenitiesData = data.amenities;

                const amenitiesTableBody = document.querySelector("#amenities-table tbody");
                amenitiesTableBody.innerHTML = ''; // Clear existing table rows

                let innerTag = '';
                let count = 0;
                // Loop through the aminities data and populate the table
                amenitiesData.forEach((record, index) => {
                    ++count;
                    innerTag += `<tr>
                <td>${count}</td>
                <td>${record.name}</td>
                <td><a onClick='remove_amenity(${count})'>remove <i class="fas fa-trash"></i></a></td>
                </tr>`;
                });

                amenitiesTableBody.innerHTML = innerTag;
            })
            .catch(error => {
                console.error('Error during fetch:', error);
            });

// RE-DRAWN THE AMENITY TABLE I AM USING <SELECT> , REDIRECTING REINITIALIZES THE <SELECT> ELEMENT
                }
            })
            .catch(error => {
                console.error('Error during fetch:', error);
            });
            */
}