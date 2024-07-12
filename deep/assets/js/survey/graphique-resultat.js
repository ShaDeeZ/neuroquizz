function viewMoreInfo(event){
    let div_all_categories = event.target.closest('.div_all_categories')
    let icon_chevron = div_all_categories.getElementsByClassName('fa-circle-chevron-down')[0]
    let div_more_info = div_all_categories.getElementsByClassName('div_more_info_ctagories')[0]

    icon_chevron.classList.toggle('fa-circle-chevron-up')
    div_more_info.classList.toggle('none')
}



let pt_philosophe = 0;
let pt_novateur = 0;
let pt_animateur = 0;
let pt_gestionnaire = 0;
let pt_stratege = 0;
let pt_competiteur = 0;
let pt_participatif = 0;
let pt_solidaire = 0;

let rep_to_explode = document.getElementById('resultat_chart').value;

let rep_par_Q = rep_to_explode.split(';');
for(let x = 0; x<rep_par_Q.length; x++){
    let rep = rep_par_Q[x].split('/');
    for(let i = 0; i<rep.length; i++){
        
        switch (rep[i]) {
            case "1" :
                pt_philosophe++;
            break;
            case "2" :
                pt_novateur++;
            break;
            case "3" :
                pt_animateur++;
            break;
            case "4" :
                pt_gestionnaire++;
            break;
            case "5" :
                pt_stratege++;
            break;
            case "6" :
                pt_competiteur++;
            break;
            case "7" :
                pt_participatif++;
            break;
            case "8" :
                pt_solidaire++;
            break;
                        

}

    }
}


let tab_resultat = [pt_philosophe, pt_animateur, pt_competiteur, pt_gestionnaire, pt_novateur, pt_stratege, pt_participatif, pt_solidaire];

console.log(tab_resultat);



   let tab_info_result =  [{nom:'PHILOSOPHE',point: pt_philosophe,color:'#FF9C39'},
                           {nom:'ANIMATEUR',point: pt_animateur,color:'#FFD253'},
                           {nom:'COMPETITEUR',point: pt_competiteur,color:'#FF5050'},
                           {nom:'GESTIONNAIRE',point: pt_gestionnaire,color:'#CC9700'},
                           {nom:'NOVATEUR',point: pt_novateur,color:'#33CC33'},
                           {nom:'STRATEGE',point: pt_stratege,color:'#BA8CDC'},
                           {nom:'PARTICIPATIF',point: pt_participatif,color:'#00B0F0'},
                           {nom:'SOLIDAIRE',point: pt_solidaire,color:'#BFBFBF'}];
tab_info_result.sort(function (a, b) {
    return b.point - a.point;
    });

console.log(tab_info_result);

   
console.log(tab_info_result[0].point);




var ctx = document.getElementById('myChart').getContext('2d');
Chart.defaults.global.legend.display = false;
Chart.defaults.global.defaultFontFamily = 'Nunito';
Chart.defaults.global.defaultFontSize = 14;
var myChart = new Chart(ctx, {

type: 'bar',

data: {
labels: [[tab_info_result[0].nom,tab_info_result[0].point],[tab_info_result[1].nom,tab_info_result[1].point],[tab_info_result[2].nom,tab_info_result[2].point],[tab_info_result[3].nom,tab_info_result[3].point],[tab_info_result[4].nom,tab_info_result[4].point],[tab_info_result[5].nom,tab_info_result[5].point],[tab_info_result[6].nom,tab_info_result[6].point],[tab_info_result[7].nom,tab_info_result[7].point],],

datasets: [{
    label: 'Vos Profils',
    data: [tab_info_result[0].point,tab_info_result[1].point,tab_info_result[2].point,tab_info_result[3].point,tab_info_result[4].point,tab_info_result[5].point,tab_info_result[6].point,tab_info_result[7].point],
    backgroundColor: [
        tab_info_result[0].color,
        tab_info_result[1].color,
        tab_info_result[2].color,
        tab_info_result[3].color,
        tab_info_result[4].color,
        tab_info_result[5].color,
        tab_info_result[6].color,
        tab_info_result[7].color,
        
    ],
  /*  borderColor: [
        'rgba(255, 99, 132, 1)',
        'rgba(54, 162, 235, 1)',
        'rgba(255, 206, 86, 1)',
        'rgba(75, 192, 192, 1)',
        'rgba(153, 102, 255, 1)',
        'rgba(255, 159, 64, 1)',
        'rgba(155, 159, 64, 1)',
        'rgba(255, 59, 64, 1)',
    ],
    borderWidth: 1*/
}]
},
options: { 



scales: {
    yAxes: [{
        display : false,
        ticks: {
            beginAtZero: true
        },
        gridLines: {
        color: "rgba(0, 0, 0, 0)",
        }
    }],

    xAxes: [{
    gridLines: {
        color: "rgba(0, 0, 0, 0)",
    }   
}]
    

},
aspectRatio:4, 

}
});