<?php
session_start();

include "layout/header.php";
include "layout/nav.php";
?>

<div class="container">

    <h4 class="text-uppercase fw-bold text-secondary mt-2">Daftar Pengaduan Yang Dibuat</h4>
    <hr>

    <div class="row justify-content-center">

        <div class="col-sm-4">
            <div class="card bg-warning text-white m-3">
                <!-- <img src="..." class="card-img-top" alt="..."> -->
                <div class="card-body">
                    <h5 class="card-title">JUMLAH PENGADUAN</h5>
                    <div class="display-4 fw-bold">25</div>
                    <a href="#" class="text-decoration-none">
                        <p class="card-text text-white">Selengkapnya >></p>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="card bg-info text-white m-3">
                <!-- <img src="..." class="card-img-top" alt="..."> -->
                <div class="card-body">
                    <h5 class="card-title">PENGADUAN DIPROSES</h5>
                    <div class="display-4 fw-bold">5</div>
                    <a href="#" class="text-decoration-none">
                        <p class="card-text text-white">Selengkapnya >></p>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="card bg-success text-white m-3">
                <!-- <img src="..." class="card-img-top" alt="..."> -->
                <div class="card-body">
                    <h5 class="card-title">PENGADUAN SELESAI</h5>
                    <div class="display-4 fw-bold">20</div>
                    <a href="#" class="text-decoration-none">
                        <p class="card-text text-white">Selengkapnya >></p>
                    </a>
                </div>
            </div>
        </div>

    </div>

    <a href="" class="btn btn-primary mt-5 mb-3">BUAT PENGADUAN BARU</a>

    <table id="myTable" class="table table-striped table-hover">
        <thead>
            <tr>
                <th scope="col">No.</th>
                <th scope="col">Tanggal</th>
                <th scope="col">Isi Pengaduan</th>
                <th scope="col">Status</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th scope="row">1</th>
                <td>2021-02-01</td>
                <td><a href="" class="text-secondary">Kondisi Jalan Disana Macet</a></td>
                <td>Sedang Ditangani</td>
            </tr>
            <tr>
                <th scope="row">2</th>
                <td>2021-02-01</td>
                <td><a href="" class="text-secondary">Kondisi Jalan Disana Macet</a></td>
                <td>Sedang Ditangani</td>
            </tr>
            <tr>
                <th scope="row">3</th>
                <td>2021-02-01</td>
                <td><a href="" class="text-secondary">Kondisi Jalan Disana Macet</a></td>
                <td>Sedang Ditangani</td>
            </tr>
        </tbody>
    </table>
</div>

<div class="bg-primary">
    <div class="container text-white text-center py-5 mt-3">
        <p>&copy; Muhammad Rajaswa Raihanu Bhamakerti</p>
    </div>
</div>



<script src="js/jquery-3.6.1.slim.min.js"></script>
<script src="js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        $('#myTable').DataTable();
    });
</script>
<?php

include "layout/footer.php";
