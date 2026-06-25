<?php

class Koneksi {
    private $host     = "localhost";
    private $username = "root";
    private $password = ""; // Sesuaikan dengan password MySQL masing-masing
    private $database = "DB_UAS_PBO_TI1D_FawwazFadhlurRahmanAyyasi";
    protected $conn;

    // Constructor otomatis berjalan saat class dipanggil
    public function __construct() {
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);

        // Cek koneksi secara OOP
        if ($this->conn->connect_error) {
            die("Koneksi ke database gagal: " . $this->conn->connect_error);
        }
    }

    // Method untuk mengambil objek koneksi
    public function getKoneksi() {
        return $this->conn;
    }

    // Method untuk menutup koneksi
    public function tutupKoneksi() {
        $this->conn->close();
    }
}