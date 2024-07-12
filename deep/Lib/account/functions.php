<?php
function selectTextApp($type_text, $bdd)
{
    $tabTexte = getAppText($bdd);
    $tabTypeText = array_column($tabTexte, 'type_text');
    $idxText = array_search($type_text, $tabTypeText);
    $text = ($idxText !== false) ? $tabTexte[$idxText]['text'] : 'pas de texte trouvé';
    return $text;
}
?>