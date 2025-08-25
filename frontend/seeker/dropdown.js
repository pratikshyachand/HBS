
const searchInput = document.getElementById('search');
const provinceSelect = document.getElementById('province');
const hostelGrid = document.querySelector('.hostel-grid');

function filterHostels() {
    const search = searchInput.value.trim();
    const province = provinceSelect.value || '';
    const typeRadio = document.querySelector('input[name="type"]:checked');
    const type = typeRadio ? typeRadio.value : 'All';

    fetch(`../../backend/fetch_hostels.php?search=${encodeURIComponent(search)}&province=${encodeURIComponent(province)}&type=${encodeURIComponent(type)}`)
        .then(res => res.text())
        .then(data => {
            hostelGrid.innerHTML = data;
        })
        .catch(err => console.error(err));
}

// Trigger filtering as user types
searchInput.addEventListener('input', filterHostels);

// Initial load
filterHostels();

