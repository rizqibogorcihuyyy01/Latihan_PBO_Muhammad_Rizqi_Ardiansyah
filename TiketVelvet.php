<?php
require_once 'Tiket.php';

/**
 * Class TiketVelvet
 * Menangani tiket bioskop untuk tipe studio Velvet.
 */
class TiketVelvet extends Tiket {
    // Properti tambahan spesifik Velvet
    protected $bantalSelimutPack;
    protected $layananButler; // Dipetakan dari kolom 'layanan_butter' di database

    /**
     * Constructor TiketVelvet
     *
     * @param int $id_tiket
     * @param string $nama_film
     * @param string $jadwal_tayang
     * @param int $jumlah_kursi
     * @param float $hargaDasarTiket
     * @param string|null $bantalSelimutPack
     * @param string|null $layananButler
     */
    public function __construct($id_tiket, $nama_film, $jadwal_tayang, $jumlah_kursi, $hargaDasarTiket, $bantalSelimutPack, $layananButler) {
        // Memanggil constructor dari parent class (Tiket)
        parent::__construct($id_tiket, $nama_film, $jadwal_tayang, $jumlah_kursi, $hargaDasarTiket);
        $this->bantalSelimutPack = $bantalSelimutPack;
        $this->layananButler = $layananButler;
    }

    /**
     * Menghitung total harga untuk studio Velvet (Harga Dasar * Jumlah Kursi)
     *
     * @return float
     */
    public function hitungTotalHarga() {
        return $this->hargaDasarTiket * $this->jumlah_kursi;
    }

    /**
     * Menampilkan informasi fasilitas tambahan studio Velvet
     *
     * @return string
     */
    public function tampilkanInfoFasilitas() {
        $bantalInfo = $this->bantalSelimutPack ? $this->bantalSelimutPack : "Tidak Ada";
        $butlerInfo = $this->layananButler ? $this->layananButler : "Tidak Ada";
        return "Studio Velvet - Paket Bantal Selimut: " . $bantalInfo . ", Layanan Butler: " . $butlerInfo;
    }

    // Getter untuk paket bantal selimut
    public function getBantalSelimutPack() {
        return $this->bantalSelimutPack;
    }

    // Getter untuk layanan butler
    public function getLayananButler() {
        return $this->layananButler;
    }
}
?>
