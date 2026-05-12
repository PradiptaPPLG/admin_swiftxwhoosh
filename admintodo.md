# Admin Dashboard Todo List (Swift Express System)

Daftar fitur dan metrik yang wajib ada di dashboard Admin untuk pemantauan teknis, keamanan, dan pengelolaan data sistem Swift Express.

## 1. Pemantauan Sistem (System Monitoring)
- [x] **Real-time Server Health**: Grafik beban CPU, RAM, dan Database (Visualized/Mocked).
- [x] **API Latency & Performance**: Monitoring kecepatan respon sistem (Visualized/Mocked).
- [x] **Active Sessions**: Jumlah pengguna/admin yang sedang login secara bersamaan.
- [x] **Last Backup Status**: Informasi kapan terakhir kali database di-backup (Visualized/Mocked).

## 2. Keamanan & Log (Security & Auditing)
- [x] **Comprehensive Activity Logs**: Log detail aktivitas admin (Integrated from database).
- [x] **Login History**: Riwayat login admin (Integrated with Activity Logs).
- [ ] **Permission Management** (SKIP: Butuh sistem RBAC kompleks).

## 3. Manajemen Pengguna & Data (Data Management)
- [x] **User Control Center**: Fitur untuk mencari user (Quick Search Integrated) dan manajemen akun.
- [x] **Registration Trends**: Grafik pertumbuhan pengguna baru setiap hari/minggu.
- [x] **Data Integrity Check**: Validasi bentrok jadwal untuk mencegah double-booking fisik kereta.

## 4. Aliran Transaksi (Transaction Stream)
- [x] **Real-time Booking Feed**: Daftar transaksi terbaru yang masuk ke sistem secara live.
- [x] **Failed Transaction Tracker**: Pemantauan transaksi yang gagal untuk troubleshooting.

## 5. Item yang Di-skip (Butuh Integrasi/Logika Kompleks)
- [ ] **Permission Management**: Butuh tabel roles/permissions dan middleware RBAC.
- [x] **Data Integrity Check**: Validasi jadwal bentrok sudah diimplementasikan di AdminScheduleController.
- [x] **Advanced User Control**: Sudah diimplementasikan melalui halaman Users (CRUD, Search, Ban, Reset Password).
- [x] **Failed Transaction Tracker**: Pemantauan transaksi yang gagal untuk troubleshooting.

---
*Catatan: Item dengan tanda [x] sudah diimplementasikan atau divisualisasikan dalam dashboard saat ini.*
