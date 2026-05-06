<?php

require_once "connexion.php";

$result = $conn->query("SELECT COUNT(*) as total FROM accessos");
$row = $result->fetch_assoc();
$total = $row['total'];


$pagines = $conn->query("SELECT pagina, COUNT(*) as total
    FROM accessos
    GROUP BY pagina
");


$usuaris = $conn->query("SELECT usuari, COUNT(*) as total
    FROM accessos
    GROUP BY usuari
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Estadísticas</title>
</head>

<style>
body {
    font-family: Arial;
   
}

table {
    width: 95%;
    border-collapse: collapse;
}

th, td {
    border: 1px solid black;
    padding: 8px;
}

th {
    background: #8270e7;
}

textarea {
    width: 50%;
    margin: 5px;
}

.botones {
    padding: 10px 15px;
    background: #8270e7;
    border: none;
    cursor: pointer;
    text-decoration: none;
    color: white;
}

.botones:hover {
    background: #a27ee7;
}
</style>

<body>

<h2>Estadísticas de acceso en els departaments</h2>


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

<a href="index.php" class="botones" style="margin-top: 20px; display: inline-block;">Inicio</a>

</body>
</html>