<?php
require_once 'Tiket.php';

/**
 * Class TiketIMAX
 * Menangani tiket bioskop untuk tipe studio IMAX.
 */
class TiketIMAX extends Tiket {
    // Properti tambahan spesifik IMAX
    protected $kacamata3dId; // Representasi dari properti kacamata3dId / kacamata3dld
    protected $efekGerakFitur;

    /**
     * Constructor TiketIMAX
     *
     * @param int $id_tiket
     * @param string $nama_film
     * @param string $jadwal_tayang
     * @param int $jumlah_kursi
     * @param float $hargaDasarTiket
     * @param string|null $kacamata3dId
     * @param string|null $efekGerakFitur
     */
    public function __construct($id_tiket, $nama_film, $jadwal_tayang, $jumlah_kursi, $hargaDasarTiket, $kacamata3dId, $efekGerakFitur) {
        // Memanggil constructor dari parent class (Tiket)
        parent::__construct($id_tiket, $nama_film, $jadwal_tayang, $jumlah_kursi, $hargaDasarTiket);
        $this->kacamata3dId = $kacamata3dId;
        $this->efekGerakFitur = $efekGerakFitur;
    }

    /**
     * [OVERRIDE] Menghitung total harga untuk studio IMAX.
     * Logika Bisnis: Dikenakan biaya tambahan teknologi proyeksi layar lebar IMAX
     * dan audio flat sebesar Rp35.000.
     * Formula: (jumlah_kursi * hargaDasarTiket) + 35000
     *
     * @return float Total harga tiket IMAX
     */
    public function hitungTotalHarga() {
        // Biaya tambahan teknologi proyeksi IMAX & audio flat
        $biayaTeknologiIMAX = 35000;
        return ($this->jumlah_kursi * $this->hargaDasarTiket) + $biayaTeknologiIMAX;
    }

    /**
     * Menampilkan informasi fasilitas tambahan studio IMAX
     *
     * @return string
     */
    public function tampilkanInfoFasilitas() {
        $kacamataInfo = $this->kacamata3dId ? $this->kacamata3dId : "Tidak Ada";
        $efekGerakInfo = $this->efekGerakFitur ? $this->efekGerakFitur : "Tidak Ada";
        return "Studio IMAX - ID Kacamata 3D: " . $kacamataInfo . ", Efek Gerak: " . $efekGerakInfo;
    }

    // Getter untuk ID kacamata 3D
    public function getKacamata3dId() {
        return $this->kacamata3dId;
    }

    // Getter untuk fitur efek gerak
    public function getEfekGerakFitur() {
        return $this->efekGerakFitur;
    }
}
?>
