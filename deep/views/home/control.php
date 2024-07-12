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
    <h1> Home </h1>

    <div class="flex-row flex-center div_surveys">
        <div class="div_add_survey card-1 flex-center flex-col">
            <h2> Ajouter une enquete </h2>
            <form method="post" action="../../model/survey/add-survey.php" class="flex-col">
                <input type="text" name="name_survey" class="input-text input_add_survey" placeholder="Nom de l'enquete" />
                <input type="number" name="nbr_question" class="input-text input_add_survey" placeholder="Nombre question" />
                <button class="btn-orange" type="submit"> Ajouter L'enquete </button>
            </form>
        </div>

        <div class="div_list_survey card-1 flex-col">
            <h2> Liste des enquetes </h2>
            <div class="flex-row spaced-between flex-center flex-wrap">
                <?php
                $tabSurvey = getAllSurvey($bdd);
                foreach ($tabSurvey as $survey) {
                    $visibility = $survey['visible'];
                    $icon = ($visibility == 1) ? '✅' : '❌';
                    echo '<div class="flex-row flex-center div_double_btn">';

                    echo '<form action="../../model/survey/go-to-edit.php" method="post" class="flex-row flex-center">';
                    echo '<input type="hidden" name="survey_id" value="' . $survey['id_survey'] . '">';
                    echo '<div class="btn_masquer_enquete none" data-enquete="' . $survey['id_survey'] . '" data-visible="' . $visibility . '" onclick="changeVisibilityEnquete(event)">' . $icon . '</div>';
                    echo '<button type="submit" class="p_survey btn-orange">' . $survey['name_survey'] . '</button>';
                    echo '</div>';
                    echo '</form>';
                }
                ?>
            </div>
        </div>
    </div>
    <script src="../../assets/js/ajax.js"></script>
    <script src="../../assets/js/control/control.js"></script>
</body>

</html>