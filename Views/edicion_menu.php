<?php
include_once "templates/header.php";
$titulo = "Nuevo";
$edicion = 0;
if (isset($menu)) {
    $titulo = "Editar";
    $edicion = 1;
    $menu = (object) $menu;
}
// echo "<pre>"; print_r($menu); echo "</pre>"; die();
?>
<main>
    <div class="contenedor">
        <div class="titulo">
            <?php echo $titulo; ?> menú
        </div>
        <div class="errores">
            <?php if (!empty($errors)): ?>
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
        <form action="?action=create" method="post">
            <input type="hidden" id="id" name="id" value="<?php echo (($edicion == 1) ? $menu->id : 0); ?>">
            <div class="grupo-form">
                <label for="txtNombre">Nombre menú:</label>
                <input type="text" id="txtNombre" name="nombre"
                    value="<?php echo (($edicion == 1) ? $menu->nombre : ""); ?>" required>
            </div>
            <div class="grupo-form">
                <label for="txtDescripcion">Descripción:</label>
                <input type="text" id="txtDescripcion" name="descripcion"
                    value="<?php echo (($edicion == 1) ? $menu->descripcion : ""); ?>" required>
            </div>
            <div class="grupo-form">
                <label for="cmbMenuPadre">Menú padre:</label>
                <select id="cmbMenuPadre" name="menu_id" min="1">
                    <option value="0">Sin menú padre</option>
                    <?php
                    $stmt = $this->menu->read();
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $selected = "";
                        if ($edicion == 1) {
                            $selected = $row['id'] == $menu->menu_id ? 'selected' : '';
                        }

                        echo "<option value='" . $row['id'] . "' $selected>" . $row['nombre'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="grupo-form">
                <a href="<?php echo ""; ?>" class="boton eliminar">Cancelar</a><input type="submit" value="Actualizar"
                    class="boton editar">
            </div>
        </form>
</main>
<?php include_once "templates/footer.php"; ?>
