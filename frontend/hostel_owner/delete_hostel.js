document.addEventListener('DOMContentLoaded', function() {
    const deleteBtn = document.getElementById('deleteHostelBtn');
    const modal = document.getElementById('deleteModal');
    const cancelBtn = document.getElementById('cancelDelete');
    const closeBtn = document.querySelector('#deleteModal .close');
    const confirmBtn = document.getElementById('confirmDelete');
    const hostelSelect = document.getElementById('hostel_id');

    function showPopup(message, success = true) {
        const popup = document.createElement('div');
        popup.className = "popup-message popup";  
        popup.innerHTML = `<p>${message}</p><span class="popup-close" onclick="this.parentElement.remove()">×</span>`;
        document.body.appendChild(popup);  
        setTimeout(() => popup.remove(), 4000);
    }
    
    if (deleteBtn && modal) {
        deleteBtn.addEventListener('click', function() {
            if (!hostelSelect.value) {
                showPopup(`⚠️ Please select a hostel first.`, false);
                return;
            }
            modal.style.display = 'flex';
        });
    }

    if (closeBtn) closeBtn.onclick = () => modal.style.display = 'none';
    if (cancelBtn) cancelBtn.onclick = () => modal.style.display = 'none';

    if (confirmBtn) {
        confirmBtn.onclick = async function() {
            const selectedHostel = hostelSelect.value;
            if (!selectedHostel) return;

            try {
                const response = await fetch('../../backend/delete_hostel.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `id=${encodeURIComponent(selectedHostel)}`
                });

                const result = await response.json();

                if (response.ok && result.success) {
                    showPopup("✅ Hostel deleted successfully!");
                    hostelSelect.querySelector(`option[value="${selectedHostel}"]`).remove(); // remove from dropdown
                    hostelSelect.value = ""; // reset selection
                } else {
                    showPopup(result.message || "❌ Error deleting hostel.", false);
                }
            } catch (error) {
                console.error(error);
                showPopup("❌ Server error. Please try again later.", false);
            } finally {
                modal.style.display = 'none';
            }
        }
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
});
