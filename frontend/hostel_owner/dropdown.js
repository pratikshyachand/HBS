function getDistricts(provinceID,formName)
{
    console.log('called');
    let districtDropDown = document.forms[formName].district;

    if(provinceID === "")
        {
            districtDropDown.disabled = true;
            districtDropDown.selectedIndex = 0;
            districtDropDown.innerHTML = '<option value="" selected disabled>Select District</option>'
            return false;
        }
    
        fetch(`../../backend/province.php?id=${provinceID}`)
        .then(response => response.json())
        .then(function(districts){
            let out = "";
            if (formName !== 'edit-hostel') out += '<option value="" selected disabled>Select District</option>';

            for(let district of districts)
            {
               out += `<option value="${district.id}">${district.title}</option>`;
  
            }
            districtDropDown.innerHTML = out; 
            districtDropDown.disabled = false;

        });
          
}

function getMunicipalities(districtID,formName)
{
    let municipalityDropDown = document.forms[formName].municipality;
    console.log("District id is ",districtID);

    if(districtID === "")
        {   
            municipalityDropDown.disabled = true;
            municipalityDropDown.selectedIndex = 0;
            municipalityDropDown.innerHTML = '<option value="" selected disabled>Select District</option>'
            return false;
        }
    
        fetch(`../../backend/district.php?id=${districtID}`)
        .then(response => response.json())
        .then(function(municipalities){
            let out = "";
            if (formName !== 'edit-hostel') out += '<option value="" selected disabled>Select Municipality</option>';

            for(let municipality of municipalities)
            {
               out += `<option value="${municipality.id}">${municipality.title}</option>`;
  
            }
            municipalityDropDown.innerHTML = out ;
            municipalityDropDown.disabled = false;

        });
          
}