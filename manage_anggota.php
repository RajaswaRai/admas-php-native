<?php
session_start();
include "koneksi.php";

if (empty($_SESSION['nik']) && $_SESSION['level'] !== 'admin') {
    header("location: form_login.php");
} else {

    // NAV ACTIVE
    $nav_active = 'manajemen';
    $sub_active = '';

    // SQL MASYARAKAT
    $sqlMasyarakat = "SELECT * FROM masyarakat ORDER BY nik DESC";
    $excMasyarakat = mysqli_query($koneksi, $sqlMasyarakat);
    $jumlahMasyarakat = mysqli_num_rows($excMasyarakat);

    // SQL PETUGAS
    $sqlPetugas = "SELECT * FROM petugas WHERE `level`='petugas' ORDER BY nama_petugas DESC";
    $excPetugas = mysqli_query($koneksi, $sqlPetugas);
    $jumlahPetugas = mysqli_num_rows($excPetugas);

    // SQL ADMIN
    $sqlAdmin = "SELECT * FROM petugas WHERE `level`='admin' ORDER BY nama_petugas DESC";
    $excAdmin = mysqli_query($koneksi, $sqlAdmin);
    $jumlahAdmin = mysqli_num_rows($excAdmin);


    // HEADER HTML
    include "layout/header.php";
    include "layout/nav.php";
?>
    <!-- Body HTML -->
    <div class="container">

        <h4 class="text-uppercase fw-bold text-secondary mt-2">Rekapitulasi Pengguna</h4>
        <hr>

        <div class="row justify-content-center m-2">
            <div class="col-sm-3">
                <a href="manage_anggota.php?jenis=masyarakat" class="text-decoration-none">
                    <div class="card bg-primary text-white mb-2" style="height: 10rem;">
                        <!-- <img src="..." class="card-img-top" alt="..."> -->
                        <div class="card-body">
                            <h5 class="card-title">MASYARAKAT</h5>
                            <div class="display-4 fw-bold"><?= $jumlahMasyarakat ?></div>
                            <p class="card-text text-white">Selengkapnya >></p>
                        </div>
                    </div>
                </a>
            </div>



            <div class="col-sm-3">
                <a href="manage_anggota.php?jenis=petugas" class="text-decoration-none">
                    <div class="card bg-warning text-white mb-2" style="height: 10rem;">
                        <!-- <img src="..." class="card-img-top" alt="..."> -->
                        <div class="card-body">
                            <h5 class="card-title">PETUGAS</h5>
                            <div class="display-4 fw-bold"><?= $jumlahPetugas ?></div>
                            <p class="card-text text-white">Selengkapnya >></p>
                        </div>
                    </div>
                </a>
            </div>



            <div class="col-sm-3">
                <a href="manage_anggota.php?jenis=admin" class="text-decoration-none">
                    <div class="card bg-success text-white mb-2" style="height: 10rem;">
                        <!-- <img src="..." class="card-img-top" alt="..."> -->
                        <div class="card-body">
                            <h5 class="card-title">ADMINISTRATOR</h5>
                            <div class="display-4 fw-bold"><?= $jumlahAdmin ?></div>
                            <p class="card-text text-white">Selengkapnya >></p>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <?php
        if ((isset($_GET['jenis']) && $_GET['jenis'] == "masyarakat") || empty($_GET['jenis'])) :
        ?>
            <!-- TABEL MASYARAKAT -->
            <div class="row border-top border-3 border-primary my-4">
                <div class="col-sm-10">
                    <h4 id="h4-masyarakat" class="text-uppercase fw-bold text-secondary mt-3">Tabel Masyarakat</h4>
                </div>

                <div class="col-sm-2 device-desktop">
                    <span data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Tambah Masyarakat">
                        <button style="width: 160px;" data-bs-toggle="modal" data-bs-target="#modal-masyarakat" class="mt-2 mb-1 btn btn-warning"><i class="me-3 fa-solid fa-plus"></i>Tambah</button>
                    </span>
                </div>

                <div class="col-sm-12 device-mobile">
                    <span data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Tambah Masyarakat">
                        <button style="width: 100%;" data-bs-toggle="modal" data-bs-target="#modal-masyarakat" class="mt-2 mb-1 btn btn-warning"><i class="me-3 fa-solid fa-plus"></i>Tambah</button>
                    </span>
                </div>

                <hr>
                <div class="col-sm-12">
                    <table id="myTable" class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th scope="col">No.</th>
                                <th scope="col">NIK</th>
                                <th scope="col">Nama</th>
                                <th scope="col">No. Telepon</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($excMasyarakat as $t) :
                            ?>

                                <!-- ISI TABLE -->
                                <tr class="align-middle">
                                    <td scope="row"><?= $no ?></td>
                                    <td><?= $t['nik'] ?></td>
                                    <td><?= $t['nama'] ?></td>
                                    <td><?= $t['telp'] ?></td>
                                </tr>

                            <?php
                                $no++;
                            endforeach;
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- MODAL TAMBAH MASYARAKAT -->
            <div class="modal fade" id="modal-masyarakat" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Masyarakat</h1>
                            <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                        </div>
                        <div class="modal-body">
                            <form action="system/tambah_masyarakat.php" method="POST">

                                <div class="row mb-4">
                                    <div class="col-sm-12">
                                        <div class="form-input-group">
                                            <label for="inp_nik" class="form-label">NIK :</label>
                                            <input class="form-control" type="number" name="nik" id="inp_nik">
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-sm-6">
                                        <div class="form-input-group">
                                            <label for="inp_nama" class="form-label">Nama :</label>
                                            <input class="form-control" type="text" name="nama" id="inp_nama">
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-input-group">
                                            <label for="inp_username" class="form-label">Username :</label>
                                            <input class="form-control" type="text" name="username" id="inp_username">
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-sm-12">
                                        <div class="form-input-group">
                                            <label for="inp_password" class="form-label">Password :</label>
                                            <input class="form-control" type="password" name="password" id="inp_password">
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-sm-12">
                                        <div class="form-input-group">
                                            <label for="inp_telepon" class="form-label">Telepon :</label>
                                            <input class="form-control" type="number" name="telepon" id="inp_telepon">
                                        </div>
                                    </div>
                                </div>

                        </div>
                        <div class="modal-footer">
                            <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary" name="tambah_masyarakat">Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        <?php
        endif;
        if ((isset($_GET['jenis']) && $_GET['jenis'] == "petugas") || empty($_GET['jenis'])) :
        ?>
            <!-- TABEL PETUGAS -->
            <div class="row border-top border-3 border-primary my-4">
                <div class="col-sm-10">
                    <h4 id="h4-petugas" class="text-uppercase fw-bold text-secondary mt-3">Tabel Petugas</h4>
                </div>

                <div class="col-sm-2 device-desktop">
                    <span data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Tambah Petugas">
                        <button style="width: 160px;" data-bs-toggle="modal" data-bs-target="#modal-petugas" class="mt-2 mb-1 btn btn-warning"><i class="me-3 fa-solid fa-plus"></i>Tambah</button>
                    </span>
                </div>

                <div class="col-sm-12 device-mobile">
                    <span data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Tambah Petugas">
                        <button style="width: 100%;" data-bs-toggle="modal" data-bs-target="#modal-petugas" class="mt-2 mb-1 btn btn-warning"><i class="me-3 fa-solid fa-plus"></i>Tambah</button>
                    </span>
                </div>

                <hr>
                <div class="col-sm-12">
                    <table id="tablePetugas" class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th scope="col">No.</th>
                                <th scope="col">Nama</th>
                                <th scope="col">No. Telepon</th>
                                <th scope="col">Level</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($excPetugas as $t) :
                            ?>

                                <!-- ISI TABLE -->
                                <tr class="align-middle">
                                    <td scope="row"><?= $no ?></td>
                                    <td><?= $t['nama_petugas'] ?></td>
                                    <td><?= $t['telp'] ?></td>
                                    <td><?= $t['level'] ?></td>
                                </tr>

                            <?php
                                $no++;
                            endforeach;
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- MODAL TAMBAH PETUGAS -->
            <div class="modal fade" id="modal-petugas" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Petugas</h1>
                            <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                        </div>
                        <div class="modal-body">
                            <form action="system/tambah_petugas.php" method="POST">

                                <div class="row mb-4">
                                    <div class="col-sm-6">
                                        <div class="form-input-group">
                                            <label for="inp_nama2" class="form-label">Nama :</label>
                                            <input class="form-control" type="text" name="nama" id="inp_nama2">
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-input-group">
                                            <label for="inp_username2" class="form-label">Username :</label>
                                            <input class="form-control" type="text" name="username" id="inp_username2">
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-sm-12">
                                        <div class="form-input-group">
                                            <label for="inp_password2" class="form-label">Password :</label>
                                            <input class="form-control" type="password" name="password" id="inp_password2">
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-sm-12">
                                        <div class="form-input-group">
                                            <label for="inp_telepon2" class="form-label">Telepon :</label>
                                            <input class="form-control" type="number" name="telepon" id="inp_telepon2">
                                        </div>
                                    </div>
                                </div>

                        </div>
                        <div class="modal-footer">
                            <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary" name="tambah_petugas">Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        <?php
        endif;
        if ((isset($_GET['jenis']) && $_GET['jenis'] == "admin") || empty($_GET['jenis'])) :
        ?>
            <!-- TABEL ADMIN -->
            <div class="row border-top border-3 border-primary my-4">
                <div class="col-sm-10">
                    <h4 id="h4-admin" class="text-uppercase fw-bold text-secondary mt-3">Tabel Admin</h4>
                </div>

                <div class="col-sm-2 device-desktop">
                    <span data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Tambah Admin">
                        <button style="width: 160px;" data-bs-toggle="modal" data-bs-target="#modal-admin" class="mt-2 mb-1 btn btn-warning"><i class="me-3 fa-solid fa-plus"></i></i>Tambah</button>
                    </span>
                </div>

                <div class="col-sm-12 device-mobile">
                    <span data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Tambah Admin">
                        <button style="width: 100%;" data-bs-toggle="modal" data-bs-target="#modal-admin" class="mt-2 mb-1 btn btn-warning"><i class="me-3 fa-solid fa-plus"></i>Tambah</button>
                    </span>
                </div>

                <hr>
                <div class="col-sm-12">
                    <table id="tableAdmin" class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th scope="col">No.</th>
                                <th scope="col">Nama</th>
                                <th scope="col">No. Telepon</th>
                                <th scope="col">Level</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($excAdmin as $t) :
                            ?>

                                <!-- ISI TABLE -->
                                <tr class="align-middle">
                                    <td scope="row"><?= $no ?></td>
                                    <td><?= $t['nama_petugas'] ?></td>
                                    <td><?= $t['telp'] ?></td>
                                    <td><?= $t['level'] ?></td>
                                </tr>

                            <?php
                                $no++;
                            endforeach;
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
    </div>

    <!-- MODAL TAMBAH Admin -->
    <div class="modal fade" id="modal-admin" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Admin</h1>
                    <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                </div>
                <div class="modal-body">
                    <form action="system/tambah_petugas.php" method="POST">

                        <div class="row mb-4">
                            <div class="col-sm-6">
                                <div class="form-input-group">
                                    <label for="inp_nama3" class="form-label">Nama :</label>
                                    <input class="form-control" type="text" name="nama" id="inp_nama3">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-input-group">
                                    <label for="inp_username3" class="form-label">Username :</label>
                                    <input class="form-control" type="text" name="username" id="inp_username3">
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-sm-12">
                                <div class="form-input-group">
                                    <label for="inp_password3" class="form-label">Password :</label>
                                    <input class="form-control" type="password" name="password" id="inp_password3">
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-sm-12">
                                <div class="form-input-group">
                                    <label for="inp_telepon3" class="form-label">Telepon :</label>
                                    <input class="form-control" type="number" name="telepon" id="inp_telepon3">
                                </div>
                            </div>
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" name="tambah_admin">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php
        endif;
?>





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

        $('#tablePetugas').DataTable({
            responsive: true
        });

        $('#tableAdmin').DataTable({
            responsive: true
        });
    });
</script>


<?php
    include "layout/footer.php";
}
?>