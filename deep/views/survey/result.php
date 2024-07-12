<?php
include ("../../bdd/connexion_bdd.php");
include ('../../api/survey/index.php');
include ('../../api/personality/index.php');

?>
<!DOCTYPE html>

<head>
    <meta charset="utf-8" />
    <title> DEEP TEST </title>
    <link rel="shortcut icon" href="../img/imgGlobal/pixy.ico">
    <link rel="stylesheet" type="text/css" href="../../assets/css/app.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
    <link rel="stylesheet" type="text/css" media="print" href="../css/resultat-print.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js" integrity="sha512-BNaRQnYJYiPSqHHDb58B0yaPfCu+Wgds8Gp/gU33kqBtgNS4tSPHuGibyoeqMV/TJlSKda6FXzoEyYGjTe+vXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src="sharer.min.js"></script>
</head>

<body>
    <?php
    include ('../navbar.php');
    include ('./components/new-result.php');

    ?>
    <div class="flex-row flex-spaced div_return none">
        <button class="btn_return_acceuil"><i class="fa-solid fa-chevron-left"></i> revenir à l'acceuil </button>
        <i class="fa-solid fa-arrow-up-right-from-square icon-share"></i>
    </div>


    <h1 id="h1_finish_quest"> QUESTIONNAIRE TERMINE ! <span class="span_icon_check none"><i
                class="fa-solid fa-circle-check" style="color: #00bf63;"></i></span></h1>
    <p class="text-center p_sous_title flex-row flex-center">Découvre maintenant ce que signifie chaque profil !
        <button onclick="window.print()" class="btn_print print_none btn-orange"> Imprime tes résultats 🖨
        </button>
    </p>

    <?php
    $tabProfils = getAllPersonality($bdd);
    $tabIdProfils = array_column($tabProfils, 'id_perso');
    $tabScore = [];
    foreach ($tabProfils as $profil) {
        $tabScore[$profil['id_perso']] = 0;
    }

    $rep_to_explode = $_SESSION['result'];

    $tabAnswers = getAnswsersByCodeAndSurvey($_SESSION['code'], $_SESSION['survey_neurotest'], $bdd);

    $tabDetailSurvey = getSurveyById($_SESSION['survey_neurotest'], $bdd);
    $nbrQ = $tabDetailSurvey['nbr_question'];

    //var_dump($tabAnswers);
    foreach ($tabAnswers as $answer) {
        foreach ($tabIdProfils as $idProfil) {
            if (strstr('/' . $answer['reponses'], '/' . $idProfil . '/')) {
                $tabScore[$idProfil]++;
            }
        }
    }

    arsort($tabScore);
    ?>

    <div class="div_body_test">
        <div class="div_header_result flex-row flex-wrap">
            <div class="div_blazon none">
                <input type="text" id="resultat_chart" value="<?php echo $rep_to_explode; ?>" class="none" />
                <h2 class="h2_result">Ton blazon</h2>

                <?php
                renderBlazon($tabScore);
                ?>

            </div>
            <div class="div_motsclefs">
                <?php





                // var_dump($tabDetailMotsClefs);
                $tabColors = $_SESSION['tab_colors'];
                ?>

                <div class="flex-center">
                    <div class="mots_clefs">
                        <h2 class="h2_result"> Tes Maîtres-mots </h2>
                        <div class="flex-row spaced-around flex-wrap div_mots_clefs">
                            <?php
                            for ($x = 0; $x < 3; $x++) {

                                $id_profil = $_SESSION['tabProfilToLight'][$x];
                                $tabDetailMotsClefs = getDetailProfil($id_profil, 'motsclefs', $bdd);
                                $detailProfil = array_column($tabDetailMotsClefs, 'detail');
                                foreach ($detailProfil as $profil) {
                                    $tabMotsClefs = explode('/', $profil);
                                    $nbrWords = 0;
                                    foreach ($tabMotsClefs as $motsClefs) {
                                        if ($nbrWords == 2) {
                                            continue;
                                        }
                                        ?>
                                        <div class="motsclefs flex-center"
                                            style="background-color:<?= $tabColors[$id_profil]['color']; ?>;">
                                            <p>
                                                <?= $motsClefs; ?>
                                            </p>
                                        </div>
                                        <?php
                                        $nbrWords++;
                                    }
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="div_perso_dominante">
                <h2 class="h2_result h2_perso_dominante">Tes tempéraments </h2>
                <?php

                $x = 0;
                $nbrProfilToRender = 2;

                $tabTextIntroProfil = [''];
                foreach ($tabProfils as $profil) {

                    $tabDetailSlogan = getDetailProfil($profil['id_perso'], 'slogan', $bdd);
                    // var_dump($tabDetailSlogan);
                    $slogan = (isset($tabDetailSlogan[0])) ? $tabDetailSlogan[0]['detail'] : 'pas de slogan';
                    $tabTextIntroProfil[] = '<span class="title_bar">' . $profil['nom'] . '</span> - ' . $slogan;
                }
                /*
                $tabTextIntroProfil = [
                    '',
                    '<span class="title_bar">PHILOSOPHE</span> - Le plaisir',
                    '<span class="title_bar">NOVATEUR</span> - Le plaisir',
                    '<span class="title_bar">ANIMATEUR</span> - bouger',
                    '<span class="title_bar">GESTIONNAIRE</span> - Le plaisir',
                    '<span class="title_bar">STRATEGE</span> - Le plaisir',
                    '<span class="title_bar">COMPETITEUR</span> - Le plaisir',
                    '<span class="title_bar">PARTICIPATIF</span> - Le plaisir',
                    '<span class="title_bar">SOLIDAIRE </span>- Le plaisir',
                ];
                */

                foreach ($tabScore as $idProf => $score) {
                    if ($score != 0) {
                        renderBarGraph($tabScore, $idProf, $tabTextIntroProfil[$idProf], $nbrQ);
                    }
                }

                ?>
            </div>
        </div>
        <?php


        renderCardsToLight($tabScore, 0, 2, 'Motivations les plus fortes', 'Découvre maintenant ce que signifie chaque profil!', $bdd);
        renderCardsToLight($tabScore, 3, 4, 'Motivations modérées', 'Découvre maintenant ce que signifie chaque profil!', $bdd);
        renderCardsToLight($tabScore, 5, 5, 'Motivations faibles', 'Découvre maintenant ce que signifie chaque profil!', $bdd);

        // var_dump($tabScore);
        ?>
    </div>
    <div class="div_detail_perso non print_ok">
        <?php
        $p = 0;
        foreach ($tabScore as $key => $score) {
            if ($p < 3) {
                $_SESSION['detail_profil'] = $key;
                include ('./detail-profil.php');
            }
            $p++;
        }

        /*
        $_SESSION['detail_profil'] = $tabScore[1];
        include('./detail-profil.php');
        $_SESSION['detail_profil'] = $tabScore[2];
        include('./detail-profil.php');
        */
        ?>
 
    </div>
    <script src="../../assets/js/survey/result.js"></script>
    <link rel="stylesheet" type="text/css" media="print" href="../../assets/css/print.css" />

    <button onclick="genererPDF()">Générer PDF</button>

<script>
  function genererPDF() {
    // Créez une instance de jsPDF
    var doc = new jsPDF();

    // Ajoutez la page actuelle au document PDF
    doc.addHTML(document.body, function(page) {
      // Une fois la page ajoutée, convertissez-la en PDF
      doc.output('page_imprimee.pdf');
    });
  }
</script>
</body>