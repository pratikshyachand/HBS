// Dynamic search filter
document.getElementById('searchInput').addEventListener('keyup', function() {
    const keyword = this.value.toLowerCase();
    const rows = document.querySelectorAll('#tableBody tr');

    rows.forEach(row => {
        const cells = row.querySelectorAll('td');
        let found = false;

        cells.forEach(cell => {
            if (cell.textContent.toLowerCase().includes(keyword)) {
                found = true;
            }
        });

        row.style.display = found ? '' : 'none';
    });
});
