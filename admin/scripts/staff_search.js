let userSearch = document.getElementById("user-search");
let userFirstnameSearch = document.getElementById("user-firstname-search");
let userLastnameSearch = document.getElementById("user-lastname-search");
let userJobSearch = document.getElementById("user-job-search");
let resultsPerPage = document.getElementById("results-per-page");

userFirstnameSearch.addEventListener("keyup", () => {
  staffLoad(
    userFirstnameSearch.value,
    userLastnameSearch.value,
    userJobSearch.value
  );
});
userLastnameSearch.addEventListener("keyup", () => {
  staffLoad(
    userFirstnameSearch.value,
    userLastnameSearch.value,
    userJobSearch.value
  );
});
userJobSearch.addEventListener("keyup", () => {
  staffLoad(
    userFirstnameSearch.value,
    userLastnameSearch.value,
    userJobSearch.value
  );
});
resultsPerPage.addEventListener("change", () => {
  staffLoad(
    userFirstnameSearch.value,
    userLastnameSearch.value,
    userJobSearch.value
  );
});

staffLoad();
function staffLoad(
  userFirstname = "",
  userLastname = "",
  userJob = "",
  page_number = 1
) {
  let formdata = new FormData();
  formdata.append("user-firstname", userFirstname);
  formdata.append("user-lastname", userLastname);
  formdata.append("user-job", userJob);
  formdata.append("results-per-page", resultsPerPage.value);
  formdata.append("page", page_number);
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "./includes/staff_search.php", true);
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
          html += "<td>" + response.data[count].jobName + "</td>";
          html += "<td>" + response.data[count].jobDescription + "</td>";
          html += "<td>" + response.data[count].jobSalary + "</td>";
          if (response.data[count].executive == 1) {
            html += "<td>Yes</td>";
          } else {
            html += "<td>No</td>";
          }
          html += "<td>" + response.data[count].dateBegin + "</td>";
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
