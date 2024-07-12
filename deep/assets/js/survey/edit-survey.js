

function uploadImage(e) {
  let container = e.target.closest('.div_card_rep_edit')
  let num_q = e.target.dataset.question;
  let id_survey = e.target.dataset.id;
  let num_res = e.target.dataset.num;
  let new_image = e.target.files[0];
  let formData = new FormData();
  let div_refresh = container.querySelector('.div_image_refresh');

  formData.append('new_image', new_image);
  formData.append('num_q', num_q);
  formData.append('id_survey', id_survey);
  formData.append('num_res', num_res);

  $.ajax({
    type: "POST",
    url: "../../model/survey/edit-image-survey.php",
    data: formData,
    contentType: false,
    processData: false,
    success: function (datas) {
      setTimeout(() => {
        location.reload();
      }, "1000");
   
    },
    error: function (error) {
      //console.error(error);
      div_refresh.textContent = error.responseText;
    }
  });
}

function editTextReponse(e) {

  let container = e.target.closest('.div_card_rep_edit');
  let text = e.target.innerText;
  console.log(container.getElementsByClassName('input_id_survey'))
  let id_survey = container.getElementsByClassName('input_id_survey')[0].value;
  let num_q = container.getElementsByClassName('input_num_q')[0].value;
  let num_res = container.getElementsByClassName('input_num_res')[0].value;
  console.log()

  new Promise((resolve, reject) => {
    $.ajax({
      type: "POST",
      url: "../../model/survey/edit-text-reponse.php",
      data: { text: text, id_survey: id_survey, num_q: num_q, num_res: num_res },
      success: function (datas) {
        resolve(datas);
      },
    });
  }).then((datas) => {
    console.log(datas);
    // location.reload();
  });

}

function editTextQuestion(e) {

  let text = e.target.innerText;
  let id_q = e.target.dataset.idq;



  new Promise((resolve, reject) => {
    $.ajax({
      type: "POST",
      url: "../../model/survey/edit-text-question.php",
      data: { text: text, id_q: id_q },
      success: function (datas) {
        resolve(datas);
      },
    });
  }).then((datas) => {
    console.log(datas);
    // location.reload();
  });

}

function editPersoReponse(e) {

  let container = e.target.closest('.div_card_rep');
  let id_perso = e.target.dataset.perso;
  let id_survey = container.getElementsByClassName('input_id_survey')[0].value;
  let num_q = container.getElementsByClassName('input_num_q')[0].value;
  let num_res = container.getElementsByClassName('input_num_res')[0].value;
  tab_btn_perso = container.getElementsByClassName('p_perso');
  for (let i = 0; i < tab_btn_perso.length; i++) {
    tab_btn_perso[i].classList.remove('persoActif');
  }
  e.target.classList.add('persoActif')

  new Promise((resolve, reject) => {
    $.ajax({
      type: "POST",
      url: "../../model/survey/edit-personality-reponse.php",
      data: { id_perso: id_perso, id_survey: id_survey, num_q: num_q, num_res: num_res },
      success: function (datas) {
        resolve(datas);
      },
    });
  }).then((datas) => {
    console.log(datas);

    // location.reload();
  });
}



function allowDrop(event) {
  event.preventDefault();
}

function drag(event) {
  event.dataTransfer.setData("text/plain", event.target.innerHTML);
}
function drop(event) {
  event.preventDefault();
  const data = event.dataTransfer.getData("text/plain");
  const draggedElement = document.querySelector('.dragging');

  if (draggedElement && event.target.classList.contains('div_rep_question')) {
    // Créer un nouvel élément div
    const newDiv = document.createElement("div");
    newDiv.classList.add("draggable");
    newDiv.classList.add("div_card_rep");
    newDiv.draggable = true;
    newDiv.innerHTML = data;

    // Attacher l'événement dragstart à l'élément nouvellement créé
    newDiv.addEventListener('dragstart', function (e) {
      drag(e);
    });

    // Insérer le nouvel élément juste avant l'élément suivant l'endroit du drop
    const nextElement = getNextElement(event.clientX, event.clientY);
    event.target.insertBefore(newDiv, nextElement);

    // Supprimer la classe 'dragging' de l'élément d'origine
    draggedElement.remove();
  }
}

function getNextElement(x, y) {
  const draggableElements = document.querySelectorAll('.draggable');
  let closestElement = null;
  let closestDistance = Infinity;

  draggableElements.forEach(element => {
    const rect = element.getBoundingClientRect();
    const distance = Math.sqrt((x - rect.left) ** 2 + (y - rect.top) ** 2);

    if (distance < closestDistance) {
      closestDistance = distance;
      closestElement = element;
    }
  });

  return closestElement;
}
document.addEventListener('dragstart', function (event) {
  if (event.target.classList.contains('draggable')) {
    event.target.classList.add('dragging');
  }
});

document.addEventListener('dragend', function (event) {
  if (event.target.classList.contains('draggable')) {
    event.target.classList.remove('dragging');
  }
});


function renameSurvey(e){
  let newName = e.target.value;

  
  new Promise((resolve, reject) => {
    $.ajax({
      type: "POST",
      url: "../../model/survey/rename-survey.php",
      data: { newName: newName},
      success: function (datas) {
        resolve(datas);
      },
    });
  }).then((datas) => {
    console.log(datas);
    // location.reload();
  });

}

function changeVisibilityQuestion (e){
  let inactive = e.target.dataset.inactive;
  let newValue = (inactive == 1) ? 0 : 1;
  new Promise((resolve, reject) => {
    $.ajax({
      type: "POST",
      url: "../../model/survey/change-visibilty-question.php",
      data: { newValue: newValue},
      success: function (datas) {
        resolve(datas);
      },
    });
  }).then((datas) => {
    console.log(datas);
     location.reload();
  });
}