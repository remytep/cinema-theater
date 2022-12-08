let sessionIdSearch = document.getElementById("session-id-search");
let movieTitleSearch = document.getElementById("movie-title-search");
let movieGenreSearch = document.getElementById("movie-genre-search");
let resultsPerPage = document.getElementById("results-per-page");

sessionIdSearch.addEventListener("input", () => {
  userHistorySearch(
    userId,
    sessionIdSearch.value,
    movieTitleSearch.value,
    movieGenreSearch.value
  );
});

movieTitleSearch.addEventListener("input", () => {
  userHistorySearch(
    userId,
    sessionIdSearch.value,
    movieTitleSearch.value,
    movieGenreSearch.value
  );
});

movieGenreSearch.addEventListener("change", () => {
  userHistorySearch(
    userId,
    sessionIdSearch.value,
    movieTitleSearch.value,
    movieGenreSearch.value
  );
});

resultsPerPage.addEventListener("change", () => {
  userHistorySearch(
    userId,
    sessionIdSearch.value,
    movieTitleSearch.value,
    movieGenreSearch.value
  );
});

function userHistorySearch(
  userId,
  sessionId = "",
  movieTitle = "",
  movieGenre = "all",
  page_number = 1
) {
  let formdata = new FormData();
  formdata.append("user-id", userId);
  formdata.append("session-id", sessionId);
  formdata.append("movie-title", movieTitle);
  formdata.append("movie-genre", movieGenre);
  formdata.append("results-per-page", resultsPerPage.value);
  formdata.append("page", page_number);
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "../includes/user_profile/history/search.php", true);
  xhr.send(formdata);
  xhr.onreadystatechange = () => {
    if (xhr.readyState == 4 && xhr.status == 200) {
      let response = JSON.parse(xhr.responseText);
      let html = "";
      if (response.data.length > 0) {
        for (let count = 0; count < response.data.length; count++) {
          html += "<tr class='align-middle'>";
          html += "<td>" + response.data[count].sessionId + "</td>";
          html += "<td>" + response.data[count].movieId + "</td>";
          html += "<td>" + response.data[count].title + "</td>";
          html += "<td>" + response.data[count].genre + "</td>";
          html += "<td>" + response.data[count].room + "</td>";
          html += "<td>" + response.data[count].sessionDate + "</td>";
          html += "<td>" + response.data[count].sessionHour + "</td>";
          html +=
            "<td><button class='btn btn-danger delete popup' value=" +
            response.data[count].logId +
            " id=delete" +
            response.data[count].logId +
            " onclick='deleteButton(this.value);'>Delete</button></td>";
          html += "</tr>";
        }
      } else {
        html +=
          '<tr><td colspan="8" class="text-center">No Data Found</td></tr>';
      }
      document.getElementById("post-data").innerHTML = html;
      document.getElementById("number-results").innerHTML = response.total_data;
      document.getElementById("pagination-link").innerHTML =
        response.pagination;
    }
  };
}
