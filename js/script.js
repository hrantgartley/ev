document.addEventListener("DOMContentLoaded", () => {
    let menuButton = document.querySelector(".menu-btn");
    let menu = document.querySelector(".menu");
    let menuLinks = document.querySelectorAll(".menu a");
    let close = document.querySelector("#close-icon");

    const toggleMenu = () => {
        menu.style.display = menu.style.display === "block" ? "none" : "block";
    };
    menuButton.addEventListener("click", toggleMenu);
    close.addEventListener("click", toggleMenu);

    menuLinks.forEach((link) => {
        link.addEventListener("click", () => {
            toggleMenu();
        });
    });
});
