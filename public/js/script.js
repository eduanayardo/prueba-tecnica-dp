document.querySelectorAll("table.paginated").forEach(function (table) {
  var currentPage = 0;
  var numPerPage = 5;

  function repaginate() {
    var rows = table.querySelectorAll("tbody tr");
    rows.forEach(function (row, index) {
      row.style.display =
        index >= currentPage * numPerPage &&
        index < (currentPage + 1) * numPerPage
          ? ""
          : "none";
    });
  }

  repaginate();

  var numRows = table.querySelectorAll("tbody tr").length;
  var numPages = Math.ceil(numRows / numPerPage);
  var pager = document.createElement("div");
  pager.className = "pager";

  for (var page = 0; page < numPages; page++) {
    var pageNumber = document.createElement("span");
    pageNumber.className = "page-number clickable";
    pageNumber.textContent = page + 1;
    pageNumber.addEventListener("click", function (event) {
      currentPage = parseInt(event.target.textContent) - 1;
      repaginate();
      pager.querySelectorAll(".page-number").forEach(function (span) {
        span.classList.remove("active");
      });
      event.target.classList.add("active");
    });
    pager.appendChild(pageNumber);
  }

  table.insertAdjacentElement("afterend", pager);
  pager.querySelector(".page-number").classList.add("active");
});

function mostrarDescripcion(event) {
  event.preventDefault();
  const description = event.currentTarget.getAttribute("data-descripcion");
  const descriptionBox = document.getElementById("descripcion-box");
  descriptionBox.textContent = description;
}
function confirmarEliminacion(event) {
  console.log("entro");
  event.preventDefault();
  if (confirm("¿Desea eliminar el menú?")) {
    console.log("confirmo");
    const id_menu = event.currentTarget.getAttribute("data-id");
    window.location = base_url + "?accion=menuEliminar&id=" + id_menu;
  }
}

document.addEventListener("DOMContentLoaded", function () {
  const menuItems = document.querySelectorAll(".menu li.dropdown");

  menuItems.forEach(function (menuItem) {
    menuItem.addEventListener("mouseenter", function () {
      this.classList.add("active");
    });

    menuItem.addEventListener("mouseleave", function () {
      this.classList.remove("active");
    });
  });
});

function toggleMenu() {
  const menu = document.getElementById("navbar-menu");
  if (menu.style.display === "block") {
    menu.style.display = "none";
  } else {
    menu.style.display = "block";
  }
}