<?php include("../../bdd/connexion_bdd.php");


?>
<!DOCTYPE html>

<head>
    <meta charset="utf-8" />
    <title> DEEP TEST </title>
    <link rel="shortcut icon" href="../img/imgGlobal/pixy.ico">
    <link rel="stylesheet" type="text/css" href="../../assets/css/profil.css" />
    <link rel="stylesheet" type="text/css" href="../../assets/css/resultat.css" />
    <link rel="stylesheet" type="text/css" media="print" href="../css/resultat-print.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>
    <script src="sharer.min.js"></script>
</head>

<body>
    <?php include('../navbar.php');
    include('./components/result.php');

    ?>


    <?php

    $tab_nom_profil = ['PHILOSOPHE', 'ANIMATEUR', 'COMPETITEUR', 'GESTIONNAIRE', 'NOVATEUR', 'STRATEGE', 'PARTICIPATIF', 'SOLIDAIRE'];
    $tab_nom_img = ['FONDPHILOSOPHE', 'FONDANIMATEUR', 'FONDCOMPETITEUR', 'FONDGESTIONNAIRE', 'FONDNOVATEUR', 'FONDSTRATEGE', 'FONDPARTICIPATIF', 'FONDSOLIDAIRE'];

    //VAPRIBALE NOMBRE DE POINT OBTENU (SUR 24)
    $pt_PHILOSOPHE = 0;
    $pt_ANIMATEUR = 0;
    $pt_COMPETITEUR = 0;
    $pt_GESTIONNAIRE = 0;
    $pt_NOVATEUR = 0;
    $pt_STRATEGE = 0;
    $pt_PARTICIPATIF = 0;
    $pt_SOLIDAIRE = 0;


    $rep_to_explode = $_SESSION['result'];
    // $rep_to_explode = $_GET['rep_precedente'] . $_GET['rep_to_explode'];



    $tab_rep_par_Q = explode(';', $rep_to_explode);
    for ($q = 0; $q < count($tab_rep_par_Q); $q++) {
        $tab_rep_Q = explode('/', $tab_rep_par_Q[$q]);
        for ($p = 0; $p < count($tab_rep_Q); $p++) {
            switch ($tab_rep_Q[$p]) {
                case 1:
                    $pt_PHILOSOPHE++;
                    break;
                case 2:
                    $pt_NOVATEUR++;
                    break;
                case 3:
                    $pt_ANIMATEUR++;
                    break;
                case 4:
                    $pt_GESTIONNAIRE++;
                    break;
                case 5:
                    $pt_STRATEGE++;
                    break;
                case 6:
                    $pt_COMPETITEUR++;
                    break;
                case 7:
                    $pt_PARTICIPATIF++;
                    break;
                case 8:
                    $pt_SOLIDAIRE++;
                    break;
            }
        }
    }


    ?>
    <div class="div_body">

        <input type="text" id="resultat_chart" value="<?php echo $rep_to_explode; ?>" class="none" />
        <h2>Voici vos personnalités dominantes !</h2>

        <canvas id="myChart"></canvas>
        

        <?php

        $tabScore = [$pt_PHILOSOPHE, $pt_NOVATEUR,  $pt_ANIMATEUR, $pt_GESTIONNAIRE, $pt_STRATEGE, $pt_COMPETITEUR, $pt_PARTICIPATIF, $pt_SOLIDAIRE];
        // var_dump($tabScore);
        arsort($tabScore);
        //  var_dump($tabScore);
        $tab_nomprofil = ['philosophe', 'novateur', 'animateur', 'gestionnaire', 'statege', 'competiteur', 'participatif', 'solidaire'];

        $x = 0;
        foreach ($tabScore as $key => $score) {


            if ($x < 2) {


                switch ($key) {
                    case 0:
                        renderPhilosopheE();
                        break;
                    case  1:
                        renderNovateurE();
                        break;
                    case 2:
                        renderAnimateurE();
                        break;
                    case 3:
                        renderGestionnaireE();
                        break;
                    case  4:
                        renderStrategeE();
                        break;
                    case 5:
                        renderCompetiteurE();
                        break;
                    case 6:
                        renderParticipatifE();
                        break;
                    case 7:
                        renderSolidaireE();
                        break;


                    default:
                        echo "Your favorite color is neither red, blue, nor green!";
                }
            }

            $x++;
        }

        ?>

        <h3 class="print-none">Bravo, découvre maintenant ce que signifie chaque profil! </h3>
        <div class="div_btn_profil flex-center print-none">
            <a href="liste-profil.php">
                <div class="btn_profil">VOIR LES PROFILS DETAILLES</div>
            </a>
        </div>
        <div class="flex-center print-none">
            <a href="../intro/intro-quizz.php">
                <div class="btn_profil btn_telecharger none"> TELECHARGER PIXY </div>
            </a>
        </div>
        <div class="print-none" id="btn_share">
            <h3>PARTAGE TES RESULTATS</h3>
        </div>
        <div class="flex-center div_btn_share flex-row print-none">

            <!-- AddToAny BEGIN -->
            <?php $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

            ?>
            <div class="a2a_kit a2a_kit_size_32 a2a_default_style" id="btn_shares" data-a2a-title="RESULTAT TEST DE PERSONNALITE">
                <a class="a2a_dd" href="<?php echo $actual_link; ?>"></a>
                <a class="a2a_button_facebook"></a>
                <a class="a2a_button_twitter"></a>
                <a class="a2a_button_email"></a>
                <a class="a2a_button_whatsapp"></a>
            </div>
            <script>
                var a2a_config = a2a_config || {};
                a2a_config.locale = "fr";
            </script>
            <script async src="https://static.addtoany.com/menu/page.js"></script>
            <!-- AddToAny END -->
        </div>

        <div class="flex-row flex-right print-none">
            <img src="../img/imgGlobal/neurolead-logo.png" class="img_canape none" />
            <div class="espace_intro none"></div>
            <a href="../intro/intro-quizz.php">

                <div class="btn_profil btn_test">REFAIRE LE TEST </div>
            </a>
        </div>


    </div>
    <script src="../../assets/js/survey/graphique-resultat.js"></script>
  
</body>