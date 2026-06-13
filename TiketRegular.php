<?php
require_once 'Tiket.php';

/**
 * Class TiketRegular
 * Menangani tiket bioskop untuk tipe studio Regular.
 */
class TiketRegular extends Tiket {
    // Properti tambahan spesifik Regular
    protected $tipeAudio;
    protected $lokasiBaris;

    /**
     * Constructor TiketRegular
     *
     * @param int $id_tiket
     * @param string $nama_film
     * @param string $jadwal_tayang
     * @param int $jumlah_kursi
     * @param float $hargaDasarTiket
     * @param string $tipeAudio
     * @param string $lokasiBaris
     */
    public function __construct($id_tiket, $nama_film, $jadwal_tayang, $jumlah_kursi, $hargaDasarTiket, $tipeAudio, $lokasiBaris) {
        // Memanggil constructor dari parent class (Tiket)
        parent::__construct($id_tiket, $nama_film, $jadwal_tayang, $jumlah_kursi, $hargaDasarTiket);
        $this->tipeAudio = $tipeAudio;
        $this->lokasiBaris = $lokasiBaris;
    }

    /**
     * [OVERRIDE] Menghitung total harga untuk studio Regular.
     * Logika Bisnis: Tarif standar murni tanpa biaya tambahan fasilitas.
     * Formula: jumlah_kursi * hargaDasarTiket
     *
     * @return float Total harga tiket Regular
     */
    public function hitungTotalHarga() {
        // Tarif standar murni: tidak ada biaya tambahan fasilitas
        return $this->jumlah_kursi * $this->hargaDasarTiket;
    }

    /**
     * Menampilkan informasi fasilitas tambahan studio Regular
     *
     * @return string
     */
    public function tampilkanInfoFasilitas() {
        return "Studio Regular - Tipe Audio: " . $this->tipeAudio . ", Lokasi Baris: " . $this->lokasiBaris;
    }

    // Getter untuk tipe audio
    public function getTipeAudio() {
        return $this->tipeAudio;
    }

    // Getter untuk lokasi baris kursi
    public function getLokasiBaris() {
        return $this->lokasiBaris;
    }
}
?>
