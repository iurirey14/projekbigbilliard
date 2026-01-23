// ============ DATA STORAGE ============
let currentUser = {
    id: 1,
    name: 'John Doe',
    email: 'john@example.com'
};

let tables = [
    { id: 1, table_name: 'Meja Premium A', price_per_hour: 50000, status: 'available' },
    { id: 2, table_name: 'Meja Premium B', price_per_hour: 50000, status: 'available' },
    { id: 3, table_name: 'Meja Standard 1', price_per_hour: 30000, status: 'booked' },
    { id: 4, table_name: 'Meja Standard 2', price_per_hour: 30000, status: 'available' },
    { id: 5, table_name: 'Meja VIP Eksklusif', price_per_hour: 75000, status: 'available' }
];

let bookings = [
    {
        id: 1,
        table_id: 1,
        table_name: 'Meja Premium A',
        booking_date: '2026-01-25',
        start_time: '10:00',
        duration: 2,
        total_price: 100000,
        status: 'confirmed',
        notes: 'Booking untuk event'
    },
    {
        id: 2,
        table_id: 3,
        table_name: 'Meja Standard 1',
        booking_date: '2026-01-23',
        start_time: '14:00',
        duration: 1,
        total_price: 30000,
        status: 'completed',
        notes: ''
    }
];

let payments = [
    {
        id: 'TRX-001',
        booking_id: 2,
        table_name: 'Meja Standard 1',
        booking_date: '2026-01-23',
        amount: 30000,
        method: 'transfer_bank',
        status: 'paid',
        payment_date: '2026-01-23'
    },
    {
        id: 'TRX-002',
        booking_id: 1,
        table_name: 'Meja Premium A',
        booking_date: '2026-01-25',
        amount: 100000,
        method: 'credit_card',
        status: 'paid',
        payment_date: '2026-01-22'
    }
];

let currentBooking = null;

// ============ PAGE NAVIGATION ============
function showPage(pageName) {
    // Hide all pages
    document.querySelectorAll('.page').forEach(page => {
        page.classList.remove('active');
    });

    // Show selected page
    const page = document.getElementById(pageName);
    if (page) {
        page.classList.add('active');

        // Initialize page content
        if (pageName === 'tables') {
            renderTables();
        } else if (pageName === 'bookings') {
            renderTableSelect();
            renderBookingHistory();
        } else if (pageName === 'payments') {
            renderPaymentHistory();
        }
    }

    // Scroll to top
    window.scrollTo(0, 0);
}

// ============ HOME PAGE ============
// Home page loads automatically

// ============ TABLES PAGE ============
function renderTables() {
    const grid = document.getElementById('tablesGrid');
    grid.innerHTML = '';

    tables.forEach(table => {
        const statusClass = table.status === 'available' ? 'status-available' : 'status-booked';
        const statusText = table.status === 'available' ? 'Tersedia' : 'Dipesan';

        const card = document.createElement('div');
        card.className = 'table-card';
        card.innerHTML = `
            <div class="table-number">🎱 #${table.id}</div>
            <div class="table-name">${table.table_name}</div>
            <span class="table-status ${statusClass}">${statusText}</span>
            <div class="table-price">
                Rp ${formatCurrency(table.price_per_hour)}
                <small>per jam</small>
            </div>
            <button class="btn btn-primary btn-small" 
                    onclick="selectTableForBooking(${table.id})"
                    ${table.status === 'booked' ? 'disabled' : ''}>
                Pesan Sekarang
            </button>
        `;
        grid.appendChild(card);
    });
}

function selectTableForBooking(tableId) {
    showPage('bookings');
    document.getElementById('tableSelect').value = tableId;
    updateSummary();
}

// ============ BOOKINGS PAGE ============
function renderTableSelect() {
    const select = document.getElementById('tableSelect');
    select.innerHTML = '<option value="">-- Pilih Meja --</option>';

    tables.forEach(table => {
        const option = document.createElement('option');
        option.value = table.id;
        option.textContent = `${table.table_name} (Rp ${formatCurrency(table.price_per_hour)}/jam)`;
        select.appendChild(option);
    });

    // Set minimum date to today
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('bookingDate').min = today;
}

function updateSummary() {
    const tableId = document.getElementById('tableSelect').value;
    const bookingDate = document.getElementById('bookingDate').value;
    const startTime = document.getElementById('startTime').value;
    const duration = parseInt(document.getElementById('duration').value) || 0;

    const table = tables.find(t => t.id == tableId);

    // Update summary
    document.getElementById('summaryTable').textContent = table ? table.table_name : '-';
    document.getElementById('summaryDate').textContent = bookingDate ? formatDate(bookingDate) : '-';
    document.getElementById('summaryTime').textContent = startTime ? startTime : '-';
    document.getElementById('summaryDuration').textContent = duration ? `${duration} jam` : '-';

    // Calculate price
    const totalPrice = table ? table.price_per_hour * duration : 0;
    document.getElementById('summaryPrice').textContent = `Rp ${formatCurrency(totalPrice)}`;
}

// Add event listeners for summary updates
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('tableSelect').addEventListener('change', updateSummary);
    document.getElementById('bookingDate').addEventListener('change', updateSummary);
    document.getElementById('startTime').addEventListener('change', updateSummary);
    document.getElementById('duration').addEventListener('change', updateSummary);
});

function submitBooking(event) {
    event.preventDefault();

    const tableId = parseInt(document.getElementById('tableSelect').value);
    const bookingDate = document.getElementById('bookingDate').value;
    const startTime = document.getElementById('startTime').value;
    const duration = parseInt(document.getElementById('duration').value);
    const notes = document.getElementById('notes').value;

    if (!tableId || !bookingDate || !startTime || !duration) {
        alert('Mohon lengkapi semua field yang diperlukan');
        return;
    }

    if (duration < 1 || duration > 12) {
        alert('Durasi harus antara 1-12 jam');
        return;
    }

    const table = tables.find(t => t.id === tableId);
    const totalPrice = table.price_per_hour * duration;

    // Create booking
    currentBooking = {
        table_id: tableId,
        table_name: table.table_name,
        booking_date: bookingDate,
        start_time: startTime,
        duration: duration,
        total_price: totalPrice,
        notes: notes
    };

    // Show payment modal
    showPaymentModal(totalPrice);
}

function renderBookingHistory() {
    const tbody = document.getElementById('bookingHistory');
    tbody.innerHTML = '';

    if (bookings.length === 0) {
        tbody.innerHTML = '<tr><td colspan="7" class="empty-state">Belum ada riwayat pemesanan</td></tr>';
        return;
    }

    bookings.forEach(booking => {
        const statusClass = `status-${booking.status}`;
        const statusText = {
            'confirmed': 'Dikonfirmasi',
            'completed': 'Selesai',
            'cancelled': 'Dibatalkan'
        }[booking.status] || booking.status;

        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${booking.table_name}</td>
            <td>${formatDate(booking.booking_date)}</td>
            <td>${booking.start_time}</td>
            <td>${booking.duration} jam</td>
            <td>Rp ${formatCurrency(booking.total_price)}</td>
            <td><span class="status-badge ${statusClass}">${statusText}</span></td>
            <td>
                <button class="btn btn-secondary btn-small" onclick="viewBookingDetail(${booking.id})">
                    Lihat
                </button>
            </td>
        `;
        tbody.appendChild(row);
    });
}

function viewBookingDetail(bookingId) {
    const booking = bookings.find(b => b.id === bookingId);
    if (booking) {
        alert(`Detail Pemesanan:\n\nMeja: ${booking.table_name}\nTanggal: ${formatDate(booking.booking_date)}\nWaktu: ${booking.start_time}\nDurasi: ${booking.duration} jam\nTotal: Rp ${formatCurrency(booking.total_price)}\nStatus: ${booking.status}`);
    }
}

// ============ PAYMENTS PAGE ============
function renderPaymentHistory() {
    const tbody = document.getElementById('paymentHistory');
    tbody.innerHTML = '';

    if (payments.length === 0) {
        tbody.innerHTML = '<tr><td colspan="7" class="empty-state">Belum ada riwayat pembayaran</td></tr>';
        return;
    }

    payments.forEach(payment => {
        const statusClass = `status-${payment.status}`;
        const statusText = payment.status === 'paid' ? 'Lunas' : 'Pending';

        const methodText = {
            'transfer_bank': '🏦 Transfer Bank',
            'credit_card': '💳 Kartu Kredit',
            'e_wallet': '📱 E-Wallet',
            'cash': '💵 Tunai'
        }[payment.method] || payment.method;

        const row = document.createElement('tr');
        row.innerHTML = `
            <td><strong>${payment.id}</strong></td>
            <td>${payment.table_name}</td>
            <td>${formatDate(payment.booking_date)}</td>
            <td>Rp ${formatCurrency(payment.amount)}</td>
            <td>${methodText}</td>
            <td><span class="status-badge ${statusClass}">${statusText}</span></td>
            <td>
                <button class="btn btn-secondary btn-small" onclick="showReceipt('${payment.id}')">
                    🧾 Kwitansi
                </button>
            </td>
        `;
        tbody.appendChild(row);
    });
}

// ============ MODALS ============
function showPaymentModal(totalPrice) {
    const modal = document.getElementById('paymentModal');
    
    if (currentBooking) {
        const table = tables.find(t => t.id === currentBooking.table_id);
        document.getElementById('paymentTable').textContent = currentBooking.table_name;
        document.getElementById('paymentDate').textContent = formatDate(currentBooking.booking_date) + ' ' + currentBooking.start_time;
        document.getElementById('paymentAmount').textContent = `Rp ${formatCurrency(totalPrice)}`;
    }

    modal.classList.add('show');
}

function closeModal() {
    document.getElementById('paymentModal').classList.remove('show');
}

function closeReceiptModal() {
    document.getElementById('receiptModal').classList.remove('show');
}

function processPayment() {
    const method = document.querySelector('input[name="method"]:checked').value;

    if (!currentBooking) {
        alert('Terjadi kesalahan. Silakan coba lagi.');
        return;
    }

    // Create new booking
    const newBooking = {
        id: Math.max(...bookings.map(b => b.id), 0) + 1,
        table_id: currentBooking.table_id,
        table_name: currentBooking.table_name,
        booking_date: currentBooking.booking_date,
        start_time: currentBooking.start_time,
        duration: currentBooking.duration,
        total_price: currentBooking.total_price,
        status: 'confirmed',
        notes: currentBooking.notes
    };

    // Create new payment
    const newPayment = {
        id: `TRX-${String(payments.length + 1).padStart(3, '0')}`,
        booking_id: newBooking.id,
        table_name: currentBooking.table_name,
        booking_date: currentBooking.booking_date,
        amount: currentBooking.total_price,
        method: method,
        status: 'paid',
        payment_date: new Date().toISOString().split('T')[0]
    };

    // Add to arrays
    bookings.push(newBooking);
    payments.push(newPayment);

    // Close payment modal
    closeModal();

    // Show receipt
    showReceiptModal(newPayment);

    // Reset form
    document.getElementById('tableSelect').value = '';
    document.getElementById('bookingDate').value = '';
    document.getElementById('startTime').value = '';
    document.getElementById('duration').value = '1';
    document.getElementById('notes').value = '';
    updateSummary();

    // Update booking status in tables
    const table = tables.find(t => t.id === currentBooking.table_id);
    if (table && new Date(currentBooking.booking_date).toDateString() === new Date().toDateString()) {
        table.status = 'booked';
    }

    currentBooking = null;
}

function showReceiptModal(payment) {
    const booking = bookings.find(b => b.id === payment.booking_id);
    
    if (booking) {
        document.getElementById('receiptId').textContent = payment.id;
        document.getElementById('receiptDate').textContent = formatDate(payment.payment_date);
        document.getElementById('receiptTableName').textContent = booking.table_name;
        document.getElementById('receiptBookingDate').textContent = formatDate(booking.booking_date);
        document.getElementById('receiptTime').textContent = booking.start_time;
        document.getElementById('receiptDuration').textContent = `${booking.duration} jam`;
        document.getElementById('receiptSubtotal').textContent = `Rp ${formatCurrency(booking.total_price)}`;
        document.getElementById('receiptTotal').textContent = `Rp ${formatCurrency(payment.amount)}`;
        
        const methodText = {
            'transfer_bank': 'Transfer Bank',
            'credit_card': 'Kartu Kredit',
            'e_wallet': 'E-Wallet',
            'cash': 'Tunai'
        }[payment.method] || payment.method;
        
        document.getElementById('receiptMethod').textContent = methodText;

        document.getElementById('receiptModal').classList.add('show');
    }
}

function showReceipt(paymentId) {
    const payment = payments.find(p => p.id === paymentId);
    if (payment) {
        showReceiptModal(payment);
    }
}

function printReceipt() {
    window.print();
}

function downloadReceipt() {
    const receiptId = document.getElementById('receiptId').textContent;
    alert(`Kwitansi ${receiptId} berhasil diunduh sebagai PDF`);
}

// ============ UTILITY FUNCTIONS ============
function formatCurrency(amount) {
    return new Intl.NumberFormat('id-ID').format(amount);
}

function formatDate(dateString) {
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    const date = new Date(dateString);
    return date.toLocaleDateString('id-ID', options);
}

function switchTab(tabName) {
    // Hide all tab contents
    document.querySelectorAll('.tab-content').forEach(tab => {
        tab.classList.remove('active');
    });

    // Remove active class from all tab buttons
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('active');
    });

    // Show selected tab
    const tab = document.getElementById(tabName);
    if (tab) {
        tab.classList.add('active');
    }

    // Add active class to clicked button
    event.target.classList.add('active');
}

function logout() {
    if (confirm('Apakah Anda yakin ingin logout?')) {
        alert('Anda telah berhasil logout');
        // Redirect or reset
        showPage('home');
    }
}

// ============ INITIALIZATION ============
document.addEventListener('DOMContentLoaded', function() {
    // Show home page on load
    showPage('home');
    
    // Set minimum date for booking
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('bookingDate').min = today;

    // Render tables for selection
    renderTableSelect();
});

// Close modal when clicking outside
window.onclick = function(event) {
    const paymentModal = document.getElementById('paymentModal');
    const receiptModal = document.getElementById('receiptModal');
    
    if (event.target == paymentModal) {
        paymentModal.classList.remove('show');
    }
    if (event.target == receiptModal) {
        receiptModal.classList.remove('show');
    }
}
