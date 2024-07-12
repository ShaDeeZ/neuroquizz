<?php


$id_profil = $_SESSION['detail_profil'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    <link rel="stylesheet" type="text/css" href="../../assets/css/profil-description.css" />
    <link href="https://fonts.googleapis.com/css2?family=AR+One+Sans:wght@400;500&family=Lato&family=Maitree:wght@700&family=Open+Sans:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" media="print" href="../css/resultat-print.css" />
    <title>Document</title>
</head>
<style>
    .div_all_card_categories{
        width:auto;
        height: auto;
    }
    .div_img_categories{
        width: auto;
    }
    </style>
<body>


    <div class="div_return none print_none">
        <h1 id="h1_return" onclick="history.back()"><i class="fa-solid fa-chevron-left"></i></h1>
    </div>

    <div class="flex-center flex-col div_all_desc">
        <div class="div_container_profil flex-col">
            <?php

            /*
            $tabDetailFirst  =  getDetailCategories($id_profil, '1', $bdd);
            $tabDetailSecond =  getDetailCategories($id_profil, '2', $bdd);
            $tabDetailThird  =  getDetailCategories($id_profil, '3', $bdd);
            $tabDetailFour   =  getDetailCategories($id_profil, '4', $bdd);
            */

            $tabDescription = getDescriptionProfil($id_profil, $bdd);
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

            /*
            $tabCategories = [
                1 => [
                    'text' => (!isset($tabDetailFirst[0]['text']) ? 'pas encore' : $tabDetailFirst[0]['text']),
                    'categories' => '😃 Moteurs'
                ],

                2 => [
                    'text' => (!isset($tabDetailSecond[0]['text']) ? 'pas encore' : $tabDetailSecond[0]['text']),
                    'categories' => '🥺 Intolerances'
                ],

                3 => [
                    'text' => (!isset($tabDetailThird[0]['text']) ? 'pas encore' : $tabDetailThird[0]['text']),
                    'categories' => '🤩 Motivation'
                ],

                4 => [
                    'text' => (!isset($tabDetailFour[0]['text']) ? 'pas encore' : $tabDetailFour[0]['text']),
                    'categories' => '🤨 Comment leur parler'
                ],
                
            ];
    */


            $tabColor = $_SESSION['tab_colors'];

            //recup slogan
            $tabDetailSlogan = getDetailProfil($id_profil, 'slogan', $bdd);

            //recup image
            $tabDetailImg = getDetailProfil($id_profil, 'img', $bdd);

            //recup motsclefs
            $tabDetailMotsClefs = getDetailProfil($id_profil, 'motsclefs', $bdd);

            $tabAllPersonalite = getProfilById($id_profil, $bdd);
            // var_dump($tabAllPersonalite);

            foreach ($tabAllPersonalite as $personalite) {
                //var_dump($personalite);

            ?>

                <div class="div_card_and_categories flex-center flex-col spaced-around">

                    <div class="div_card_categorie">

                        <div class="div_all_card_categories relative">

                            <div class="div_img_categories none">
                                <img id="img_personalite" class="none" src="<?= (empty($tabDetailImg)) ? '../../assets/img/res/btn-add.png' : '../../assets/' . $tabDetailImg[0]['detail']; ?>" />
                            </div>

                            <div class="div_color_profil" style="background-color:<?= $tabColor[$id_profil]['color']; ?>"> </div>

                                <div class="div_on_img flex-row flex-center">

                                    <div class="div_icon" style="background-color:<?= $tabColor[$id_profil]['color']; ?>">
                                        <p id="icon_color">
                                            <i class="fa-solid <?= $tabColor[$id_profil]['icon']; ?>"></i>
                                        </p>
                                    </div>

                                    <div class="flex-col div_info_choose">
                                        <p  class="p_nom_perso">
                                            <?= $personalite['nom']; ?>
                                        </p>

                                        <p class="p_slogan">
                                            <?= (empty($tabDetailSlogan)) ? 'pas de slogan' : html_entity_decode($tabDetailSlogan[0]['detail']); ?>
                                        </p>
                                    </div>

                                </div>

                           

                        </div>
                    </div>


                    <div class="categories flex-col">
                        <?php
                        $x = 0;
                        foreach ($tabCategories as $categorie) {
                            $isNone = ($x == 0) ? '' : 'none';
                        ?>
                            <div class="div_all_categories">

                                <div class="div_categories flex-center spaced-around">
                                    <p id="p_view_more_info" onclick="viewMoreInfo(event)">
                                        <i class="fa-solid fa-circle-chevron-down fa-lg" style="color:<?= $tabColor[$id_profil]['color']; ?>;"></i>
                                    </p>
                                    <p id="p_categorie">
                                        <?= $categorie['categories']; ?>
                                    </p>
                                </div>

                                <div class="div_more_info_ctagories">

                                    <p class="p_text">
                                        <?= html_entity_decode($categorie['text']); ?>
                                    </p>

                                </div>
                            </div>
                    <?php
                            $x++;
                        }
                    }
                    ?>
                    </div>

                </div>



                <div class="all_mots_clefs flex-center">
                    <div class="mots_clefs flex-col">
                        <h2 id="id_master_mots">Maîtres-mots : </h2>
                        <div class="flex-row flex-center div_mots_clefs flex-wrap spaced-around">
                            <?php
                            $detailProfil = array_column($tabDetailMotsClefs, 'detail');
                            foreach ($detailProfil as $profil) {
                                $tabMotsClefs = explode('/', $profil);
                                foreach ($tabMotsClefs as $motsClefs) {
                            ?>
                                    <div class="motsclefs flex-center" style="background-color:<?= $tabColor[$id_profil]['color']; ?>;">
                                        <p>
                                            <?= html_entity_decode($motsClefs); ?>
                                        </p>
                                    </div>
                            <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
        </div>
    </div>

    <script src="../../assets/js/survey/graphique-resultat.js"></script>
    <script src="../../assets/js/survey/result.js"></script>

</body>

</html>