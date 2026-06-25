<?php
require_once 'Mahasiswa.php';

class MahasiswaBidikmisi extends Mahasiswa {
    // Properti tambahan spesifik Bidikmisi
    private $nomorKipKuliah;
    private $danaSakuSubsidi;

    // Constructor untuk menginisialisasi atribut induk dan anak
    public function __construct($id_mahasiswa, $nama_mahasiswa, $nim, $semester, $tarifUktNominal, $nomorKipKuliah, $danaSakuSubsidi) {
        parent::__construct($id_mahasiswa, $nama_mahasiswa, $nim, $semester, $tarifUktNominal);
        $this->nomorKipKuliah = $nomorKipKuliah;
        $this->danaSakuSubsidi = $danaSakuSubsidi;
    }

    // Implementasi metode abstrak dari kelas induk
    public function hitungTagihanSemester() {
        // Skema Bidikmisi: Biasanya UKT ditanggung penuh/0 rupiah oleh pemerintah
        return 0;
    }

    public function tampilkanSpesifikasiAkademik() {
        return "Mahasiswa Penerima Bidikmisi - No KIP: " . $this->nomorKipKuliah . ", Mendapat Subsidi Saku: Rp " . number_format($this->danaSakuSubsidi, 0, ',', '.');
    }

    // Method untuk menghasilkan query SELECT-WHERE spesifik Bidikmisi
    public function getSqlQueryAmbilData() {
        return "SELECT id_mahasiswa, nama_mahasiswa, nim, semester, tarif_ukt_nominal, jenis_pembiayaan, nomor_kip_kuliah, dana_suku_subsidi 
                FROM tabel_mahasiswa 
                WHERE jenis_pembiayaan = 'Bidikmisi' AND id_mahasiswa = " . $this->id_mahasiswa . ";";
    }
}