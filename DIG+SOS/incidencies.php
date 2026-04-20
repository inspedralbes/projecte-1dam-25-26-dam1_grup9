<?php
$mysqli = include_once "conexion.php";
$resultado = $mysqli->query("SELECT id, departament, fecha, descripcion FROM videojuegos");
$videojuegos = $resultado->fetch_all(MYSQLI_ASSOC); ?>

<table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Departament</th>
                    <th>Data</th>
                    <th>Descripció</th>
                    <th>Eliminar</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($videojuegos as $videojuego) { ?>
                    <tr>
                        <td><?php echo $videojuego["id"] ?></td>
                        <td><?php echo $videojuego["nombre"] ?></td>
                        <td><?php echo $videojuego["descripcion"] ?></td>
                        <td>
                            <a href="afegir_actuacio.php?id=<?php echo $videojuego["id"] ?>">Editar</a>
                        </td>

                    </tr>
                <?php } ?>
            </tbody>
        </table>