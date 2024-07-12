<?php

function getAllPersonality($bdd){
    $req = $bdd->query('SELECT * FROM personnalite');
    return $req->fetchAll();
}

function getProfilById($id_profil, $bdd){
    $req = $bdd->prepare('SELECT * FROM personnalite WHERE id_perso = ?');
    $req->execute([
        $id_profil
    ]);
    return $req->fetchAll();
}


function addDetailProfil($type_detail,$numero_detail,$detail,$id_profil,$bdd){

    $del = $bdd -> prepare('DELETE FROM detail_profil WHERE type_detail = ? AND numero_detail = ? AND id_profil = ?');
    $del -> execute([$type_detail,$numero_detail,$id_profil]);

    $req = $bdd -> prepare ('INSERT INTO detail_profil(type_detail,numero_detail,detail,id_profil) VALUES(?,?,?,?)');
    $req -> execute ([$type_detail,$numero_detail,$detail,$id_profil]);
}

function getDetailProfil($id_profil,$type_detail,$bdd){
    $req = $bdd -> prepare('SELECT * FROM detail_profil WHERE id_profil = ? AND type_detail LIKE ? ORDER BY id_detail_profil DESC');
    $req -> execute ([$id_profil,"%".$type_detail."%"]);
    return $req -> fetchAll();
}

function addProfil($nom,$bdd){
    $req = $bdd -> prepare('INSERT INTO personnalite(nom) VALUES(?)');
    $req -> execute([$nom]);
}

function deleteProfilById($id_personnalite,$bdd){
    $req = $bdd -> prepare('DELETE FROM personnalite WHERE id_perso = ?');
    $req -> execute([$id_personnalite]);
}
function checkPersoExist($nom,$bdd){
    $req = $bdd -> prepare('SELECT * FROM personnalite WHERE nom = ?');
    $req ->execute([$nom]);
    return $req->fetchAll();
}


function addDescriptionProfil($id_profil,$id_categorie,$type_text,$description,$bdd){

    $del = $bdd->prepare('DELETE FROM app_text WHERE id_profil = ? AND id_categorie = ? AND type_text = ?');
    $del->execute([$id_profil, $id_categorie, $type_text]);
    
    $req = $bdd->prepare('INSERT INTO app_text (id_profil, id_categorie, type_text, text) VALUES (?, ?, ?, ?)');
    $req->execute([$id_profil, $id_categorie, $type_text, $description]);
    
    }
    
    function getDescriptionProfil($id_profil,$bdd){
        $req = $bdd -> prepare('SELECT * FROM app_text WHERE id_profil = ? AND type_text = ?');
        $req -> execute([$id_profil,'profil_description']);
        return $req -> fetchAll();
    }
    
    
    function getDetailCategories($id_profil,$id_categorie,$bdd){
        $req = $bdd -> prepare('SELECT * FROM app_text WHERE id_profil = ? AND id_categorie = ?');
        $req -> execute([$id_profil,$id_categorie]);
        return $req -> fetchAll();
    }
      
?>