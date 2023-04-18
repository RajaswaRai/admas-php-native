<?php
session_start();

if (!empty($_SESSION['nik']) && !empty($_GET['id_pengaduan'])) :

    $nav_active = "";
    $sub_active = "";

    include "koneksi.php";
    include "layout/header.php";
    include "layout/nav.php";

    // SQL DATA PENGADUAN
    $sql_detail = "SELECT * FROM pengaduan pa INNER JOIN masyarakat ms ON pa.nik = ms.nik WHERE id_pengaduan=$_GET[id_pengaduan]";
    $exc_detail = mysqli_query($koneksi, $sql_detail);
    $detail     = mysqli_fetch_array($exc_detail);

    // STATUS BAR CONDITION
    function progress_bar($detail)
    {
        if ($detail['status'] == "0") {
            $persen         = "100%";
            $pesan_progress = "Laporan Sedang dalam peninjauan";
            $warna_progress = "bg-secondary text-white";
            return [$persen, $warna_progress, $pesan_progress];
        } elseif ($detail['status'] == "proses") {
            $persen         = "50%";
            $pesan_progress = "Pekerjaan sedang berlangsung";
            $warna_progress = "bg-primary text-white";
            return [$persen, $warna_progress, $pesan_progress];
        } elseif ($detail['status'] == "selesai") {
            $persen         = "100%";
            $pesan_progress = "Pekerjaan sudah selesai";
            $warna_progress = "bg-success text-white";
            return [$persen, $warna_progress, $pesan_progress];
        } else {
            return;
        }
    }

    $progress = progress_bar($detail);
?>

    <div class="container">

        <!-- CARD PENGADUAN -->
        <div class="row justify-content-center">
            <div class="card p-0 mt-4" style="width: 50rem;">

                <div class="card-header text-white bg-primary fw-semibold text-center">
                    <!-- Button Edit Laporan Mobile -->
                    <div class="row">

                        <!-- Mobile Display -->
                        <?php
                        if ($_SESSION['level'] !== 'masyarakat') :
                        ?>
                            <div class="col-sm-1 device-mobile">
                                <span data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Ubah Status Laporan">
                                    <button style="width: 100%;" data-bs-toggle="modal" data-bs-target="#modal-status" class="m-0 btn btn-warning"><i class="m-0 fa-solid fa-ellipsis-vertical"></i> EDIT</button>
                                </span>
                            </div>
                        <?php
                        endif;
                        ?>

                        <div class="col-sm-11">
                            <p class="mt-2 mb-0">Pengaduan dari <?= $detail['nama'] ?> pada Tanggal <?= $detail['tgl_pengaduan'] ?></p>
                        </div>

                        <!-- TABLET -> DESKTOP DISPLAY -->
                        <?php
                        if ($_SESSION['level'] !== 'masyarakat') :
                        ?>
                            <div class="col-sm-1 device-desktop">
                                <span data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Ubah Status Laporan">
                                    <button data-bs-toggle="modal" data-bs-target="#modal-status" class="m-0 btn btn-warning"><i class="m-0 fa-solid fa-ellipsis-vertical"></i></button>
                                </span>
                            </div>
                        <?php
                        endif;
                        ?>

                    </div>
                </div>

                <img src="img_pengaduan/<?= $detail['foto'] ?>" class="card-img-top" alt="Foto Pengaduan" style="height: 20rem; object-fit: cover;">

                <div class="card-body">
                    <figure class="text-center">
                        <blockquote class="card-text blockquote">
                            <h5 class="card-title"><?= $detail['isi_laporan'] ?></h5>
                        </blockquote>
                        <figcaption class="blockquote-footer mt-1">
                            <?= $detail['nama'] ?> - <cite title="Source Title"><?= $detail['nik'] ?></cite>
                        </figcaption>
                    </figure>

                    <div class="row">
                        <div class="col-sm-12">
                            <p class="text-center mb-1">Status Pengerjaan</p>
                            <!-- Progress Bar -->
                            <div class="progress">
                                <div class="progress-bar <?= $progress[1] ?> progress-bar-striped progress-bar-animated" role="progressbar" aria-label="Default striped example" style="width: <?= $progress[0] ?>" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"><?= $progress[2] ?></div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- MODAL EDIT PENGADUAN PETUGAS -->
        <div class="modal fade" id="modal-status" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Form Perubahan Status Laporan</h1>
                        <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                    </div>
                    <div class="modal-body">
                        <form action="system/ubah_status.php" method="POST">
                            <div class="row">

                                <?php
                                // Function Selected Value
                                function select_progress($detail)
                                {
                                    if ($detail['status'] == '0') {
                                        $selected   = ['selected', '', ''];
                                        // $background = ["class='bg-primary text-white'", '', ''];

                                        return [$selected];
                                    } elseif ($detail['status'] == 'proses') {
                                        $selected   = ['', 'selected', ''];
                                        // $background = ['', "class='bg-primary text-white'", ''];

                                        return [$selected];
                                    } elseif ($detail['status'] == 'selesai') {
                                        $selected = ['', '', 'selected'];
                                        // $background = ['', '', "class='bg-primary text-white'"];

                                        return [$selected];
                                    } else {
                                        return;
                                    }
                                }
                                $selected = select_progress($detail);
                                ?>

                                <div class="col-sm-12">
                                    <div class="form-input-group">
                                        <label class="form-label" for="select-status">Progress Pengerjaan Laporan :</label>
                                        <select class="form-select" name="status" id="select-status">
                                            <option value="0" <?= $selected[0][0] ?>>Laporan Sedang dalam peninjauan</option>
                                            <option value="proses" <?= $selected[0][1] ?>>Pekerjaan sedang berlangsung</option>
                                            <option value="selesai" <?= $selected[0][2] ?>>Pekerjaan sudah selesai</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Input Id Pengaduan -->
                            <input type="text" name="id_pengaduan" value="<?= $_GET['id_pengaduan'] ?>" hidden>

                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <!-- CARD TANGGAPAN -->
        <div class="row mt-5 justify-content-center">
            <div class="card p-0" style="width: 50rem;">
                <div class="card-header text-white bg-primary fw-semibold text-center">
                    <div class="row">
                        <!-- Mobile Display -->
                        <?php
                        if ($_SESSION['level'] !== 'masyarakat') :
                        ?>
                            <div class="col-sm-1 device-mobile">
                                <span data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Tambah Tanggapan">
                                    <button style="width: 100%;" data-bs-toggle="modal" data-bs-target="#modal-tanggapan" class="m-0 btn btn-warning"><i class="m-0 fa-solid fa-plus"></i> TAMBAH</button>
                                </span>
                            </div>
                        <?php
                        endif;
                        ?>

                        <div class="col-sm-11">
                            <p class="mt-2 mb-0">Tanggapan</p>
                        </div>

                        <!-- TABLET -> DESKTOP DISPLAY -->
                        <?php
                        if ($_SESSION['level'] !== 'masyarakat') :
                        ?>
                            <div class="col-sm-1 device-desktop">
                                <span data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Tambah Tanggapan">
                                    <button data-bs-toggle="modal" data-bs-target="#modal-tanggapan" class="m-0 btn btn-warning"><i class="m-0 fa-solid fa-plus"></i></button>
                                </span>
                            </div>
                        <?php
                        endif;
                        ?>
                    </div>
                </div>
                <div class=" card-body">

                    <!-- ISI TANGGAPAN -->
                    <?php
                    $sql_tanggapan = "SELECT * FROM tanggapan ta INNER JOIN petugas pe ON ta.id_petugas = pe.id_petugas WHERE id_pengaduan='$_GET[id_pengaduan]' ORDER BY id_tanggapan DESC";
                    $exc_tanggapan = mysqli_query($koneksi, $sql_tanggapan);
                    $jml_tanggapan = mysqli_num_rows($exc_tanggapan);

                    if ($jml_tanggapan !== 0) {
                        foreach ($exc_tanggapan as $t) :
                    ?>
                            <div class="alert alert-info" role="alert">
                                <figure class="m-0 p-0">
                                    <blockquote class="fw-semibold">
                                        <p class="m-0"><?= $t['tanggapan'] ?></p>
                                    </blockquote>
                                    <figcaption class="blockquote-footer m-0">
                                        <?= $t['nama_petugas'] ?> <cite title="Source Title"><?= $t['tgl_tanggapan'] ?></cite>
                                    </figcaption>
                                </figure>
                            </div>
                    <?php
                        endforeach;
                    } else {
                        echo "<p class='text-center'>- Tanggapan Kosong -</p>";
                    }
                    ?>


                </div>
            </div>
        </div>

        <!-- MODAL TANGGAPAN -->
        <div class="modal fade" id="modal-tanggapan" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Form Tambah Tanggapan</h1>
                        <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                    </div>
                    <div class="modal-body">
                        <form action="system/tambah_tanggapan.php" method="POST">
                            <div class="row">
                                <div class="form-input-group">
                                    <label for="tanggapan" class="form-label">Tanggapan Baru</label>
                                    <textarea class="form-control" name="tanggapan" id="tanggapan" rows="3"></textarea>
                                </div>
                            </div>

                            <!-- Input Id Pengaduan -->
                            <input type="text" name="id_pengaduan" value="<?= $_GET['id_pengaduan'] ?>" hidden>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>



    </div>

<?php
    include "layout/copyright.php";
    include "layout/footer.php";

else :
    header("location: index.php");
endif;


?>