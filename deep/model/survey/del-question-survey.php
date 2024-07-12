<?php
include('../../bdd/connexion_bdd.php');
include('../../api/personality/index.php');
include('../../api/survey/index.php');

$nbrQuestionDel = sanatizeString($_POST['nbr_question_delete']);

delQuestionSurvey($nbrQuestionDel,$bdd);

goPreviousUrl();
?>