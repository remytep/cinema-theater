let sessionIdSearch = document.getElementById("session-id-search");
let movieTitleSearch = document.getElementById("movie-title-search");
let movieGenreSearch = document.getElementById("movie-genre-search");
let movieSessionDateSearch = document.getElementById(
  "movie-session-date-search"
);
let resultsPerPage = document.getElementById("results-per-page");

let addMovieSessionButton = document.getElementById("add-movie-session");

sessionIdSearch.addEventListener("input", () => {
  movieSessionLoad(
    sessionIdSearch.value,
    movieTitleSearch.value,
    movieSessionDateSearch.value,
    movieGenreSearch.value
  );
});

movieTitleSearch.addEventListener("input", () => {
  movieSessionLoad(
    sessionIdSearch.value,
    movieTitleSearch.value,
    movieSessionDateSearch.value,
    movieGenreSearch.value
  );
});

movieSessionDateSearch.addEventListener("input", () => {
  movieSessionLoad(
    sessionIdSearch.value,
    movieTitleSearch.value,
    movieSessionDateSearch.value,
    movieGenreSearch.value
  );
});

movieGenreSearch.addEventListener("change", () => {
  movieSessionLoad(
    sessionIdSearch.value,
    movieTitleSearch.value,
    movieSessionDateSearch.value,
    movieGenreSearch.value
  );
});

resultsPerPage.addEventListener("change", () => {
  movieSessionLoad(
    sessionIdSearch.value,
    movieTitleSearch.value,
    movieSessionDateSearch.value,
    movieGenreSearch.value
  );
});

// Récupère les films dont des séances sont prévues ce jour
movieSessionLoad();
function movieSessionLoad(
  sessionId = "",
  movieTitle = "",
  movieSessionDate = "2018-01-01",
  movieGenre = "all",
  page_number = 1
) {
  let formdata = new FormData();
  formdata.append("session-id", sessionId);
  formdata.append("movie-title", movieTitle);
  formdata.append("movie-genre", movieGenre);
  formdata.append("movie-session-date", movieSessionDate);
  formdata.append("results-per-page", resultsPerPage.value);
  formdata.append("page", page_number);
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "./includes/movie_session/search.php", true);
  xhr.send(formdata);
  xhr.onreadystatechange = () => {
    if (xhr.readyState == 4 && xhr.status == 200) {
      //console.log(xhr.responseText);
      let response = JSON.parse(xhr.responseText);
      //console.log(response);
      let html = "";
      if (response.data.length > 0) {
        for (let count = 0; count < response.data.length; count++) {
          html += "<tr class='align-middle'>";
          html += "<td>" + response.data[count].title + "</td>";
          html += "<td>" + response.data[count].genre + "</td>";
          html += "<td>" + response.data[count].room + "</td>";
          html += "<td>" + response.data[count].sessionDate + "</td>";
          html += "<td>" + response.data[count].sessionHour + "</td>";
          html += "</tr>";
        }
      } else {
        html +=
          '<tr><td colspan="9" class="text-center">No Data Found</td></tr>';
      }
      document.getElementById("post-data").innerHTML = html;
      document.getElementById("number-results").innerHTML = response.total_data;
      document.getElementById("pagination-link").innerHTML =
        response.pagination;
    }
  };
}
