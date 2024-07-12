<?php 
include('../../bdd/connexion_bdd.php'); 
verifAcces($_SESSION);
include('../../api/survey/index.php');

$detailSurvey = getSurveyById($_SESSION['survey_neurotest'], $bdd);

$nbrQ = $detailSurvey['nbr_question'];

$to = sanatizeString($_GET['to']);
if($to == "previous" and $_SESSION['num_question'] > 1){
    $_SESSION['num_question']--;
}

if($to == "next" and $_SESSION['num_question'] < $nbrQ ){
    $_SESSION['num_question']++;
}

// Utilisation de la superglobale $_SERVER pour obtenir l'URL précédente
goPreviousUrl();
  

?>