<?php 
include("../../bdd/connexion_bdd.php");
include('../../api/survey/index.php');
include('../../api/personality/index.php');

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
    <?php
     // include('../navbar.php');
     include('./components/new-result.php');

    ?>


    <?php

    $tabProfils = getAllPersonality($bdd);
    $tabIdProfils = array_column($tabProfils, 'id_perso');

    $tabScore = [];
    foreach($tabProfils as $profil){
        $tabScore[$profil['id_perso']] = 0;
    }   

   
    $rep_to_explode = $_SESSION['result'];
 

    $tabAnswers = getAnswsersByCodeAndSurvey($_SESSION['code'], $_SESSION['survey_neurotest'], $bdd);
    //var_dump($tabAnswers);
    foreach($tabAnswers as $answer){
        foreach($tabIdProfils as $idProfil){
            if(strstr('/'.$answer['reponses'],'/'.$idProfil.'/')){
                $tabScore[$idProfil]++;
            }
        }
    }
   


    ?>
    <div class="div_body">

        <input type="text" id="resultat_chart" value="<?php echo $rep_to_explode; ?>" class="none" />
        <h2>Voici vos personnalités dominantes !</h2>

        <canvas id="myChart"></canvas>


        <?php

        arsort($tabScore);
    
        $x = 0;
        $nbrProfilToRender = 2;
       // var_dump($tabScore);
        foreach ($tabScore as $key => $score) {
            if ($x < $nbrProfilToRender) {
                renderProfil($key, $bdd);
                $x++;  
            }
            
          
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