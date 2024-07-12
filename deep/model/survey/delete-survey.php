<link rel="stylesheet" type="text/css" href="../../assets/css/app.css" />
<style>
    .form{
        height:100vh;
    }
    </style>
<form method="post" class="flex-center form" action="">
    <input type="number" class="none" value="1" name="sure"/>
    <button class="btn-rouge">JE SUIS SUR QUE JE VEUX SUPPRIMER CE TEST </button>
</form>
<?php
include('../../bdd/connexion_bdd.php');
include('../../api/personality/index.php');
include('../../api/survey/index.php');

if(!isset($_POST['sure']) or $_POST['sure'] != 1 ){
    die;
}
$id_survey = sanatizeString($_SESSION['survey_neurotest']);
// $newName = sanatizeString($_POST['newName']);
//var_dump($id_survey);

deleteSurvey($id_survey, $bdd);
header('Location:../../views/home/control.php'); ?>
