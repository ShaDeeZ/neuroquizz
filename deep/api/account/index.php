<?php
    function getAppText($bdd){
        $req = $bdd->query('SELECT * FROM app_text');
        return $req->fetchAll();
    }

    function editTextApp($type_text, $text, $bdd){
        $del = $bdd->prepare('DELETE FROM app_text WHERE type_text = ?');
        $del->execute([
            $type_text
        ]);
        $req = $bdd->prepare('INSERT INTO app_text (type_text, text) VALUES (?,?)');
        $req->execute([
            $type_text,
            $text
        ]);
    }


?>