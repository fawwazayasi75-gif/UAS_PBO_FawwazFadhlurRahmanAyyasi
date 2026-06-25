<?php
require_once 'Mahasiswa.php';

class MahasiswaPrestasi extends Mahasiswa {
    // Properti tambahan spesifik Prestasi
    private $namaInstansiBeasiswa;
    private $minimalIpkSyarat;

    // Constructor untuk menginisialisasi atribut induk dan anak
    public function __construct($id_mahasiswa, $nama_mahasiswa, $nim, $semester, $tarifUktNominal, $namaInstansiBeasiswa, $minimalIpkSyarat) {
        parent::__construct($id_mahasiswa, $nama_mahasiswa, $nim, $semester, $tarifUktNominal);
        $this->namaInstansiBeasiswa = $namaInstansiBeasiswa;
        $this->minimalIpkSyarat = $minimalIpkSyarat;
    }

    // Implementasi metode abstrak dari kelas induk
    public function hitungTagihanSemester() {
        // Skema Prestasi: Tagihan berupa tarif nominal awal dikurangi potongan/diskon (bisa disesuaikan logikanya)
        return $this->tarifUktNominal; 
    }

    public function tampilkanSpesifikasiAkademik() {
        return "Mahasiswa Jalur Prestasi - Beasiswa: " . $this->namaInstansiBeasiswa . ", Syarat Minimal IPK: " . $this->minimalIpkSyarat;
    }

    // Method untuk menghasilkan query SELECT-WHERE spesifik Prestasi
    public function getSqlQueryAmbilData() {
        return "SELECT id_mahasiswa, nama_mahasiswa, nim, semester, tarif_ukt_nominal, jenis_pembiayaan, nama_instansi_beasiswa, minimal_ipk_syarat 
                FROM tabel_mahasiswa 
                WHERE jenis_pembiayaan = 'Prestasi' AND id_mahasiswa = " . $this->id_mahasiswa . ";";
    }
}