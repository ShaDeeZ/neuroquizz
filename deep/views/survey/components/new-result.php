<?php

function renderProfil($id_profil, $bdd)
{
    // on recupere les datas du profil
    $profil = getProfilById($id_profil, $bdd);
    $tabDetailProfil = getDetailProfil($id_profil, '', $bdd);
    $tabTypeDetail = array_column($tabDetailProfil, 'type_detail');

    // on recupere le slogan
    $idxSlogan = array_search('slogan', $tabTypeDetail);
    $slogan = ($idxSlogan !== false) ? $tabDetailProfil[$idxSlogan]['detail'] : 'Ceci est le slogan';

    // on recupere la description
    $idxDescription = array_search('description', $tabTypeDetail);
    $description = ($idxDescription !== false) ? $tabDetailProfil[$idxDescription]['detail'] : 'Ceci est la Description';

    // on recupere les images
    $tabKeysImg = array_keys($tabTypeDetail, 'img');

    // on lon recupères la listes des mots clefs
    $idxMotsClefs = array_search('motsclefs', $tabTypeDetail);
    $motsClefs = ($idxMotsClefs !== false) ? $tabDetailProfil[$idxMotsClefs]['detail'] : 'Renseigne/Tes/Mots/Clefs';

    ?>
    <div class="flex-row div_profil ">
        <div class="div_column_left">
            <h2>
                <?= $profil['nom']; ?>
            </h2>
            <p class="p_slogan">
                <?= $slogan; ?>
            </p>
            <p class="p_cara"> Heureux et content</p>
            <div class="flex-row flex-wrap flex-center">
                <?php
                foreach ($tabKeysImg as $keyImg) {
                    $urlImg = $tabDetailProfil[$keyImg]['detail'];
                    echo '<img src="../../assets/' . $urlImg . '" class="img_profil" />';
                }
                ?>

            </div>
        </div>

        <div class="flex-row div_column_mid">
            <div class="div_mid">
                <?= $description; ?>
            </div>
        </div>
        <div class="div_column_right">

            <h2 class="h2_valeurs"> Valeurs et mots clefs </h2>
            <ul class="ul_p ul_qualite">
                <?php
                $tabMotsClefs = explode('/', $motsClefs);
                foreach ($tabMotsClefs as $mot) {
                    echo '<li class="li_p li_qualite"> ' . $mot . '</li>';
                }
                ?>
            </ul>
        </div>
    </div>

    <?php
}

function renderBarGraph($TabScore, $idProfil, $texteProfil, $nbrQ)
{


    $scoreProfil = $TabScore[$idProfil];
    $percent = ($scoreProfil / $nbrQ) * 100;

    $tabColor = $_SESSION['tab_colors'];


    ?>
    <div class="flex-center">
        <div class="div_contain_bar_profil flex-row flex-center relative">

            <div class="flex-center relative">
                <div class="div_img_bar flex-center absolute"
                    style="background-color:<?= $tabColor[$idProfil]['color']; ?> !important">
                    <i class="fa-solid <?= $tabColor[$idProfil]['icon']; ?>"></i>
                </div>
            </div>

            <div class="div_progress_profil">
                <div class="progress_profil"
                    style="width:<?= $percent; ?>%; background-color:<?= $tabColor[$idProfil]['color']; ?>"></div>
            </div>

            <div class="div_texte_bar absolute flex-row">
                <p class="p_texte_bar">
                    <?= $texteProfil; ?>
                </p>
            </div>

            <div>
                <p class="p_pourcentage">
                    <?= round($percent) ?> %
                </p>
            </div>

        </div>
    </div>
    <?php
}

function renderBlazon($tabScore)
{

    // var_dump($_SESSION['tab_colors']);
    function renderCaseBlazon($idProfil, $tabProfilToLight)
    {

        $tabColors = $_SESSION['tab_colors'];

        $idxProfil = array_search($idProfil, $tabProfilToLight);
        $toLight = ($idxProfil === false) ? 'transparent' : $tabColors[$idProfil]['color'];
        echo '<div class="carre-blazon flex-center" data-blazon="1" style="background-color:' . $toLight . '"><i class="fa-solid ' . $tabColors[$idProfil]['icon'] . ' fa-lg"></i></div>';
    }

    ?>


    <div class="flex-center">
        <div id="blazon" class="flex-col ">

            <?php
            $tabProfilToLight = [];
            $x = 0;
            foreach ($tabScore as $idProfil => $score) {
                if ($x > 3) {
                    continue;
                }
                array_push($tabProfilToLight, $idProfil);
                $x++;
            }
            $_SESSION['tabProfilToLight'] = $tabProfilToLight;
            //  var_dump($tabProfilToLight);
        
            ?>
            <div class="blazon-ligne flex-row">
                <?php renderCaseBlazon(1, $tabProfilToLight); ?>
                <?php renderCaseBlazon(2, $tabProfilToLight); ?>
                <?php renderCaseBlazon(3, $tabProfilToLight); ?>
            </div>

            <div class="blazon-ligne flex-row">
                <?php renderCaseBlazon(4, $tabProfilToLight); ?>
                <div class="carre-blazon flex-center">
                    <img class="image-blazon" src="../../assets/img/logo-neurolead.png" />
                </div>
                <?php renderCaseBlazon(5, $tabProfilToLight); ?>
            </div>

            <div class="blazon-ligne flex-row">
                <?php renderCaseBlazon(6, $tabProfilToLight); ?>
                <?php renderCaseBlazon(7, $tabProfilToLight); ?>
                <?php renderCaseBlazon(8, $tabProfilToLight); ?>
            </div>

        </div>
    </div>

<?php }




function renderProfilCase($id_profil, $nomProfil, $tabDetailImg, $tabDetailSlogan)
{

    $tabColor = $_SESSION['tab_colors'];

    $tabIdFromImg = array_column($tabDetailImg, 'id_profil');
    $tabIdFromSlogan = array_column($tabDetailSlogan, 'id_profil');

    $idxImg = array_search($id_profil, $tabIdFromImg);
    $idxSlogan = array_search($id_profil, $tabIdFromSlogan);

    $img = ($idxImg === false) ? '../../assets/img/res/btn-add.png' : '../../assets/' . $tabDetailImg[$idxImg]['detail'];
    $slogan = ($idxSlogan === false) ? 'Pas de slogan' : $tabDetailSlogan[$idxSlogan]['detail'];
    ?>
    <div class="div_card_categories">
        <a href="../profils/profil-description.php?perso=<?= $id_profil; ?>">


      

                <div class="flex-center div_img_profils">
                    <img  class="img-select" src="<?= $img; ?>" />
                </div>

                <div class="div_nom relative flex-center" style="background-color:<?= $tabColor[$id_profil]['color']; ?>;">
                    <div class="div_on_img flex-row flex-center">

                        <div>
                            <p id="p_icon_perso">
                                <i class="fa-solid <?= $tabColor[$id_profil]['icon']; ?>"></i>
                            </p>
                        </div>

                        <div>
                            <p id="p_nom_perso">
                                <?= $nomProfil; ?>
                            </p>
                            <p id="p_slogan">
                                <?= $slogan; ?>
                            </p>
                        </div>

                    </div>
                </div>

       

        </a>
    </div>

    <?php
}


function renderCardsToLight($tabScore, $idxDebut, $idxFin, $titre, $sousTitre, $bdd)
{
    ?>
    <div class="print_none">
        <h2 id="h2-motivations" class="h2_result">
            <?= $titre; ?>
        </h2>
        <h4 class="flex-center h4-title-card">
            <?= $sousTitre; ?>
        </h4>
        <div class="flex-col div_card_profil print_none flex-center">
            <?php
            $tabProfils = getAllPersonality($bdd);
            $tabIdFromProfil = array_column($tabProfils, 'numero');

            //   var_dump($tabDetailImg, $tabDetailSlogan);
            $y = 0;
            foreach ($tabScore as $profilToLight => $score) {
                if ($y >= $idxDebut and $y <= $idxFin) {
                    $idxNameProfil = array_search($profilToLight, $tabIdFromProfil);
                    $nameProfil = $tabProfils[$idxNameProfil]['nom'];
                    //recup slogan
                    $tabDetailSlogan = getDetailProfil($profilToLight, 'slogan', $bdd);
                    //recup image
                    $tabDetailImg = getDetailProfil($profilToLight, 'img', $bdd);


                    renderProfilCase($profilToLight, $nameProfil, $tabDetailImg, $tabDetailSlogan);
                }
                $y++;
            }

            ?>
        </div>
    </div>
    <?php
}
?>