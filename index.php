<?php
// Include semua kelas yang diperlukan
require_once 'Mahasiswa.php';
require_once 'MahasiswaMandiri.php';
require_once 'MahasiswaBidikmisi.php';
require_once 'MahasiswaPrestasi.php';
require_once 'koneksi.php'; // Panggil file koneksi OOP yang terpisah

// 1. Ambil koneksi database secara OOP lewat Class Koneksi
$db = new Koneksi();
$conn = $db->getKoneksi(); 

// 2. Ambil Data dari Database
$query  = "SELECT * FROM tabel_mahasiswa";
$result = $conn->query($query);

// Array penampung objek berdasarkan kategori pembiayaan
$listMandiri   = [];
$listBidikmisi = [];
$listPrestasi  = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Bungkus objek PBO beserta data mentahnya agar bisa dipanggil di HTML tanpa melanggar enkapsulasi protected
        $dataMhs = [
            'objek' => null,
            'nim'   => $row['nim'],
            'nama'  => $row['nama_mahasiswa'],
            'smstr' => $row['semester']
        ];

        if ($row['jenis_pembiayaan'] == 'Mandiri') {
            $dataMhs['objek'] = new MahasiswaMandiri(
                $row['id_mahasiswa'], $row['nama_mahasiswa'], $row['nim'], 
                $row['semester'], $row['tarif_ukt_nominal'], $row['golongan_ukt'], $row['nama_wali']
            );
            $listMandiri[] = $dataMhs;
        } elseif ($row['jenis_pembiayaan'] == 'Bidikmisi') {
            $dataMhs['objek'] = new MahasiswaBidikmisi(
                $row['id_mahasiswa'], $row['nama_mahasiswa'], $row['nim'], 
                $row['semester'], $row['tarif_ukt_nominal'], $row['nomor_kip_kuliah'], $row['dana_suku_subsidi']
            );
            $listBidikmisi[] = $dataMhs;
        } elseif ($row['jenis_pembiayaan'] == 'Prestasi') {
            $dataMhs['objek'] = new MahasiswaPrestasi(
                $row['id_mahasiswa'], $row['nama_mahasiswa'], $row['nim'], 
                $row['semester'], $row['tarif_ukt_nominal'], $row['nama_instansi_beasiswa'], $row['minimal_ipk_syarat']
            );
            $listPrestasi[] = $dataMhs;
        }
    }
}
$db->tutupKoneksi(); // Tutup koneksi via method dari class Koneksi
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Registrasi Pembayaran Kuliah Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; padding-top: 30px; }
        .card { margin-bottom: 35px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .table th { background-color: #343a40; color: white; text-align: center; }
    </style>
</head>
<body>

<div class="container">
    <div class="text-center mb-5">
        <h2 class="fw-bold">SISTEM REGISTRASI PEMBAYARAN KULIAH</h2>
        <p class="text-muted">Data Dinamis Berbasis PBO dan Database Relasional</p>
        <hr>
    </div>

    <div class="card">
        <div class="card-header bg-primary text-white font-weight-bold">
            <h5 class="mb-0">Daftar Mahasiswa - Jalur Mandiri</h5>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped table-hover align-middle">
                <thead>
                    <tr>
                        <th>NIM</th>
                        <th>Nama Mahasiswa</th>
                        <th>Semester</th>
                        <th>Spesifikasi Akademik</th>
                        <th>Total Tagihan (+Biaya Ops)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($listMandiri)): ?>
                        <tr><td colspan="5" class="text-center">Tidak ada data.</td></tr>
                    <?php else: ?>
                        <?php foreach ($listMandiri as $mhs): ?>
                            <tr>
                                <td class="text-center"><?= htmlspecialchars($mhs['nim']) ?></td>
                                <td><?= htmlspecialchars($mhs['nama']) ?></td>
                                <td class="text-center"><?= htmlspecialchars($mhs['smstr']) ?></td>
                                <td><?= htmlspecialchars($mhs['objek']->tampilkanSpesifikasiAkademik()) ?></td>
                                <td class="text-end fw-bold text-danger">Rp <?= number_format($mhs['objek']->hitungTagihanSemester(), 0, ',', '.') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0">Daftar Mahasiswa - Penerima Bidikmisi / KIP-K</h5>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped table-hover align-middle">
                <thead>
                    <tr>
                        <th>NIM</th>
                        <th>Nama Mahasiswa</th>
                        <th>Semester</th>
                        <th>Spesifikasi Beasiswa & Subsidi Negara</th>
                        <th>Total Tagihan Semester</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($listBidikmisi)): ?>
                        <tr><td colspan="5" class="text-center">Tidak ada data.</td></tr>
                    <?php else: ?>
                        <?php foreach ($listBidikmisi as $mhs): ?>
                            <tr>
                                <td class="text-center"><?= htmlspecialchars($mhs['nim']) ?></td>
                                <td><?= htmlspecialchars($mhs['nama']) ?></td>
                                <td class="text-center"><?= htmlspecialchars($mhs['smstr']) ?></td>
                                <td><?= htmlspecialchars($mhs['objek']->tampilkanSpesifikasiAkademik()) ?></td>
                                <td class="text-end fw-bold text-success">Rp <?= number_format($mhs['objek']->hitungTagihanSemester(), 0, ',', '.') ?> (Gratis)</td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-warning text-dark">
            <h5 class="mb-0">Daftar Mahasiswa - Jalur Prestasi</h5>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped table-hover align-middle">
                <thead>
                    <tr>
                        <th>NIM</th>
                        <th>Nama Mahasiswa</th>
                        <th>Semester</th>
                        <th>Spesifikasi Instansi & Syarat IPK</th>
                        <th>Tagihan Akhir (Potongan 75%)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($listPrestasi)): ?>
                        <tr><td colspan="5" class="text-center">Tidak ada data.</td></tr>
                    <?php else: ?>
                        <?php foreach ($listPrestasi as $mhs): ?>
                            <tr>
                                <td class="text-center"><?= htmlspecialchars($mhs['nim']) ?></td>
                                <td><?= htmlspecialchars($mhs['nama']) ?></td>
                                <td class="text-center"><?= htmlspecialchars($mhs['smstr']) ?></td>
                                <td><?= htmlspecialchars($mhs['objek']->tampilkanSpesifikasiAkademik()) ?></td>
                                <td class="text-end fw-bold text-primary">Rp <?= number_format($mhs['objek']->hitungTagihanSemester(), 0, ',', '.') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>