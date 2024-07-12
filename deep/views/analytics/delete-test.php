<?php include('../../bdd/connexion_bdd.php');

if (isset($_POST['code'])) {
    $code = sanatizeString($_POST['code']);
}

$req_del = $bdd->prepare("DELETE FROM result_test WHERE code = ? ");
$req_del->execute(
    array(
        $code
    )
);

$req_del = $bdd->prepare("DELETE FROM user_answer WHERE codeAcces = ? ");
$req_del->execute(
    array(
        $code
    )
);
?>
<script>
    history.back();
</script>