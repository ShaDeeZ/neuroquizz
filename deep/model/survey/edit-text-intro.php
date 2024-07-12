<?php 
include('../../bdd/connexion_bdd.php'); 
verifAcces($_SESSION);
include('../../api/account/index.php');

$introduction = sanatizeString($_POST['intro']);
;

if($introduction != ''){
editTextApp('introduction', $introduction, $bdd);
}

goPreviousUrl();

?>