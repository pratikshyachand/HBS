
document.getElementById('hostel_id').addEventListener('change', function () {
    const hostelID = this.value;
    document.getElementById('hostel_id_hidden').value = hostelID;
    if (hostelID) {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', '../../backend/get_hostel_ajax.php', true); 
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onload = function () {
            if (xhr.status === 200) {
                const data = JSON.parse(xhr.responseText);
                console.log(data);
                // Populate fields
                document.getElementById('hostel_name').value = data.hostel_name;
                document.getElementById('owner_name').value = data.owner;
                document.getElementById('type').value = data.type;
                document.getElementById('contact').value = data.contact;
                document.getElementById('emailID').value = data.email;
                document.getElementById('ward_no').value = data.ward;
                getDistricts(data.province_id,'edit-hostel');
                getMunicipalities(data.district_id,'edit-hostel');
                document.getElementById('province').value = data.province_id;
                document.getElementById('district').value = data.district_id;
                document.getElementById('municipality').value = data.municip_id;
               
             
        }
        else 
            console.log('status != 200');
    }
        xhr.send('hostel_id=' + encodeURIComponent(hostelID));
    }
});
