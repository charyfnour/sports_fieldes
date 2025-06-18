<?php
session_start();
include "../../config/config.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../auth/formulaireconnexion.php");
    exit;
}

// Récupérer tous les terrains
$stmt = $pdo->query("SELECT * FROM terrains ORDER BY terrain_id DESC");
$terrains = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestion des terrains - SportsField</title>
    
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
                <a class="nav-link" href="../../auth/logout.php">
                    <i class="fas fa-sign-out-alt"></i> Déconnexion
                </a>
            </li>
        </ul>
    </nav>

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="../index.php" class="brand-link">
            <i class="fas fa-futbol brand-image"></i>
            <span class="brand-text font-weight-light">SportsField Admin</span>
        </a>

        <div class="sidebar">
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                    <li class="nav-item">
                        <a href="../index.php" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="index.php" class="nav-link active">
                            <i class="nav-icon fas fa-map-marked-alt"></i>
                            <p>Gestion des terrains</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="../users/index.php" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Gestion des utilisateurs</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="../reservations/index.php" class="nav-link">
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
                        <h1 class="m-0">Gestion des terrains</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="../index.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Terrains</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Liste des terrains</h3>
                                <div class="card-tools">
                                    <a href="add.php" class="btn btn-primary btn-sm">
                                        <i class="fas fa-plus"></i> Ajouter un terrain
                                    </a>
                                </div>
                            </div>
                            
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Image</th>
                                            <th>Nom</th>
                                            <th>Catégorie</th>
                                            <th>Localisation</th>
                                            <th>Prix/heure</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($terrains as $terrain): ?>
                                        <tr>
                                            <td><?php echo $terrain['terrain_id']; ?></td>
                                            <td>
                                                <img src="../../<?php echo htmlspecialchars($terrain['image']); ?>" 
                                                     alt="<?php echo htmlspecialchars($terrain['terrain_name']); ?>" 
                                                     class="img-thumbnail" style="width: 60px; height: 40px; object-fit: cover;">
                                            </td>
                                            <td><?php echo htmlspecialchars($terrain['terrain_name']); ?></td>
                                            <td>
                                                <span class="badge badge-info"><?php echo htmlspecialchars($terrain['category']); ?></span>
                                            </td>
                                            <td><?php echo htmlspecialchars($terrain['location']); ?></td>
                                            <td><?php echo number_format($terrain['price_per_hour'], 2); ?> €</td>
                                            <td>
                                                <a href="edit.php?id=<?php echo $terrain['terrain_id']; ?>" class="btn btn-info btn-sm">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="delete.php?id=<?php echo $terrain['terrain_id']; ?>" 
                                                   class="btn btn-danger btn-sm" 
                                                   onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce terrain ?')">
                                                    <i class="fas fa-trash"></i>
                                                </a>
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

    <footer class="main-footer">
        <strong>Copyright &copy; 2025 <a href="#">SportsField</a>.</strong>
        Tous droits réservés.
    </footer>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>
</html>