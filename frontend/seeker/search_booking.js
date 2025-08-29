
    const searchInput = document.querySelector('.search-box input');
    const searchBtn = document.querySelector('.search-box button');
    const filterButtons = document.querySelectorAll('.filter-btn');
    let activeFilter = "All Bookings"; // default

    function applyFilters() {
        const searchTerm = searchInput.value.toLowerCase();
        const orders = document.querySelectorAll('.order-card');

        orders.forEach(order => {
            const hostel = order.querySelector('.seller-name').textContent.toLowerCase();
            const room = order.querySelector('.product-nam').textContent.toLowerCase();
            const bookingId = order.querySelector('.product-name').textContent.toLowerCase();
            const status = order.getAttribute('data-status');

            // Search match
            const matchesSearch = hostel.includes(searchTerm) || room.includes(searchTerm) || bookingId.includes(searchTerm);

            // Filter match
            const matchesFilter = (activeFilter === "All Bookings") || (status.toLowerCase() === activeFilter.toLowerCase());

            // Show only if both conditions match
            if (matchesSearch && matchesFilter) {
                order.style.display = 'block';
            } else {
                order.style.display = 'none';
            }
        });
    }

    // Search button
    searchBtn.addEventListener('click', applyFilters);

    // Enter key
    searchInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            applyFilters();
        }
    });

    // Filter buttons
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            filterButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            activeFilter = this.getAttribute('data-status') || "All Bookings";
            applyFilters();
        });
    });

