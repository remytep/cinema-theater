userSubscriptions(userId);

function userSubscriptions(userId) {
  let formdata = new FormData();
  formdata.append("user-id", userId);
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "../includes/user_profile/subscriptions/load.php", true);
  xhr.send(formdata);
  xhr.onreadystatechange = () => {
    if (xhr.readyState == 4 && xhr.status == 200) {
      let response = JSON.parse(xhr.responseText);
      let html = "";
      if (response.data.length > 0) {
        for (let count = 0; count < response.data.length; count++) {
          html += "<tr class='align-middle'>";
          html += "<td>" + response.data[count].subscriptionName + "</td>";
          html +=
            "<td>" + response.data[count].subscriptionDescription + "</td>";
          html += "<td>" + response.data[count].datebegin + "</td>";
          html += "<td>" + response.data[count].dateend + "</td>";
          html +=
            "<td><button class='btn btn-warning edit popup' value=" +
            response.data[count].membershipId +
            " id=edit" +
            response.data[count].membershipId +
            " onclick='editButton(this.value)'>Edit</button></td>";
          html +=
            "<td><button class='btn btn-danger delete popup' value=" +
            response.data[count].membershipId +
            " id=delete" +
            response.data[count].membershipId +
            " onclick='deleteButton(this.value)'>Delete</button></td>";
          html += "</tr>";
        }
      } else {
        html +=
          '<tr><td colspan="6" class="text-center">No subscriptions found</td></tr>';
      }
      document.getElementById("post-data").innerHTML = html;
      document.getElementById("number-results").innerHTML = response.total_data;
    }
  };
}
