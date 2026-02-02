<?php
if (isset($error)) {
?>
    <script>
        alert("Une erreur s'est produite lors de la deconnexion : <?= $error ?>");
    </script>
<?php }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
    <title>Document</title>
</head>

<body>
    <?php if (isset($_SESSION['user_id'])): ?>
        <a href="/logout" class="btn btn-danger position-absolute top-0 end-0 m-3">
            Déconnexion
        </a>
    <?php endif; ?>

    <h1>Welcome to the FlightPHP Skeleton Example!</h1>
    <?php if (!empty($message)) { ?>
        <h3><?= $message ?></h3>
    <?php } ?>
</body>

</html>