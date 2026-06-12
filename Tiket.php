<?php
/**
 * Class Abstrak Tiket
 * Mewakili model dasar untuk Tiket Bioskop dengan enkapsulasi properti.
 */
abstract class Tiket {
    // Properti terenkapsulasi (protected)
    protected $id_tiket;
    protected $nama_film;
    protected $jadwal_tayang;
    protected $jumlah_kursi;
    protected $hargaDasarTiket; // Dipetakan dari kolom 'harga_dasar_tiket' di database

    /**
     * Constructor untuk memetakan nilai properti dari kolom tabel database
     *
     * @param int $id_tiket
     * @param string $nama_film
     * @param string $jadwal_tayang
     * @param int $jumlah_kursi
     * @param float $hargaDasarTiket
     */
    public function __construct($id_tiket, $nama_film, $jadwal_tayang, $jumlah_kursi, $hargaDasarTiket) {
        $this->id_tiket = $id_tiket;
        $this->nama_film = $nama_film;
        $this->jadwal_tayang = $jadwal_tayang;
        $this->jumlah_kursi = $jumlah_kursi;
        $this->hargaDasarTiket = $hargaDasarTiket;
    }

    /**
     * Metode abstrak untuk menghitung total harga tiket berdasarkan jenis studio & aturan spesifik.
     * Wajib dideklarasikan tanpa isi (body) di kelas abstrak ini.
     *
     * @return float
     */
    abstract public function hitungTotalHarga();

    /**
     * Metode abstrak untuk menampilkan informasi fasilitas spesifik masing-masing studio.
     * Wajib dideklarasikan tanpa isi (body) di kelas abstrak ini.
     *
     * @return string
     */
    abstract public function tampilkanInfoFasilitas();

    // Getter untuk properti protected agar dapat diakses/dibaca secara aman dari luar class
    public function getIdTiket() {
        return $this->id_tiket;
    }

    public function getNamaFilm() {
        return $this->nama_film;
    }

    public function getJadwalTayang() {
        return $this->jadwal_tayang;
    }

    public function getJumlahKursi() {
        return $this->jumlah_kursi;
    }

    public function getHargaDasarTiket() {
        return $this->hargaDasarTiket;
    }
}
?>
