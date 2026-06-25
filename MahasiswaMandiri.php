<?php
require_once 'Mahasiswa.php';

class MahasiswaMandiri extends Mahasiswa {
    // Properti tambahan spesifik Mandiri
    private $golonganUkt;
    private $namaWali;

    // Constructor untuk menginisialisasi atribut induk dan anak
    public function __construct($id_mahasiswa, $nama_mahasiswa, $nim, $semester, $tarifUktNominal, $golonganUkt, $namaWali) {
        parent::__construct($id_mahasiswa, $nama_mahasiswa, $nim, $semester, $tarifUktNominal);
        $this->golonganUkt = $golonganUkt;
        $this->namaWali = $namaWali;
    }

    /**
     * TAHAP 5: Overriding hitungTagihanSemester()
     * Skema Mandiri: tarifUktNominal + 100000 (biaya operasional flat)
     */
    public function hitungTagihanSemester() {
        $biayaOperasional = 100000;
        return $this->tarifUktNominal + $biayaOperasional;
    }

    public function tampilkanSpesifikasiAkademik() {
        return "Mahasiswa Jalur Mandiri - Golongan UKT: " . $this->golonganUkt . ", Wali: " . $this->namaWali;
    }

    // Method untuk menghasilkan query SELECT-WHERE spesifik Mandiri
    public function getSqlQueryAmbilData() {
        return "SELECT id_mahasiswa, nama_mahasiswa, nim, semester, tarif_ukt_nominal, jenis_pembiayaan, golongan_ukt, nama_wali 
                FROM tabel_mahasiswa 
                WHERE jenis_pembiayaan = 'Mandiri' AND id_mahasiswa = " . $this->id_mahasiswa . ";";
    }
}