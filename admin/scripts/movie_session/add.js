let movieIdAddSession = document.getElementById("movie-id-addsession");
let movieTitleAddSession = document.getElementById("movie-title-addsession");
let movieRoomAddSession = document.getElementById("movie-room-addsession");
let movieSessionDateAddSession = document.getElementById(
  "movie-session-date-addsession"
);
let movieSessionTimeAddSession = document.getElementById(
  "movie-session-time-addsession"
);

addMovieSessionButton.addEventListener("click", (e) => {
  e.preventDefault();
  addMovieSession();
});

function addMovieSession() {
  movieSessionLoad();
  let movieSessionDateBegin =
    movieSessionDateAddSession.value + " " + movieSessionTimeAddSession.value;
  let formdata = new FormData();
  formdata.append("movie-id-add", movieIdAddSession.value);
  formdata.append("movie-title-add", movieTitleAddSession.value);
  formdata.append("movie-room-add", movieRoomAddSession.value);
  formdata.append("movie-datebegin-add", movieSessionDateBegin);
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "./includes/movie_session/add.php", true);
  xhr.send(formdata);
  location.reload();
}
