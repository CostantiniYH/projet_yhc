<?php
// Sélectionner tous les articles
function select($pdo) {
    try {
        $sql = "SELECT p.*, c.nom AS nom_categorie FROM t_produits p
        INNER JOIN t_categories c ON p.id_categorie = c.id";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        
    } catch (Exception $e) {
        echo "Erreur: " .$e->getMessage();
        return [];
    }
}

function updateArticle($pdo, $id, $nom,  $prix, $devise, $quantite, $description, $id_categorie, $destination) {
    try {
        $req = $pdo->prepare("UPDATE t_produits 
        SET id = :id, nom = :nom, prix = :prix, devise = :devise, quantite = :quantite, description = :description,
        id_categorie = :id_categorie, image = :image WHERE id = :id");
        $req->bindParam(':id', $id);
        $req->bindParam(':nom', $nom);
        $req->bindParam(':prix', $prix);
        $req->bindParam(':devise', $devise);
        $req->bindParam(':quantite', $quantite);
        $req->bindParam(':description', $description);
        $req->bindParam(':id_categorie', $id_categorie);
        $req->bindParam(':image', $destination);

        $req->execute();
            return $req->rowCount();
    }   catch (Exception $e) {
        echo "Erreur : " .$e->getMessage();
    }
}

function insertUser($pdo, $nom, $prenom, $email, $password, $telephone, $societe, $photo) {
    try {
        $sql = "INSERT INTO t_users (nom, prenom, email, password, telephone, societe, photo) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nom, $prenom, $email, $password, $telephone, $societe, $photo]);
        return true;
    } catch (PDOException $e) {
        echo "Erreur : " .$e->getMessage();
    }
}
function getUser($pdo) {
    try {
        $query = "SELECT * FROM t_users";
        $stmt = $pdo->prepare($query);
        $stmt->execute([]);
        return $stmt->fetchALl( PDO::FETCH_ASSOC );

    } catch (PDOException $e) {
        echo "Erreur : " .$e->getMessage();
    }
}

function updateUser($pdo, $email, $password) {
    try {
        $req = $pdo->prepare("UPDATE t_users SET email = :email, password = :password WHERE id = :id");
        $req->execute([$email, $password]);
    } catch (PDOException $e) {
        echo "Erreur : " .$e->getMessage();
    }
}

function deleteUser($pdo, $id) {
    try {
        $req = $pdo->prepare("DELETE FROM t_users WHERE id = :id");
        $req->execute([$id]);
    } catch (PDOException $e) {
        echo "Erreur : " .$e->getMessage();
    }
}
?>


<?php 
    $link_c = '../categories.php';
    $link_p = '../produits.php';
    $link_i = '../image.php';

    $links = [
        'catégories' => $link_c,
        'produits'   => $link_p,
        'galerie'     => $link_i,
    ];

    $categories = findAll($pdo = connect(), 't_categories');
    $produits = findAll2($pdo, 't_produits');
    $images = findAll2($pdo, 't_images');

    $tables = [
        'catégories' => $categories,
        'produits'   => $produits,
        'galerie'     => $images,
    ];
    ?>

    <div class="container">       
        <?php foreach ($tables as $section => $items): ?>
            <h2 class="my-4 text-capitalize" data-aos="fade-up" data-aos-duration="1500"><?= $section ?></h2>
            <div class="row row-cols-1 row-cols-md-3 g-4" data-aos="fade-up" data-aos-duration="2000" >
                <?php foreach ($items as $item): ?>
                    <div class="col" data-aos="flip-up" data-aos-duration="2000" data-aos-delay="2000">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body">
                                <img src="<?= $item['image'] ?>" alt="<?= $item['nom'] ?>" class="img-fluid">
                                <h5 class="card-title">
                                    <?= htmlspecialchars($item['nom'] ?? $item['titre'] ?? 'Sans titre') ?>
                                </h5>
                                <p class="card-text">
                                    ID : <?= $item['id'] ?>
                                </p>
                            </div>
                            <div class="card-footer text-end">
                                <a href="<?= $links[$section] ?>" class="btn btn-sm btn-outline-primary">
                                    Voir <?= $section ?>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>          
    </div>
