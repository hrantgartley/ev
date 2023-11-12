document.addEventListener("DOMContentLoaded", function () {
  var menuButton = document.querySelector(".menu-btn");
  var menu = document.querySelector(".menu");
  var menuLinks = document.querySelectorAll(".menu a");
  var close = document.querySelector("#close-icon");

  function toggleMenu() {
    menu.style.display = menu.style.display === "block" ? "none" : "block";
  }

  menuButton.addEventListener("click", toggleMenu);
  close.addEventListener("click", toggleMenu);

  menuLinks.forEach(function (link) {
    link.addEventListener("click", function () {
      toggleMenu();
    });
  });
});
