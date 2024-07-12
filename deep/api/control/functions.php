<?php
function upVisibilitySurvey($enquete, $newVisibility, $bdd){
    $req = $bdd->prepare('UPDATE survey SET visible = ? WHERE id_survey = ?');
    $req->execute([
        $newVisibility,
        $enquete
    ]);
}


?>