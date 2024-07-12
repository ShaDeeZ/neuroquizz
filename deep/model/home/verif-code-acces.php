<?php
include('../../bdd/connexion_bdd.php');

$mail = sanatizeString($_POST['mail']);
$code = sanatizeString($_POST['code']);

function verifCodeAcces($mail, $code, $bdd)
{
    $req = $bdd->prepare('SELECT * FROM users WHERE mail = ? AND code_acces = ?  LIMIT 1');
    $req->execute([
        $mail,
        $code
    ]);

    if ($req->rowCount() == 1) {
        $data = $req->fetch();
        $_SESSION['code'] = $code;
        $_SESSION['isValid'] = 1;
        $_SESSION['mail'] = $mail;
        $_SESSION['survey_neurotest'] = $data['id_survey'];
        $_SESSION['num_question'] = 1;
        var_dump( $_SESSION['survey_neurotest']);
        header('Location:../../views/survey/survey.php');
    } else {
        $_SESSION['code'] = "xxx";
        $_SESSION['isValid'] = 0;
        $_SESSION['mail'] = $mail;
        $_SESSION['survey_neurotest'] = 0;
        $_SESSION['num_question'] = 0;
        header('Location:../../views/home/code-acces.php?acces=0');
    }
}

verifCodeAcces($mail, $code, $bdd);
