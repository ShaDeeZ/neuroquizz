<?php
include('../../bdd/connexion_bdd.php');
verifAcces($_SESSION);
include('../../api/survey/index.php');
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
    <form method="post" action="">
        <input type="password" name="mdp" placeholder="mdp" />
        <button type="submit"> envoyer </button>
    </form>
    <?php
    $mdp = "1383d449e269130984fe9967cf36fdf89288e6ef";


    if (isset($_POST['mdp'])  && $_POST['mdp'] == $mdp) {
        $_SESSION['mdp'] = "ok";
    }
    if (isset($_SESSION['mdp'])  && $_SESSION['mdp'] == "ok") {


    ?>


        <div class="div_body">
            <div class="div_left">
                <form method="post" action="#">
                    <input type="text" name="search" class="input_search" />
                    <div class="flex-col div_select_question">

                        <?php
                        function renderCaseQuestion($numero)
                        {
                        ?>
                            <div class="div_btn_question question_selected" data-numq="<?= $numero; ?>" onclick="clickBtnQuestion(event)">
                                <div class=" btn_type event-none"><?= $numero; ?>
                                </div>

                                <input type="checkbox" class="none event-none ipt_question question_selected" value="<?= $numero; ?>" name="questions[]" checked />
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

                    <div class="flex-row">
                        <?php
                        $tabSurvey =  getAllActiveSurvey($bdd);
                        foreach ($tabSurvey as $survey) {
                        ?>
                            <label for="ipt_adult">
                                <div class="btn_type"><?= $survey['name_survey']; ?></div>
                            </label>
                            <input type="checkbox" value="<?= $survey['id_survey']; ?>" name="type_test[]" id="ipt_adult" checked />
                        <?php
                        }
                        ?>

                    </div>
                    <br>
                    <div class="flex-row">
                        <input type="date" name="date_debut" class="ipt-date" />
                        <input type="date" name="date_fin" class="ipt-date" />
                    </div>
                    <button type="submit" id="btn-search"> ENVOYER </button>
                </form>
            </div>

            <div class="div_right">
                <div class="div_contain_chart">
                    <canvas id="myChart"></canvas>
                </div>
                <?php

                $search = "";
                if (isset($_POST['type_test'])) {
                    $str_type = implode('","', $_POST['type_test']);
                    $str_question = implode('/', $_POST['questions']) . '/';
                    $timeDebut = ($_POST['date_debut'] != '') ? strtotime($_POST['date_debut']) : 0;
                    $timeFin = ($_POST['date_fin'] != '') ? strtotime($_POST['date_fin']) : 2660299127;
                    $search = htmlspecialchars($_POST['search']);
                } else {
                    $str_type  = '5","6';
                    $str_question = "1/2/3/4/5/6/7/8/9/10/11/12";
                    $timeDebut = 0;
                    $timeFin =  2660299127;
                }


                // on traite la recherche 

                $multipleSearch = 0;
                if (strstr($search, ',')) {
                    $multipleSearch = 1;
                    $search  = str_replace(',', '","', $search);
                } else {
                }



                $_SESSION['tabScoreTotal'] = [0, 0, 0, 0, 0, 0, 0, 0, 0];
                function addPoint($strResult, $profil, $numeroProfil, $numQ, $strQ)
                {
                    if (strstr($strResult, $numeroProfil)) {
                        $profil++;
                        if (strstr($strQ, strval($numQ) . "/")) {
                            $_SESSION['tabScoreTotal'][$numeroProfil]++;
                        }
                    }

                    return $profil;
                }

                function renderCaseProfil($point, $numero, $nom)
                {
                ?>
                    <div class="div_profil_detail <?= $nom; ?>" data-numero="<?= $numero; ?>" data-point="<?= $point; ?>"> <?= $point . ' points ' . $nom; ?> </div>

                <?php
                }





                echo '<div class="flex-row flex-wrap div_all_result"> ';

                if ($multipleSearch == 1) {
                    $req = $bdd->query('SELECT * FROM result_test WHERE (mail_test IN ("' . $search . '") OR  code IN ("' . $search . '")   )AND type_test IN ("' . $str_type . '") AND date_test > ' . $timeDebut . ' AND date_test < ' . $timeFin . ' ORDER BY id_result DESC LIMIT 1200 ');
                } else {
                    $req = $bdd->query('SELECT * FROM result_test WHERE (mail_test LIKE "%' . $search . '%" OR  code LIKE "%' . $search . '%" )AND type_test IN ("' . $str_type . '") AND date_test > ' . $timeDebut . ' AND date_test < ' . $timeFin . ' ORDER BY id_result DESC LIMIT 1200 ');
                }
                // var_dump($req);
                foreach ($req as $test) {
                    // var_dump($test);
                ?>
                    <div class="div_resultat">
                        <div class="flex-row">
                            <p class="p_detail_result p_mail"> <?= $test["mail_test"]; ?> </p>
                            <p class="p_detail_result  p_date"> <?= date('d-m-Y', $test['date_test']); ?> </p>
                        </div>
                        <div class="div_detail_result flex-col">

                            <?php
                            $explodeResult1 = explode(';', ltrim($test['result'], ";"));

                            $ptAnimateur = 0;
                            $ptPhilosophe = 0;
                            $ptNovateur = 0;
                            $ptGestionnaire = 0;
                            $ptStratege = 0;
                            $ptCompetiteur = 0;
                            $ptParticipatif = 0;
                            $ptSolidaire = 0;



                            echo '<div class="flex-row"><div class="div_rep_question">';
                            $x = 0;

                            foreach ($explodeResult1 as $result1) {
                                $x++;
                                echo '<p class="p_res"> question : ' . $x . ' : ' . $result1 . '</p>';
                                $ptAnimateur = addPoint($result1, $ptAnimateur, "3", $x, $str_question);
                                $ptPhilosophe = addPoint($result1, $ptPhilosophe, "1", $x, $str_question);
                                $ptNovateur = addPoint($result1, $ptNovateur, "2", $x, $str_question);
                                $ptGestionnaire = addPoint($result1, $ptGestionnaire, "4", $x, $str_question);
                                $ptStratege = addPoint($result1, $ptStratege, "5", $x, $str_question);
                                $ptCompetiteur = addPoint($result1, $ptCompetiteur, "6", $x, $str_question);
                                $ptParticipatif = addPoint($result1, $ptParticipatif, "7", $x, $str_question);
                                $ptSolidaire = addPoint($result1, $ptSolidaire, "8", $x, $str_question);
                            }


                            $tabProfil = [$ptPhilosophe, $ptNovateur, $ptAnimateur, $ptGestionnaire, $ptStratege, $ptCompetiteur, $ptParticipatif, $ptSolidaire];
                            $tabNomProfil = ["Philosophe", "Novateur", "Animateur", "Gestionnaire", "Stratege", "Competiteur", "Participatif", "Solidaire"];


                            // var_dump($tabProfil);
                            $x = 0;
                            $y = 0;
                            echo '</div>';
                            echo '<div class="div_profils">';
                            foreach ($tabProfil as $profil) {
                                $y++;
                                renderCaseProfil($profil, $y, $tabNomProfil[$x],);
                                $x++;
                            }
                            ?> <p class="p_detail_result  p_code"> <?= $test['code']; ?> </p>

                            <?php


                            echo  '</div></div>';

                            ?>
                            <form method="post" action="./delete-test.php">
                                <input type="text" class="none" name="idTest" value="<?= $test['id_result']; ?> " />
                                <button type="submt"> Supprimer le test </button>
                            </form>
                        </div>

                    </div>

                <?php

                }

                echo '</div>';


                // var_dump($_SESSION['tabScoreTotal']);

                $strScoreTotal = implode('/', $_SESSION['tabScoreTotal']);
                echo '<input type="text" id="scoreTotal" class="none" value="' . $strScoreTotal . '" />';
                if (isset($_POST['questions'])) {
                    $str_questions = implode('/', $_POST['questions']);
                } else {
                    $str_questions = "1/2/3/4/5/6/7/8/9/10/11/12";
                }
                echo '<input type="text" id="inputActiveQ" class="none" value="' . htmlspecialchars($str_questions) . '" />';


                ?>

            </div>

            <script src="./analytics.js"></script>
</body>

<?php } ?>

</html>