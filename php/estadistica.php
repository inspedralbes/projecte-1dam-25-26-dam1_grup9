<?php
// 1. CONEXIÓN A LA BASE DE DATOS
require_once "connexio.php";

// 2. CONSULTA: TOTAL ACCESOS
$result = $conn->query("SELECT COUNT(*) as total FROM accessos");
$row = $result->fetch_assoc();
$total = $row['total'];

// 3. CONSULTA: PÁGINAS MÁS VISITADAS
$pagines = $conn->query("
    SELECT pagina, COUNT(*) as total
    FROM accessos
    GROUP BY pagina
");

// 4. CONSULTA: USUARIOS MÁS ACTIVOS
$usuaris = $conn->query("
    SELECT usuari, COUNT(*) as total
    FROM accessos
    GROUP BY usuari
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Estadísticas</title>
</head>

<body>

<h2>Estadísticas de acceso</h2>

<!-- RESUMEN -->
<h3>Resumen</h3>
<p>Accesos totales: <?= $total ?></p>

<!-- PÁGINAS -->
<h3>Páginas más visitadas</h3>
<table border="1">
<tr>
    <th>Página</th>
    <th>Accesos</th>
</tr>

<?php while($p = $pagines->fetch_assoc()): ?>
<tr>
    <td><?= $p['pagina'] ?></td>
    <td><?= $p['total'] ?></td>
</tr>
<?php endwhile; ?>

</table>

<!-- USUARIOS -->
<h3>Usuarios más activos</h3>
<table border="1">
<tr>
    <th>Usuario</th>
    <th>Accesos</th>
</tr>

<?php while($u = $usuaris->fetch_assoc()): ?>
<tr>
    <td><?= $u['usuari'] ?></td>
    <td><?= $u['total'] ?></td>
</tr>
<?php endwhile; ?>

</table>

</body>
</html>