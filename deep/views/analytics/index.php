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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/liste-profil.css" />
    <link rel="stylesheet" type="text/css" href="./analytics.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Caveat&family=Nunito:wght@300&display=swap" rel="stylesheet">
    <title>Document</title>
</head>

<body>
    <form method="post" class="none" action="">
        <input type="password" name="mdp" placeholder="mdp" />
        <button type="submit"> envoyer </button>
    </form>
    <?php



        ?>
        <div class="div_body">
            <div class="div_left">
                <form method="post" action="#">
                <h1 class="h1_analytics"> Filtres   <a href="./create-excel.php" class="a_excel"> excel </a> </h1>
                    <h2 class="h2_analytics"> Rechercher par code ou par mail </h2>
                    <input type="text" name="searchAnalytics" placeholder="Recherche.." class="input_search_analytics" />
                    <h2 class="h2_analytics"> Filtrer par question </h2>
                    <div class="flex-col div_select_question">

                        <?php
                        function renderCaseQuestion($numero)
                        {
                            ?>
                            <div class="div_btn_question question_selected" data-numq="<?= $numero; ?>"
                                onclick="clickBtnQuestion(event)">
                                <div class=" btn_type event-none">
                                    <?= $numero; ?>
                                </div>

                                <input type="checkbox" class="none event-none ipt_question question_selected"
                                    value="<?= $numero; ?>" name="questions[]" checked />
                            </div>
                            <?php
                        }
                        ?>
                        <div class="flex-row">
                            <?php renderCaseQuestion(1); ?>
                            <?php renderCaseQuestion(2); ?>
                            <?php renderCaseQuestion(3); ?>
                            <?php renderCaseQuestion(4); ?>
                        </div>
                        <div class="flex-row">
                            <?php renderCaseQuestion(5); ?>
                            <?php renderCaseQuestion(6); ?>
                            <?php renderCaseQuestion(7); ?>
                            <?php renderCaseQuestion(8); ?>
                        </div>
                        <div class="flex-row">
                            <?php renderCaseQuestion(9); ?>
                            <?php renderCaseQuestion(10); ?>
                            <?php renderCaseQuestion(11); ?>
                            <?php renderCaseQuestion(12); ?>
                        </div>
                    </div>
                    <h2 class="h2_analytics"> Filtrer par enquête </h2>
                    <div class="flex-row flex-wrap">
                        <?php
                        $tabSurvey = getAllSurvey($bdd);
                        foreach ($tabSurvey as $survey) {
                            ?>
                            <label for="ipt_adult">
                                <div class="btn_type">
                                    <?= $survey['name_survey']; ?>
                                </div>
                            </label>
                            <input type="checkbox" value="<?= $survey['id_survey']; ?>" name="type_test[]" id="ipt_adult"
                                checked />
                            <?php
                        }
                        ?>

                    </div>
                    <br>
                    <h2 class="h2_analytics"> Filtrer par date</h2>
                    <div class="flex-row">
                        <input type="date" value="2020-01-01" name="date_debut" class="ipt-date" />
                        <input type="date" value="<?= date('Y-m-d', time());?>" name="date_fin" class="ipt-date" />
                    </div>
                    <button type="submit" class="btn-orange" id="btn-search"> Appliquer les filtres </button>
                </form>
            </div>

            <div class="div_right">
                <div class="div_contain_chart">
                    <canvas id="myChart"></canvas>
                </div>
                <?php
                //  var_dump($_POST);
                $search = "";
                if (isset($_POST['type_test'])) {
                    $str_type = implode('","', $_POST['type_test']);
                    $str_question = implode('/', $_POST['questions']) . '/';
                    $timeDebut = ($_POST['date_debut'] != '') ? strtotime($_POST['date_debut']) : 0;
                    $timeFin = ($_POST['date_fin'] != '') ? strtotime($_POST['date_fin']) : 2660299127;
                    $search = htmlspecialchars($_POST['searchAnalytics']);
                } else {
                    $str_type = '5","6';
                    $str_question = "1/2/3/4/5/6/7/8/9/10/11/12";
                    $timeDebut = 0;
                    $timeFin = 2660299127;
                }


                // on traite la recherche 
            
                $multipleSearch = 0;
                if (strstr($search, ',')) {
                    $multipleSearch = 1;
                    $search = str_replace(',', '","', $search);
                } else {
                }



                function renderCaseProfil($point, $numero, $nom)
                {

                    ?>
                    <div class="div_profil_detail <?= $nom; ?>" data-numero="<?= $numero; ?>" data-point="<?= $point; ?>">
                        <?= $point . ' points ' . $nom; ?>
                    </div>

                    <?php
                }

                echo '<div class="flex-row flex-wrap div_all_result"> ';
                $tabProfils = getAllPersonality($bdd);
                $tabIdProfils = array_column($tabProfils, 'id_perso');

                if (isset($_POST['questions'])) {
                    $str_questions = implode('/', $_POST['questions']);
                    $str_req_questions = implode( '","', $_POST['questions']);
                } else {
                    $str_questions = "1/2/3/4/5/6/7/8/9/10/11/12";
                }
                $req = $bdd->query('SELECT * FROM user_answer as a
                LEFT JOIN users as b ON a.codeAcces = b.code_acces
                 WHERE a.id_survey IN ("' . $str_type . '")
                 AND(b.mail LIKE "%' . $search . '%" OR  b.code_acces LIKE "%' . $search . '%" )
                AND a.num_q IN ("'.$str_req_questions.'")
                 AND time_reponse > ' . $timeDebut . ' 
                AND time_reponse < ' . $timeFin . ' ORDER BY a.codeAcces, a.num_q LIMIT 800 ');

                $tabReponses = $req->fetchAll();
                // var_dump($tabReponses);
                $tabCodes = array_column($tabReponses, 'codeAcces');
                $tabUniqueCode = array_unique($tabCodes);


                $_SESSION['tabScoreTotal'] = [];

                foreach ($tabProfils as $profil) {

                    $_SESSION['tabScoreTotal'][$profil['id_perso']] = 0;

                }

                foreach ($tabUniqueCode as $code) {
                    $tabKeyCode = array_keys($tabCodes, $code);
                    ?>

                    <div class="div_resultat">
                        <div class="flex-row">
                            <p class="p_detail_result p_mail">
                                <?= $code; ?>
                            </p>
                            <p class="p_detail_result p_mail">
                                <?= $tabReponses[$tabKeyCode[0]]['mail']; ?>
                            </p>
                            <p class="p_detail_result  p_date">
                                <?= date('d-m-Y', $tabReponses[$tabKeyCode[0]]['time_reponse']); ?>
                            </p>
                        </div>
                        <div class="div_detail_result flex-col">

                            <?php

                            $tabPointProfil = [];

                            $tabNomProfil = [];
                            foreach ($tabProfils as $profil) {
                                $tabPointProfil[$profil['id_perso']] = 0;

                                $tabNomProfil[] = $profil['nom'];
                            }

                            echo '<div class="flex-row"><div class="div_rep_question">';

                            $x = 0;
                            foreach ($tabKeyCode as $keyAnswer) {
                                $x++;
                                $answer = $tabReponses[$keyAnswer];
                                // var_dump($answer);
                                foreach ($tabIdProfils as $idProfil) {
                                    if (strstr('/' . $answer['reponses'], '/' . $idProfil . '/')) {
                                        //  var_dump(strstr('/' . $answer['reponses'], '/' . $idProfil . '/'));
                                        $tabPointProfil[$idProfil]++;
                                        $_SESSION['tabScoreTotal'][$idProfil]++;
                                    }
                                }
                                // var_dump($_SESSION['tabScoreTotal'], $tabPointProfil);
                                //var_dump($answer);
                                $tab_rep = explode('/', $answer['reponses']);
                                $str_rep = '';
                                foreach ($tab_rep as $idProfil) {
                                    $idxPr = array_search($idProfil, $tabIdProfils);
                                    if ($idxPr !== false) {
                                        $str_rep = $str_rep . ' - ' . $tabProfils[$idxPr]['nom'];
                                    }
                                }
                                echo '<p class"p_point_q"> question : ' . $answer['num_q'] . ' --> <span class="rep_q">' . $str_rep . '</span></p>';
                            }

                            // var_dump( $_SESSION['tabScoreTotal']);
                            $x = 0;
                            $y = 0;
                            echo '</div>';
                            echo '<div class="div_profils">';
                            foreach ($tabPointProfil as $profil) {
                                $y++;
                                renderCaseProfil($profil, $y, $tabNomProfil[$x]);
                                $x++;
                            }

                            echo '</div></div>';
                            ?>
                            <form method="post" action="./delete-test.php">
                                <input type="text" class="none" name="code" value="<?= $code; ?>" />
                                <button type="submt"> Supprimer le test </button>
                            </form>
                        </div>

                    </div>
                    <?php
                }
                echo '</div>';

                $strScoreTotal = implode('/', $_SESSION['tabScoreTotal']);
                echo '<input type="text" id="scoreTotal" class="none" value="' . $strScoreTotal . '" />';

                echo '<input type="text" id="inputActiveQ" class="none" value="' . htmlspecialchars($str_questions) . '" />';


                ?>

            </div>
           
            <script src="./analytics.js"></script>
    </body>

</html>