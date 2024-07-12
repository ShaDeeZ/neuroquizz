<?php
include('../../bdd/connexion_bdd.php');
include('../../api/survey/index.php');
include('../../api/personality/index.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="../../assets/css/app.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=AR+One+Sans:wght@400;500&family=Lato&family=Maitree:wght@700&family=Open+Sans:wght@300&display=swap" rel="stylesheet">

    <title>Document</title>
</head>

<body>

    <?php

    var_dump($_SESSION['survey_neurotest']);
    $idSurvey = (isset($_SESSION['survey_neurotest'])) ? $_SESSION['survey_neurotest'] : 0;
    if ($idSurvey == 0) {
        //header('location:../home/welcome.php');
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

    $divisionByNbrq = 300 / $nbrQ;
    $progressPixelBar = $question['num_q'] * $divisionByNbrq;

    include('../navbar.php');
    ?>


    <div class="flex-center div_body">
        <div class="div_progress">
            <div class="progress" style="width:<?= $progressPixelBar; ?>px !important;"></div>
        </div>
    </div>

    <?php
    ?>
    <div class="div_all_img flex-row flex-wrap">
        <?php

        $tabRes = getTitleReponseByQuestionRandom($question['num_q'], $idSurvey, $bdd);
        ?>

        <h3 class="h2_q text-center">QUESTION
            <?= $question['num_q']; ?>
        </h3>
        <h2 class="title_q text-center">
            <?= html_entity_decode($question['name_fr']); ?>
        </h2>

        <div class="div_container_rep flex-center">
            <div class="flex-col flex-wrap flex-center div_rep_question">
                <?php
                $i = 1;
                foreach ($tabRes as $reponse) { ?>
                    <div class="card_rep_other flex-col flex-center" onclick="selectReponse(event)" data-perso="<?= $reponse['id_perso']; ?>">

                        <div class="div_image_other flex-center">
                            <?php
                            echo '<img class="img_quizz" src="../../assets/' . $reponse['img'] . '" alt="' . $reponse['name_fr'] . '" />';
                            ?>
                        </div>

                        <div class="">
                            <p class="p_title_reponse">
                                <?= nl2br($reponse['name_fr']); ?>
                            </p>
                        </div>
                    </div>
                <?php
                    $i++;
                }
                ?>
            </div>
        </div>

        <div class="div_fleche flex-center flex-row fixed">
            <p class="p_fleche"><a href="../../model/survey/change-question.php?to=previous"> <i class="fa-solid fa-circle-chevron-left" style="color: #8f8e8e;"></i> </a></p>

            <form method="post" action="../../model/survey/next-question.php">
                <input id="input_reponse" class="none" type="text" value="0" name="reponses">
                <p id="p_warning_test" class="none red"> Veuillez choisir 2 ou 3 réponses </p>
                <div class="p_fleche" onclick="goToNextQuestion(event)"> <i class="fa-solid fa-circle-chevron-right" style="color: #8f8e8e;"></i> </div>
            </form>

        </div>

    </div>

    <script src="../../assets/js/ajax.js"></script>
    <script src="../../assets/js/survey/survey.js"></script>
    <script src="../../assets/js/survey/result.js"></script>

</body>

</html>