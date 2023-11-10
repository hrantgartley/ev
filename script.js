document.addEventListener("DOMContentLoaded", function () {
  var menuButton = document.querySelector(".menu-btn");
  var menu = document.querySelector(".menu");
  var menuLinks = document.querySelectorAll(".menu a");

  menuButton.addEventListener("click", function () {
    menu.style.display = menu.style.display === "block" ? "none" : "block";
  });

  menuLinks.forEach(function (link) {
    link.addEventListener("click", function () {
      menu.style.display = "none";
    });
  });
});
