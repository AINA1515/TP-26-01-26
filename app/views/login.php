<!DOCTYPE html>
<html lang="fr" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/css/icon/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="d-flex justify-content-center align-items-center vh-100"
      style="background: linear-gradient(135deg, #0b1a3d, #000000);">

    <div class="row g-4 justify-content-center w-100">
        <div class="col-lg-4">
            <div class="card bg-dark bg-opacity-75 shadow-lg">

                <!-- Header -->
                <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-person-circle me-2 text-primary"></i>Login
                    </h5>
                    <?php if(isset($_SESSION['user_id'])): ?>
                        <a href="/logout" class="btn btn-outline-light btn-sm">Déconnexion</a>
                    <?php endif; ?>
                </div>

                <!-- Body -->
                <div class="card-body text-white">
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger">
                            <?= htmlspecialchars($error) ?>
                        </div>
                    <?php endif; ?>

                    <form method="post" action="/login">
                        <div class="mb-4">
                            <label class="form-label fw-bold">Pseudo</label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-text bg-secondary text-white">
                                    <i class="bi bi-person"></i>
                                </span>
                                <input
                                    type="text"
                                    class="form-control bg-transparent text-white border-white"
                                    name="pseudo"
                                    placeholder="Entrez votre pseudo"
                                    required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg w-100">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Se connecter
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>

</body>
</html>
