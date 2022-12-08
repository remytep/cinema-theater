let popUpAddSubscriptionButton = document.getElementById(
  "popup-add-subscription-button"
);
let addSubscriptionButton = document.getElementById("add-subscription-button");
let addSubscriptionType = document.getElementById("add-subscription-type");
let addSubscriptionDate = document.getElementById("add-subscription-date");
let addSubscriptionTime = document.getElementById("add-subscription-time");

popUpAddSubscriptionButton.addEventListener("click", (e) => {
  e.preventDefault();
  openPopUpAddSubscription();
  document.body.addEventListener("click", function (e) {
    if (!e.target.classList.contains("popup-add-subscription")) {
      closePopUpAddSubscription();
    }
  });
});

function openPopUpAddSubscription() {
  document.getElementById("popup-add-subscription").style.display = "block";
  document.getElementById("popup-add-subscription").classList.add("highlight");
}
function closePopUpAddSubscription() {
  document.getElementById("popup-add-subscription").style.display = "none";
}

addSubscriptionButton.addEventListener("click", (e) => {
  e.preventDefault();
  addSubscription(
    userId,
    addSubscriptionType.value,
    addSubscriptionDate.value,
    addSubscriptionTime.value
  );
});

function addSubscription(
  userId,
  subscriptionType,
  subscriptionDate,
  subscriptionTime
) {
  let formdata = new FormData();
  formdata.append("user-id", userId);
  formdata.append("subscription-type", subscriptionType);
  formdata.append("subscription-date", subscriptionDate);
  formdata.append("subscription-time", subscriptionTime);
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "../includes/user_profile/subscriptions/add.php", true);
  xhr.send(formdata);
  location.reload();
}
