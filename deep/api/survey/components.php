<?php
 function renderBarGraph($TabScore, $idProfil, $texteProfil, $nbrQ)
 {


     $scoreProfil = $TabScore[$idProfil];
     $percent = ($scoreProfil / $nbrQ) * 100;

     $tabColor = $_SESSION['tab_colors'];

     ?>
     <div class="div_contain_bar_profil flex-row flex-center relative">
         <div class="div_bg_img" style="background-color:<?= $tabColor[$idProfil]; ?>">
             <div class="div_img_bar flex-center">
                 <i class="fa-solid fa-clipboard-list"></i>
             </div>
         </div>
         <div class="div_progress_profil">
             <div class="progress_profil" style="width:<?= $percent; ?>%; background-color:<?= $tabColor[$idProfil]; ?>"></div>
         </div>
         <div class="div_texte_bar absolute">
             <p class="p_texte_bar"> <?= $texteProfil; ?></p>
         </div>
     </div>
     <?php
 }


?>