<?php
session_start();
include "koneksi.php";

// Nav Active
$nav_active = "pengaduan";
$sub_active = "total";

if (empty($_SESSION['nik'])) {
    header("location: form_login.php");
} else {

    if ($_SESSION['level'] == 'masyarakat') {
        // SQL PENGADUAN PEMILIK AKUN
        $sqlPengaduan = "SELECT * FROM pengaduan WHERE nik='$_SESSION[nik]' ORDER BY tgl_pengaduan DESC";
        $excPengaduan = mysqli_query($koneksi, $sqlPengaduan);
        $jumlahPengaduan = mysqli_num_rows($excPengaduan);
    } elseif (($_SESSION['level'] == 'admin') || ($_SESSION['level'] == 'petugas')) {
        $sqlPengaduan = "SELECT * FROM pengaduan ORDER BY tgl_pengaduan DESC";
        $excPengaduan = mysqli_query($koneksi, $sqlPengaduan);
        $jumlahPengaduan = mysqli_num_rows($excPengaduan);
    } else {
        header("location:index.php");
    }


    // HEADER HTML
    include "layout/header.php";
    include "layout/nav.php";
?>
    <!-- Body HTML -->
    <div class="container">

        <h4 class="text-uppercase fw-bold text-secondary mt-2">Daftar Pengaduan Total</h4>
        <hr>

        <!-- TABLE PENGADUAN -->
        <?php
        if ($_SESSION['level'] == 'masyarakat') :
        ?>
            <a href="form_tambah_aduan.php" class="btn btn-primary mb-3">BUAT PENGADUAN BARU</a>
        <?php
        endif;
        ?>

        <?php
        if ($_SESSION['level'] == 'admin') :
        ?>
            <div class="row mb-3">
                <div class="col-sm-12">
                    <a href="system/report_total.php" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Export Data Kedalam File .xls" class="btn btn-success d-flex justify-content-center"><img style="fill: white;" class="me-2 text-white" src="svg/icons8-microsoft-excel.svg" alt="xls_svg">XLS</a>
                </div>
            </div>
        <?php
        endif;
        ?>

        <table id="myTable" class="table table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col">No.</th>
                    <?php
                    if ($_SESSION['level'] !== 'masyarakat') {
                        echo "<th scope='col'>NIK Masyarakat</th>";
                    }
                    ?>
                    <th scope="col">Tanggal</th>
                    <th scope="col">Isi Pengaduan</th>
                    <th scope="col">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                while ($data = mysqli_fetch_array($excPengaduan)) {
                ?>

                    <!-- ISI TABLE -->
                    <tr>
                        <th scope="row"><?= $no ?></th>

                        <!-- KOLOM NIK JIKA LOGIN SEBAGAI PETUGAS/ADMIN -->
                        <?php
                        if ($_SESSION['level'] !== 'masyarakat') {
                            echo "<td>
                                    $data[nik]
                                 </td>";
                        }
                        ?>

                        <td><?= $data['tgl_pengaduan'] ?></td>
                        <td><a href="pengaduan_detail.php?id_pengaduan=<?= $data['id_pengaduan'] ?>" class="text-secondary"><?= $data['isi_laporan'] ?></a></td>
                        <td><?= $data['status'] ?></td>
                    </tr>

                <?php
                    $no++;
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- FOOTER -->
    <?php
    include "layout/copyright.php";
    ?>


    <script src="js/jquery-3.6.1.slim.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/dataTables.responsive.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                responsive: true
            });
        });
    </script>


<?php
    include "layout/footer.php";
}
?>