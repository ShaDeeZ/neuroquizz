<?php
include('../../bdd/connexion_bdd.php');
include('../../api/personality/index.php');
include('../../api/survey/index.php');

addQuestionSurvey($_SESSION['survey_neurotest'], $_SESSION['num_question'], $bdd);

goPreviousUrl();
?>
