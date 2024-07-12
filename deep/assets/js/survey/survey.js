function selectReponse(e) {
    let tab_selected = document.getElementsByClassName('reponseSelected')
    if (tab_selected.length == 3 && e.target.classList.contains('reponseSelected') === false) {
        return;
    }
    let input_reponse = document.getElementById('input_reponse')
    let div_card_rep = e.target.closest('.card_rep_other')
    div_card_rep.classList.toggle('reponseSelected')
    let formulaire = document.getElementById('monFormulaire');

    let rep = '';
    let div_all_rep = document.getElementsByClassName('card_rep_other');
    for (let i = 0; i < div_all_rep.length; i++) {
        if (div_all_rep[i].classList.contains('reponseSelected')) {
            rep = rep + div_all_rep[i].dataset.perso + '/';

            if (rep.length > 2) {
                /*
                let chevronRight = document.getElementsByClassName('fa-solid fa-circle-chevron-right')[0]
                chevronRight.classList.add('icon-reponse-selected')
                */
            } else {
                let chevronRight = document.getElementsByClassName('fa-solid fa-circle-chevron-right')[0]
                chevronRight.classList.remove('icon-reponse-selected')
            }
        }
    }
    tab_selected = document.getElementsByClassName('reponseSelected')
    if (tab_selected.length == 3) {

        formulaire.submit()
    }
    input_reponse.value = rep;
    // console.log(rep)
}

function goToNextQuestion(e) {

    let tab_selected = document.getElementsByClassName('reponseSelected');
    let form = e.target.closest('form')
    let p_warning = document.getElementById('p_warning_test')

   //  if (tab_selected.length == 2 || tab_selected.length == 3) {
    if (tab_selected.length == 3) {
        form.submit()
    } else {
        p_warning.classList.remove('none')
    }

}

function removePopup(e){
    e.target.classList.add('none')
}