<?php include_once "templates/header.php"; ?>
<header>
    <nav>
        <div class="contenedor">
            <h1>Evaluación</h1>
            <ul class="menu">
                    <?php
                    function renderizarMenu($menus, $menu_id = null, $nivel = 0)
                    {
                        foreach ($menus as $menu) {
                            if ($menu['menu_id'] == $menu_id) {
                                echo "<li class='item-menu'>" . htmlspecialchars($menu['nombre']). "</li>";
                                echo "<ul class='submenu'>";
                                    renderizarMenu($menus, $menu['id'], $nivel + 1);
                                echo "</ul>";
                            }
                        }
                    }
                    renderizarMenu($menus);
                ?>
            </ul>
        </div>
    </nav>
</header>
<?php include_once "templates/footer.php"; ?>
