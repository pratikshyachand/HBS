
const filterOptions = document.querySelectorAll('.filter-option');
const hostelCards = document.querySelectorAll('.hostel-card');
const provinceSelect = document.getElementById('province');
const districtSelect = document.getElementById('district');
const municipalitySelect = document.getElementById('municipality');

function filterHostels() {
    const selectedType = document.querySelector('.filter-option.active').textContent.toLowerCase();
    const selectedProvince = provinceSelect.value;
    const selectedDistrict = districtSelect.value;
    const selectedMunicipality = municipalitySelect.value;

    hostelCards.forEach(card => {
        let show = true;

        // Filter by type
       if (selectedType !== 'all') {
    if (selectedType === 'travellers' && card.dataset.type === 'traveller') {
        show = true;
    } else if (card.dataset.type !== selectedType) {
        show = false;
    }
}

        // Filter by province
        if (selectedProvince && card.dataset.province !== selectedProvince) {
            show = false;
        }

        // Filter by district
        if (selectedDistrict && card.dataset.district !== selectedDistrict) {
            show = false;
        }

        // Filter by municipality
        if (selectedMunicipality && card.dataset.municipality !== selectedMunicipality) {
            show = false;
        }

        card.style.display = show ? 'block' : 'none';
    });
}

// Trigger filter on selecting hostel type
filterOptions.forEach(option => {
    option.addEventListener('click', () => filterHostels());
});

// Trigger filter on location change
[provinceSelect, districtSelect, municipalitySelect].forEach(select => {
    select.addEventListener('change', () => filterHostels());
});

