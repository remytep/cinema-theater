let popUpEditMovieSessionButton = document.getElementById(
  "popup-edit-moviesession-button"
);

let editMovieSessionMovieId = document.getElementById(
  "popup-edit-moviesession-id"
);
let editMovieSessionTitle = document.getElementById(
  "popup-edit-moviesession-title"
);
let editMovieSessionRoom = document.getElementById(
  "popup-edit-moviesession-room"
);
let editMovieSessionDate = document.getElementById(
  "popup-edit-moviesession-date"
);
let editMovieSessionTime = document.getElementById(
  "popup-edit-moviesession-time"
);

function editButton(value) {
  function openPopUpEditMovieSession() {
    document.getElementById("popup-edit-moviesession").style.display = "block";
    document
      .getElementById("popup-edit-moviesession")
      .classList.add("highlight");
  }
  function closePopUpEditMovieSession() {
    document.getElementById("popup-edit-moviesession").style.display = "none";
  }
  openPopUpEditMovieSession();
  document.body.addEventListener("click", function (e) {
    if (!e.target.classList.contains("popup")) {
      closePopUpEditMovieSession();
    }
  });
  popUpEditMovieSessionButton.addEventListener("click", (e) => {
    e.preventDefault();
    editMovieSession(
      value,
      editMovieSessionMovieId.value,
      editMovieSessionRoom.value,
      editMovieSessionDate.value,
      editMovieSessionTime.value
    );
  });
}
function editMovieSession(
  sessionId,
  movieSessionMovieId,
  movieSessionRoom,
  movieSessionDate,
  movieSessionTime
) {
  let formdata = new FormData();
  formdata.append("session-id", sessionId);
  formdata.append("moviesession-movieid", movieSessionMovieId);
  formdata.append("moviesession-room", movieSessionRoom);
  formdata.append("moviesession-date", movieSessionDate);
  formdata.append("moviesession-time", movieSessionTime);
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "./includes/movie_session/edit.php", true);
  xhr.send(formdata);
  location.reload();
}
