<?php
session_start(); // Start session

// Redirect if the session is not set and show alert
if (empty($_SESSION['name_user'])) {
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>';
    echo '<script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                title: "Alert",
                text: "Akses Halaman Ini Diabatasi, Silahkan Login Terlebih Dahulu",
                icon: "info",
                confirmButtonColor: "#3085d6",
                confirmButtonText: "Ok"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "../../login.php";
                }
            });
        });
    </script>';
    exit();
}

if ($_SESSION['hook']) {
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>';
    echo '<script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                title: "Success",
                text: "Anda Berhasil Login",
                icon: "success",
                confirmButtonColor: "#3085d6",
                confirmButtonText: "Ok"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "./";
                }
                
            });
        });
    </script>';
    unset($_SESSION['hook']);
    exit();
}

if ($_SESSION['logout'] == 1) {
    // Load SweetAlert script
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>';

    // Display SweetAlert message
    echo '<script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                title: "Success",
                text: "Anda Sudah Logout",
                icon: "success",
                confirmButtonColor: "#3085d6",
                confirmButtonText: "Ok"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "./";
                }
            });
        });
    </script>';

    // Unset the logout session and stop further execution
    unset($_SESSION['logout']);
    exit();
}

if ($_SESSION['role_id'] != 1) {
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>';
    echo '<script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                title: "Warning",
                text: "Anda tidak memiliki hak akses",
                icon: "warning", // Perbaiki "watning" menjadi "warning"
                confirmButtonColor: "#3085d6",
                confirmButtonText: "Ok"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "../../login.php";
                }
            });
        });
    </script>';
    unset($_SESSION['role_id']);
    exit();
}

if (!($_SESSION['role_id'] == 1) || empty($_SESSION['role_id'])) {
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>';
    echo '<script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                title: "Warning!",
                text: "Anda tidak memiliki hak akses untuk ini",
                icon: "info",
                confirmButtonColor: "#3085d6",
                confirmButtonText: "Ok"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "../../login.php;
                                        
                }
            });
        });
    </script>';

    exit();
}


// if ($_SESSION['errorImage']) {
//     echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>';
//     echo '<script>
//         document.addEventListener("DOMContentLoaded", function() {
//             Swal.fire({
//                 title: "Warning",
//                 text: "image Terlalu Besar",
//                 icon: "warning", // Perbaiki "watning" menjadi "warning"
//                 confirmButtonColor: "#3085d6",
//                 confirmButtonText: "Ok"
//             }).then((result) => {
//                 if (result.isConfirmed) {
//                     window.location.href = "../../login.php";
//                 }
//             });
//         });
//     </script>';
//     unset($_SESSION['errorImage']);
//     exit();
// }

?>


<?php if (!empty($_SESSION['error'])) { ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                title: "Perhatian !!",
                text: "<?php echo $_SESSION['error']; ?>",
                icon: "error"
            });
        });
    </script>
    <?php unset($_SESSION['error']); ?>
<?php } ?>




<head>
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Dashboard - SMOM</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../../assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="../../assets/vendor/fonts/boxicons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="../../assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="../../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="../../assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <link rel="stylesheet" href="../../assets/vendor/libs/apex-charts/apex-charts.css" />

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="../../assets/vendor/js/helpers.js"></script>
    <!-- build:js assets/vendor/js/core.js -->
    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS -->
    <!-- <script src="../../assets/js/main.js"></script> -->

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="../../assets/js/config.js"></script>
    <!-- Tambahkan CSS DataTables -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <!-- Tambahkan JavaScript DataTables -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.4/css/dataTables.dataTables.css" />

    <script src="https://cdn.datatables.net/2.1.4/js/dataTables.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

</head>