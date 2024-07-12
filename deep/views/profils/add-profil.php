<?php
include('../../bdd/connexion_bdd.php');
verifAcces($_SESSION);
include('../../api/survey/index.php');
include('../../api/personality/index.php');
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
    <?php include('../nav.php'); ?>

    <div class="flex-center">
        <div class="div_add_profil flex-center flex-col spaced-around">

            <h1 id="h1_add_profil"> Ajouter le profil </h1>
            <?php echo (isset($_GET['errPersoExist']) && $_GET['errPersoExist'] == 1) ? '<p id="p_err">Ce nom existe deja</p>':''?>
            <form method="post" action="../../model/profils/add-profil.php">
                <input class="input_add_profil" type="text" name="name_profil" placeholder="Nom du profil" />
                <button class="btn-orange" type="submit"> Ajouter le profil </button>
            </form>
        </div>
    </div>

</body>

</html>