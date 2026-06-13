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
     * [OVERRIDE] Menghitung total harga untuk studio Velvet.
     * Logika Bisnis: Dikenakan surcharge/biaya tambahan kelas premium
     * sebesar 50% dari total harga dasar.
     * Formula: (jumlah_kursi * hargaDasarTiket) * 1.50
     *
     * @return float Total harga tiket Velvet
     */
    public function hitungTotalHarga() {
        // Surcharge kelas premium Velvet: 50% dari total harga dasar
        $surchargeKlasPremium = 1.50;
        return ($this->jumlah_kursi * $this->hargaDasarTiket) * $surchargeKlasPremium;
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
