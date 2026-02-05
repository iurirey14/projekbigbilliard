@extends('layouts.app')

@section('title', 'Pesan Meja Billiard')

@section('content')
    <div style="max-width: 600px; margin: 0 auto;">
        <h2>Pesan Meja Billiard</h2>
        
        <form method="POST" action="{{ route('bookings.store') }}" class="card">
            @csrf
            
            <div class="form-group">
                <label>Pilih Meja</label>
                <select name="table_id" required>
                    <option value="">-- Pilih Meja --</option>
                    @foreach($tables as $table)
                        <option value="{{ $table->id }}">{{ $table->table_name }} - Rp {{ number_format($table->price_per_hour, 0, ',', '.') }}/jam</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Tanggal Pemesanan</label>
                <input type="date" name="booking_date" required min="{{ date('Y-m-d', strtotime('+1 day')) }}">
            </div>

            <div class="form-group">
                <label>Jam Mulai</label>
                <input type="time" name="start_time" required>
            </div>

            <div class="form-group">
                <label>Durasi (Jam)</label>
                <input type="number" name="duration_hours" min="1" max="12" value="1" required>
            </div>

            <div class="form-group">
                <label>Kategori Meja</label>
                <select name="category" required>
                    <option value="">-- Pilih Kategori --</option>
                    <option value="regular">Regular</option>
                    <option value="vip">VIP</option>
                </select>
            </div>

            <div class="form-group">
                <label>Catatan (Opsional)</label>
                <textarea name="notes" placeholder="Tambahkan catatan pemesanan Anda..."></textarea>
            </div>

            <div class="summary">
                <h3>Ringkasan Pemesanan</h3>
                <div class="summary-item">
                    <span>Meja:</span>
                    <span id="selected-table">-</span>
                </div>
                <div class="summary-item">
                    <span>Tanggal:</span>
                    <span id="selected-date">-</span>
                </div>
                <div class="summary-item">
                    <span>Jam:</span>
                    <span id="selected-time">-</span>
                </div>
                <div class="summary-item">
                    <span>Durasi:</span>
                    <span id="selected-duration">-</span>
                </div>
                <div class="summary-item">
                    <span>Kategori:</span>
                    <span id="selected-category">-</span>
                </div>
                <div class="summary-total">
                    <span>Total Harga:</span>
                    <span id="total-price">Rp 0</span>
                </div>
            </div>

            <button type="submit" class="btn btn-success" style="width: 100%; margin-top: 1.5rem; padding: 1rem;">Lanjut ke Pembayaran</button>
            <a href="{{ route('tables.index') }}" class="btn" style="width: 100%; margin-top: 1rem; padding: 1rem; text-align: center; background: #999;">Kembali</a>
        </form>
    </div>

   <script>
    // 1. Ambil data dari PHP ke format JSON yang valid untuk JS
    const tables = {!! json_encode($tables->keyBy('id')->toArray()) !!};

    const tableSelect = document.querySelector('select[name="table_id"]');
    const dateInput = document.querySelector('input[name="booking_date"]');
    const startTimeInput = document.querySelector('input[name="start_time"]');
    const durationInput = document.querySelector('input[name="duration_hours"]');
    const categorySelect = document.querySelector('select[name="category"]');

    function updateSummary() {
        const tableId = tableSelect.value;
        const duration = parseInt(durationInput.value);
        const category = categorySelect.value;

        // Validasi apakah semua input sudah terisi
        if (tableId && dateInput.value && startTimeInput.value && duration && category) {
            const table = tables[tableId]; // Mengambil data meja berdasarkan ID
            const totalPrice = table.price_per_hour * duration;

            // Update tampilan ringkasan
            document.getElementById('selected-table').textContent = table.table_name;
            document.getElementById('selected-date').textContent = new Date(dateInput.value).toLocaleDateString('id-ID', {
                day: 'numeric', 
                month: 'long', 
                year: 'numeric'
            });
            document.getElementById('selected-time').textContent = startTimeInput.value;
            document.getElementById('selected-duration').textContent = duration + ' jam';
            document.getElementById('selected-category').textContent = category === 'regular' ? 'Regular' : 'VIP';
            document.getElementById('total-price').textContent = 'Rp ' + totalPrice.toLocaleString('id-ID');
        }
    }

    // 2. Event listener untuk setiap perubahan input
    tableSelect.addEventListener('change', updateSummary);
    dateInput.addEventListener('change', updateSummary);
    startTimeInput.addEventListener('change', updateSummary);
    durationInput.addEventListener('change', updateSummary);
    categorySelect.addEventListener('change', updateSummary);

    // 3. Panggil updateSummary saat halaman pertama kali dimuat
    updateSummary();
</script>
@endsection
