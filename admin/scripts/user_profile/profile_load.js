const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);
const userId = urlParams.get("id");
// Set les liens de la navbar
document
  .getElementById("navbar-brand-title")
  .setAttribute("href", "./personal_information.php?id=" + userId);
document
  .getElementById("user-personal-information")
  .setAttribute("href", "./personal_information.php?id=" + userId);
document
  .getElementById("user-subscriptions")
  .setAttribute("href", "./subscriptions.php?id=" + userId);
document
  .getElementById("user-history")
  .setAttribute("href", "./history.php?id=" + userId);

profileLoad(userId);

function profileLoad(userId) {
  let formdata = new FormData();
  formdata.append("user-id", userId);
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "../includes/user_profile/profile_load.php", true);
  xhr.send(formdata);
  xhr.onreadystatechange = () => {
    if (xhr.readyState == 4 && xhr.status == 200) {
      let response = JSON.parse(xhr.responseText);
      let user = response[0];
      //Set les informations personnelles de l'utilisateur
      document.getElementById("page-title").innerHTML =
        user["firstname"] + " " + user["lastname"];
      document.getElementById("profile-name").innerHTML =
        user["firstname"] + " " + user["lastname"] + "'s Profile";
      document.getElementById("navbar-brand-title").innerHTML =
        user["firstname"] + " " + user["lastname"];
    }
  };
}
