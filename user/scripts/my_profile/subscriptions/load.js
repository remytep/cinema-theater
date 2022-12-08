userSubscriptions();

function userSubscriptions() {
  let formdata = new FormData();
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "../includes/my_profile/subscriptions/load.php", true);
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
