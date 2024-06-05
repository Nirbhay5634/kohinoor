function toggleMenu() {
  var menu = document.getElementById("menu");
  if (menu.style.display === "block") {
    menu.style.display = "none";
  } else {
    menu.style.display = "block";
  }
}

document.addEventListener("click", function (event) {
  var menu = document.getElementById("menu");
  var menuIcon = document.querySelector(".menu-icon");

  // Check if the clicked element is not part of the menu or the menu icon
  if (!menu.contains(event.target) && event.target !== menuIcon) {
    menu.style.display = "none";
  }
});
