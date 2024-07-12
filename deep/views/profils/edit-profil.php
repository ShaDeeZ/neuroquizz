<?php
include('../../bdd/connexion_bdd.php');
verifAcces($_SESSION);
include('../../api/survey/index.php');
include('../../api/personality/index.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="../../assets/css/app.css" />
    <title>Document</title>
</head>

<body>
    <?php include('../nav.php'); ?>
    <?php

    // si aucune valeur de $_SESSION['profil_to_edit']
    (!isset($_SESSION['profil_to_edit'])) ? $_SESSION['profil_to_edit'] = 1 : $_SESSION['profil_to_edit'];

    $tabDescription = getDescriptionProfil($_SESSION['profil_to_edit'], $bdd);
    $tabTypeDescription = array_column($tabDescription, 'id_categorie');

    $tabNomCategories = [
        '😃 Moteurs',
        '🥺 Intolerances',
        '🤩 Motivation',
        '🤨 Comment leur parler',
    ];

    $tabCategories = [];
    for ($x = 1; $x < 5; $x++) {
        $idxText = array_search($x, $tabTypeDescription);
        $tabCategories[$x] = [
            'text' => ($idxText !== false) ? $tabDescription[$idxText]['text'] : 'pas encore',
            'categories' => $tabNomCategories[$x - 1]
        ];
    }


    echo '<div class="flex-center"><div class="flex-center flex-wrap flex-row div_choose_perso">';
    $tabProfils = getAllPersonality($bdd);
    $tabIdProfil = array_column($tabProfils, 'id_perso');

    $idxProfil = array_search($_SESSION['profil_to_edit'], $tabIdProfil);
    foreach ($tabProfils as $profil) {
        echo '<a class="a_choose_perso" href="../../model/profils/select-profil-to-edit.php?profil=' . $profil['id_perso'] . '">' . $profil['nom'] . '</a>';
    }
    echo '</div></div></div>';
    $detailProfil = $tabProfils[$idxProfil];
    ?>

    <div class="flex-start spaced-evenly">
        <!--Partie de gauche-->
        <?php
        echo '<div>';
        echo '<h1 class="h1_profil_nom">' . $detailProfil['nom'] . '</h1>';

        $tabDetailProfils = getDetailProfil($_SESSION['profil_to_edit'], '', $bdd);
        // var_dump($tabDetailProfils);
        $tabTypeDetail = array_column($tabDetailProfils, 'type_detail');

        // on recupère le slogan 
        $idxSlogan = array_search('slogan', $tabTypeDetail);
        $slogan = ($idxSlogan === false) ? 'Ecrivez votre slogan' : $tabDetailProfils[$idxSlogan]['detail'];

        // on recupère la description 
        $description = (!empty($tabTextDetail)) ? $tabTextDetail[0] : 'Ecrivez votre description';



        // on recupère les mots clefs 
        $idxMotsCelfs = array_search('motsclefs', $tabTypeDetail);
        $motsClefs = ($idxMotsCelfs === false) ? 'Ecrivez/Vos/Mots/Clefs' : $tabDetailProfils[$idxMotsCelfs]['detail'];
        ?>
        <div class="flex-col spaced-around  div_edit_slogan">
            <label id="label_for_change" for="slogan"> Change slogan :</label>
            <form method="post" action="../../model/profils/edit-slogan-profil.php" class="flex-col flex-center form_edit_slogan">
                <input class="input_edit_slogan" type="text" value="<?= html_entity_decode($slogan); ?>" name="slogan" />
                <button class="btn-orange-edit-profil" type="submit"> Mettre a jour les slogans </button>
            </form>
        </div>
        <?php
        echo '<div class="flex-col flex-wrap">';
        $nombreImage = 6;
        for ($x = 0; $x < $nombreImage; $x++) {
        ?>
            <div class="flex-col spaced-around div_image flex-center">
                <form method="post" action="../../model/profils/edit-image-profil.php" class="flex-center flex-row form_edit_img" enctype="multipart/form-data">
                    <input class="none" type="number" name="image_number" value="<?= $x + 1; ?>" />
                    <input type="file" name="new_image" required />
                    <button class="btn-orange-edit-profil" type="submit"> Upload image </button>
                </form>
                <?php


                $tab_image = getDetailProfil($_SESSION['profil_to_edit'], 'img', $bdd);
                $tabIdImage = array_column($tab_image, 'numero_detail');
                $idxImage = array_search($x + 1, $tabIdImage);

                $urlImage = ($idxImage !== false) ? $tab_image[$idxImage]['detail'] : 'img/res/btn-add.png';

                ?>
                <img id="img_perso" src="<?= '../../assets/' . $urlImage; ?>" />
            </div>
        <?php

        }
        echo '</div></div>';
        ?>

        <!--Partie de droite-->
        <div class="flex-center">
            <div class="div_all_form_for_edit flex-col spaced-around">


                <div class="flex-col">
                    <label id="label_for_change" for="slogan"> Change description:</label>
                    <?php

                    echo '<div class="categories">';
                    //var_dump($tabCategories);
                    foreach ($tabCategories as $idCategorie => $categories) {
                        echo '<div class="div_all_categories">';
                        echo '<div class="a_choose_categorie flex-center spaced-around">';

                        echo ' <p id="p_view_more_info" onclick="changeDescription(event)">';
                        echo ' <i class="fa-solid fa-circle-chevron-down fa-lg"></i>';
                        echo ' </p>';

                        echo '<p id="p_categorie">' . $categories['categories'] . '</p>';
                        echo '</div>';

                    ?>
                        <div class="none div_more_info_categories flex-center">
                            <form method="post" action="../../model/profils/edit-description-profil.php" class="flex-col">
                                <textarea class="textarea_edit_description" rows="15" cols="5" type="text" name="description">
                                <?= html_entity_decode($categories['text']); ?>   
                            </textarea>
                                <input type="number" value="<?= $idCategorie; ?>" class="none" name="categorie" />

                                <button class="btn-edit-profil" type="submit">valider </button>
                            </form>
                        </div>
                    <?php
                        echo '</div>';
                    }
                    echo '</div>';

                    //echo '<div class="flex-col flex-center">';
                    //foreach ($tabCategories as $idxCategories => $valCategorie) {

                    //}
                    //echo '</div>';




                    ?>

                </div>


                <div class="flex-col">
                    <h1 class="h1_value_motsclefs">Valeurs et mots clefs</h1>
                    <label id="label_for_change" for="slogan"> Change motsclefs :</label>
                    <form method="post" action="../../model/profils/edit-motsclefs-profil.php" class="flex-col ">
                        <input class="input_edit_motsclefs" type="text" value="<?= html_entity_decode($motsClefs); ?>" name="motsclefs" />
                        <button class="btn-orange-edit-profil" type="submit"> Mettre a jour les motsclefs </button>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <script src="../../assets/js/ajax.js"></script>
    <script src="../../assets/js/profil/edit-profil.js"></script>

</body>

</html>