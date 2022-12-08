let userSearch = document.getElementById("user-search");
let userFirstnameSearch = document.getElementById("user-firstname-search");
let userLastnameSearch = document.getElementById("user-lastname-search");
let resultsPerPage = document.getElementById("results-per-page");
let userIsMember = document.getElementById("user-ismember");
userIsMember.addEventListener("change", () => {
  userLoad(userFirstnameSearch.value, userLastnameSearch.value);
});
userFirstnameSearch.addEventListener("keyup", () => {
  userLoad(userFirstnameSearch.value, userLastnameSearch.value);
});
userLastnameSearch.addEventListener("keyup", () => {
  userLoad(userFirstnameSearch.value, userLastnameSearch.value);
});
resultsPerPage.addEventListener("change", () => {
  userLoad(userFirstnameSearch.value, userLastnameSearch.value);
});

userLoad();
function userLoad(
  userFirstname = "",
  userLastname = "",
  ismember = userIsMember.checked,
  page_number = 1
) {
  let formdata = new FormData();
  formdata.append("user-firstname", userFirstname);
  formdata.append("user-lastname", userLastname);
  formdata.append("results-per-page", resultsPerPage.value);
  formdata.append("isMember", ismember);
  formdata.append("page", page_number);
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "./includes/user_search.php", true);
  xhr.send(formdata);
  xhr.onreadystatechange = () => {
    if (xhr.readyState == 4 && xhr.status == 200) {
      //console.log(xhr.responseText);
      let response = JSON.parse(xhr.responseText);
      //console.log(response);
      let html = "";
      if (response.data.length > 0) {
        for (let count = 0; count < response.data.length; count++) {
          html +=
            `<tr class="user" id="user` +
            response.data[count].id +
            `" onclick="location.href = './user_profile/personal_information.php?id=` +
            response.data[count].id +
            `'">`;
          html += "<td>" + response.data[count].id + "</td>";
          html += "<td>" + response.data[count].firstname + "</td>";
          html += "<td>" + response.data[count].lastname + "</td>";
          html += "<td>" + response.data[count].email + "</td>";
          if (response.data[count].subscription !== null) {
            html += "<td>" + response.data[count].subscription + "</td>";
            html += "<td>" + response.data[count].datebegin + "</td>";
            html += "<td>" + response.data[count].dateend + "</td>";
          } else {
            html += "<td>None</td>";
            html += "<td>-</td>";
            html += "<td>-</td>";
          }
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
