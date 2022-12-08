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
      deleteMovieSession(value);
    });
  document.getElementById("delete-button-no").addEventListener("click", (e) => {
    e.preventDefault();
    closePopUpDelete();
  });
}

function deleteMovieSession(sessionId) {
  window.movieSessionLoad = movieSessionLoad;
  let formdata = new FormData();
  formdata.append("session-id", sessionId);
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "./includes/movie_session/delete.php", true);
  xhr.send(formdata);
  location.reload();
}
