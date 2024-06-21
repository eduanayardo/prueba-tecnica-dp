<?php include_once "templates/header.php"; ?>
<header>
    <nav class="navbar">
        <h1>Evaluación</h1>
        <div class="navbar-header">
            <span class="navbar-toggle" onclick="toggleMenu()">☰</span>
        </div>
        <ul class="menu" id="navbar-menu">
            <?php
            function menuHijos($menus, $parent_id)
            {
                foreach ($menus as $menu) {
                    if ($menu['menu_id'] == $parent_id) {
                        return true;
                    }
                }
                return false;
            }
            function renderizarMenu($menus, $menu_id = null, $nivel = 0)
            {
                foreach ($menus as $menu) {
                    if ($menu['menu_id'] == $menu_id) {
                        $menuHijo = menuHijos($menus, $menu['id']);
                        echo "<li class='" . (($menuHijo) ? "dropdown" : "") . "'>";
                        echo "<a href='#' data-descripcion='" . htmlspecialchars($menu['descripcion']) . "' onclick='mostrarDescripcion(event)'>" . htmlspecialchars($menu['nombre']) . "</a>";
                        if ($menuHijo) {
                            echo "<ul class='submenu'>";
                            renderizarMenu($menus, $menu['id'], $nivel + 1);
                            echo "</ul>";
                        }
                        echo "</li>";
                    }
                }
            }
            renderizarMenu($menus);
            ?>
        </ul>
    </nav>
</header>
<main>
    <div id="descripcion-box"></div>
    <div>
        <a href="<?php echo BASE_URL; ?>?accion=menuListado" class="boton">LISTADO DE MENUS</a><a href=""></a>
    </div>
</main>
<?php include_once "templates/footer.php"; ?>
