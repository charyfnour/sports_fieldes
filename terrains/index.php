<?php 
include "config/config.php"
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réserver un terrain de sport</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="contaier">

<section class="hero">
    <div class="container">
        <h1>Réserver un terrain<br>de sport</h1>
        <button class="cta-button">Réserver maintenant</button>
     
    </div>
</section>

<section class="categories">
    <div class="container">
   
        <div class="categories-content">
            <h2>Catégories de terrains</h2>
            <div class="category-filters">
                <button class="filter-btn active">Tous</button>
                <button class="filter-btn">Football</button>
                <button class="filter-btn">Tennis</button>
                <button class="filter-btn">Basket</button>
            </div>
        </div>
    </div>
</section>

<section class="facilities">
    <div class="container">
        <div class="facilities-grid">

        <section class="facilities">
    <div class="container">
        <div class="facilities-grid">
            <?php $sql = "SELECT terrain_id, terrain_name, location, description, image FROM terrains";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $terrains = $stmt->fetchAll(PDO::FETCH_ASSOC); ?>
            <?php if (count($terrains) > 0):?>
                <?php foreach ($terrains as $terrain): 
                    
                    ?>
                    <div class="facility-card">
                        <img src="../<?php echo htmlspecialchars($terrain['image']); ?>" alt="<?php echo htmlspecialchars($terrain['terrain_name']); ?>" class="facility-image">
                        <div class="facility-content">
                            <div class="facility-header">
                                <h3 class="facility-name"><?php echo htmlspecialchars($terrain['terrain_name']); ?></h3>
                                <span class="facility-capacity"><?php echo htmlspecialchars($terrain['location']); ?></span>
                            </div>
                            <p><?php echo nl2br(htmlspecialchars($terrain['description'])); ?></p>
                            <!-- Tu peux ajouter une balise sport-tag si tu as cette info dans la BDD -->
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Aucun terrain disponible.</p>
            <?php endif; ?>
        </div>
    </div>
</section>
</div>

<footer class="footer">
  <div class="container">
    <div class="footer-content">

      <div class="footer-column">
        <div class="logo">⚽</div>
        <p>Réservez facilement votre terrain de sport préféré, quand vous voulez.</p>
      </div>

      <div class="footer-column">
        <h4>Liens utiles</h4>
        <ul>
          <li><a href="#">Accueil</a></li>
          <li><a href="#">Profil</a></li>
          <li><a href="#">Réservations</a></li>
          <li><a href="#">Paramètres</a></li>
        </ul>
      </div>

      <div class="footer-column">
        <h4>Service client</h4>
        <ul>
          <li><a href="#">FAQ</a></li>
          <li><a href="#">Conditions d'utilisation</a></li>
          <li><a href="#">Mentions légales</a></li>
          <li><a href="#">Nous contacter</a></li>
        </ul>
      </div>

      <div class="footer-column">
        <h4>Suivez-nous</h4>
        <ul>
          <li><a href="#">Facebook</a></li>
          <li><a href="#">Instagram</a></li>
          <li><a href="#">Twitter</a></li>
          <li><a href="#">LinkedIn</a></li>
        </ul>
      </div>

    </div>

    <div class="footer-bottom" style="text-align: center; margin-top: 2rem; color: #a6a6a6;">
      <p>© 2025 SportsField, Inc. Tous droits réservés.</p>
    </div>
  </div>
</footer>

</body>
</html>
