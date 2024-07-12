<?php 
include('../../bdd/connexion_bdd.php'); 
verifAcces($_SESSION);
include('../../api/personality/index.php');
include('../../api/survey/index.php');

$id_perso = sanatizeString($_POST['id_perso']);
$id_survey = sanatizeString($_POST['id_survey']);
$num_q = sanatizeString($_POST['num_q']);
$num_res = sanatizeString($_POST['num_res']);

if($id_perso != ''){
editPersoReponse($id_perso, $id_survey, $num_q, $num_res, $bdd);
}

?>