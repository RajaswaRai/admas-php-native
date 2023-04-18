<?php
session_start();

if (!empty($_SESSION['nik'])) {

    $nav_active = "pengaduan_baru";
    $sub_active = "";

    include "layout/header.php";
    include "layout/nav.php";

    if ($_SESSION['level'] == 'masyarakat') {
?>

        <div class="container">
            <h3 class="mt-4 text-center fw-bold text-secondary">FORM PENAMBAHAN ADUAN MASYARAKAT</h3>
            <hr>

            <form action="system/upload_aduan_mas.php" enctype="multipart/form-data" method="POST">

                <!-- Isi -->
                <div class="row mb-3">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="isi_keluhan" class="form-label">Apa Keluhan Anda</label>
                            <textarea name="isi_laporan" class="form-control" id="isi_keluhan" cols="3"></textarea>
                        </div>
                    </div>
                </div>

                <!-- Foto -->
                <div class="row mb-3">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="foto" class="form-label">Unggah Foto Laporan</label>
                            <input type="file" name="foto" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-12">
                        <button class="btn btn-success" type="submit">Simpan</button>
                    </div>
                </div>

            </form>
        </div>

<?php
        include "layout/copyright.php";
        include "layout/footer.php";
    } else {
        header("location:index.php");
    }
}
?>