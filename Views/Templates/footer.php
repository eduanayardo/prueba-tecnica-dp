<script>
    const base_url = '<?php echo BASE_URL; ?>'
    <?php
        if (isset($_GET["error"])) {
            switch ($_GET["error"]) {
                case '1':
                    echo 'alert("Surgio un error al intentar crear el menú, intentelo nuevamente.")';
                    break;
                case '2':
                    echo 'alert("Surgio un error al intentar actualizar el menú, intentelo nuevamente.")';
                    break;
                case '3':
                    echo 'alert("Surgio un error al intentar eliminar el menú, intentelo nuevamente.")';
                    break;
            }
        }
    ?>
</script>
<script src="<?php echo URL_SUB_FOLDER . "/public/js/script-min.js"; ?>"></script>
</body>

</html>
