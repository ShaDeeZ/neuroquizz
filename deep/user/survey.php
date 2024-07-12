<?php 
include('../bdd/connexion_bdd.php');
$code = sanatizeString($_GET['code']);
function verifCodeAcces( $code, $bdd)
{
    $req = $bdd->prepare('SELECT * FROM users WHERE  code_acces = ?  LIMIT 1');
    $req->execute([
        $code
    ]);

    if ($req->rowCount() == 1) {
        $data = $req->fetch();
        //echo 'lol1';
        $_SESSION['code'] = $code;
        $_SESSION['isValid'] = 1;
        $_SESSION['mail'] = $data['mail'];
        $_SESSION['survey_neurotest'] = $data['id_survey'];
        $_SESSION['num_question'] = 1;
        header('Location:../views/survey/survey.php');
    } else {
        //echo 'lol2';
        $_SESSION['code'] = "xxx";
        $_SESSION['isValid'] = 0;
        $_SESSION['mail'] = 'xxx';
        $_SESSION['survey_neurotest'] = 0;
        $_SESSION['num_question'] = 0;
       header('Location:../views/home/code-acces.php?acces=0');
    }
}

verifCodeAcces( $code, $bdd);

?>