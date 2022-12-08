userProfile();

function userProfile() {
  let formdata = new FormData();
  let xhr = new XMLHttpRequest();
  xhr.open(
    "POST",
    "../includes/my_profile/personal_information/load.php",
    true
  );
  xhr.send(formdata);
  xhr.onreadystatechange = () => {
    if (xhr.readyState == 4 && xhr.status == 200) {
      let response = JSON.parse(xhr.responseText);
      let user = response[0];
      //Set les informations personnelles de l'utilisateur      document.getElementById("page-title").innerHTML =
      document.getElementById("user-email").innerHTML = user["email"];
      document.getElementById("user-address").innerHTML =
        user["address"] +
        ", " +
        user["city"] +
        " " +
        user["zipcode"] +
        ", " +
        user["country"];
      document.getElementById("user-birthdate").innerHTML = user["birthDate"];
    }
  };
}
