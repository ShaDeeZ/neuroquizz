<?php
include ('../../bdd/connexion_bdd.php');
verifAcces($_SESSION);
include ('../../api/survey/index.php');
include ('../../api/personality/index.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../../assets/css/app.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Document</title>
</head>

<body>
    <?php include ('../nav.php'); ?>
    <h1> Edit Survey </h1>
    <?php
    $idSurvey = $_SESSION['survey_neurotest'];
    $detailSurvey = getSurveyById($idSurvey, $bdd);
    //var_dump($detailSurvey);
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

    <?php
    if ($question['num_q'] == 1) {
        //  var_dump($_SESSION);
        ?>

        <div class="div_edit_survey flex-row flex-around flew-wrap">
            <a href="../home/welcome.php?n=<?= $_SESSION['survey_neurotest']; ?>" class="btn-orange"> Accéder au lien de
                l'enquête </a>
            <a href="../../model/survey/duplicate-survey.php" class="btn-orange">Dupliquer l'enquête</a>
            <div class="flex-row">
                <input type="text" class="input_rename_survey" value="<?= $detailSurvey['name_survey']; ?>"
                    onfocusout="renameSurvey(event)" /> <button class="btn-orange"> renommer l'enquête </button>
            </div>
            <form method="post" action="../../model/survey/delete-survey.php">
                <input type="number" class="none" value="<?= $_SESSION['survey_neurotest']; ?>" name="survey" />
                <button class="btn-rouge">Supprimer l'enquête</button>
            </form>

        </div>
        <div class="flex-row flex-center div_container_rep">

            <div class="div_question_choose flex-center flex-col">
                <h3> Ajouter des questions </h3>
                <form method="POST" action="../../model/survey/add-question-survey.php">
                    <input id="inpt_change_question" name="nbr_question_choose" type="number"
                        placeholder="Nombre de question a ajouter" required />
                    <button id="btn_change_question" type="submit"> Add question</button>
                </form>
            </div>

            <div class="div_question_choose flex-center flex-col">
                <h3> Supprimer des questions </h3>
                <form method="POST" action="../../model/survey/del-question-survey.php">
                    <input id="inpt_change_question" name="nbr_question_delete" type="number"
                        placeholder="Nombre de question a supprimer" required />
                    <button id="btn_change_question" type="submit"> suppr question </button>
                </form>
            </div>

        </div>
        <?php
    }
    ?>

    <p class="p_q text-center">Le quizz comporte :
        <?= $nbrQ; ?> questions
    </p>
    <div class="div_all_question flex-row flex-wrap">
        <?php
        //var_dump($idSurvey);
        $tabRes = getTitleReponseByQuestion($question['num_q'], $idSurvey, $bdd);
        ?>

        <div class="div_fleche flex-row flex-spaced">
            <p class="p_fleche"><a href="../../model/survey/change-question.php?to=previous"><i
                        class="fa-solid fa-circle-chevron-left" style="color: #8f8e8e;"></i></a></p>
            <p class="p_fleche"><a href="../../model/survey/change-question.php?to=next"><i
                        class="fa-solid fa-circle-chevron-right" style="color: #8f8e8e;"></i></a></p>
        </div>
        <h2 class="h2_q text-center">
            <?= '<span class="span_title_q" data-idq="' . $question['id_question'] . '" contenteditable="true" onfocusout="editTextQuestion(event)">' . html_entity_decode($question['name_fr']) . '</span> (' . $question['num_q'] . ')'; ?>
        </h2>
        <div class="div_add_question">
            <form method="POST" action="../../model/survey/add-question-survey.php">
                <button class="btn-orange">Ajouter une question </button>
            </form>

            <button class="btn-orange">Supprimer la question </button>
        </div>


        <?php
        // var_dump($question);
        
        $iconVisibility = ($question['inactive'] == 1) ? '⛔️' : '✅';
        $inactive = ($question['inactive'] == 1) ? '1' : '0';
        ?>
        <span class="span_masquer_question" data-inactive="<?= $inactive; ?>" onclick="changeVisibilityQuestion(event)">
            <?= $iconVisibility; ?>
        </span>




        <div class="div_container_question flex-center">
            <div class="flex-row flex-wrap flex-center div_rep_question" ondrop="drop(event)"
                ondragover="allowDrop(event)">
                <?php
                $i = 1;
                foreach ($tabRes as $reponse) { ?>
                    <div class="div_card_rep_edit draggable" draggable="true" ondragstart="drag(event)">
                        <h3 class="none"> BOX
                            <?= $i; ?>
                        </h3>
                        <p class="p_rep_q text-center" contenteditable="true" onfocusout="editTextReponse(event)">
                            <?= html_entity_decode(nl2br($reponse['name_fr'])); ?>
                        </p>

                        <?php
                        echo '<div class="flex-center div_image_refresh">';
                        echo '<img class="img_rep_q" src="../../assets/' . $reponse['img'] . '" alt="' . $reponse['name_fr'] . '"/>';
                        echo '</div>';
                        ?>

                        <input type="number" class="none input_num_res" name="num_res" value="<?= $reponse['num_res']; ?>">
                        <input type="number" class="none input_id_survey" name="id_survey" value="<?= $idSurvey; ?>">
                        <input type="number" class="none input_num_q" name="num_q" value="<?= $reponse['id_q']; ?>">

                        <form id="imageForm" enctype="multipart/form-data" class="flex-center">
                            <input type="file" class="input_file" name="new_image" accept="image/*"
                                data-num="<?= $reponse['num_res']; ?>" data-id="<?= $idSurvey; ?>"
                                data-question="<?= $reponse['id_q']; ?>" onchange="uploadImage(event)" />
                        </form>

                        <?php
                        echo '<div class="flex-row flex-wrap flex-spaced flex-center div_all_btn_perso">';
                        foreach ($tabPersonality as $personality) {
                            $isPersoActif = '';
                            if ($personality['id_perso'] == $reponse['id_perso']) {
                                $isPersoActif = 'persoActif';
                            }
                            echo '<p class="p_perso btn-white ' . $isPersoActif . '" onclick="editPersoReponse(event)" data-perso="' . $personality['id_perso'] . '">' . $personality['nom'] . '</p>';
                        }
                        echo '</div>';

                        ?>
                    </div>
                    <?php
                    $i++;
                }
                ?>
            </div>
        </div>


    </div>

    <script src="../../assets/js/ajax.js"></script>
    <script src="../../assets/js/survey/edit-survey.js"></script>
</body>

</html>