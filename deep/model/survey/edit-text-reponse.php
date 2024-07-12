<?php 
include('../../bdd/connexion_bdd.php'); 
verifAcces($_SESSION);
include('../../api/personality/index.php');
include('../../api/survey/index.php');

$question = sanatizeString($_POST['text']);
$id_survey = sanatizeString($_POST['id_survey']);
$num_q = sanatizeString($_POST['num_q']);
$num_res = sanatizeString($_POST['num_res']);

if($question != ''){
editTextReponse($question, $id_survey, $num_q, $num_res, $bdd);
}

?>