function deleteButton(value) {
  function openPopUpDelete() {
    document.getElementById("popup-delete").style.display = "block";
    document.getElementById("popup-delete").classList.add("highlight");
  }
  function closePopUpDelete() {
    document.getElementById("popup-delete").style.display = "none";
  }
  openPopUpDelete();
  document.body.addEventListener("click", function (e) {
    if (!e.target.classList.contains("popup")) {
      closePopUpDelete();
    }
  });
  document
    .getElementById("delete-button-yes")
    .addEventListener("click", (e) => {
      e.preventDefault();
      deleteMovieLog(value);
    });
  document.getElementById("delete-button-no").addEventListener("click", (e) => {
    e.preventDefault();
    closePopUpDelete();
  });
}

function deleteMovieLog(logId) {
  let formdata = new FormData();
  formdata.append("log-id", logId);
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "../includes/user_profile/history/delete.php", true);
  xhr.send(formdata);
  location.reload();
}
