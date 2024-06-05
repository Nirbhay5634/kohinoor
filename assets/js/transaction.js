function rowPerPage() {
  document
    .getElementById("rowPerPageActive")
    .classList.add(
      "van-dropdown-menu__title--active",
      "van-dropdown-menu__title--down"
    );
  var selector = document.getElementById("rowPerPageSelector");
  if (selector.style.display == "none" || selector.style.display == "") {
    selector.style.display = "flex";
    // selector.style.top = "auto";
  } else {
    selector.style.display = "none";
  }
}

function updateRowsPerPage(value) {
  document.getElementById("rowPerPageActive").innerText = value;
  document.getElementById("rowPerPageSelector").style.display = "none";
}

function handlePagination(action) {
  if (action === "first") {
    document.getElementById("toast__text").innerHTML = "First Page now.";
    document.getElementById("van-toast").style.display = "flex";
    setTimeout(function () {
      document.getElementById("van-toast").style.display = "none";
    }, 3000);
  } else if (action === "last") {
    document.getElementById("toast__text").innerHTML = "Last Page now.";
    document.getElementById("van-toast").style.display = "flex";
    setTimeout(function () {
      document.getElementById("van-toast").style.display = "none";
    }, 3000);
  }
}
