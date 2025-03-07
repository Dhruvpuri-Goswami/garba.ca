<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION["username"])) {
    header("Location: ../vender/admin_login.php");
    exit();
}

// Get the username from the session
$username = $_SESSION["username"];

// Connect to the database and fetch request details
require 'connection.php';

$sql = "SELECT * FROM tbl_event WHERE give_away='1' LIMIT 1";
$result = mysqli_query($conn, $sql);

$event = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Using a prepared statement to avoid SQL injection
    $stmt = $conn->prepare("SELECT * FROM tbl_giveaway ORDER BY RAND() LIMIT 5");
    $stmt->execute();
    $result_winners = $stmt->get_result();

    $winners = [];
    while ($row_winner = mysqli_fetch_assoc($result_winners)) {
        $winners[] = $row_winner;
        $winner_id = $row_winner['id'];

        // Update is_winner for selected winners
        $updateStmt = $conn->prepare("UPDATE tbl_giveaway SET is_winner = 1 WHERE id = ?");
        $updateStmt->bind_param("i", $winner_id);
        $updateStmt->execute();
        $updateStmt->close();
    }
    $stmt->close();
    header('Content-Type: application/json');
    echo json_encode(['success' => true, 'winners' => $winners]);
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Garba.ca</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">


    <!-- Custom fonts for this template-->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="admin_dashboard.php">
                <div class="sidebar-brand-text mx-3">Garba</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="./admin_dashboard.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>


            <!-- Divider -->
            <hr class="sidebar-divider">



            <!-- Heading -->
            <div class="sidebar-heading">
                Events
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
                    aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>APPROVE EVENTS</span>
                </a>
                <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">APROVE EVENTS</h6>
                        <a class="collapse-item" href="./approve_requests.php">APPROVE EVENT</a>
                        <a class="collapse-item" href="./accepted_requests.php">ACCEPTED EVENTS</a>
                    </div>
                </div>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">


            <!-- Heading -->
            <div class="sidebar-heading">
                STATUS
            </div>


            <!-- Nav Item - Utilities Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                    aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>CHECK HISTORY</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">CHECK HISTORY</h6>
                        <a class="collapse-item" href="./all_requests.php">EVENT HISTORY</a>
                    </div>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="featured_events.php">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>FEATURE EVENTS</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="give_away.php">
                    <i class="fas fa-fw fa-donate"></i>
                    <span>GIVE AWAY</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="give_away_result.php">
                    <i class="fas fa-fw fa-donate"></i>
                    <span>GIVE AWAY RESULT</span>
                </a>
            </li>

            <!-- Nav Item - Charts -->

            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->
                    <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">admin</span>
                                <img class="img-profile rounded-circle" src="../img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="../logout.php" data-toggle="modal"
                                    data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>

                <div class="container-fluid">
                    <h2 class="mb-4 text-primary"><b>Giveaway Result</b></h2>
                    <hr>
                    <div class="row">
                        <!-- Event Display -->
                        <div class="col-md-4">
                            <?php if ($event): ?>
                                <div class="card shadow-lg mb-4">
                                    <img src="<?php echo $event['event_poster']; ?>" class="card-img-top" alt="Event Poster"
                                        style="height: 400px; object-fit: cover;">
                                    <div class="card-body">
                                        <h5 class="card-title text-primary">
                                            <?php echo $event['event_name']; ?>
                                        </h5>
                                        <p class="card-text"><i class="fas fa-map-marker-alt text-muted"></i> Venue:
                                            <?php echo $event['event_venue']; ?>
                                        </p>
                                        <p class="card-text"><i class="fas fa-user text-muted"></i> Host:
                                            <?php echo $event['event_host']; ?>
                                        </p>
                                    </div>
                                    <div class="card-footer">
                                        <button id="selectWinners" class="btn btn-primary btn-block">Select Winners</button>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="alert alert-warning" role="alert">
                                    There is no current giveaway.
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="col-md-8">
                            <div id="winnersContainer" class="mt-4"></div>
                            <button id="endGiveaway" class="btn btn-danger mt-4">End Giveaway</button>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>

        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <a class="btn btn-primary" href="../login.php">Logout</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bootstrap core JavaScript-->
        <script src="../vendor/jquery/jquery.min.js"></script>
        <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

        <!-- Core plugin JavaScript-->
        <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

        <!-- Custom scripts for all pages-->
        <script src="../js/sb-admin-2.min.js"></script>

        <!-- Page level plugins -->
        <script src="../vendor/chart.js/Chart.min.js"></script>

        <!-- Page level custom scripts -->
        <script src="../js/demo/chart-area-demo.js"></script>
        <script src="../js/demo/chart-pie-demo.js"></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            $('#selectWinners').on('click', function () {
                $.post('', {}, function (response) {
                    if (response.success) {
                        // Display winners in a table
                        let winnersTable = '<table class="table table-bordered">';
                        winnersTable +=
                            '<thead><tr><th>Name</th><th>Email</th><th>Contact No</th></tr></thead><tbody>';
                        response.winners.forEach(winner => {
                            winnersTable +=
                                `<tr><td>${winner.name}</td><td>${winner.email}</td><td>${winner.contact_no}</td></tr>`;
                        });
                        winnersTable += '</tbody></table>';
                        $('#winnersContainer').html(winnersTable);
                    } else {
                        alert('Error selecting winners.');
                    }
                }, 'json');
            });
            $('#endGiveaway').on('click', function () {
                Swal.fire({
                    title: 'End Giveaway?',
                    text: "Have you noted down the winners? This action will remove the giveaway!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, end it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Make an AJAX request to end the giveaway
                        $.post('end_giveaway.php', {}, function (response) {
                            if (response.success) {
                                Swal.fire(
                                    'Ended!',
                                    'The giveaway has been ended.',
                                    'success'
                                ).then(() => {
                                    location.reload(); // Reload the page
                                });
                            } else {
                                alert('Error ending the giveaway.');
                            }
                        }, 'json');
                    }
                });
            });
        </script>
</body>

</html>