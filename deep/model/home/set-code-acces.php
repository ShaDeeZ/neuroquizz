<?php
include('../../bdd/connexion_bdd.php');

require '../../assets/phpmailer/src/Exception.php';
require '../../assets/phpmailer/src/PHPMailer.php';
require '../../assets/phpmailer/src/SMTP.php';


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//$mailAdress = sanatizeString($_POST['mail']);
if(isset($_POST['mail'])){
    $mailAdress = sanatizeString($_POST['mail']);
}else{
    $mailAdress = 'cream.ludovic@gmail.com';
}

$valideJusque = time() + 86400;

function generateRandomString($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}


$codeAcces = generateRandomString();
//$codeAcces = rand(0,10000);
$end_mail = explode('@', $mailAdress)[1];
$req = $bdd->prepare('INSERT INTO users (mail, code_acces, valide_jusque, end_mail,id_survey) VALUES (?,?,?,?,?) ');
$req->execute(array(
    $mailAdress, $codeAcces, $valideJusque, $end_mail, $_SESSION['survey_neurotest']
));
// Instanciation de PHPMailer
$mail = new PHPMailer(true);
?>
<style>
    body {
        padding: 0;
        margin: 0;
        font-family: "Open Sans", sans-serif;
    }
</style>
<?php
try {
    // Configuration du serveur SMTP (utilisez smtp.gmail.com pour Gmail)
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'neurolead.360@gmail.com';
    $mail->Password = 'sojl nkpu dita mswc';
    $mail->CharSet = 'UTF-8';
    // $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;


    // Configuration de l'expéditeur et du destinataire
    $mail->setFrom('neurolead.360@gmail.com', 'Neurolead');
    $mail->addAddress($mailAdress);

    // Configuration du contenu de l'e-mail
    $mail->isHTML(true);
    $mail->Subject =  "Bonjour, Votre code d'accès au test de personnalité est ".$codeAcces;
    $mail->Body = " Votre code d'accès personnel pour accéder au questionnaire DEEP est ".$codeAcces." .<br><br>
    
    Veuillez cliquer sur ce lien pour <a href='http://localhost/neurotest/user/survey.php?code=".$codeAcces."'> accéder directement au questionnaire </a>. 
    Répondez de la manière naturelle possible sans trop réfléchir.<br><br> Bon amusement. <br><br> l'équipe Neurolead";
    //echo $mail->Body;
    $mail->send();
} catch (Exception $e) {
    echo 'Erreur lors de l\'envoi de l\'e-mail : ', $mail->ErrorInfo;
}


// header('Location:../../frontend/views/companies/');


header('Location:../../views/home/code-acces.php?mail=' . $mailAdress);
