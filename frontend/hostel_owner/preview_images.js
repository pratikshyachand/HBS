// Cover Image Preview
function previewCoverImage(input) {
    const container = input.parentElement.querySelector('.preview-container');
    container.innerHTML = ''; // Clear previous preview

    if (input.files && input.files[0]) {
        const file = input.files[0];
        const reader = new FileReader();

        reader.onload = function(e) {
            const wrapper = document.createElement('div');
            wrapper.style.position = 'relative';
            wrapper.style.display = 'inline-block';

            const img = document.createElement('img');
            img.src = e.target.result;
            img.style.width = '150px';
            img.style.height = '150px';
            img.style.objectFit = 'cover';
            img.style.borderRadius = '8px';
            wrapper.appendChild(img);

            const removeBtn = document.createElement('button');
            removeBtn.type = 'button';
            removeBtn.innerText = '✖';
            removeBtn.style.position = 'absolute';
            removeBtn.style.top = '2px';
            removeBtn.style.right = '2px';
            removeBtn.style.background = 'rgba(0,0,0,0.6)';
            removeBtn.style.color = '#fff';
            removeBtn.style.border = 'none';
            removeBtn.style.borderRadius = '50%';
            removeBtn.style.width = '20px';
            removeBtn.style.height = '20px';
            removeBtn.style.cursor = 'pointer';
            removeBtn.onclick = function() {
                input.value = '';
                container.innerHTML = '';
            };
            wrapper.appendChild(removeBtn);

            container.appendChild(wrapper);
        }

        reader.readAsDataURL(file);
    }
}

// Gallery Images Preview
function previewGalleryImages(input) {
    const container = input.parentElement.querySelector('.gallery-preview-container');
    container.innerHTML = ''; // Clear previous previews

    Array.from(input.files).forEach((file, index) => {
        const reader = new FileReader();

        reader.onload = function(e) {
            const wrapper = document.createElement('div');
            wrapper.style.position = 'relative';
            wrapper.style.display = 'inline-block';
            wrapper.style.margin = '5px';

            const img = document.createElement('img');
            img.src = e.target.result;
            img.style.width = '120px';
            img.style.height = '120px';
            img.style.objectFit = 'cover';
            img.style.borderRadius = '8px';
            wrapper.appendChild(img);

            const removeBtn = document.createElement('button');
            removeBtn.type = 'button';
            removeBtn.innerText = '✖';
            removeBtn.style.position = 'absolute';
            removeBtn.style.top = '2px';
            removeBtn.style.right = '2px';
            removeBtn.style.background = 'rgba(0,0,0,0.6)';
            removeBtn.style.color = '#fff';
            removeBtn.style.border = 'none';
            removeBtn.style.borderRadius = '50%';
            removeBtn.style.width = '20px';
            removeBtn.style.height = '20px';
            removeBtn.style.cursor = 'pointer';
            removeBtn.onclick = function() {
                removeGalleryImage(index, input);
            };
            wrapper.appendChild(removeBtn);

            container.appendChild(wrapper);
        }

        reader.readAsDataURL(file);
    });
}

// Remove gallery image
function removeGalleryImage(index, input) {
    const dt = new DataTransfer();
    Array.from(input.files).forEach((file, i) => {
        if (i !== index) dt.items.add(file);
    });
    input.files = dt.files;

    previewGalleryImages(input);
}
