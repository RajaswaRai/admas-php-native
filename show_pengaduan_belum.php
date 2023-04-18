<?php
session_start();
include "koneksi.php";

if (empty($_SESSION['nik'])) {
    header("location: form_login.php");
} else {

    // NAV ACTIVE
    $nav_active = 'pengaduan';
    $sub_active = 'belum';

    // SQL PENGADUAN YANG BELUM DITANGANI

    if ($_SESSION['level'] == 'masyarakat') {
        $sqlPengaduanBlm = "SELECT * FROM pengaduan WHERE nik='$_SESSION[nik]' AND `status`='0' ORDER BY tgl_pengaduan DESC";
        $excPengaduanBlm = mysqli_query($koneksi, $sqlPengaduanBlm);
        $jumlahPengaduanBlm = mysqli_num_rows($excPengaduanBlm);
    } else {
        $sqlPengaduanBlm = "SELECT * FROM pengaduan WHERE `status`='0' ORDER BY tgl_pengaduan DESC";
        $excPengaduanBlm = mysqli_query($koneksi, $sqlPengaduanBlm);
        $jumlahPengaduanBlm = mysqli_num_rows($excPengaduanBlm);
    }


    // HEADER HTML
    include "layout/header.php";
    include "layout/nav.php";
?>
    <!-- Body HTML -->
    <div class="container">

        <h4 class="text-uppercase fw-bold text-secondary mt-2">Daftar Pengaduan Belum Ditangani</h4>
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
                    <a href="system/report_belum.php" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Export Data Kedalam File .xls" class="btn btn-success d-flex justify-content-center"><img style="fill: white;" class="me-2 text-white" src="svg/icons8-microsoft-excel.svg" alt="xls_svg">XLS</a>
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
                while ($data = mysqli_fetch_array($excPengaduanBlm)) {
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