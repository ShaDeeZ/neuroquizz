<?php
function addSurvey($name, $nbrQuestion, $bdd)
{
    $req = $bdd->prepare('INSERT INTO survey (name_survey, nbr_question, visible) VALUES (?,?,?)');
    $req->execute([
        $name,
        $nbrQuestion,
        0
    ]);

    $tabPersonality = getAllPersonality($bdd);
    $nbr_rep = count($tabPersonality);

    $req_id = $bdd->query('SELECT id_survey FROM survey ORDER BY id_survey DESC LIMIT 1 ');
    $data = $req_id->fetch();
    $idSurey = $data['id_survey'];

    for ($x = 1; $x < $nbrQuestion + 1; $x++) {

        $req = $bdd->prepare('INSERT INTO questions (name_fr, id_survey, num_q) VALUES (?,?,?)');
        $req->execute([
            'Titre question',
            $idSurey,
            $x
        ]);

        for ($i = 0; $i < $nbr_rep; $i++) {

            $detailPerso = $tabPersonality[$i];
            $req = $bdd->prepare('INSERT INTO title_reponse (name_fr, img, id_q, id_perso, num_res, id_survey) VALUES (?,?,?,?,?,?)');
            $req->execute([
                'Titre reponse',
                'img/res/btn-add.png',
                $x,
                $detailPerso['id_perso'],
                $i + 1,
                $idSurey

            ]);
        }
    }
}

function editImageReponse($urlImg, $num_q, $num_res, $id_survey, $bdd)
{
    $req = $bdd->prepare('UPDATE title_reponse SET img = ? WHERE id_q = ? AND num_res = ? and id_survey = ?');
    $req->execute([
        $urlImg,
        $num_q,
        $num_res,
        $id_survey
    ]);
}

function editTextReponse($text, $id_survey, $num_q, $num_res, $bdd)
{
    $req = $bdd->prepare('UPDATE title_reponse SET name_fr = ? WHERE id_q = ? AND num_res = ? and id_survey = ?');
    $req->execute([
        $text,
        $num_q,
        $num_res,
        $id_survey
    ]);
}


function editTextQuestion($text, $id_question, $bdd)
{
    $req = $bdd->prepare('UPDATE questions SET name_fr = ? WHERE id_question = ?');
    $req->execute([
        $text,
        $id_question,
    ]);
}


function editPersoReponse($id_perso, $id_survey, $num_q, $num_res, $bdd)
{
    $req = $bdd->prepare('UPDATE title_reponse SET id_perso = ? WHERE id_q = ? AND num_res = ? and id_survey = ?');
    $req->execute([
        $id_perso,
        $num_q,
        $num_res,
        $id_survey
    ]);
}

function getAllSurvey($bdd)
{
    $req = $bdd->query('SELECT * FROM survey');
    return $req->fetchAll();
}

function getAllActiveSurvey($bdd)
{
    $req = $bdd->query('SELECT * FROM survey WHERE visible = 1');
    return $req->fetchAll();
}

function getSurveyById($id_survey, $bdd)
{
    $req = $bdd->prepare('SELECT * FROM survey WHERE id_survey = ?');
    $req->execute([
        $id_survey
    ]);
    return $req->fetch();
}


function getQuestionsBySurvey($id_survey, $bdd)
{
    $req = $bdd->prepare('SELECT * FROM questions WHERE id_survey = ?');
    $req->execute([
        $id_survey
    ]);
    return $req->fetchAll();
}

function getTitleReponseByQuestion($id_q, $id_survey, $bdd)
{
    $req = $bdd->prepare('SELECT * FROM title_reponse WHERE id_q = ? AND id_survey = ?');
    $req->execute([
        $id_q, $id_survey
    ]);
    return $req->fetchAll();
}


function getTitleReponseByQuestionRandom($id_q, $id_survey, $bdd)
{
    $req = $bdd->prepare('SELECT * FROM title_reponse WHERE id_q = ? AND id_survey = ? ORDER BY RAND()');
    $req->execute([
        $id_q, $id_survey
    ]);
    return $req->fetchAll();
}


function addReponseByQuestion($res, $question, $survey, $codeAcces, $time, $bdd)
{

    $del = $bdd->prepare('DELETE FROM user_answer WHERE num_q = ? AND id_survey = ? AND codeAcces = ?');
    $del->execute([
        $question,
        $survey,
        $codeAcces
    ]);
    $req = $bdd->prepare('INSERT INTO user_answer (reponses, num_q, id_survey, codeAcces, time_reponse) VALUES (?,?,?,?,?)');
    $req->execute([
        $res,
        $question,
        $survey,
        $codeAcces,
        $time
    ]);
}

function getAnswsersByCodeAndSurvey($codeAcces, $survey, $bdd)
{
    $req = $bdd->prepare('SELECT * FROM user_answer WHERE id_survey = ? AND codeAcces = ? ORDER BY num_q');
    $req->execute([
        $survey,
        $codeAcces
    ]);
    return $req->fetchAll();
}


function getAllAnswers($bdd)
{
    $req = $bdd->query('SELECT * FROM user_answer as a LEFT JOIN users as b ON a.codeAcces = b.code_acces ORDER BY a.id_answer_user DESC LIMIT 10000');
    return $req->fetchAll();
}

function addResultSurvey($codeAcces, $survey, $bdd)
{
    // on s'asure que les donées sont bien formatées (bon nombre de question/reponses)
    $detailSurvey = getSurveyById($survey, $bdd);
    $nbrQ = $detailSurvey['nbr_question'];
    $tabAnswers = getAnswsersByCodeAndSurvey($codeAcces, $survey, $bdd);
    if ($nbrQ != count($tabAnswers)) {
        echo 'le nombre de réponses ne correspond pas au nombre de question';
        die;
    }

    // on crée la string pour insert dans les résultats
    $str_res = '';
    foreach ($tabAnswers as $answer) {
        $str_res .= ';' . $answer['reponses'];
    }

    // on insert dans les résultats
    $req = $bdd->prepare('INSERT INTO result_test (code, mail_test, result, type_test, date_test) VALUES (?,?,?,?,?)');
    $req->execute([
        $codeAcces,
        'mail@mail',
        $str_res,
        $survey,
        time()
    ]);

    $_SESSION['result'] = $str_res;
}

function addQuestionSurveyOld($nbrQuestionAdd, $bdd)
{
    $tabSurveyById =  getAllSurvey($bdd);
    $nbrQuestion = array_column($tabSurveyById, 'id_survey');
    $idxQuestion = array_search($_SESSION['survey_neurotest'], $nbrQuestion);

    $question = $tabSurveyById[$idxQuestion];
    $result = $question['nbr_question'] + $nbrQuestionAdd;

    $req = $bdd->prepare('UPDATE survey SET nbr_question = ? WHERE id_survey = ?');
    $req->execute([$result, $_SESSION['survey_neurotest']]);

    $req_id = $bdd->prepare('SELECT num_q FROM questions WHERE id_survey = ? ORDER BY num_q DESC LIMIT 1');
    $req_id->execute([$_SESSION['survey_neurotest']]);

    $tabPersonality = getAllPersonality($bdd);
    $nbr_rep = count($tabPersonality);

    foreach ($req_id as $req) {

        $nbrQuestionBase = $req['num_q'];

        for ($x = 1; $x <= $nbrQuestionAdd; $x++) {
            $NbreQuestionsAdd = $nbrQuestionBase + $x;


            $req = $bdd->prepare('INSERT INTO questions (name_fr, id_survey, num_q) VALUES (?,?,?)');
            $req->execute([
                'Titre question',
                $_SESSION['survey_neurotest'],
                $NbreQuestionsAdd
            ]);

            for ($i = 0; $i < $nbr_rep; $i++) {

                $detailPerso = $tabPersonality[$i];
                $req = $bdd->prepare('INSERT INTO title_reponse (name_fr, img, id_q, id_perso, num_res, id_survey) VALUES (?,?,?,?,?,?)');
                $req->execute([
                    'Titre reponse',
                    'img/res/btn-add.png',
                    $NbreQuestionsAdd,
                    $detailPerso['id_perso'],
                    $i + 1,
                    $_SESSION['survey_neurotest']

                ]);
            }
        }
    }
}


function upPlaceAddQuestion($survey, $numeroQ, $bdd){
    $req_question = $bdd->prepare('SELECT * FROM questions WHERE id_survey = ? AND num_q >= ? ');
    $req_question->execute([
        $survey,
        $numeroQ,
    ]);
    foreach($req_question as $question){
        $numQ = $question['num_q'];
        var_dump($numQ);
        $up_question = $bdd->prepare('UPDATE questions SET num_q = num_q + 1 WHERE id_survey = ? AND num_q = ? ');
        $up_question->execute([
            $survey,
            $numQ
        ]);
        $up_reponse = $bdd->prepare('UPDATE title_reponse SET id_q = id_q + 1 WHERE id_survey = ? AND id_q = ? ');
        $up_reponse->execute([
            $survey,
            $numQ
        ]);
        $up_answer = $bdd->prepare('UPDATE user_answer SET num_q = num_q + 1 WHERE id_survey = ? AND num_q = ? ');
        $up_answer->execute([
            $survey,
            $numQ
        ]);
    }
}

function addQuestionSurvey($survey, $numeroQuestion, $bdd)
{
    upPlaceAddQuestion($survey, $numeroQuestion, $bdd);
    $tabSurveyById =  getAllSurvey($bdd);
    $nbrQuestion = array_column($tabSurveyById, 'id_survey');
    $idxQuestion = array_search($survey, $nbrQuestion);
    $nbrQuestionAdd = 1;
    $question = $tabSurveyById[$idxQuestion];
    $result = $question['nbr_question'] + $nbrQuestionAdd;

    $req = $bdd->prepare('UPDATE survey SET nbr_question = ? WHERE id_survey = ?');
    $req->execute([$result, $survey]);


    $tabPersonality = getAllPersonality($bdd);
    $nbr_rep = count($tabPersonality);

            $req = $bdd->prepare('INSERT INTO questions (name_fr, id_survey, num_q) VALUES (?,?,?)');
            $req->execute([
                'Titre question',
                $survey,
                $numeroQuestion
            ]);

            for ($i = 0; $i < $nbr_rep; $i++) {

                $detailPerso = $tabPersonality[$i];
                $req = $bdd->prepare('INSERT INTO title_reponse (name_fr, img, id_q, id_perso, num_res, id_survey) VALUES (?,?,?,?,?,?)');
                $req->execute([
                    'Titre reponse',
                    'img/res/btn-add.png',
                    $numeroQuestion,
                    $detailPerso['id_perso'],
                    $i + 1,
                    $_SESSION['survey_neurotest']

                ]);
            }
       
    
}

function delQuestionSurvey($nbrQuestionDel, $bdd)
{

    $tabSurveyById =  getAllSurvey($bdd);
    $nbrQuestion = array_column($tabSurveyById, 'id_survey');
    $idxQuestion = array_search($_SESSION['survey_neurotest'], $nbrQuestion);

    $question = $tabSurveyById[$idxQuestion];
    $result = $question['nbr_question'] - $nbrQuestionDel;

    $req = $bdd->prepare('UPDATE survey SET nbr_question = ? WHERE id_survey = ?');
    $req->execute([$result, $_SESSION['survey_neurotest']]);

    $req_id = $bdd->prepare('SELECT num_q FROM questions WHERE id_survey = ? ORDER BY num_q DESC LIMIT 1');
    $req_id->execute([$_SESSION['survey_neurotest']]);

    $tabPersonality = getAllPersonality($bdd);
    $nbr_rep = count($tabPersonality);

    foreach ($req_id as $req) {

        $nbrQuestionBase = $req['num_q'];

        for ($x = 0; $x < $nbrQuestionDel; $x++) {
            $NbreQuestionsSuppr = $nbrQuestionBase - $x;

            $req = $bdd->prepare('DELETE FROM questions WHERE num_q = ? AND id_survey = ?');
            $req->execute([
                $NbreQuestionsSuppr,
                $_SESSION['survey_neurotest']
            ]);

            for ($i = 0; $i < $nbr_rep; $i++) {

                $detailPerso = $tabPersonality[$i];

                $req = $bdd->prepare('DELETE FROM title_reponse WHERE id_q = ? AND id_survey = ?');
                $req->execute([
                    $NbreQuestionsSuppr,
                    $_SESSION['survey_neurotest']
                ]);
            }
        }
    }
}

function delSurvey($id_survey, $bdd)
{
    $req = $bdd->prepare('DELETE FROM questions WHERE id_survey = ?');
    $req->execute([
        $id_survey
    ]);
    $req = $bdd->prepare('DELETE FROM survey WHERE id_survey = ?');
    $req->execute([
        $id_survey
    ]);
    $req = $bdd->prepare('DELETE FROM title_reponse WHERE id_survey = ?');
    $req->execute([
        $id_survey
    ]);
}


function duplicateSurvey($id_survey, $bdd){
    $req_survey = getSurveyById($id_survey, $bdd);
    $req = $bdd->prepare('INSERT INTO survey (name_survey, nbr_question, visible) VALUES (?,?,?)');
    $req->execute([
        $req_survey['name_survey'].' copie',
        $req_survey['nbr_question'],
        0
    ]);
    $req_last_survey = $bdd->query('SELECT * FROM survey ORDER BY id_survey DESC LIMIT 1');
    $last_survey = $req_last_survey->fetch();
    $idNewSurvey = $last_survey['id_survey'];
    $tab_questions = getQuestionsBySurvey($id_survey, $bdd);
   // var_dump($tab_questions);
   
    foreach($tab_questions as $question){
      
        $add_question = $bdd->prepare('INSERT INTO questions (name_fr, id_survey, num_q) VALUES (?,?,?)');
        $add_question->execute([
            $question['name_fr'],
            $idNewSurvey,
            $question['num_q'] 
        ]);
     

         $tab_details_question = getTitleReponseByQuestion($question['num_q'], $id_survey, $bdd);
         //var_dump($tab_details_question);
         foreach($tab_details_question as $detail_question){
            $add_detail_question = $bdd->prepare('INSERT INTO title_reponse (name_fr, img, id_q, id_perso, num_res, id_survey) VALUES (?,?,?,?,?,?)');
            $add_detail_question->execute([
                $detail_question['name_fr'],
                $detail_question['img'],
                $detail_question['id_q'],
                $detail_question['id_perso'],
                $detail_question['num_res'],
                $idNewSurvey
            ]);
         }  
    } 

    
}

function renameSurvey($id_survey, $newName, $bdd){
    $req = $bdd->prepare('UPDATE survey SET name_survey = ? WHERE id_survey = ?');
    $req->execute([
        $newName,
        $id_survey
    ]);
}

function deleteSurvey($id_survey, $bdd){
    $req = $bdd->prepare('DELETE FROM survey WHERE id_survey = ?');
    $req->execute([
        $id_survey
    ]);
}

function changeVisibilityQuestion($id_survey, $num_q, $new_value, $bdd){
    $req = $bdd->prepare('UPDATE questions SET inactive = ? WHERE id_survey = ? AND num_q = ?');
    $req->execute([
        $new_value,
        $id_survey,
        $num_q
    ]);
}