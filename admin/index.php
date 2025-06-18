<?php
session_start();
include "../config/config.php";

// Vérifier si l'utilisateur est connecté et est admin
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/formulaireconnexion.php");
    exit;
}

// Récupérer les statistiques pour le dashboard
$stats = [];

// Nombre total de terrains
$stmt = $pdo->query("SELECT COUNT(*) as total FROM terrains");
$stats['terrains'] = $stmt->fetch()['total'];

// Nombre total d'utilisateurs
$stmt = $pdo->query("SELECT COUNT(*) as total FROM users");
$stats['users'] = $stmt->fetch()['total'];

// Nombre total de réservations
$stmt = $pdo->query("SELECT COUNT(*) as total FROM reservations");
$stats['reservations'] = $stmt->fetch()['total'];

// Réservations récentes
$stmt = $pdo->query("
    SELECT r.*, u.first_name, u.last_name, t.terrain_name 
    FROM reservations r 
    JOIN users u ON r.user_id = u.user_id 
    JOIN terrains t ON r.terrain_id = t.terrain_id 
    ORDER BY r.created_at DESC 
    LIMIT 5
");
$recent_reservations = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Administration - SportsField</title>
    
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- AdminLTE -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>
        
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="../auth/logout.php">
                    <i class="fas fa-sign-out-alt"></i> Déconnexion
                </a>
            </li>
        </ul>
    </nav>

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="index.php" class="brand-link">
            <i class="fas fa-futbol brand-image"></i>
            <span class="brand-text font-weight-light">SportsField Admin</span>
        </a>

        <div class="sidebar">
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                    <li class="nav-item">
                        <a href="index.php" class="nav-link active">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="terrains/index.php" class="nav-link">
                            <i class="nav-icon fas fa-map-marked-alt"></i>
                            <p>Gestion des terrains</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="users/index.php" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Gestion des utilisateurs</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="reservations/index.php" class="nav-link">
                            <i class="nav-icon fas fa-calendar-check"></i>
                            <p>Gestion des réservations</p>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>

    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dashboard</h1>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3><?php echo $stats['terrains']; ?></h3>
                                <p>Terrains</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-map-marked-alt"></i>
                            </div>
                            <a href="terrains/index.php" class="small-box-footer">Plus d'infos <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3><?php echo $stats['users']; ?></h3>
                                <p>Utilisateurs</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <a href="users/index.php" class="small-box-footer">Plus d'infos <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3><?php echo $stats['reservations']; ?></h3>
                                <p>Réservations</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                            <a href="reservations/index.php" class="small-box-footer">Plus d'infos <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Réservations récentes -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Réservations récentes</h3>
                            </div>
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Utilisateur</th>
                                            <th>Terrain</th>
                                            <th>Date</th>
                                            <th>Heure</th>
                                            <th>Statut</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($recent_reservations as $reservation): ?>
                                        <tr>
                                            <td><?php echo $reservation['reservation_id']; ?></td>
                                            <td><?php echo htmlspecialchars($reservation['first_name'] . ' ' . $reservation['last_name']); ?></td>
                                            <td><?php echo htmlspecialchars($reservation['terrain_name']); ?></td>
                                            <td><?php echo date('d/m/Y', strtotime($reservation['reservation_date'])); ?></td>
                                            <td><?php echo date('H:i', strtotime($reservation['start_time'])) . ' - ' . date('H:i', strtotime($reservation['end_time'])); ?></td>
                                            <td>
                                                <span class="badge badge-<?php echo $reservation['status'] === 'confirmed' ? 'success' : 'warning'; ?>">
                                                    <?php echo ucfirst($reservation['status']); ?>
                                                </span>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Footer -->
    <footer class="main-footer">
        <strong>Copyright &copy; 2025 <a href="#">SportsField</a>.</strong>
        Tous droits réservés.
    </footer>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap 4 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>
</html>