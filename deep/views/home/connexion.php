<?php
include ('../../bdd/connexion_bdd.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../../assets/css/app.css" />
    <title>Document</title>
</head>

<body>
    <?php
    $_SESSION['is_connected'] = 0;
    if (isset ($_POST['mdp'])) {
        $mdp = "ChienChat";
        if (sanatizeString($_POST['mdp']) == $mdp) {
            $_SESSION['is_connected'] = 1;
            header('Location:./control.php');
        }
    }
    ?>
    <div class="flex-center">
        <div class="flex-center div_box_connexion">
            <form method="post" action="">
                <input type="text" name="mdp" placeholder="mdp" />
                <button class="btn_connexion"> Connexion </buton>
            </form>
        </div>
    </div>
</body>

</html>