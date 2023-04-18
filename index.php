<?php
session_start();
include "koneksi.php";

// NAV ACTIVE
$nav_active = 'beranda';
$sub_active = '';


if (empty($_SESSION['nik'])) {
    header("location: form_login.php");
} else {

    if ($_SESSION['level'] == "masyarakat") {

        // SQL UNTUK MASYARAKAT

        // SQL PENGADUAN PEMILIK AKUN
        $sqlPengaduan = "SELECT * FROM pengaduan WHERE nik='$_SESSION[nik]' ORDER BY id_pengaduan DESC";
        $excPengaduan = mysqli_query($koneksi, $sqlPengaduan);
        $jumlahPengaduan = mysqli_num_rows($excPengaduan);

        // SQL PENGADUAN BELUM DI PROSES
        $sqlPengaduanBelum = "SELECT * FROM pengaduan WHERE nik='$_SESSION[nik]' AND status='0'";
        $excPengaduanBelum = mysqli_query($koneksi, $sqlPengaduanBelum);
        $jumlahPengaduanBelum = mysqli_num_rows($excPengaduanBelum);

        // SQL PENGADUAN SEDANG DI PROSES
        $sqlPengaduanDiproses = "SELECT * FROM pengaduan WHERE nik='$_SESSION[nik]' AND status='proses'";
        $excPengaduanDiproses = mysqli_query($koneksi, $sqlPengaduanDiproses);
        $jumlahPengaduanDiproses = mysqli_num_rows($excPengaduanDiproses);

        // SQL PENGADUAN SELESAI
        $sqlPengaduanSelesai = "SELECT * FROM pengaduan WHERE nik='$_SESSION[nik]' AND status='selesai'";
        $excPengaduanSelesai = mysqli_query($koneksi, $sqlPengaduanSelesai);
        $jumlahPengaduanSelesai = mysqli_num_rows($excPengaduanSelesai);
    } else {

        // SQL UNTUK PETUGAS

        // SQL PENGADUAN PEMILIK AKUN
        $sqlPengaduan = "SELECT * FROM pengaduan ORDER BY id_pengaduan DESC";
        $excPengaduan = mysqli_query($koneksi, $sqlPengaduan);
        $jumlahPengaduan = mysqli_num_rows($excPengaduan);

        // SQL PENGADUAN BELUM DI PROSES
        $sqlPengaduanBelum = "SELECT * FROM pengaduan WHERE status='0'";
        $excPengaduanBelum = mysqli_query($koneksi, $sqlPengaduanBelum);
        $jumlahPengaduanBelum = mysqli_num_rows($excPengaduanBelum);

        // SQL PENGADUAN SEDANG DI PROSES
        $sqlPengaduanDiproses = "SELECT * FROM pengaduan WHERE status='proses'";
        $excPengaduanDiproses = mysqli_query($koneksi, $sqlPengaduanDiproses);
        $jumlahPengaduanDiproses = mysqli_num_rows($excPengaduanDiproses);

        // SQL PENGADUAN SELESAI
        $sqlPengaduanSelesai = "SELECT * FROM pengaduan WHERE status='selesai'";
        $excPengaduanSelesai = mysqli_query($koneksi, $sqlPengaduanSelesai);
        $jumlahPengaduanSelesai = mysqli_num_rows($excPengaduanSelesai);
    }


    // HEADER HTML
    include "layout/header.php";
    include "layout/nav.php";
?>
    <!-- Body HTML -->
    <div class="container">

        <h4 class="text-uppercase fw-bold text-secondary mt-2">Daftar Pengaduan Yang Dibuat</h4>
        <hr>

        <div class="row justify-content-center m-2">
            <div class="col-sm-3">
                <a href="show_pengaduan_total.php" class="text-decoration-none">
                    <div class="card bg-primary text-white mb-2" style="height: 10rem;">
                        <!-- <img src="..." class="card-img-top" alt="..."> -->
                        <div class="card-body">
                            <h5 class="card-title">JUMLAH PENGADUAN</h5>
                            <div class="display-4 fw-bold"><?php echo $jumlahPengaduan ?></div>
                            <p class="card-text text-white">Selengkapnya >></p>
                        </div>
                    </div>
                </a>
            </div>



            <div class="col-sm-3">
                <a href="show_pengaduan_belum.php" class="text-decoration-none">
                    <div class="card bg-secondary text-white mb-2" style="height: 10rem;">
                        <!-- <img src="..." class="card-img-top" alt="..."> -->
                        <div class="card-body">
                            <h5 class="card-title">BELUM DIPROSES</h5>
                            <div class="display-4 fw-bold"><?php echo $jumlahPengaduanBelum ?></div>
                            <p class="card-text text-white">Selengkapnya >></p>
                        </div>
                    </div>
                </a>
            </div>



            <div class="col-sm-3">
                <a href="show_pengaduan_diproses.php" class="text-decoration-none">
                    <div class="card bg-warning text-white mb-2" style="height: 10rem;">
                        <!-- <img src="..." class="card-img-top" alt="..."> -->
                        <div class="card-body">
                            <h5 class="card-title">PENGADUAN DIPROSES</h5>
                            <div class="display-4 fw-bold"><?php echo $jumlahPengaduanDiproses ?></div>
                            <p class="card-text text-white">Selengkapnya >></p>
                        </div>
                    </div>
                </a>
            </div>



            <div class="col-sm-3">
                <a href="show_pengaduan_selesai.php" class="text-decoration-none">
                    <div class="card bg-success text-white mb-2" style="height: 10rem;">
                        <!-- <img src="..." class="card-img-top" alt="..."> -->
                        <div class="card-body">
                            <h5 class="card-title">PENGADUAN SELESAI</h5>
                            <div class="display-4 fw-bold"><?php echo $jumlahPengaduanSelesai ?></div>
                            <p class="card-text text-white">Selengkapnya >></p>
                        </div>
                    </div>
                </a>
            </div>
        </div>


        <!-- TABLE PENGADUAN -->
        <?php
        if ($_SESSION['level'] == 'masyarakat') {
            echo "<a href='form_tambah_aduan.php' class='btn btn-primary mt-4 mb-3'>BUAT PENGADUAN BARU</a>";
        } else {
            echo "<div class='mb-5'></div>";
        }
        ?>

        <div class="row">
            <div class="col-sm-12">
                <table id="myTable" class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col">No.</th>

                            <!-- KOLOM NIK JIKA LOGIN SEBAGAI PETUGAS/ADMIN -->
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
                        // Bulan Indo
                        function bulan_indo($data)
                        {
                            $tanggal = explode("-", $data['tgl_pengaduan']);
                            $bulan = "";
                            switch ($tanggal[1]) {
                                case '1':
                                    $bulan = "Januari";
                                    break;
                                case '2':
                                    $bulan = "Februari";
                                    break;
                                case '3':
                                    $bulan = "Maret";
                                    break;
                                case '4':
                                    $bulan = "April";
                                    break;
                                case '5':
                                    $bulan = "Mei";
                                    break;
                                case '6':
                                    $bulan = "Juni";
                                    break;
                                case '7':
                                    $bulan = "Juli";
                                    break;
                                case '8':
                                    $bulan = "Agustus";
                                    break;
                                case '9':
                                    $bulan = "September";
                                    break;
                                case '10':
                                    $bulan = "Oktober";
                                    break;
                                case '11':
                                    $bulan = "November";
                                    break;
                                case '12':
                                    $bulan = "Desember";
                                    break;
                                default:
                                    $bulan = "Undefined";
                            }

                            $tgl_indo = $tanggal[2] . "-" .  $bulan . "-" . $tanggal[0];
                            return $tgl_indo;
                        }

                        $no = 1;
                        while ($data = mysqli_fetch_array($excPengaduan)) {
                        ?>

                            <!-- ISI TABLE -->
                            <tr class="align-middle">
                                <td scope="row"><?= $no ?></td>

                                <!-- KOLOM NIK JIKA LOGIN SEBAGAI PETUGAS/ADMIN -->
                                <?php
                                if ($_SESSION['level'] !== 'masyarakat') {
                                    echo "<td>
                                    $data[nik]
                                 </td>";
                                }
                                ?>

                                <td><?= bulan_indo($data) ?></td>

                                <td><a href="pengaduan_detail.php?id_pengaduan=<?php echo $data['id_pengaduan'] ?>" class="text-secondary"><?= $data['isi_laporan'] ?></a></td>

                                <td><?= $data['status'] ?></td>
                            </tr>

                        <?php
                            $no++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
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