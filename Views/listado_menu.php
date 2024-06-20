<?php include_once "templates/header.php"; ?>
<main>
    <div class="contenedor">
        <div class="titulo">
            Menús
            <a href="<?php echo BASE_URL; ?>?action=menuNuevo" class="boton">Nuevo</a>
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
                $menu = (object)$menu;

                echo "<tr>
                        <td>" . ($key + 1) . "</td>
                        <td>{$menu->nombre}</td>
                        <td>{$menu->padre}</td>
                        <td>{$menu->descripcion}</td>
                        <td>
                            <a href='".BASE_URL."?action=menuActualizar&id={$menu->id}' class='boton editar'>Editar</a>
                            <a href='".BASE_URL."?action=menuEliminar&id={$menu->id}' class='boton eliminar'>Eliminar</a>
                        </td>
                    </tr>";
            }
            ?>
        </table>
    </div>
</main>
<?php include_once "templates/footer.php"; ?>
