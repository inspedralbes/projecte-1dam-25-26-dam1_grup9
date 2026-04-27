<?php
$mysqli = include_once "conexion.php";
$resultado = $mysqli->query("SELECT id, departament, fecha, descripcion FROM Incidencies");
$videojuegos = $resultado->fetch_all(MYSQLI_ASSOC); ?>

<table class="table">
            <thead>
                 <tr>
                    <th>Tipus d'incidència</th>
                    <th>ID Departament</th>
                    <th>Data i Hora</th>
                    <th>Descripció detallada</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($Incidencies as $Incidencies) { ?>
                    <tr>
                        <td><?= htmlspecialchars($fila['tipus']) ?></td>
                        <td><?= htmlspecialchars($fila['dept_id']) ?></td>
                        <td><?= htmlspecialchars($fila['data']) ?></td>
                        <td><?= htmlspecialchars($fila['descripcio']) ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>



