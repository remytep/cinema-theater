let moviesArr = [];

// Récupere un array des titres de films
let xhr = new XMLHttpRequest();
xhr.open("POST", "./includes/movie_list.php", true);
let formdata = new FormData();
xhr.send(formdata);
xhr.onreadystatechange = () => {
  if (xhr.readyState == 4 && xhr.status == 200) {
    let response = JSON.parse(xhr.responseText);
    for (let count = 0; count < response.length; count++) {
      moviesArr.push(response[count].title);
    }
  }
};
autocomplete(movieTitleAddSession, movieIdAddSession, moviesArr);
autocomplete(editMovieSessionTitle, editMovieSessionMovieId, moviesArr);

function autocomplete(input, id, arr) {
  var currentFocus;
  input.addEventListener("input", function (e) {
    var a,
      b,
      i,
      val = this.value;
    closeAllLists();
    if (!val) {
      return false;
    }
    currentFocus = -1;
    a = document.createElement("DIV");
    a.setAttribute("id", this.id + "autocomplete-list");
    a.setAttribute(
      "class",
      "autocomplete-items popup form-text p-1 text-dark bg-white"
    );
    this.parentNode.appendChild(a);
    let numberOfMatch = 0;
    for (i = 0; i < arr.length; i++) {
      /*check if the item starts with the same letters as the text field value:*/
      if (
        numberOfMatch < 7 &&
        arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()
      ) {
        /*create a DIV element for each matching element:*/
        numberOfMatch++;
        b = document.createElement("DIV");
        b.setAttribute("class", "p-1 popup");
        /*make the matching letters bold:*/
        b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
        b.innerHTML += arr[i].substr(val.length);
        /*insert a input field that will hold the current array item's value:*/
        b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
        let title = arr[i];
        /*execute a function when someone clicks on the item value (DIV element):*/
        b.addEventListener("click", function (e) {
          /*insert the value for the autocomplete text field:*/
          input.value = title;
          if (arr.includes(input.value)) {
            id.value = arr.indexOf(input.value) + 1;
          }
          closeAllLists();
        });
        a.appendChild(b);
      }
    }
  });
  /*execute a function presses a key on the keyboard:*/
  input.addEventListener("keydown", function (e) {
    var x = document.getElementById(this.id + "autocomplete-list");
    if (x) x = x.getElementsByTagName("div");
    if (e.keyCode == 40) {
      /*If the arrow DOWN key is pressed,
          increase the currentFocus variable:*/
      currentFocus++;
      /*and and make the current item more visible:*/
      addActive(x);
    } else if (e.keyCode == 38) {
      //up
      /*If the arrow UP key is pressed,
          decrease the currentFocus variable:*/
      currentFocus--;
      /*and and make the current item more visible:*/
      addActive(x);
    } else if (e.keyCode == 13) {
      /*If the ENTER key is pressed, prevent the form from being submitted,*/
      e.preventDefault();
      if (currentFocus > -1) {
        /*and simulate a click on the "active" item:*/
        if (x) x[currentFocus].click();
      }
    }
  });
  function addActive(x) {
    /*a function to classify an item as "active":*/
    if (!x) return false;
    /*start by removing the "active" class on all items:*/
    removeActive(x);
    if (currentFocus >= x.length) currentFocus = 0;
    if (currentFocus < 0) currentFocus = x.length - 1;
    /*add class "autocomplete-active":*/
    x[currentFocus].classList.add("autocomplete-active");
  }
  function removeActive(x) {
    /*a function to remove the "active" class from all autocomplete items:*/
    for (var i = 0; i < x.length; i++) {
      x[i].classList.remove("autocomplete-active");
    }
  }
  function closeAllLists(elmnt) {
    /*close all autocomplete lists in the document,
      except the one passed as an argument:*/
    var x = document.getElementsByClassName("autocomplete-items");
    for (var i = 0; i < x.length; i++) {
      if (elmnt != x[i] && elmnt != input) {
        x[i].parentNode.removeChild(x[i]);
      }
    }
  }
  /*execute a function when someone clicks in the document:*/
  document.addEventListener("click", function (e) {
    closeAllLists(e.target);
  });

  id.addEventListener("input", () => {
    if (0 < id.value && id.value < 2414) {
      input.value = arr[id.value - 1];
    } else {
      input.value = "";
    }
  });
}
