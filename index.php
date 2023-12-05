<!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <title>Artyfind</title>
    </head>
    <body>
        <header>
            <nav class="navbar navbar-expand-lg bg-body-tertiary">
                <div class="container-fluid">
                    <a class="navbar-brand" href="/index.php">
                        <img src="imgs/logo.png" alt="Logo" width="48" height="48">
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="/index.php">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/map.php">Mappa</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/profile.php">Profilo</a>
                            </li>
                        </ul>
                        <form class="d-flex" role="search">
                            <input class="form-control me-2" type="search" placeholder="Cerca" arial-label="Search">
                            <button class="btn btn-outline-success" type="submit">Cerca</button>
                        </form>
                    </div>
                </div>
            </nav>

            <div class="container mt-4">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newPostModal">
                    Nuovo post
                </button>
            </div>
        </header>

        <main>

        </main>

        <aside>
            <div class="modal fade" id="newPostModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="newPostModal" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Nuovo post</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form>
                            <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="postName" class="col-form-label">Titolo:</label>
                                        <input type="text" class="form-control" id="postName" name="postName">
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