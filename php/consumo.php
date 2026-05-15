<?php
require_once "connexion.php";
include_once "logger.php";

// Consulta el id del departamento, nombre del departamento, número total de incidencias de ese departamento
// y tiempo total invertido en actuaciones relacionadas a ese departamento
$sql = ("SELECT DISTINCT i.departament_id, d.departament_nom AS departament_nom, (SELECT COUNT(*) FROM incidencies i2 WHERE i2.departament_id = i.departament_id) AS num_incidencies,
(SELECT COALESCE(SUM(a.temps),0) FROM actuacions a
JOIN incidencies i3 ON i3.id = a.incidencia_id WHERE i3.departament_id = i.departament_id) AS temps_total
FROM incidencies i
JOIN departament d ON d.id = i.departament_id
ORDER BY i.departament_id
");
//ejecuta la consulta sql
$resultat = $conn->query($sql);

//si la consulta no funciona mostrara un mensaje de error
if ($resultat) {
    $data = $resultat->fetch_all(MYSQLI_ASSOC);
} else {
    echo "Error en la consulta: " . $conn->error;
}

$departaments = $resultat->fetch_all(MYSQLI_ASSOC);

//guardar tiempo 
$tempsArray = array();
//guardar departamento
$deptArray = array();
// Guardará número incidencias
$numArray = array();
?>


<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Consum per Departaments</title>
<link rel="stylesheet" href="css/consumo.css">

</head>

<body>

<div>
    <header>
        <h2>Consum per Departaments</h2>
    </header>
    <?php include "header2.php" ?>    
    <table>
        <tr>
            <th>Departament</th>
            <th>Nombre total d'incidències</th>
            <th>Temps total</th>
        </tr>

        <?php if (count($data) > 0): ?>
            <?php foreach ($data as $d): ?>
                <?php
                $tempsArray[] = $d['temps_total'];
                $deptArray[] = $d['departament_nom']; 
                $numArray[] = $d['num_incidencies'];
                ?>

                <tr>
                    <td><?= htmlspecialchars($d['departament_nom']) ?></td>
                    <td><?= $d['num_incidencies'] ?></td>
                    <td><?= $d['temps_total'] ?> min</td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="3">No hi ha dades</td>
            </tr>
        <?php endif; ?>

    </table>

    <div style="width: 50%; margin: auto; margin-top: 30px; display: flex; justify-content: center; gap: 20px;">
        <canvas id="myChart" width="400" height="400"></canvas>
        <script  src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <script>
            const ctx = document.getElementById('myChart');

            new Chart (ctx, {
                type: 'pie',
                data: {
                    //etiquetas departamento
                    labels: <?php echo json_encode($deptArray); ?>,
                    datasets: [{
                        label: 'Temps total (min)',
                        // Valores 
                        data: <?php echo json_encode($tempsArray); ?>,
                        borderWidth: 1
                    }]
                },
                options: {
                    plugins: {
                        title: {
                            //titulo del grafico
                            display: true,
                            text: 'Consum de Temps Total per Departaments'
                        }
                    },
                    scales: {

                        y: {
                            beginAtZero: true

                        }

                    }
                    
                }
            });
        </script>

        <canvas id="myChart2" width="400" height="400"></canvas>
        <script  src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const ctx2 = document.getElementById('myChart2');

            new Chart (ctx2, {
                type: 'pie',
                data: {
                    // Etiquetas departamentos
                    labels: <?php echo json_encode($deptArray); ?>,
                    datasets: [{ 
                        label: 'Nombre d\'incidències totals',
                        // Valores incidencias
                        data: <?php echo json_encode($numArray); ?>,
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {

                        y: {
                            beginAtZero: true

                        }

                    },
                    plugins: {
                        //titulo del grafico
                        title: {
                            display: true,
                            text: 'Nombre d\'incidències totals per Departament'
                        }
                    }
                }
            });
        </script>
    </div>
    <br>
</div>
<div>
    <br>
    <a href="administrador.php" class="inicio">Inicio</a>
</div>


</body>
</html>