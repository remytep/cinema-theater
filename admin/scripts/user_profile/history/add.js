let sessionIdAddSession = document.getElementById("session-id-addsession");
let addMovieSessionButton = document.getElementById("add-movie-session");
let popUpAdd = document.getElementById("popup-add");
let popUpAddMovieSessionButton = document.getElementById(
  "add-movie-session-button"
);

function openPopUp() {
  document.getElementById("popup-add").style.display = "block";
  document.getElementById("popup-add").classList.add("highlight");
}
function closePopUp() {
  document.getElementById("popup-add").style.display = "none";
}

addMovieSessionButton.addEventListener("click", (e) => {
  e.preventDefault();
  openPopUp();
  document.body.addEventListener("click", function (e) {
    if (!e.target.classList.contains("popup")) {
      closePopUp();
    }
  });
  popUpAddMovieSessionButton.addEventListener("click", (e) => {
    e.preventDefault();
    addMovieSession(sessionIdAddSession.value);
  });
});

function addMovieSession(sessionIdAddSession = 0) {
  let formdata = new FormData();
  formdata.append("session-id-add", sessionIdAddSession);
  formdata.append("user-id", userId);
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "../includes/user_profile/history/add.php", true);
  xhr.send(formdata);
  location.reload();
}
