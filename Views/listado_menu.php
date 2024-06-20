<?php include_once "templates/header.php"; ?>
<main>
    <div class="contenedor">
        <div class="titulo">
            Menús
            <a href="?action=create" class="boton">Nuevo</a>
        </div>
        <table class="paginated">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Menú padre</th>
                    <th>Descripción</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <?php
            foreach ($menus as $key => $menu) {
                echo "<tr>
                        <td>" . ($key + 1) . "</td>
                        <td>{$menu['nombre']}</td>
                        <td>{$menu['descripcion']}</td>
                        <td>" . ($menu['menu_id'] ? $menu['menu_id'] : '---') . "</td>
                        <td>
                            <a href='?action=edit&id={$menu['id']}' class='boton editar'>Editar</a>
                            <a href='Controllers/MenuController.php?action=delete&id={$menu['id']}' class='boton eliminar'>Eliminar</a>
                        </td>
                    </tr>";
            }
            ?>
        </table>
    </div>
</main>
<?php include_once "templates/footer.php"; ?>
