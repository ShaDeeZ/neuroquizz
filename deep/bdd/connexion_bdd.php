<?php session_start();

date_default_timezone_set('Europe/Paris');
function sanatizeString($str)
{
    $dirty_string = $str;

    // Supprimer les balises HTML et PHP
    $clean_string = strip_tags($dirty_string);

    // Convertir les caractères spéciaux en entités HTML
    $clean_string = htmlspecialchars($clean_string);

    // Supprimer les espaces en début et fin de chaîne
    // $clean_string = trim($clean_string);

    // Utiliser le filtre FILTER_SANITIZE_STRING pour enlever les balises HTML et PHP et convertir les caractères spéciaux en entités HTML
    $clean_string = filter_var($clean_string, FILTER_SANITIZE_STRING);

    // Utiliser la chaîne nettoyée dans votre application
    return $clean_string;
}

function removeLast($str)
{
    $str = substr($str, 0, -1);
    return $str;
}

function replaceXXX($str)
{
    $str = str_replace('!G!', '<b>', $str);
    $str = str_replace('!FG!', '</b>', $str);
    return $str;
}


function goPreviousUrl()
{
    $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php';
    header('Location: ' . $referer);
}

function preparedInsert(object $bdd, array $column_names, string $table_name, array $values)
{
    if (count($values) == 0) {
        return false;
    }
    $placeholders = '(' . implode(',', array_fill(0, count($column_names), '?')) . '),';
    $insert_string = '';
    foreach ($values as $val) {
        $insert_string .= $placeholders;
    }
    // remove last ','
    $insert_string = substr($insert_string, 0, -1);
    // Create the base INSERT INTO statement
    $sql = 'INSERT INTO ' . $table_name . '(' . implode(',', $column_names) . ') VALUES ' . $insert_string;
    // Prepare and execute the statement
    $query = $bdd->prepare($sql);
    return $query->execute(array_merge(...$values));
}

function verifAccesCode($code, $bdd)
{
    $req = $bdd->prepare('SELECT * FROM acces_codes WHERE code_acces = ? ');
    $req->execute(
        array(
            $code
        )
    );

    if ($req->rowCount() == 0) {
        // header('Location:../home/');
        echo "Code d'accès invalide";
        die;
    } else {
        return $req->fetchAll();
    }
}

function verifAcces($session)
{
    if (!isset($session) or !isset($session['is_connected'])) {
        header('Location:http://localhost/neurotest/views/home/connexion.php');
    }
    if ($session['is_connected'] != 1) {
        header('Location:http://localhost/neurotest/views/home/connexion.php');
    }
}

function StrLang($str_fr, $str_nl, $str_en)
{
    $str = $str_fr;
    if ($_SESSION['current_lang'] == "nl") {
        $str = $str_nl;
    }

    if ($_SESSION['current_lang'] == "en") {
        $str = $str_en;
    }

    return $str;
};
function connectDb()
{
    $_SESSION['tab_colors'] = [

        0 => [
            'color' => 'red',
            'icon' => 'fa-gears'
        ],

        1 => [
            'color' => '#F9B907',
            'icon' => 'fa-gears'
        ],

        2 => [
            'color' => '#FEBE5E',
            'icon' => 'fa-magnifying-glass'
        ],

        3 => [
            'color' => '#F68016',
            'icon' => 'fa-sun'
        ],

        4 => [
            'color' => '#CF591E',
            'icon' => 'fa-trophy'
        ],

        5 => [
            'color' => '#A4A6A6',
            'icon' => 'fa-chess-knight'
        ],

        6 => [
            'color' => '#494949',
            'icon' => 'fa-handshake-simple'
        ],

        7 => [
            'color' => '#63C5DF',
            'icon' => 'fa-person-chalkboard'
        ],

        8 => [
            'color' => '#004CA7',
            'icon' => 'fa-users-viewfinder'
        ],

        /*        
        1 => '#F9B907', // philosphe
        2 => '#FEBE5E', // novateur
        3 => '#F68016', // animateur
        4 => '#CF591E', // gestionnaire
        5 => '#A4A6A6', // stratege
        6 => '#494949', // competiteur
        7 => '#63C5DF', // participatif
        8 => '#004CA7', // solidaire
        */
    ];

    $serveur = "gf7ug.myd.infomaniak.com";
    $base = "gf7ug_dyp";
    $user = "gf7ug_ludo";
    $pass = "A1383d449e269130984fe9967cf36fdf89288e6ef";

    $bdd = new PDO('mysql:host=' . $serveur . ';dbname=' . $base, $user, $pass, array('charset' => 'utf8'));
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $bdd->query("SET CHARACTER SET utf8");


    return $bdd;
}

$bdd = connectDb();
$_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
