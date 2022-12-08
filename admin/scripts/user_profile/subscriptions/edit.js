let editButtons = document.getElementsByClassName("edit");
let popUpEditSubscriptionButton = document.getElementById(
  "popup-edit-subscription-button"
);
let editSubscriptionType = document.getElementById("edit-subscription-type");
let editSubscriptionDate = document.getElementById("edit-subscription-date");
let editSubscriptionTime = document.getElementById("edit-subscription-time");

function openPopUpEditSubscription() {
  document.getElementById("popup-edit-subscription").style.display = "block";
  document.getElementById("popup-edit-subscription").classList.add("highlight");
}
function closePopUpEditSubscription() {
  document.getElementById("popup-edit-subscription").style.display = "none";
}

function editButton(value) {
  openPopUpEditSubscription();
  document.body.addEventListener("click", function (e) {
    if (!e.target.classList.contains("popup")) {
      closePopUpEditSubscription();
    }
  });
  popUpEditSubscriptionButton.addEventListener("click", (e) => {
    e.preventDefault();
    editSubscription(
      value,
      editSubscriptionType.value,
      editSubscriptionDate.value,
      editSubscriptionTime.value
    );
  });
}
function editSubscription(
  subscriptionId,
  subscriptionType,
  subscriptionDate,
  subscriptionTime
) {
  let formdata = new FormData();
  formdata.append("subscription-id", subscriptionId);
  formdata.append("subscription-type", subscriptionType);
  formdata.append("subscription-date", subscriptionDate);
  formdata.append("subscription-time", subscriptionTime);
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "../includes/user_profile/subscriptions/edit.php", true);
  xhr.send(formdata);
  //location.reload();
}
