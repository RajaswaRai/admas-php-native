<?php
session_start();

if (empty($_SESSION['nik'])) {
    include "layout/header.php";
?>

    <style>
        body {
            background-color: whitesmoke;
        }

        .kotak-login {
            display: flex;
            position: absolute;
            margin: auto;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            width: 30rem;
            height: fit-content;
        }

        /* FOR MOBILE */
        @media only screen and (max-width: 768px) {
            .kotak-login {
                width: 20rem;
            }
        }
    </style>


    <div class="container">
        <div class="row">
            <div class="col-sm-12 ">
                <div class="card shadow kotak-login">
                    <div class="card-body">
                        <h5 class="mt-2 card-title text-center fw-semibold">FORM LOGIN ADMAS</h5>
                        <hr>
                        <form action="system/cek_login.php" method="POST">
                            <div class="row my-3">
                                <div class="form-group">
                                    <label for="">Username</label>
                                    <input type="text" class="form-control" name="username" placeholder="Masukkan username anda" required>
                                </div>
                            </div>

                            <div class="row my-3">
                                <div class="form-group">
                                    <label for="">Password</label>
                                    <input type="password" class="form-control" name="password" placeholder="Masukkan username anda" required>
                                </div>
                            </div>

                            <div class="row mt-4 mb-1">
                                <div class="col-sm-12">
                                    <a style="width: 100%;" class="justify-content-center btn btn-sm btn-secondary d-flex" role="button" data-bs-toggle="modal" data-bs-target="#modal-register">
                                        <span><small>Daftar Baru</small></span>
                                    </a>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-sm-6">
                                    <button style="width: 100%;" class="float-start btn btn-primary mb-1" type="submit">Masuk</button>
                                </div>

                                <div class="col-sm-6">
                                    <button style="width: 100%;" class="float-end btn btn-danger" type="reset">Reset</button>
                                </div>
                            </div>

                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- MODAL REGISTER -->
    <div class="modal fade" id="modal-register" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
    include "layout/footer.php";
} else {
    header("location:index.php");
}
?>