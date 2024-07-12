<?php
include('../../bdd/connexion_bdd.php');
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
    <div class="div_nav"></div>
    
    <?php
    $idSurvey = (isset($_SESSION['survey_neurotest'])) ? $_SESSION['survey_neurotest'] : 0;
    if($idSurvey == 0){
        header('location:../home/welcome.php');
        die;
    }

    $_SESSION['survey_neurotest'] = $idSurvey;

    $detailSurvey = getSurveyById($idSurvey, $bdd);
    $tabPersonality = getAllPersonality($bdd);
    $nbrQ = $detailSurvey['nbr_question'];
    $nbr_rep = count($tabPersonality);
    $tabQuestions = getQuestionsBySurvey($idSurvey, $bdd);
    $tab_numq_from_q = array_column($tabQuestions, 'num_q');

    $_SESSION['num_question'] = (!isset($_SESSION['num_question'])) ? 1 : $_SESSION['num_question'];
    $num_q = $_SESSION['num_question'];
    
    $idxQ = array_search($num_q, $tab_numq_from_q);
    $question = $tabQuestions[$idxQ];
    ?>
    <div class="div_all_img flex-row flex-wrap">
        <?php

        $tabRes = getTitleReponseByQuestion($question['num_q'],$idSurvey, $bdd);
        ?>

        <h3 class="h2_q text-center">QUESTION : 
            <?= $question['num_q']; ?>
        </h3>
        <h2 class="h2_q text-center">
            <?= $question['name_fr']; ?>
        </h2>

        <div class="div_container_rep flex-center">
            <div class="flex-row flex-wrap flex-center div_rep_question">

                <?php
                $i = 1;
                foreach ($tabRes as $reponse) { ?>
                    <div class="card_rep" onclick="selectReponse(event)" data-perso="<?= $reponse['id_perso']; ?>">

                        <?php
                        echo '<div class="flex-center">';
                        echo '<div class="flex-center div_img_survey"><img class="img_rep_q" src="../../assets/' . $reponse['img'] . '" alt="' . $reponse['name_fr'] . '"/></div>';
                        echo '</div>';

                        ?>

                        <p class="p_rep_q text-center">
                            <?= $reponse['name_fr']; ?>
                        </p>
                    </div>
                    <?php
                    $i++;
                }
                ?>
            </div>
        </div>

        <div class="div_fleche flex-center flex-row flex-spaced">
            <p class="p_fleche"><a href="../../model/survey/change-question.php?to=previous">⬅️ </a></p>
            
            <form method="post" action="../../model/survey/next-question.php">
                <input id="input_reponse" class="none" type="text" value="0" name="reponses">
                <button type="submit" class="p_fleche"> ➡️ </button>
            </form>

        </div>

    </div>

    <script src="../../assets/js/ajax.js"></script>
    <script src="../../assets/js/survey/survey.js"></script>

</body>

</html>