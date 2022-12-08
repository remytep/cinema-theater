userHistory();
function userHistory(results = 10, page_number = 1) {
  let formdata = new FormData();
  formdata.append("results-per-page", results);
  formdata.append("page", page_number);
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "../includes/my_profile/history/load.php", true);
  xhr.send(formdata);
  xhr.onreadystatechange = () => {
    if (xhr.readyState == 4 && xhr.status == 200) {
      let response = JSON.parse(xhr.responseText);
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
          '<tr><td colspan="8" class="text-center">No Data Found</td></tr>';
      }
      document.getElementById("post-data").innerHTML = html;
      document.getElementById("number-results").innerHTML = response.total_data;
      document.getElementById("pagination-link").innerHTML =
        response.pagination;
    }
  };
}
