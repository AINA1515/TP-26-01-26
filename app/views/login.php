<?php
if (isset($error)) {
?>
    <script>
        alert("Une erreur s'est produite lors de la connexion : <?php echo $error; ?>");
    </script>
<?php
}
?>

<!DOCTYPE html>
<html lang="fr" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-dark text-white d-flex justify-content-center align-items-center vh-100 position-relative">

    <div class="card bg-dark text-white shadow p-4" style="width: 100%; max-width: 400px;">
        <h3 class="text-center mb-4">Connexion</h3>

        <form method="post" action="/login">
            <div class="mb-3">
                <label for="pseudo" class="form-label">Pseudo</label>
                <input
                    type="text"
                    class="form-control bg-dark text-white"
                    id="pseudo"
                    name="pseudo"
                    placeholder="Entrez votre pseudo"
                    required>
            </div>

            <button type="submit" class="btn btn-primary w-100">
                Se connecter
            </button>
        </form>
    </div>

</body>
</html>
