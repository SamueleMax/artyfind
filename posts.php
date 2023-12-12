<?php
require 'config.php';

/* This variable is used to show alerts to the user.
   <Bootstrap Alert Type> => <Alert Text>
   So, for example:
   primary => Error uploading the file.
   The alert types */
$alerts = [];

// Connect to database
try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $password);
} catch (PDOException $e) {
    echo $e->getMessage();
}

if (isset($_GET['uuid'])) {
    $uuid = $_GET['uuid'];
    // Retrieve post
    $stmt = $pdo->prepare('SELECT title, address, description, image FROM posts WHERE uuid = :uuid');
    $stmt->bindParam(':uuid', $uuid);
    $stmt->execute();
    $post = $stmt->fetch();
    if ($post === false) {
        $alerts += ['danger' => 'Il post richiesto non è più disponibile.'];
    } else {
        if (isset($_GET['action']) && $_GET['action'] === 'delete') {
            $stmt = $pdo->prepare('DELETE FROM posts WHERE uuid = :uuid');
            $stmt->bindParam(':uuid', $uuid);
            $stmt->execute();
            unlink($post['image']);
            header('Location: index.php');
        }
    }
} else {
    header('Location: index.php');
}

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
                                <a class="nav-link active" aria-current="page" href="index.php"><i class="bi bi-house-fill"></i> Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="map.php"><i class="bi bi-geo-alt-fill"></i> Mappa</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="profile.php"><i class="bi bi-person-fill"></i> Profilo</a>
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
                <?php foreach ($alerts as $type => $text): ?>
                    <div class="alert alert-<?= $type ?> alert-dismissible" role="alert">
                        <div><?= $text ?></div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endforeach; ?>
                <?php if ($post !== false): ?>
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deletePostModal">
                        <i class="bi bi-trash3-fill"></i> Elimina post
                    </button>
                <?php endif; ?>
            </div>
        </header>

        <main class="container mt-3 d-flex gap-4 flex-column align-items-center">
            <?php if ($post !== false): ?>
                <img class="w-50" src="<?= htmlspecialchars($post['image']) ?>">
                <h3><?= htmlspecialchars($post['title']) ?></h3>
                <p class="text-secondary"><?= htmlspecialchars($post['address']) ?></p>
                <p><?= htmlspecialchars($post['description']) ?></p>
            <?php endif; ?>
        </main>

        <aside>
            <div class="modal fade" id="deletePostModal" tabindex="-1" aria-labelledby="deletePostModal" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Elimina post</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Sei veramente sicuro di voler eliminare questo post?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                            <a href="posts.php?uuid=<?= $uuid ?>&action=delete" class="btn btn-danger">Elimina</a>
                        </div>
                    </div>
                </div>
            </div>
        </aside>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    </body>
</html>