function clickBtnQuestion(e){

    let input = e.target.getElementsByClassName('ipt_question')[0]
    if(input.checked == 1 ){
        input.checked = 0;
        e.target.classList.remove('question_selected')
    }else{
        input.checked = 1;
        e.target.classList.add('question_selected')
    }
}

function sortOut(divDepart) {
    var classname = divDepart.getElementsByClassName('div_profil_detail');
    var divs = [];
    for (var i = 0; i < classname.length; ++i) {
        divs.push(classname[i]);
    }
    divs.sort(function(a, b) {
        return b.dataset.point.localeCompare(a.dataset.point);
    });
    
    var br = document.getElementsByTagName("br")[0];

    divs.forEach(function(el) {
        divDepart.appendChild(el, br);
    });

}



function trierProfilDetail(){
    let containers = document.getElementsByClassName('div_profils');
    console.log(containers)
  
    for(let x = 0; x < containers.length; x++){

       sortOut(containers[x]);

    }   
}

trierProfilDetail();


function genererGraphique(){

    let inputScoreTotal = document.getElementById('scoreTotal');
    console.log(inputScoreTotal)

    let tabScore = inputScoreTotal.value.split('/');

    let pt_philosophe = tabScore[0];
    let pt_novateur = tabScore[1];
    let pt_animateur = tabScore[2];
    let pt_gestionnaire= tabScore[3];
    let pt_stratege = tabScore[4];
    let pt_competiteur = tabScore[5];
    let pt_participatif = tabScore[6];
    let pt_solidaire = tabScore[7];
    

    
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




}

genererGraphique();


function prepareInterface(){
    let strScore = document.getElementById('inputActiveQ').value;
    let tabBtnQ = document.getElementsByClassName('div_btn_question');
    for(let x = 0; x < tabBtnQ.length; x++){

        console.log(tabBtnQ[x])
        strScore = "/" + strScore + "/";

        console.log(strScore);
       
        if( strScore.indexOf( "/" + tabBtnQ[x].dataset.numq + "/") == -1  ){
            tabBtnQ[x].classList.remove('question_selected');
            tabBtnQ[x].getElementsByClassName('ipt_question')[0].checked = 0;
        }
    }
}

 prepareInterface();