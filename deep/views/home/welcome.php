<?php
include('../../bdd/connexion_bdd.php');
include('../../api/survey/index.php');
include('../../api/account/index.php');
include('../../Lib/account/functions.php');
?>

<!DOCTYPE html>

<head>
    <meta charset="utf-8" />
    <title>Welcome</title>
    <?php //include('../header.php'); 
    ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../../assets/css/intro.css" />
    <link rel="stylesheet" type="text/css" href="../../assets/css/app.css" />
</head>

<body>


    <div class="div_body">
        <?php include('../navbar.php'); ?>

        <div class="flex-center div_img_haut_de_page relative">
            <img id="img_haut_de_page" src="../../assets/img/pexels-rfstudio-3811082.jpg">

            <div class="absolute">
                <h2 id="h2_title">DEEP</h2>
            </div>
        </div>



        <img src="../../assets/img/logo-neurolead.png" class="img_canape none" />
        <div class="flex-center">
            <div class="div_text_intro">
                <?php
                echo replaceXXX(nl2br(html_entity_decode(selectTextApp('introduction', $bdd))));
                ?>
            </div>
        </div>
        <div class="flex-row flex-center flex-wrap div_form_go">

            <?php
            $survey = (isset($_GET['n'])) ? sanatizeString($_GET['n']) : 32;
            $tabSurvey = [getSurveyById($survey, $bdd)];
           // $tabSurvey = getAllActiveSurvey($bdd);
            foreach ($tabSurvey as $survey) {
            ?>
                <form method="post" action="../home/code-acces.php">
                    <input class="none" type="number" name="id_survey" value="<?= $survey['id_survey']; ?>">
                    <button class="btn-orange btn_choose_enquete" type="submit">
                        <?= $survey['name_survey']; ?>

                    </button>
                </form>

            <?php
            }
            ?>

        </div>

    </div>

    <!--
    <h2 class="h2_code"> Vous désirez un code d'accès ? </h2>

    <form method="post" class="flex-center flex-row" action="../session/set-code-acces.php">
        <input type="mail" placeholder="mail" class="mail_code" name="mail" />
        <button type="submit" class="btn_commencer"> ENVOYER UN CODE </button>
    </form>

-->
    <script src="../../assets/js/survey/result.js"></script>
</body>