document.addEventListener('DOMContentLoaded', () => {
    const statusButtons = document.querySelectorAll('.filter-btn');
    const dateButtons = document.querySelectorAll('.filter-btn-date');
    const orderCards = document.querySelectorAll('.order-card');

    let selectedStatus = 'all';
    let selectedDate = 'all';

    function filterBookings() {
        const now = new Date();
        const yyyy = now.getFullYear();
        const mm = String(now.getMonth() + 1).padStart(2, '0');
        const dd = String(now.getDate()).padStart(2, '0');
        const todayStr = `${yyyy}-${mm}-${dd}`;
        const monthStr = `${yyyy}-${mm}`;

        // last 7 days for week filter
        const last7Days = [];
        for (let i = 0; i < 7; i++) {
            const d = new Date();
            d.setDate(now.getDate() - i);
            const dStr = `${d.getFullYear()}-${String(d.getMonth() + 1).padStart(2,'0')}-${String(d.getDate()).padStart(2,'0')}`;
            last7Days.push(dStr);
        }

        orderCards.forEach(card => {
            const status = card.getAttribute('data-status').trim();
            const bookingDate = card.getAttribute('data-date').trim();

            // Status filter
            const statusMatch = selectedStatus === 'all' || status === selectedStatus.toLowerCase();

            // Date filter
            let dateMatch = false;
            switch(selectedDate) {
                case 'all':
                    dateMatch = true;
                    break;
                case 'today':
                    dateMatch = bookingDate === todayStr;
                    break;
                case 'week':
                    dateMatch = last7Days.includes(bookingDate);
                    break;
                case 'month':
                    dateMatch = bookingDate.startsWith(monthStr);
                    break;
            }

            card.style.display = (statusMatch && dateMatch) ? 'block' : 'none';
        });
    }

    // Status button clicks
    statusButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            statusButtons.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            selectedStatus = btn.getAttribute('data-status') || 'all';
            filterBookings();
        });
    });

    // Date button clicks
    dateButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            dateButtons.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            selectedDate = btn.getAttribute('data-date') || 'all';
            filterBookings();
        });
    });

    // Initial load
    filterBookings();
});
