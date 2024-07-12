<?php 
include('../../bdd/connexion_bdd.php'); 
verifAcces($_SESSION);
include('../../api/personality/index.php');
include('../../api/survey/index.php');

$name = sanatizeString($_POST['name_survey']);
$nbrQ = sanatizeString($_POST['nbr_question']);

if($name != ''){
addSurvey($name, $nbrQ, $bdd);
}
goPreviousUrl();

?>