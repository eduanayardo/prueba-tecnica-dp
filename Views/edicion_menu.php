<?php
include_once "templates/header.php";
$titulo = "Nuevo";
$edicion = 0;
if (isset($menu)) {
    $titulo = "Editar";
    $edicion = 1;
    $menu = (object) $menu;
}

$stmt = $this->menu->getMenus();
?>
<main>
    <div class="">
        <div class="titulo">
            <?php echo $titulo; ?> menú
        </div>
        <div class="errores">
            <?php
                if (!empty($errors)) {
            ?>
                    <ul>
                        <?php
                            foreach ($errors as $error){
                                echo "<li>".htmlspecialchars($error)."</li>";
                            }
                        ?>
                    </ul>
            <?php
                }
            ?>
        </div>
        <form action="?accion=<?php echo (($edicion == 0)?"menuNuevo":"menuActualizar"); ?>" method="post">
            <input type="hidden" id="id" name="id" value="<?php echo (($edicion == 1) ? $menu->id : 0); ?>">
            <div class="grupo-form">
                <label for="cmbMenuPadre">Menú padre:</label>
                <select id="cmbMenuPadre" name="menu_id" min="1">
                    <option value="0">Sin menú padre</option>
                    <?php
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $selected = "";
                        $show = "";
                        if ($edicion == 1) {
                            $selected = $row['id'] == $menu->menu_id ? 'selected' : '';
                            $show = $row['id'] == $menu->id ? 'style="display: none"' : '';
                        }
                        echo "<option value='" . $row['id'] . "' $selected $show>" . $row['nombre'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="grupo-form">
                <label for="txtNombre">Nombre menú:</label>
                <input type="text" id="txtNombre" name="nombre"
                    value="<?php echo (($edicion == 1) ? $menu->nombre : ""); ?>" required>
            </div>
            <div class="grupo-form">
                <label for="txtDescripcion">Descripción:</label>
                <textarea name="descripcion" id="txtDescripcion" rows="5" required><?php echo (($edicion == 1) ? $menu->descripcion : ""); ?></textarea>
            </div>
            <div class="grupo-form">
                <a href="<?php echo BASE_URL; ?>?accion=menuListado" class="boton eliminar">Cancelar</a><input type="submit" value="<?php echo (($edicion == 0)?"Guardar":"Actualizar"); ?>"
                    class="boton editar">
            </div>
        </form>
</main>
<?php include_once "templates/footer.php"; ?>
