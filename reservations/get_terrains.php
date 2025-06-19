<?php
include "../config/config.php";

header('Content-Type: application/json');

if (isset($_GET['category'])) {
    $category = $_GET['category'];
    
    try {
        $stmt = $pdo->prepare("SELECT terrain_id, terrain_name, location, description, image FROM terrains WHERE category = ? ORDER BY terrain_name");
        $stmt->execute([$category]);
        $terrains = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo json_encode($terrains);
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Erreur de base de données']);
    }
} else {
    echo json_encode(['error' => 'Catégorie non spécifiée']);
}
?>