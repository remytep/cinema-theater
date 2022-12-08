staffInfo(userId);

function staffInfo(userId) {
  let formdata = new FormData();
  formdata.append("user-id", userId);
  let xhr = new XMLHttpRequest();
  xhr.open(
    "POST",
    "../includes/user_profile/personal_information/staff_info_load.php",
    true
  );
  xhr.send(formdata);
  xhr.onreadystatechange = () => {
    if (xhr.readyState == 4 && xhr.status == 200) {
      let response = JSON.parse(xhr.responseText);
      let user = response[0];
      if (response !== "None") {
        let html = "";
        html += '<h3 class="text-center p-3">Staff Information</h3>';
        html +=
          '<div class="py-2"><h4 class="text-decoration-underline">Job Name : </h>';
        html += "<h5>" + user["jobName"] + "</h5></div>";
        html +=
          '<div class="py-2"><h4 class="text-decoration-underline">Executive : </h>';
        if (user["executive"] == "1") {
          html += "<h5>Yes</h5></div>";
        } else {
          html += "<h5>No</h5></div>";
        }
        html +=
          '<div class="py-2"><h4 class="text-decoration-underline">Job Description : </h>';
        html += "<h5>" + user["jobDescription"] + "</h5></div>";
        html +=
          '<div class="py-2"><h4 class="text-decoration-underline">Job Salary : </h>';
        html += "<h5>" + user["jobSalary"] + "</h5></div>";
        html +=
          '<div class="py-2"><h4 class="text-decoration-underline">Joined : </h>';
        html += "<h5>" + user["dateBegin"] + "</h5></div>";

        document.getElementById("staff-info").innerHTML = html;
      }
    }
  };
}
