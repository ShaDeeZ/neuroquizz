<?php
include('../../bdd/connexion_bdd.php');
verifAcces($_SESSION);
include('../../api/account/index.php');
include('../../api/survey/index.php');
include('../../api/personality/index.php');
include('../../Lib/account/functions.php');
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
    <div class="div_body">
        <h1 class="text-center"> Edit Survey </h1>
        <?php
        //$idSurvey = $_SESSION['survey_neurotest'];
        $introduction = html_entity_decode(selectTextApp('introduction', $bdd));
        ?>
        <form method="post" action="../../model/survey/edit-text-intro.php" class="flex-center flex-col">
            <textarea class="text-area text_area_intro" name="intro">
    <?= $introduction; ?>
    </textarea>
            <button  class="btn-orange btn-change-desc-intro" type="submit">Enregister le texte </button>
        </form>

        <script src="../../assets/js/ajax.js"></script>
        <script src="../../assets/js/survey/edit-survey.js"></script>
    </div>
</body>

</html>