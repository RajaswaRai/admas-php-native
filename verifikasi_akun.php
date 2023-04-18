<?php
include "koneksi.php";

if ($_SESSION['level'] !== 'admin' || empty($_SESSION['level'])) {
    kembali();
} else {
    include "koneksi.php";
    include "layout/header.php";
    include "layout/nav.php";
?>

    <!-- BODY HTML -->



<?php
    include "layout/copyright.php";
    include "layout/footer.php";
}
?>