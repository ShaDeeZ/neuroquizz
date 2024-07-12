<?php 
include('../../bdd/connexion_bdd.php'); 
verifAcces($_SESSION);
include('../../api/personality/index.php');
include('../../api/survey/index.php');

$question = sanatizeString($_POST['text']);
$id_q = sanatizeString($_POST['id_q']);


if($question != ''){
editTextQuestion($question, $id_q, $bdd);
}

?>