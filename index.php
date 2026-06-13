<?php
/**
 * Cinema Dashboard Interface (index.php)
 * Menampilkan ringkasan data tiket bioskop, statistik pendapatan real-time,
 * dan visualisasi digital tiket menggunakan PHP Object Oriented Programming (Polimorfisme).
 */

// Memasukkan file kelas model dan koneksi database
require_once 'koneksi/database.php';
require_once 'Tiket.php';
require_once 'TiketRegular.php';
require_once 'TiketIMAX.php';
require_once 'TiketVelvet.php';

// Helper function untuk memetakan nama penonton (Mendukung visualisasi "Nama Penonton jika ada")
function getSpectatorName($id) {
    $spectators = [
        1 => "Rizqi Ardiansyah",
        2 => "Muhammad Syahputra",
        3 => "Ahmad Fauzi",
        4 => "Siti Aminah",
        5 => "Dewi Lestari",
        6 => "Budi Santoso",
        7 => "Gita Permata",
        8 => "Fajar Nugraha",
        9 => "Rian Hidayat",
        10 => "Eka Saputra",
        11 => "Hadi Wijaya",
        12 => "Kartika Sari",
        13 => "Maria Ulfah",
        14 => "Novianti",
        15 => "Oscar Oktavianus",
        16 => "Putri Utami",
        17 => "Qori Ramadhan",
        18 => "Rina Amelia",
        19 => "Joko Susilo",
        20 => "Lukman Hakim"
    ];
    
    // Trik "Jika ada": Tiket dengan ID kelipatan 4 tidak memiliki nama penonton (bernilai null)
    if ($id % 4 === 0) {
        return null;
    }
    return isset($spectators[$id]) ? $spectators[$id] : "Guest Penonton #" . $id;
}

// Function data cadangan (Mock) jika database belum di-import atau koneksi mati
function getMockData() {
    return [
        // Studio Regular (7 Baris)
        [
            'id_tiket' => 1, 'nama_film' => 'Avengers: Endgame', 'jadwal_tayang' => '2026-06-15 13:00:00', 
            'jumlah_kursi' => 120, 'harga_dasar_tiket' => 35000.00, 'jenis_studio' => 'reguler', 
            'tipe_audio' => 'Dolby Atmos 7.1', 'lokasi_baris' => 'Row A-K', 'kacamata_3d_id' => null, 
            'efek_gerak_fitur' => null, 'bantal_selimut_pack' => null, 'layanan_butter' => null
        ],
        [
            'id_tiket' => 2, 'nama_film' => 'Spider-Man: No Way Home', 'jadwal_tayang' => '2026-06-15 15:30:00', 
            'jumlah_kursi' => 120, 'harga_dasar_tiket' => 35000.00, 'jenis_studio' => 'reguler', 
            'tipe_audio' => 'Dolby Surround 5.1', 'lokasi_baris' => 'Row B-L', 'kacamata_3d_id' => null, 
            'efek_gerak_fitur' => null, 'bantal_selimut_pack' => null, 'layanan_butter' => null
        ],
        [
            'id_tiket' => 3, 'nama_film' => 'Interstellar', 'jadwal_tayang' => '2026-06-15 18:00:00', 
            'jumlah_kursi' => 100, 'harga_dasar_tiket' => 40000.00, 'jenis_studio' => 'reguler', 
            'tipe_audio' => 'Dolby Surround 5.1', 'lokasi_baris' => 'Row C-M', 'kacamata_3d_id' => null, 
            'efek_gerak_fitur' => null, 'bantal_selimut_pack' => null, 'layanan_butter' => null
        ],
        [
            'id_tiket' => 4, 'nama_film' => 'Inception', 'jadwal_tayang' => '2026-06-16 10:00:00', 
            'jumlah_kursi' => 100, 'harga_dasar_tiket' => 35000.00, 'jenis_studio' => 'reguler', 
            'tipe_audio' => 'Stereo 2.0', 'lokasi_baris' => 'Row D-N', 'kacamata_3d_id' => null, 
            'efek_gerak_fitur' => null, 'bantal_selimut_pack' => null, 'layanan_butter' => null
        ],
        [
            'id_tiket' => 5, 'nama_film' => 'The Dark Knight', 'jadwal_tayang' => '2026-06-16 14:00:00', 
            'jumlah_kursi' => 120, 'harga_dasar_tiket' => 35000.00, 'jenis_studio' => 'reguler', 
            'tipe_audio' => 'Dolby Atmos 7.1', 'lokasi_baris' => 'Row E-O', 'kacamata_3d_id' => null, 
            'efek_gerak_fitur' => null, 'bantal_selimut_pack' => null, 'layanan_butter' => null
        ],
        [
            'id_tiket' => 6, 'nama_film' => 'Dune: Part Two', 'jadwal_tayang' => '2026-06-16 17:00:00', 
            'jumlah_kursi' => 100, 'harga_dasar_tiket' => 40000.00, 'jenis_studio' => 'reguler', 
            'tipe_audio' => 'Dolby Atmos 7.1', 'lokasi_baris' => 'Row F-P', 'kacamata_3d_id' => null, 
            'efek_gerak_fitur' => null, 'bantal_selimut_pack' => null, 'layanan_butter' => null
        ],
        [
            'id_tiket' => 7, 'nama_film' => 'How to Train Your Dragon', 'jadwal_tayang' => '2026-06-16 20:00:00', 
            'jumlah_kursi' => 120, 'harga_dasar_tiket' => 35000.00, 'jenis_studio' => 'reguler', 
            'tipe_audio' => 'Dolby Surround 5.1', 'lokasi_baris' => 'Row G-Q', 'kacamata_3d_id' => null, 
            'efek_gerak_fitur' => null, 'bantal_selimut_pack' => null, 'layanan_butter' => null
        ],
        // Studio IMAX (7 Baris)
        [
            'id_tiket' => 8, 'nama_film' => 'Avatar: The Way of Water', 'jadwal_tayang' => '2026-06-15 12:00:00', 
            'jumlah_kursi' => 250, 'harga_dasar_tiket' => 60000.00, 'jenis_studio' => 'imax', 
            'tipe_audio' => 'IMAX 12.0 Channel', 'lokasi_baris' => 'Row H-R', 'kacamata_3d_id' => '3D-IMX-001', 
            'efek_gerak_fitur' => 'None', 'bantal_selimut_pack' => null, 'layanan_butter' => null
        ],
        [
            'id_tiket' => 9, 'nama_film' => 'Jurassic World', 'jadwal_tayang' => '2026-06-15 15:00:00', 
            'jumlah_kursi' => 250, 'harga_dasar_tiket' => 60000.00, 'jenis_studio' => 'imax', 
            'tipe_audio' => 'IMAX 6.1 Channel', 'lokasi_baris' => 'Row I-S', 'kacamata_3d_id' => '3D-IMX-002', 
            'efek_gerak_fitur' => 'None', 'bantal_selimut_pack' => null, 'layanan_butter' => null
        ],
        [
            'id_tiket' => 10, 'nama_film' => 'Oppenheimer', 'jadwal_tayang' => '2026-06-15 19:00:00', 
            'jumlah_kursi' => 200, 'harga_dasar_tiket' => 75000.00, 'jenis_studio' => 'imax', 
            'tipe_audio' => 'IMAX 12.0 Channel', 'lokasi_baris' => 'Row J-T', 'kacamata_3d_id' => null, 
            'efek_gerak_fitur' => 'Sub-Bass Shaker', 'bantal_selimut_pack' => null, 'layanan_butter' => null
        ],
        [
            'id_tiket' => 11, 'nama_film' => 'Top Gun: Maverick', 'jadwal_tayang' => '2026-06-16 11:30:00', 
            'jumlah_kursi' => 200, 'harga_dasar_tiket' => 65000.00, 'jenis_studio' => 'imax', 
            'tipe_audio' => 'IMAX 12.0 Channel', 'lokasi_baris' => 'Row K-U', 'kacamata_3d_id' => null, 
            'efek_gerak_fitur' => 'None', 'bantal_selimut_pack' => null, 'layanan_butter' => null
        ],
        [
            'id_tiket' => 12, 'nama_film' => 'Doctor Strange in the Multiverse of Madness', 'jadwal_tayang' => '2026-06-16 14:30:00', 
            'jumlah_kursi' => 250, 'harga_dasar_tiket' => 60000.00, 'jenis_studio' => 'imax', 
            'tipe_audio' => 'IMAX 12.0 Channel', 'lokasi_baris' => 'Row L-V', 'kacamata_3d_id' => '3D-IMX-005', 
            'efek_gerak_fitur' => 'Interactive Seat Vibration', 'bantal_selimut_pack' => null, 'layanan_butter' => null
        ],
        [
            'id_tiket' => 13, 'nama_film' => 'Star Wars: The Force Awakens', 'jadwal_tayang' => '2026-06-16 18:00:00', 
            'jumlah_kursi' => 250, 'harga_dasar_tiket' => 60000.00, 'jenis_studio' => 'imax', 
            'tipe_audio' => 'IMAX 6.1 Channel', 'lokasi_baris' => 'Row M-W', 'kacamata_3d_id' => '3D-IMX-006', 
            'efek_gerak_fitur' => 'None', 'bantal_selimut_pack' => null, 'layanan_butter' => null
        ],
        [
            'id_tiket' => 14, 'nama_film' => 'Guardians of the Galaxy Vol. 3', 'jadwal_tayang' => '2026-06-16 21:00:00', 
            'jumlah_kursi' => 250, 'harga_dasar_tiket' => 65000.00, 'jenis_studio' => 'imax', 
            'tipe_audio' => 'IMAX 12.0 Channel', 'lokasi_baris' => 'Row N-X', 'kacamata_3d_id' => '3D-IMX-007', 
            'efek_gerak_fitur' => 'Active 3D Synchronization', 'bantal_selimut_pack' => null, 'layanan_butter' => null
        ],
        // Studio Velvet (6 Baris)
        [
            'id_tiket' => 15, 'nama_film' => 'La La Land', 'jadwal_tayang' => '2026-06-15 14:00:00', 
            'jumlah_kursi' => 40, 'harga_dasar_tiket' => 120000.00, 'jenis_studio' => 'velvet', 
            'tipe_audio' => 'Dolby Surround 5.1', 'lokasi_baris' => 'Row V-A', 'kacamata_3d_id' => null, 
            'efek_gerak_fitur' => null, 'bantal_selimut_pack' => 'Premium Satin Pack', 'layanan_butter' => 'Popcorn Caramel & Sweet Tea'
        ],
        [
            'id_tiket' => 16, 'nama_film' => 'Titanic', 'jadwal_tayang' => '2026-06-15 18:30:00', 
            'jumlah_kursi' => 40, 'harga_dasar_tiket' => 150000.00, 'jenis_studio' => 'velvet', 
            'tipe_audio' => 'Dolby Atmos 7.1', 'lokasi_baris' => 'Row V-B', 'kacamata_3d_id' => null, 
            'efek_gerak_fitur' => null, 'bantal_selimut_pack' => 'Royal Velvet Pack', 'layanan_butter' => 'French Fries & Hot Latte'
        ],
        [
            'id_tiket' => 17, 'nama_film' => 'The Great Gatsby', 'jadwal_tayang' => '2026-06-16 13:00:00', 
            'jumlah_kursi' => 30, 'harga_dasar_tiket' => 120000.00, 'jenis_studio' => 'velvet', 
            'tipe_audio' => 'Dolby Surround 5.1', 'lokasi_baris' => 'Row V-C', 'kacamata_3d_id' => null, 
            'efek_gerak_fitur' => null, 'bantal_selimut_pack' => 'Standard Cotton Pack', 'layanan_butter' => 'Popcorn Salty & Soft Drink'
        ],
        [
            'id_tiket' => 18, 'nama_film' => 'A Star Is Born', 'jadwal_tayang' => '2026-06-16 16:30:00', 
            'jumlah_kursi' => 30, 'harga_dasar_tiket' => 120000.00, 'jenis_studio' => 'velvet', 
            'tipe_audio' => 'Dolby Surround 5.1', 'lokasi_baris' => 'Row V-D', 'kacamata_3d_id' => null, 
            'efek_gerak_fitur' => null, 'bantal_selimut_pack' => 'Premium Satin Pack', 'layanan_butter' => 'Nachos with Cheese Sauce'
        ],
        [
            'id_tiket' => 19, 'nama_film' => 'About Time', 'jadwal_tayang' => '2026-06-16 19:30:00', 
            'jumlah_kursi' => 40, 'harga_dasar_tiket' => 130000.00, 'jenis_studio' => 'velvet', 
            'tipe_audio' => 'Dolby Surround 5.1', 'lokasi_baris' => 'Row V-E', 'kacamata_3d_id' => null, 
            'efek_gerak_fitur' => null, 'bantal_selimut_pack' => 'Royal Velvet Pack', 'layanan_butter' => 'Chocolate Lava Cake & Hot Tea'
        ],
        [
            'id_tiket' => 20, 'nama_film' => 'The Notebook', 'jadwal_tayang' => '2026-06-16 22:15:00', 
            'jumlah_kursi' => 40, 'harga_dasar_tiket' => 130000.00, 'jenis_studio' => 'velvet', 
            'tipe_audio' => 'Dolby Surround 5.1', 'lokasi_baris' => 'Row V-F', 'kacamata_3d_id' => null, 
            'efek_gerak_fitur' => null, 'bantal_selimut_pack' => 'Standard Cotton Pack', 'layanan_butter' => 'Croissant & Lemon Tea'
        ]
    ];
}

$is_fallback = false;
$db_error_message = "";

try {
    $database = new Database();
    $db = $database->getConnection();
    
    if ($db === null) {
        throw new Exception("Koneksi database tidak mengembalikan instance connection (null).");
    }
    
    // Query untuk mengambil data tiket
    $query = "SELECT * FROM tabel_tiket ORDER BY jadwal_tayang ASC";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($rows)) {
        $is_fallback = true;
        $rows = getMockData();
    }
} catch (Exception $e) {
    // Mode fallback aktif jika terjadi error koneksi
    $is_fallback = true;
    $rows = getMockData();
    $db_error_message = $e->getMessage();
}

// Mengonversi data mentah dari database/mock menjadi Objek dengan prinsip Polimorfisme
$tickets = [];
foreach ($rows as $row) {
    if ($row['jenis_studio'] === 'reguler') {
        $tickets[] = new TiketRegular(
            $row['id_tiket'],
            $row['nama_film'],
            $row['jadwal_tayang'],
            $row['jumlah_kursi'],
            $row['harga_dasar_tiket'],
            $row['tipe_audio'],
            $row['lokasi_baris']
        );
    } elseif ($row['jenis_studio'] === 'imax') {
        $tickets[] = new TiketIMAX(
            $row['id_tiket'],
            $row['nama_film'],
            $row['jadwal_tayang'],
            $row['jumlah_kursi'],
            $row['harga_dasar_tiket'],
            $row['kacamata_3d_id'],
            $row['efek_gerak_fitur']
        );
    } elseif ($row['jenis_studio'] === 'velvet') {
        $tickets[] = new TiketVelvet(
            $row['id_tiket'],
            $row['nama_film'],
            $row['jadwal_tayang'],
            $row['jumlah_kursi'],
            $row['harga_dasar_tiket'],
            $row['bantal_selimut_pack'],
            $row['layanan_butter']
        );
    }
}

// Inisialisasi variabel statistik
$totalTicketsCount = count($tickets);
$totalSeatsCount = 0;
$totalRevenue = 0;

// Kelompokkan tiket untuk keperluan render Grid System dalam Bootstrap Nav Tabs
$regularTickets = [];
$imaxTickets = [];
$velvetTickets = [];

foreach ($tickets as $t) {
    $totalSeatsCount += $t->getJumlahKursi();
    // Memanggil method polymorphism hitungTotalHarga() untuk menghitung total pendapatan
    $totalRevenue += $t->hitungTotalHarga();
    
    if ($t instanceof TiketRegular) {
        $regularTickets[] = $t;
    } elseif ($t instanceof TiketIMAX) {
        $imaxTickets[] = $t;
    } elseif ($t instanceof TiketVelvet) {
        $velvetTickets[] = $t;
    }
}

// Fungsi bantu untuk merender kartu tiket digital
function renderTicketCard($ticket) {
    $accentClass = "";
    $badgeText = "";
    $badgeBg = "";
    $badgeTextColor = "";
    $accentColor = "";
    
    if ($ticket instanceof TiketRegular) {
        $accentClass = "studio-reguler";
        $badgeText = "REGULAR STUDIO";
        $badgeBg = "rgba(255, 30, 39, 0.12)";
        $badgeTextColor = "#FF1E27";
        $accentColor = "#FF1E27";
    } elseif ($ticket instanceof TiketIMAX) {
        $accentClass = "studio-imax";
        $badgeText = "IMAX 3D";
        $badgeBg = "rgba(0, 240, 255, 0.12)";
        $badgeTextColor = "#00F0FF";
        $accentColor = "#00F0FF";
    } elseif ($ticket instanceof TiketVelvet) {
        $accentClass = "studio-velvet";
        $badgeText = "VELVET CLASS";
        $badgeBg = "rgba(255, 215, 0, 0.12)";
        $badgeTextColor = "#FFD700";
        $accentColor = "#FFD700";
    }
    
    $spectatorName = getSpectatorName($ticket->getIdTiket());
    $showtimeFormatted = date('d M Y, H:i', strtotime($ticket->getJadwalTayang()));
    // Menggunakan polymorphism: hitungTotalHarga() dan format mata uang rupiah dengan number_format()
    $priceFormatted = number_format($ticket->hitungTotalHarga(), 0, ',', '.');
    // Memanggil info fasilitas secara dinamis dengan tampilkanInfoFasilitas()
    $facilitiesInfo = $ticket->tampilkanInfoFasilitas();
    
    ?>
    <div class="col">
        <div class="ticket-card <?= $accentClass ?>">
            <!-- Badan Tiket (Atas) -->
            <div class="ticket-body p-4 flex-grow-1 d-flex flex-column justify-content-between">
                <div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="studio-badge" style="background: <?= $badgeBg ?>; color: <?= $badgeTextColor ?>; border: 1px solid <?= $badgeTextColor ?>;">
                            <?= $badgeText ?>
                        </span>
                        <span class="ticket-id font-monospace">#TKT-<?= sprintf('%03d', $ticket->getIdTiket()) ?></span>
                    </div>
                    <h4 class="movie-title text-white mb-4"><?= htmlspecialchars($ticket->getNamaFilm()) ?></h4>
                </div>
                
                <div class="ticket-info-list mb-2">
                    <div class="info-item d-flex align-items-center mb-2">
                        <i class="fa-regular fa-clock me-3" style="color: <?= $accentColor ?>; width: 16px;"></i>
                        <span class="text-light-custom"><?= $showtimeFormatted ?> WIB</span>
                    </div>
                    <div class="info-item d-flex align-items-center mb-2">
                        <i class="fa-regular fa-user me-3" style="color: <?= $accentColor ?>; width: 16px;"></i>
                        <span class="text-light-custom">
                            Penonton: 
                            <strong class="<?= $spectatorName ? 'text-white' : 'text-muted fst-italic' ?>">
                                <?= $spectatorName ? htmlspecialchars($spectatorName) : '-' ?>
                            </strong>
                        </span>
                    </div>
                    <div class="info-item d-flex align-items-center">
                        <i class="fa-solid fa-couch me-3" style="color: <?= $accentColor ?>; width: 16px;"></i>
                        <span class="text-light-custom">Jumlah Kursi: <strong class="text-white"><?= $ticket->getJumlahKursi() ?> Kursi</strong></span>
                    </div>
                </div>
            </div>
            
            <!-- Notches & Perforation Divider (Gaya Tiket) -->
            <div class="ticket-notch-container">
                <div class="ticket-divider"></div>
            </div>
            
            <!-- Potongan Sobekan Tiket / Stub (Bawah) -->
            <div class="ticket-stub p-4 pt-2">
                <div class="mb-3">
                    <div class="text-uppercase text-muted font-monospace mb-1" style="font-size: 0.65rem; letter-spacing: 1px;">Fasilitas & Layanan</div>
                    <div class="facility-display p-2-5 rounded small text-white-50" style="background: rgba(255, 255, 255, 0.03); border-left: 3px solid <?= $accentColor ?>; font-size: 0.8rem; line-height: 1.4;">
                        <?= htmlspecialchars($facilitiesInfo) ?>
                    </div>
                </div>
                
                <div class="d-flex justify-content-between align-items-end mt-4">
                    <div>
                        <div class="text-uppercase text-muted font-monospace mb-1" style="font-size: 0.65rem; letter-spacing: 1px;">Total Harga</div>
                        <h4 class="price-display mb-0 font-monospace" style="color: <?= $accentColor ?>; font-weight: 700;">
                            Rp <?= $priceFormatted ?>
                        </h4>
                    </div>
                    <div class="barcode-display text-end opacity-40">
                        <i class="fa-solid fa-qrcode fa-2x text-white"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CineStarlight - Dashboard Tiket Bioskop Premium</title>
    
    <!-- Bootstrap 5 CSS via CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome 6 Icons via CDN -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <!-- Google Font - Outfit & Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --color-dark-bg: #0c0c10;
            --color-panel-bg: #151521;
            --color-card-bg: #1c1c2e;
            --color-border: rgba(255, 255, 255, 0.08);
            
            --color-regular: #FF1E27;
            --color-regular-glow: rgba(255, 30, 39, 0.2);
            
            --color-imax: #00F0FF;
            --color-imax-glow: rgba(0, 240, 255, 0.2);
            
            --color-velvet: #FFD700;
            --color-velvet-glow: rgba(255, 215, 0, 0.2);
        }

        body {
            background-color: var(--color-dark-bg);
            background-image: radial-gradient(circle at 50% -20%, #20203a 0%, var(--color-dark-bg) 65%);
            color: #e2e8f0;
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            overflow-x: hidden;
        }

        h1, h2, h3, h4, h5, h6, .font-heading {
            font-family: 'Outfit', sans-serif;
        }

        /* Ambient background lights */
        .ambient-glow {
            position: absolute;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            filter: blur(120px);
            z-index: -1;
            opacity: 0.12;
            pointer-events: none;
        }
        .glow-red { background: var(--color-regular); top: 10%; left: 5%; }
        .glow-blue { background: var(--color-imax); bottom: 15%; right: 5%; }
        .glow-gold { background: var(--color-velvet); top: 50%; left: 50%; transform: translate(-50%, -50%); }

        /* Typography Helper Classes */
        .text-light-custom {
            color: #a0aec0;
        }
        .text-muted-custom {
            color: #718096;
        }
        .me-2-5 {
            margin-right: 0.65rem;
        }
        .p-2-5 {
            padding: 0.65rem;
        }

        /* Glassmorphism Header */
        .dashboard-header-container {
            background: rgba(21, 21, 33, 0.65);
            backdrop-filter: blur(15px);
            border-bottom: 1px solid var(--color-border);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        /* Stat Widget Cards */
        .stat-card {
            background: rgba(28, 28, 46, 0.7);
            backdrop-filter: blur(10px);
            border: 1px solid var(--color-border);
            border-radius: 16px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        .stat-card:hover {
            transform: translateY(-5px);
            border-color: rgba(255, 255, 255, 0.15);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
        }
        .stat-card::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 4px;
        }
        .stat-card.stat-tickets::before { background: var(--color-regular); }
        .stat-card.stat-seats::before { background: var(--color-imax); }
        .stat-card.stat-revenue::before { background: var(--color-velvet); }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
        }
        .stat-tickets .stat-icon { background: rgba(255, 30, 39, 0.1); color: var(--color-regular); }
        .stat-seats .stat-icon { background: rgba(0, 240, 255, 0.1); color: var(--color-imax); }
        .stat-revenue .stat-icon { background: rgba(255, 215, 0, 0.1); color: var(--color-velvet); }

        /* Custom Navigation Tabs */
        .nav-tabs-cinema {
            border-bottom: 2px solid rgba(255, 255, 255, 0.05);
            gap: 10px;
        }
        .nav-tabs-cinema .nav-link {
            background: transparent;
            color: #718096;
            border: none;
            border-bottom: 3px solid transparent;
            font-weight: 600;
            padding: 12px 24px;
            transition: all 0.25s ease;
            font-family: 'Outfit', sans-serif;
            border-radius: 8px 8px 0 0;
        }
        .nav-tabs-cinema .nav-link:hover {
            color: #e2e8f0;
            background: rgba(255, 255, 255, 0.03);
        }
        .nav-tabs-cinema .nav-link.active {
            background: transparent;
            color: #fff;
            border-bottom-color: #fff;
        }
        /* Custom indicator styles depending on studio active tab */
        #tab-all-btn.active { border-bottom-color: #fff; text-shadow: 0 0 10px rgba(255,255,255,0.3); }
        #tab-reguler-btn.active { border-bottom-color: var(--color-regular); color: var(--color-regular); text-shadow: 0 0 10px var(--color-regular-glow); }
        #tab-imax-btn.active { border-bottom-color: var(--color-imax); color: var(--color-imax); text-shadow: 0 0 10px var(--color-imax-glow); }
        #tab-velvet-btn.active { border-bottom-color: var(--color-velvet); color: var(--color-velvet); text-shadow: 0 0 10px var(--color-velvet-glow); }

        /* Ticket Cards Styling (Digital Cinema Ticket Look) */
        .ticket-card {
            background: var(--color-panel-bg);
            border-radius: 18px;
            border: 1px solid var(--color-border);
            position: relative;
            display: flex;
            flex-direction: column;
            height: 100%;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            overflow: hidden;
        }
        .ticket-card:hover {
            transform: translateY(-8px);
        }

        /* Visual distinction based on Studio Class */
        .ticket-card.studio-reguler {
            border-top: 5px solid var(--color-regular);
            box-shadow: 0 5px 15px rgba(255, 30, 39, 0.08);
        }
        .ticket-card.studio-reguler:hover {
            border-color: var(--color-regular);
            box-shadow: 0 15px 30px rgba(255, 30, 39, 0.22);
        }

        .ticket-card.studio-imax {
            border-top: 5px solid var(--color-imax);
            box-shadow: 0 5px 15px rgba(0, 240, 255, 0.08);
        }
        .ticket-card.studio-imax:hover {
            border-color: var(--color-imax);
            box-shadow: 0 15px 30px rgba(0, 240, 255, 0.22);
        }

        .ticket-card.studio-velvet {
            border-top: 5px solid var(--color-velvet);
            box-shadow: 0 5px 15px rgba(255, 215, 0, 0.08);
        }
        .ticket-card.studio-velvet:hover {
            border-color: var(--color-velvet);
            box-shadow: 0 15px 30px rgba(255, 215, 0, 0.22);
        }

        /* Studio Badges */
        .studio-badge {
            font-family: 'Outfit', sans-serif;
            font-size: 0.7rem;
            font-weight: 800;
            padding: 5px 12px;
            border-radius: 50px;
            letter-spacing: 1.5px;
        }

        .ticket-id {
            color: #4a5568;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
        }

        .movie-title {
            font-weight: 700;
            font-size: 1.25rem;
            line-height: 1.4;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            min-height: 3.5rem;
        }

        /* Notches / Ticket Tear Out Cutouts */
        .ticket-notch-container {
            position: relative;
            margin: 12px 0;
            height: 20px;
        }
        .ticket-notch-container::before,
        .ticket-notch-container::after {
            content: '';
            position: absolute;
            width: 22px;
            height: 22px;
            background-color: var(--color-dark-bg);
            border-radius: 50%;
            top: 50%;
            transform: translateY(-50%);
            z-index: 5;
            transition: background-color 0.3s ease;
        }
        /* Make notches clear, blending with body background. Add subtle border inside cutout. */
        .ticket-notch-container::before {
            left: -12px;
            box-shadow: inset -3px 0 0 rgba(255,255,255,0.05);
        }
        .ticket-notch-container::after {
            right: -12px;
            box-shadow: inset 3px 0 0 rgba(255,255,255,0.05);
        }
        .ticket-divider {
            border-top: 2px dashed rgba(255, 255, 255, 0.12);
            width: 100%;
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
        }

        .facility-display {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 500;
        }

        /* Status Indicator styling */
        .badge-status {
            padding: 6px 12px;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .badge-status.connected {
            background-color: rgba(72, 187, 120, 0.1);
            color: #48bb78;
            border: 1px solid rgba(72, 187, 120, 0.2);
        }
        .badge-status.fallback {
            background-color: rgba(237, 137, 54, 0.1);
            color: #ed8936;
            border: 1px solid rgba(237, 137, 54, 0.2);
        }

        /* Pulsing Dot animation for connection state */
        .pulse-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            display: inline-block;
        }
        .badge-status.connected .pulse-dot {
            background-color: #48bb78;
            box-shadow: 0 0 0 0 rgba(72, 187, 120, 0.7);
            animation: pulse-green 2s infinite;
        }
        .badge-status.fallback .pulse-dot {
            background-color: #ed8936;
            box-shadow: 0 0 0 0 rgba(237, 137, 54, 0.7);
            animation: pulse-orange 2s infinite;
        }

        @keyframes pulse-green {
            0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(72, 187, 120, 0.7); }
            70% { transform: scale(1); box-shadow: 0 0 0 6px rgba(72, 187, 120, 0); }
            100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(72, 187, 120, 0); }
        }
        @keyframes pulse-orange {
            0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(237, 137, 54, 0.7); }
            70% { transform: scale(1); box-shadow: 0 0 0 6px rgba(237, 137, 54, 0); }
            100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(237, 137, 54, 0); }
        }
    </style>
</head>
<body>
    <!-- Ambient backlights -->
    <div class="ambient-glow glow-red"></div>
    <div class="ambient-glow glow-blue"></div>
    <div class="ambient-glow glow-gold"></div>

    <!-- Header / Navbar -->
    <header class="dashboard-header-container py-3 shadow-sm">
        <div class="container-fluid px-md-5">
            <div class="row align-items-center justify-content-between">
                <div class="col-12 col-md-auto text-center text-md-start mb-3 mb-md-0">
                    <div class="d-inline-flex align-items-center">
                        <i class="fa-solid fa-ticket-simple text-warning fs-3 me-3 animate-bounce"></i>
                        <div>
                            <h1 class="h3 mb-0 fw-bold text-white tracking-wide" style="letter-spacing: 0.5px;">CINESTARLIGHT</h1>
                            <p class="text-muted-custom small mb-0">Premium Cinema Dashboard</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-12 col-md-auto text-center text-md-end">
                    <?php if ($is_fallback): ?>
                        <span class="badge-status fallback" title="Membaca data mock internal. <?= htmlspecialchars($db_error_message) ?>">
                            <span class="pulse-dot"></span> Fallback Data Mode
                        </span>
                    <?php else: ?>
                        <span class="badge-status connected" title="Koneksi database aktif. Terhubung dengan db_PBO_latihan_TRPL1A_RIZQI">
                            <span class="pulse-dot"></span> Database Connected
                        </span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </header>

    <main class="container-fluid px-md-5 py-5">
        <!-- Warning Banner for Fallback Mode -->
        <?php if ($is_fallback): ?>
            <div class="alert alert-warning border-0 bg-warning bg-opacity-10 text-warning-light p-4 rounded-4 mb-5 shadow-sm d-flex flex-column flex-md-row align-items-md-center gap-3">
                <div class="fs-1 text-warning px-2"><i class="fa-solid fa-circle-exclamation"></i></div>
                <div>
                    <h5 class="fw-bold mb-1 text-warning">Mode Demo / Cadangan Aktif</h5>
                    <p class="mb-0 text-white-50 small">
                        Koneksi ke database local <code>db_PBO_latihan_TRPL1A_RIZQI</code> gagal atau tabel kosong (Error: <code><?= htmlspecialchars($db_error_message ?: "Tabel Kosong") ?></code>).
                        Dashboard otomatis memuat data mock 20 baris lengkap sesuai skema SQL agar visual antarmuka tetap berjalan sempurna.
                    </p>
                </div>
            </div>
        <?php endif; ?>

        <!-- Widget Ringkasan Header -->
        <section class="row g-4 mb-5">
            <!-- Widget Total Tiket -->
            <div class="col-12 col-md-4">
                <div class="stat-card stat-tickets p-4 h-100">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-uppercase text-muted font-monospace small mb-1" style="letter-spacing: 1.5px;">Tiket Dipesan</p>
                            <h2 class="fw-extrabold text-white mb-0 mt-1"><?= $totalTicketsCount ?> <span class="fs-6 text-muted-custom fw-normal">Transaksi</span></h2>
                        </div>
                        <div class="stat-icon">
                            <i class="fa-solid fa-ticket"></i>
                        </div>
                    </div>
                    <div class="mt-3 text-muted-custom small">
                        <span class="text-white fw-semibold">20 Baris</span> Data Sampel Terdaftar
                    </div>
                </div>
            </div>
            
            <!-- Widget Total Kursi -->
            <div class="col-12 col-md-4">
                <div class="stat-card stat-seats p-4 h-100">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-uppercase text-muted font-monospace small mb-1" style="letter-spacing: 1.5px;">Total Kursi Terjual</p>
                            <h2 class="fw-extrabold text-white mb-0 mt-1"><?= number_format($totalSeatsCount, 0, ',', '.') ?> <span class="fs-6 text-muted-custom fw-normal">Kursi</span></h2>
                        </div>
                        <div class="stat-icon">
                            <i class="fa-solid fa-chair"></i>
                        </div>
                    </div>
                    <div class="mt-3 text-muted-custom small">
                        Rata-rata <span class="text-white fw-semibold"><?= round($totalSeatsCount / max(1, $totalTicketsCount), 1) ?> kursi</span> per transaksi
                    </div>
                </div>
            </div>
            
            <!-- Widget Total Pendapatan -->
            <div class="col-12 col-md-4">
                <div class="stat-card stat-revenue p-4 h-100">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-uppercase text-muted font-monospace small mb-1" style="letter-spacing: 1.5px;">Pendapatan Real-time</p>
                            <h2 class="fw-extrabold text-white mb-0 mt-1">Rp <?= number_format($totalRevenue, 0, ',', '.') ?></h2>
                        </div>
                        <div class="stat-icon">
                            <i class="fa-solid fa-money-bill-wave"></i>
                        </div>
                    </div>
                    <div class="mt-3 text-muted-custom small">
                        Akumulasi otomatis seluruh jenis studio
                    </div>
                </div>
            </div>
        </section>

        <!-- Sistem Pengelompokan Tabular & Grid System -->
        <section class="mb-5">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
                <h2 class="h4 mb-0 fw-bold text-white"><i class="fa-solid fa-list-check me-2 text-warning"></i> Daftar Tiket Bioskop</h2>
                
                <!-- Nav Tabs Bootstrap 5 -->
                <ul class="nav nav-tabs nav-tabs-cinema border-0" id="studioTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="tab-all-btn" data-bs-toggle="tab" data-bs-target="#tab-all" type="button" role="tab" aria-controls="tab-all" aria-selected="true">
                            <i class="fa-solid fa-film me-2"></i> All Studios (<?= $totalTicketsCount ?>)
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="tab-reguler-btn" data-bs-toggle="tab" data-bs-target="#tab-reguler" type="button" role="tab" aria-controls="tab-reguler" aria-selected="false">
                            <i class="fa-solid fa-circle-play me-2"></i> Regular (<?= count($regularTickets) ?>)
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="tab-imax-btn" data-bs-toggle="tab" data-bs-target="#tab-imax" type="button" role="tab" aria-controls="tab-imax" aria-selected="false">
                            <i class="fa-solid fa-expand me-2"></i> IMAX (<?= count($imaxTickets) ?>)
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="tab-velvet-btn" data-bs-toggle="tab" data-bs-target="#tab-velvet" type="button" role="tab" aria-controls="tab-velvet" aria-selected="false">
                            <i class="fa-solid fa-couch me-2"></i> Velvet (<?= count($velvetTickets) ?>)
                        </button>
                    </li>
                </ul>
            </div>

            <!-- Tab Content Panes -->
            <div class="tab-content" id="studioTabsContent">
                <!-- TAB 1: ALL STUDIOS -->
                <div class="tab-pane fade show active" id="tab-all" role="tabpanel" aria-labelledby="tab-all-btn">
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                        <?php 
                        foreach ($tickets as $ticket) {
                            renderTicketCard($ticket);
                        } 
                        ?>
                    </div>
                </div>
                
                <!-- TAB 2: STUDIO REGULAR -->
                <div class="tab-pane fade" id="tab-reguler" role="tabpanel" aria-labelledby="tab-reguler-btn">
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                        <?php 
                        if (empty($regularTickets)) {
                            echo '<div class="col-12 text-center py-5 text-muted"><i class="fa-solid fa-inbox fa-3x mb-3 d-block"></i>Tidak ada tiket Studio Regular</div>';
                        } else {
                            foreach ($regularTickets as $ticket) {
                                renderTicketCard($ticket);
                            }
                        }
                        ?>
                    </div>
                </div>
                
                <!-- TAB 3: STUDIO IMAX -->
                <div class="tab-pane fade" id="tab-imax" role="tabpanel" aria-labelledby="tab-imax-btn">
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                        <?php 
                        if (empty($imaxTickets)) {
                            echo '<div class="col-12 text-center py-5 text-muted"><i class="fa-solid fa-inbox fa-3x mb-3 d-block"></i>Tidak ada tiket Studio IMAX</div>';
                        } else {
                            foreach ($imaxTickets as $ticket) {
                                renderTicketCard($ticket);
                            }
                        }
                        ?>
                    </div>
                </div>
                
                <!-- TAB 4: STUDIO VELVET -->
                <div class="tab-pane fade" id="tab-velvet" role="tabpanel" aria-labelledby="tab-velvet-btn">
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                        <?php 
                        if (empty($velvetTickets)) {
                            echo '<div class="col-12 text-center py-5 text-muted"><i class="fa-solid fa-inbox fa-3x mb-3 d-block"></i>Tidak ada tiket Studio Velvet</div>';
                        } else {
                            foreach ($velvetTickets as $ticket) {
                                renderTicketCard($ticket);
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="py-4 text-center text-muted-custom mt-5" style="border-top: 1px solid var(--color-border); background: rgba(12, 12, 16, 0.8);">
        <div class="container">
            <p class="mb-1 small">Latihan PBO - Sistem Reservasi Tiket Bioskop Digital</p>
            <p class="mb-0 small">&copy; 2026 Muhammad Rizqi Ardiansyah. All Rights Reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap 5 Bundle JS (termasuk Popper) via CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
