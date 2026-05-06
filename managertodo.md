# Manager Dashboard Todo List (Whoosh Style)

Daftar fitur dan metrik yang wajib ada di dashboard Manager untuk sistem transportasi kereta cepat premium seperti Swift Express (Whoosh).

## 1. Analisis Pendapatan (Revenue Analytics)
- [x] **Revenue Trends**: Grafik pertumbuhan pendapatan bulanan/mingguan.
- [x] **Sales by Ticket Class**: Perbandingan pendapatan dari Executive, Business, dan Economy.
- [x] **RevPAS (Revenue per Available Seat)**: Metrik efisiensi pendapatan per kursi yang tersedia.
- [x] **Payment Method Analytics**: Analisis metode pembayaran yang paling sering digunakan (QRIS, VA, dll).

## 2. Wawasan Penumpang (Passenger Insights)
- [x] **Passenger Volume per Class**: Jumlah penumpang di setiap kelas kursi.
- [x] **Peak Booking Hours**: Analisis jam-jam paling sibuk di mana tiket paling banyak dipesan.
- [x] **Booking Lead Time**: Berapa hari sebelum keberangkatan rata-rata penumpang memesan tiket.
- [x] **Passenger Demographics**: Data umur dan kategori penumpang (Umum, Lansia, Anak-anak).

## 3. Performa Armada & Operasional (Fleet & Operations)
- [x] **Occupancy Rate (Load Factor)**: Persentase keterisian kursi pada setiap rangkaian kereta.
- [x] **Most Profitable Routes**: Rute yang menghasilkan pendapatan tertinggi (Halim-Padalarang vs Halim-Tegalluar).
- [x] **Station Traffic Flow**: Analisis kepadatan penumpang di setiap stasiun pada jam tertentu.

---

## 4. Item yang Di-skip (Butuh Integrasi/Data Eksternal)
Fitur di bawah ini membutuhkan tabel database baru, sensor hardware, atau algoritma kompleks yang tidak memungkinkan untuk diimplementasikan saat ini:

- [ ] **On-Time Performance (OTP)**: Membutuhkan data jam keberangkatan/kedatangan aktual (real-time) vs jadwal.
- [ ] **Train Unit Efficiency**: Membutuhkan data teknis konsumsi energi, suhu motor, dan jadwal maintenance fisik.
- [ ] **Dynamic Pricing Recommendations**: Membutuhkan pricing engine berbasis AI yang mengubah harga tiket berdasarkan demand real-time.
- [ ] **Customer Satisfaction Score (CSAT)**: Membutuhkan sistem survey/feedback penumpang setelah perjalanan selesai.

---
*Catatan: Item dengan tanda [x] sudah diimplementasikan dalam dashboard saat ini.*
