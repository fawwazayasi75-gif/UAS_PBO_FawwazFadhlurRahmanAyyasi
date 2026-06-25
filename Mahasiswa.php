<?php

abstract class Mahasiswa {
    // Properti terenkapsulasi dengan hak akses protected
    // Nilai properti ini dipetakan dari kolom tabel_mahasiswa di database
    protected $id_mahasiswa;
    protected $nama_mahasiswa;
    protected $nim;
    protected $semester;
    protected $tarifUktNominal; // Memetakan kolom tarif_ukt_nominal

    // Constructor untuk menginisialisasi atribut global saat objek dibuat
    public function __construct($id_mahasiswa, $nama_mahasiswa, $nim, $semester, $tarifUktNominal) {
        $this->id_mahasiswa = $id_mahasiswa;
        $this->nama_mahasiswa = $nama_mahasiswa;
        $this->nim = $nim;
        $this->semester = $semester;
        $this->tarifUktNominal = $tarifUktNominal;
    }

    // Metode abstrak wajib (tanpa isi/body)
    abstract public function hitungTagihanSemester();
    abstract public function tampilkanSpesifikasiAkademik();
}

?>