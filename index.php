<?php
require 'config.php';

// Connect to database
try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $password);
} catch (PDOException $e) {
    echo $e->getMessage();
}

if (isset($_GET['action']) && $_GET['action'] === 'newpost') {
    // Create a new post
    if (isset($_POST['postTitle']) &&
        isset($_POST['postAddress']) &&
        isset($_POST['postDescription']) &&
        isset($_FILES['postImage'])) {
        // Post information
        $postTitle = trim($_POST['postTitle']);
        $postAddress = trim($_POST['postAddress']);
        $postDescription = trim($_POST['postDescription']);
        if (strlen($postTitle) > $min_title_length && strlen($postTitle) < $max_title_length &&
            strlen($postAddress) > $min_address_length && strlen($postAddress) < $max_address_length &&
            strlen($postDescription) > $min_description_length && strlen($postDescription) < $max_description_length) {
                // Post image
                $imageUuid = uniqid();
                $target_path = 'content/' . $imageUuid . '.' . strtolower(pathinfo($_FILES['postImage']['name'], PATHINFO_EXTENSION));
                $image = getimagesize($_FILES['postImage']['tmp_name']);
                if ($image !== false) {
                    // Only uploads images < 20 MB
                    if ($_FILES['postImage']['size'] < (20 * 1_000_000)) {
                        if (!file_exists($target_path)) {
                            move_uploaded_file($_FILES['postImage']['tmp_name'], $target_path);
                            // Add entry to database
                            $stmt = $pdo->prepare('INSERT INTO posts (uuid, title, address, description, image)
                            VALUES (:uuid, :title, :address, :description, :image)');
                            $stmt->bindParam(':uuid', $imageUuid);
                            $stmt->bindParam(':title', $postTitle);
                            $stmt->bindParam(':address', $postAddress);
                            $stmt->bindParam(':description', $postDescription);
                            $stmt->bindParam(':image', $target_path);
                            $stmt->execute();
                        }
                    }
                }
        }
    }
}

// Retrieve posts
$stmt = $pdo->query('SELECT title, address, description, image FROM posts');

$pdo = null;
?>
<!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
        <title>Artyfind</title>
    </head>
    <body>
        <header>
            <nav class="navbar navbar-expand-lg bg-body-tertiary">
                <div class="container-fluid">
                    <a class="navbar-brand" href="index.php">
                        <img src="imgs/logo.png" alt="Logo" width="48" height="48">
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="/index.php"><i class="bi bi-house-fill"></i> Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/map.php"><i class="bi bi-geo-alt-fill"></i> Mappa</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/profile.php"><i class="bi bi-person-fill"></i> Profilo</a>
                            </li>
                        </ul>
                        <form class="d-flex" role="search">
                            <input class="form-control me-2" type="search" placeholder="Cerca" arial-label="Search">
                            <button class="btn btn-outline-success" type="submit"><i class="bi bi-search"></i></button>
                        </form>
                    </div>
                </div>
            </nav>

            <div class="container mt-4">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newPostModal">
                    <i class="bi bi-plus"></i> Nuovo post
                </button>
            </div>
        </header>

        <main class="container">
            <?php while ($row = $stmt->fetch()): ?>
                <div>
                    <p>Title: <?= $row['title'] ?></p>
                    <p>Address: <?= $row['address'] ?></p>
                    <p>Description: <?= $row['description'] ?></p>
                    <p>Image: <?= $row['image'] ?></p>
                </div>
            <?php endwhile; ?>
        </main>

        <aside>
            <div class="modal fade" id="newPostModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="newPostModal" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Nuovo post</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="index.php?action=newpost" method="post" enctype="multipart/form-data">
                            <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="postTitle" class="col-form-label">Titolo:</label>
                                        <input type="text" class="form-control" id="postTitle" name="postTitle">
                                    </div>
                                    <div class="mb-3">
                                        <label for="postAddress" class="col-form-label">Indirizzo:</label>
                                        <input type="text" class="form-control" id="postAddress" name="postAddress">
                                    </div>
                                    <div class="mb-3">
                                        <label for="postDescription" class="col-form-label">Descrizione:</label>
                                        <textarea class="form-control" id="postDescription" name="postDescription"></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="postDescription" class="col-form-label">Foto:</label>
                                        <input type="file" class="form-control" id="postImage" name="postImage">
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                                <button type="submit" class="btn btn-primary">Pubblica</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </aside>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    </body>
</html>