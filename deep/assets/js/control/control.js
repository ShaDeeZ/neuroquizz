function changeVisibilityEnquete(e) {
  let enquete = e.target.dataset.enquete;
  let visibility = e.target.dataset.visible;

  new Promise((resolve, reject) => {
    $.ajax({
      type: "POST",
      url: "../../model/control/edit-visibility-survey.php",
      data: { enquete: enquete, visibility: visibility },
      success: function (datas) {
        resolve(datas);
      },
    });
  }).then((datas) => {
    console.log(datas);
    if (visibility == 1) {
      e.target.dataset.visibility = 0;
      e.target.innerText = "❌";
    } else {
      e.target.dataset.visibility = 1;
      e.target.innerText = "✅";
    }
    // location.reload();
  });
}