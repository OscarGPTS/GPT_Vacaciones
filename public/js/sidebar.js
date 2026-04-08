var hamburger = document.querySelector(".hamburger");
hamburger.addEventListener("click", function () {
    document.querySelector("body").classList.toggle("active");
});

document.addEventListener("DOMContentLoaded", function () {
    const menuItems = document.querySelectorAll(".menu__item");

    menuItems.forEach((item) => {
        item.addEventListener("click", function () {
            const subMenu = this.querySelector(".submenu");
            // Cerrar todos los submenús antes de abrir el actual
            closeAllSubMenus();
            if (subMenu) {
                subMenu.classList.toggle("show");
            }
        });
    });
});

function closeAllSubMenus() {
    const openSubMenus = document.querySelectorAll(".submenu.show");
    openSubMenus.forEach((subMenu) => {
        subMenu.classList.remove("show");
    });
}

// SIDEBAR ejemplosw 2
// let arrow = document.querySelectorAll(".arrow");
// for (var i = 0; i < arrow.length; i++) {
//   arrow[i].addEventListener("click", (e)=>{
//  let arrowParent = e.target.parentElement.parentElement;//selecting main parent of arrow
//  arrowParent.classList.toggle("showMenu");
//   });
// }

// let sidebar = document.querySelector(".sidebar");
// let sidebarBtn = document.querySelector(".bx-menu");
// // console.log(sidebarBtn);
// sidebarBtn.addEventListener("click", ()=>{
//   sidebar.classList.toggle("close");
// });
