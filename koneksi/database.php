<?php
/**
 * Class Database
 * Menangani koneksi ke database db_PBO_latihan_TRPL1A_RIZQI dengan menggunakan PDO (PHP Data Objects).
 */
class Database {
    private $host = "localhost";
    private $db_name = "db_PBO_latihan_TRPL1A_RIZQI";
    private $username = "root";
    private $password = "";
    private $conn;

    /**
     * Membangun koneksi ke database dan mengembalikannya.
     *
     * @return PDO|null Koneksi database atau null jika gagal.
     */
    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name, 
                $this->username, 
                $this->password
            );
            // Mengatur mode error PDO ke Exception untuk mempermudah debugging
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // Mengatur default fetch mode menjadi associative array
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            // Mengatur charset koneksi ke UTF-8
            $this->conn->exec("set names utf8mb4");
        } catch (PDOException $exception) {
            throw new Exception("Koneksi database bermasalah: " . $exception->getMessage());
        }

        return $this->conn;
    }
}
?>
