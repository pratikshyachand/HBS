document.addEventListener('DOMContentLoaded', function() {
    const cancelBtn = document.getElementById('cancelBookingBtn');
    const modal = document.getElementById('cancelModal');
    const closeBtn = document.querySelector('#cancelModal .close');
    const cancelModalBtn = document.getElementById('cancelModalBtn');
    const confirmCancelBtn = document.getElementById('confirmCancelBtn');
    const bookingInput = document.getElementById('booking_id'); // hidden input

    // Function to show popup messages
    function showPopup(message, success = true) {
        const popup = document.createElement('div');
        popup.className = "popup-message popup " + (success ? 'success' : 'error');
        popup.innerHTML = `<p>${message}</p><span class="popup-close" onclick="this.parentElement.remove()">×</span>`;
        document.body.appendChild(popup);
        setTimeout(() => popup.remove(), 4000);
    }

    // Open modal on button click
    if (cancelBtn && modal) {
        cancelBtn.addEventListener('click', function() {
            modal.style.display = 'flex';
        });
    }

    // Close modal
    if (closeBtn) closeBtn.onclick = () => modal.style.display = 'none';
    if (cancelModalBtn) cancelModalBtn.onclick = () => modal.style.display = 'none';
    window.onclick = (event) => { if (event.target == modal) modal.style.display = 'none'; };

    // Confirm cancel
    if (confirmCancelBtn) {
        confirmCancelBtn.onclick = async function() {
            const bookingId = bookingInput.value;
            if (!bookingId) {
                showPopup("❌ Booking ID not found.", false);
                return;
            }

            try {
                const response = await fetch("../../backend/cancel_booking.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/x-www-form-urlencoded" },
                    body: "booking_id=" + encodeURIComponent(bookingId)
                });

                const data = await response.json();

                if (data.success) {
                    const statusEl = document.querySelector(".booking-status");
                    statusEl.innerText = "cancelled";
                    statusEl.className = "booking-status cancelled";
                    showPopup(data.msg || "✅ Booking cancelled successfully!");
                } else {
                    showPopup(data.msg || "❌ This booking is already cancelled.", false);
                }
            } catch (err) {
                console.error(err);
                showPopup("❌ Request failed. Please try again.", false);
            } finally {
                modal.style.display = 'none';
            }
        };
    }
});
