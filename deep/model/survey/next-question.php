<?php
include('../../bdd/connexion_bdd.php');
include('../../api/survey/index.php');

$detailSurvey = getSurveyById($_SESSION['survey_neurotest'], $bdd);
$nbrQ = $detailSurvey['nbr_question'];

$res = sanatizeString($_POST['reponses']);
$tab_res = explode('/', removeLast(sanatizeString($_POST['reponses'])));
if (count($tab_res) != 2 and count($tab_res) != 3) {
    echo 'Veuillez choisir 2 ou 3 réponses';
    die;
}

addReponseByQuestion($res, $_SESSION['num_question'], $_SESSION['survey_neurotest'], $_SESSION['code'], time(), $bdd);


if ($_SESSION['num_question'] != $nbrQ) {
    $_SESSION['num_question']++;
    // Utilisation de la superglobale $_SERVER pour obtenir l'URL précédente
    $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php';
    header('Location: ' . $referer);
} else {
    echo 'finito';
    addResultSurvey($_SESSION['code'], $_SESSION['survey_neurotest'], $bdd);
    header('Location:../../views/survey/result.php');
}
