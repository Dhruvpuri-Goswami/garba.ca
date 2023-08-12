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

$sql = "SELECT * FROM tbl_event";
$result = mysqli_query($conn, $sql);


$requests = [];
while ($row = mysqli_fetch_assoc($result)) {
    $requests[] = $row;
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
                    <div class="row">
                        <?php foreach ($requests as $request): ?>
                            <div class="col-lg-2 col-md-2 col-sm-6 mb-2">
                                <div class="card h-100 event-card" data-event-id="<?php echo $request['event_id']; ?>"
                                    style="cursor: pointer; max-width: 200px; margin: auto;">
                                    <img src="<?php echo $request['event_poster']; ?>" class="card-img-top"
                                        alt="Event Poster" style="height: 100px; object-fit: cover;">
                                    <span class="badge badge-success position-absolute"
                                        style="bottom: 5px; right: 5px; display: none;">Selected</span>
                                    <div class="card-body p-2">
                                        <h6 class="card-title mb-1 text-primary text-center">
                                            <b>
                                                <?php echo $request['event_name']; ?>
                                            </b>
                                        </h6>
                                        <p class="card-text mb-1">
                                            <small><i class="fas fa-map-marker-alt text-muted"></i>
                                                <?php echo $request['event_venue']; ?>
                                            </small>
                                        </p>
                                        <p class="card-text mb-1">
                                            <small><i class="fas fa-user text-muted"></i>
                                                <?php echo $request['event_host']; ?>
                                            </small>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="mt-4 text-center">
                        <button id="submitEvents" class="btn btn-primary">Submit Selected Events</button>
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
        let selectedEvents = [];

        $('.event-card').on('click', function () {
            if ($(this).hasClass('border-success')) {
                $(this).removeClass('border-success');
                $(this).find('.badge').hide();
                const index = selectedEvents.indexOf($(this).data('event-id'));
                if (index > -1) {
                    selectedEvents.splice(index, 1);
                }
            } else {
                if (selectedEvents.length < 4) {
                    $(this).addClass('border-success');
                    $(this).find('.badge').show();
                    selectedEvents.push($(this).data('event-id'));
                } else {
                    alert("You can select only up to 4 events.");
                }
            }
        });

        $('#submitEvents').on('click', function () {
            $.post('update_featured_events.php', { eventIds: selectedEvents }, function (response) {
                if (response.success) {
                    alert("Events updated successfully!");
                } else {
                    var errorMessage = response.error ? response.error : "Unknown error.";
                    alert("There was an error updating the events. Error: " + errorMessage);
                }
            }, "json");  // <-- added "json" here to ensure that jQuery treats the response as JSON.

        });

    </script>
</body>

</html>