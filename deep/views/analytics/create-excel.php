<?php
include('../../bdd/connexion_bdd.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include('../header.php');
    include('../../api/survey/index.php');
    include('../../api/personality/index.php');

    ?>

    <title>Document</title>
</head>

<body>
    <div class="div_right flex-col flex-center">
        <div class="div_all_codes">
            <?php

            //  1.  on formatte les données pour excel 
            //(on fait un tableau ou la première ligne est le titre des colonnes et chaque ligne qui suit sont les données formatées comme la première)
            
            $tabProfils = getAllPersonality($bdd);
            $tabIdProfils = array_column($tabProfils, 'id_perso');

            $tabReponses = getAllAnswers($bdd);
            $tab_info_excel = [
                ['numeroLigne', 'codeAcces', 'mail', 'heureReponse', 'idEnquete', 'Q1', 'Q2', 'Q3', 'Q4', 'Q5', 'Q6', 'Q7', 'Q8', 'Q9', 'Q10', 'Q11', 'Q12', 'Q13'],
                // push ici
            ];
            $tabCode = array_column($tabReponses, 'codeAcces');
            $tabUniqueCode = array_unique($tabCode);


            foreach ($tabUniqueCode as $uniqueCode) {
                $tabKeysReponses = array_keys($tabCode, $uniqueCode);
                $tab_one_ligne = [
                    '1',
                    $tabReponses[$tabKeysReponses[0]]['codeAcces'],
                    $tabReponses[$tabKeysReponses[0]]['mail'],
                    $tabReponses[$tabKeysReponses[0]]['time_reponse'],
                    $tabReponses[$tabKeysReponses[0]]['id_survey'],
                ];

         
                for ($x = 1; $x < 14; $x++) {
                    $answer = '';
                    foreach ($tabKeysReponses as $keyReponse) {
                        if ($tabReponses[$keyReponse]['num_q'] == $x) {
                            $str_answer = '';
                            $tab_answer = explode('/', $tabReponses[$keyReponse]['reponses']);
                            foreach($tab_answer as $idProfil){
                                $idxPro = array_search($idProfil, $tabIdProfils);
                                if($idxPro !== false){
                                    $str_answer .= $tabProfils[$idxPro]['nom'].'-';
                                }
                            }
                            $answer = removeLast($str_answer);
                        }
                    }
                    $tab_one_ligne[4 + $x] = $answer;
                }
                array_push($tab_info_excel, $tab_one_ligne);
            }
            

            // 2. on génère un excel apd du tableau de données formatté dans l'étape 1 ($tab_info_excel dans mon code)
            $filename = '../../assets/docs/participation.csv';
            $file = fopen($filename, 'w');
            for ($x = 0; $x < count($tab_info_excel); $x++) {
                $buff = implode(';', $tab_info_excel[$x]);
                fwrite($file, utf8_decode($buff) . PHP_EOL);
            }
            fclose($file);
            ?>
            <a href="<?= $filename ?>" id="btn_csv" download>Télécharger le excel </a>
            
        </div>



</body>

</html>