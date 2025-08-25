
document.addEventListener('DOMContentLoaded', function() {
    // Prefill districts if province selected
    const selectedProvince = "<?php echo $_SESSION['form_data']['province'] ?? ''; ?>";
    const selectedDistrict = "<?php echo $_SESSION['form_data']['district'] ?? ''; ?>";
    const selectedMunicipality = "<?php echo $_SESSION['form_data']['municipality'] ?? ''; ?>";

    if(selectedProvince){
        getDistricts(selectedProvince, selectedDistrict, selectedMunicipality);
    }
});

function getDistricts(provinceID, selectedDistrict = '', selectedMunicipality = ''){
    if(!provinceID) return;
    fetch('../../backend/district.php?province_id=' + provinceID)
    .then(res => res.json())
    .then(data => {
        const districtSelect = document.getElementById('district');
        districtSelect.innerHTML = '<option value="">Select District</option>';
        data.forEach(d => {
            const selected = (d.id == selectedDistrict) ? 'selected' : '';
            districtSelect.innerHTML += `<option value="${d.id}" ${selected}>${d.title}</option>`;
        });
        if(selectedDistrict) getMunicipalities(selectedDistrict, selectedMunicipality);
    });
}

function getMunicipalities(districtID, selectedMunicipality = ''){
    if(!districtID) return;
    fetch('../../backend/municipality.php?district_id=' + districtID)
    .then(res => res.json())
    .then(data => {
        const munSelect = document.getElementById('municipality');
        munSelect.innerHTML = '<option value="">Select Municipality</option>';
        data.forEach(m => {
            const selected = (m.id == selectedMunicipality) ? 'selected' : '';
            munSelect.innerHTML += `<option value="${m.id}" ${selected}>${m.title}</option>`;
        });
    });
}

