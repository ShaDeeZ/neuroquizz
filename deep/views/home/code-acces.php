<?php
include ('../../bdd/connexion_bdd.php');
if (isset($_POST['id_survey'])) {
    $_SESSION['survey_neurotest'] = sanatizeString($_POST['id_survey']);
}
// var_dump($_SESSION);
?>
<!DOCTYPE html>

<head>
    <meta charset="utf-8" />
    <title> QUESTION 1 </title>

    <link rel="stylesheet" type="text/css" href="../../assets/css/intro.css" />
    <link rel="stylesheet" type="text/css" href="../../assets/css/app.css" />

</head>

<body>
    <div class="div_body">
        <?php include ('../navbar.php'); ?>

        <h2 class="margin-500"> Vous avez déjà un code d'accès ? </h2>


        <form method="post" class="flex-row flex-center flex-col-phone" action="../../model/home/verif-code-acces.php">
            <?php

            $mail = (isset($_GET['mail'])) ? sanatizeString($_GET['mail']) : '';
            ?>
            <input type="mail" class="mail_code input_ask_code_1 text-center" placeholder="votre adresse mail"
                name="mail" value="<?= $mail; ?>" />
            <input type="text" class="mail_code input_ask_code_1 text-center" placeholder="code d'accès... "
                name="code" />
            <button type="submit" class="btn-orange"> ENVOYER</button>
        </form>
        <div class="flex-center">
            <?php
            if (isset($_GET['acces']) and $_GET['acces'] == 0) {
                echo '<p class="p_error"> Code invalide </p>';
            }

            if (isset($_GET['mail'])) {
                echo '<p class="p_ok"> un mail a été envoyé à ' . sanatizeString($_GET['mail']) . ' </p>';
            }
            ?>
        </div>

        <h2> Vous désirez un code d'accès ? </h2>
        <div class="flex-row flex-center flex-col-phone">
            <!-- <form method="post" class="flex-row flex-center flex-col-phone" action="../../model/home/set-code-acces.php"> -->
            <input type="mail" class="mail_code input_ask_code_2 text-center" placeholder="votre adresse mail"
                name="mail" required />
            <button type="submit" class="btn-orange" id="checkout"> Demander un code </button>
            <!--  </form> -->
        </div>
    </div>
    <script src="https://js.stripe.com/v3/"></script>
    <script src="../../assets/js/survey/result.js"></script>
    <script src="../../assets/js/control/checkout.js"></script>

</body>

</html>