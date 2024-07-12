<?php session_start(); ?>
<!DOCTYPE html>

<head>
    <meta charset="utf-8" />
    <title> QUESTION 1 </title>
    <?php include('../questions/header.php'); ?>
    <link rel="stylesheet" type="text/css" href="../css/question.css" />
</head>

<body onload="loader()">

    <div class="div_body">
        <?php include('../navbar.php'); ?>
        <div class="POPUP" id="div_popup">
            <div class="card_popup">
                <p class="p_popup"> CHOISSISSEZ <br> <b class="b_popup">2 IMAGES </b> </br> PAR QUESTION </p>
                <div class="btn_popup" id="btn_popup">COMMENCER LE TEST </div>
            </div>
        </div>
        <nav class="nav"> </nav>
        <h2>Question 1<br> quand je mange, je préfère quand c’est…</h2>
        <div class="div_all_img">
            <div class="flex-row flex-wrap">
                <div class="flex-row">
                    <div class="card_img flex-col">
                        <img src="../img/imgQ1A/PHILOSOPOHE.jpg" data-profil="1" class="img_question" />
                        <p class="p_response"><b>Simple et gourmand</b></p>
                    </div>
                    <div class="card_img flex-col">
                        <img src="../img/imgQ1A/NOVATEUR.jpg" data-profil="2" class="img_question" />
                        <p class="p_response"><b>Naturel et équilibré </b></p>
                    </div>

                </div>
                <div class="flex-row">
                    <div class="card_img flex-col">
                        <img src="../img/imgQ1A/ANIMATEUR.jpg" data-profil="3" class="img_question" />
                        <p class="p_response"><b>Rapide et facile </b></p>
                    </div>
                    <div class="card_img flex-col">
                        <img src="../img/imgQ1A/GESTIONNAIRE.jpg" data-profil="4" class="img_question" />
                        <p class="p_response"><b>Sain et pas trop cher</b></p>
                    </div>
                </div>
            </div>
            <div class="flex-row flex-wrap">
                <div class="flex-row">
                    <div class="card_img flex-col">
                        <img src="../img/imgQ1A/STRATEGE.jpg" data-profil="5" class="img_question" />
                        <p class="p_response"><b>Raffiné et à plusieurs</b></p>
                    </div>
                    <div class="card_img flex-col">
                        <img src="../img/imgQ1A/COMPETITEUR.jpg" data-profil="6" class="img_question" />
                        <p class="p_response"><b>Énergétique et efficace</b></p>
                    </div>
                </div>
                <div class="flex-row">
                    <div class="card_img flex-col">
                        <img src="../img/imgQ1A/PARTICIPATIF.jpg" data-profil="7" class="img_question" />
                        <p class="p_response"><b>Convivial et à partager</b></p>
                    </div>
                    <div class="card_img flex-col">
                        <img src="../img/imgQ1A/SOLIDAIRE.jpg" data-profil="8" class="img_question" />
                        <p class="p_response"><b>Naturel et basique</b> </p>
                    </div>
                </div>
            </div>
            <div class="div_barre_fleche flex-row">
                <div class="div_fleche">

                </div>
                <div class="div_space_fleche"></div>
                <div class="div_fleche flex-row">
                    <p class="p_consigne none" id="p_consigne">CHOISIS 2 IMAGES !! </p>
                    <img src="../img/imgGlobal/next-red.png" id="fleche_next_red" />
                    <label for="btn_form_rep">
                        <img src="../img/imgGlobal/next.png" id="fleche_next" class="none" />
                    </label>
                </div>
            </div>
        </div>
        <form method="POST" action="../questions-A/question-2-A.php">
            <?php
            if (isset($_POST['rep_precedente'])) {
                $rep_pre = htmlspecialchars($_POST['rep_precedente']) . ';' . $_POST['rep_to_explode'];
            } else {
                $rep_pre = '';
            }
            ?>
            <input type="input_rep_precedente" name="rep_precedente" id="input_rep_pre"
                value="<?php echo $rep_pre; ?>" />
            <input type="text" id="input_rep" name="rep_to_explode" />
            <button type="submit" id="btn_form_rep">GO</button>
        </form>
    </div>

    <script src="../question.js"></script>
    <script src="../js/popup-consigne-question.js"></script>
</body>