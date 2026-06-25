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

    /**
     * TAHAP 5: Overriding hitungTagihanSemester()
     * Skema Prestasi: Mendapat potongan 75%, sehingga cukup membayar 25% (tarifUktNominal * 0.25)
     */
    public function hitungTagihanSemester() {
        return $this->tarifUktNominal * 0.25;
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