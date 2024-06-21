/**
 * Paginación de tablas con clase "paginated"
 *
 * Este script agrega funcionalidad de paginación a todas las tablas
 * con la clase "paginated". La paginación divide las filas de la tabla
 * en páginas de un número especificado de filas por página.
 */

document.querySelectorAll("table.paginated").forEach(function (table) {
	var currentPage = 0; // Página actual
	var numPerPage = 5; // Número de filas por página

	/**
	 * Repaginar las filas de la tabla
	 *
	 * Este método muestra solo las filas correspondientes a la página actual
	 * y oculta las demás filas.
	 *
	 * @access private
	 */
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

	// Inicializa la paginación
	repaginate();

	var numRows = table.querySelectorAll("tbody tr").length; // Número total de filas
	var numPages = Math.ceil(numRows / numPerPage); // Número total de páginas
	var pager = document.createElement("div");
	pager.className = "pager";

	// Crea los controles de paginación
	for (var page = 0; page < numPages; page++) {
		var pageNumber = document.createElement("span");
		pageNumber.className = "page-number clickable";
		pageNumber.textContent = page + 1;

		/**
		 * Manejador de evento para el cambio de página
		 *
		 * Este método cambia la página actual y actualiza la visualización
		 * de las filas de la tabla.
		 *
		 * @access private
		 * @param {Event} event El evento del clic
		 */
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

	// Inserta el control de paginación después de la tabla
	table.insertAdjacentElement("afterend", pager);
	pager.querySelector(".page-number").classList.add("active");
});

/**
 * Muestra la descripción de un elemento del menú
 *
 * Este método muestra la descripción de un elemento del menú
 * en un cuadro de descripción cuando se hace clic en el elemento.
 *
 * @access public
 * @param {Event} event El evento del clic
 */
function mostrarDescripcion(event) {
	event.preventDefault();
	const description = event.currentTarget.getAttribute("data-descripcion");
	const descriptionBox = document.getElementById("descripcion-box");
	descriptionBox.textContent = description;
}

/**
 * Confirma la eliminación de un menú
 *
 * Este método muestra un cuadro de confirmación para verificar si el usuario
 * desea eliminar el menú. Si el usuario confirma, redirige a la URL para eliminar el menú.
 *
 * @access public
 * @param {Event} event El evento del clic
 */
function confirmarEliminacion(event) {
	event.preventDefault();
	if (confirm("¿Desea eliminar el menú?")) {
		const id_menu = event.currentTarget.getAttribute("data-id");
		window.location = base_url + "?accion=menuEliminar&id=" + id_menu;
	}
}

/**
 * Inicializa los eventos del DOM cuando el contenido está cargado
 *
 * Este método agrega eventos de mouse a los elementos del menú
 * para mostrar y ocultar submenús.
 *
 * @access public
 */
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

/**
 * Alterna la visibilidad del menú de navegación
 *
 * Este método muestra u oculta el menú de navegación en dispositivos móviles.
 *
 * @access public
 */
function toggleMenu() {
	const menu = document.getElementById("navbar-menu");
	if (menu.style.display === "block") {
		menu.style.display = "none";
	} else {
		menu.style.display = "block";
	}
}
