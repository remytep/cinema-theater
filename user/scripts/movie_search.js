let movieSearch = document.getElementById("movie-search");
let movieTitleSearch = document.getElementById("movie-title-search");
let movieDistributorSearch = document.getElementById(
  "movie-distributor-search"
);
let movieGenreSearch = document.getElementById("movie-genre-search");
let resultsPerPage = document.getElementById("results-per-page");

movieTitleSearch.addEventListener("keyup", () => {
  movieLoad(
    movieTitleSearch.value,
    movieDistributorSearch.value,
    movieGenreSearch.value
  );
});

movieDistributorSearch.addEventListener("keyup", () => {
  1;
  movieLoad(
    movieTitleSearch.value,
    movieDistributorSearch.value,
    movieGenreSearch.value
  );
});

movieGenreSearch.addEventListener("change", () => {
  movieLoad(
    movieTitleSearch.value,
    movieDistributorSearch.value,
    movieGenreSearch.value
  );
});

resultsPerPage.addEventListener("change", () => {
  movieLoad(
    movieTitleSearch.value,
    movieDistributorSearch.value,
    movieGenreSearch.value
  );
});

movieLoad();
function movieLoad(
  movieTitle = "",
  movieDistributor = "",
  movieGenre = "all",
  page_number = 1
) {
  let formdata = new FormData();
  formdata.append("movie-title", movieTitle);
  formdata.append("movie-distributor", movieDistributor);
  formdata.append("movie-genre", movieGenre);
  formdata.append("results-per-page", resultsPerPage.value);
  formdata.append("page", page_number);
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "./includes/movie_search.php", true);
  xhr.send(formdata);
  xhr.onreadystatechange = () => {
    if (xhr.readyState == 4 && xhr.status == 200) {
      let response = JSON.parse(xhr.responseText);
      let html = "";
      if (response.data.length > 0) {
        for (let count = 0; count < response.data.length; count++) {
          html += "<tr>";
          html += "<td>" + response.data[count].id + "</td>";
          html += "<td>" + response.data[count].title + "</td>";
          html += "<td>" + response.data[count].director + "</td>";
          html += "<td>" + response.data[count].distributor + "</td>";
          html += "<td>" + response.data[count].genre + "</td>";
          if (typeof response.data[count].duration == "string") {
            html += "<td>" + response.data[count].duration + "</td>";
          } else {
            html += "<td> - </td>";
          }
          html += "<td>" + response.data[count].rating + "</td>";
          html += "</tr>";
        }
      } else {
        html +=
          '<tr><td colspan="7" class="text-center">No Data Found</td></tr>';
      }
      document.getElementById("post-data").innerHTML = html;
      document.getElementById("number-results").innerHTML = response.total_data;
      document.getElementById("pagination-link").innerHTML =
        response.pagination;
    }
  };
}
