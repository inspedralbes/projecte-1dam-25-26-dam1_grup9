<?php
require_once 'connexion.php';
include_once "logger.php";

$sql = " SELECT
        t.nom AS nom,
        i.id AS incidencia_id, 
        a.data_actuacio, 
        a.descripcio, 
        a.temps, 
        a.visible
    FROM incidencies i
    LEFT JOIN tecnics t ON i.tecnic_id = t.id
    LEFT JOIN actuacions a ON i.id = a.incidencia_id
    ORDER BY nom ASC, i.id DESC, a.data_actuacio ASC
";

$resultat = $conn->query($sql);

// si hay un error muestar un mensaje
if (!$resultat) {
    die("Error a la consulta: " . $conn->error);
}


$tecnics = [];
// lee fila por fila en forma de array
while ($fila = $resultat->fetch_assoc()) {
    //si no hay tecnico asignado que muestre un mensaje
    $tecnic = $fila['nom'] ?? 'Sense Tècnic Assignat';
    //se guarda el id de la incidencia
    $td = $fila['incidencia_id'];
    // si es la primera vez que lee este tecnico se crea una carpeta vacia 
    if (!isset($tecnics[$tecnic])) {
        $tecnics[$tecnic] = [];
    }
    // Si esta incidencia no ha sido registrada antes dentro de este técnico, se crea su fila (para evitar duplicado)
    if (!isset($tecnics[$tecnic][$td])) {
        $tecnics[$tecnic][$td] = [
            'id' => $td,
            'data_tancament' => $fila['data_tancament'] ?? null,
            'data_obertura' => $fila['data_obertura'] ?? null,
            'actuacions' => [] //la lista de las actuaciones que tiene esa incidencia 
        ];
    }
    // Si la fila contiene una actuación, se añade a la lista 'actuacions' => []
    $tecnics[$tecnic][$td]['actuacions'][] = [
        'data_actuacio' => $fila['data_actuacio'],
        'descripcio' => $fila['descripcio'],
        'temps' => $fila['temps'],
        'visible' => $fila['visible']
    ];
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Registrar actuació</title>
 <link rel="stylesheet" href="css/informe_actuacio.css">
</head>

<body>

    <header>
        <h1>Informe d'actuació</h1>
    </header>
    <?php include "header2.php" ?>
    <fieldset>

        <h2>Historial d'actuacions</h2>

            <?php if (count($tecnics) > 0): ?>  
                <!--En cada array de tecnico guarda su nombre y dentro guardas la lista de incidencia -->
                <?php foreach ($tecnics as $nom => $incidencies): ?>
                 <h3>Tècnic assignat:  <span style="color: blue;"><?= htmlspecialchars((string)$nom) ?></span></h3>
                    
                    <fieldset>
                        <!-- Cada incidencia guardame sus valores -->
                        <?php foreach ($incidencies as $i): ?>
                        <h3>Incidència ID: <?= htmlspecialchars((string)$i['id']) ?></h3>
                            <table>
                                <tr>
                                    <th>Data de actuació</th>
                                    <th>Descripció</th>
                                    <th>Temps</th>
                                    <th>Visible</th>
                                    <th>Data de la finalització </th>
                                </tr>
                                <!--Guarda dentro de cada incidencia sus actuaciones y si no hay pon un mensaje-->
                                <?php foreach ($i['actuacions'] as $a): ?>
                                    <tr>
                                        <td><?php if ($a['data_actuacio']): ?>
                                                <?= htmlspecialchars((string)($a['data_actuacio'])) ?>
                                            <?php else: ?>
                                                <span style="color: grey; font-style: italic;">No hi ha actuació</span>
                                            <?php endif; ?>
                                        </td>

                                        <td><?php if ($a['descripcio']): ?>
                                                <?= htmlspecialchars((string)($a['descripcio'] ?? '')) ?>
                                            <?php else: ?>
                                                <span style="color: grey; font-style: italic;">---</span>
                                            <?php endif; ?>
                                        </td>

                                        <td><?php if ($a['temps']): ?>
                                                <?= htmlspecialchars((string)($a['temps'] ?? '')) ?> min
                                            <?php else: ?>
                                                <span style="color: grey; font-style: italic;">---</span>
                                            <?php endif; ?>
                                        </td>

                                        <td><?= $a['visible'] ? "Sí" : "No" ?></td>

                                        <td> <?php if ($i['data_tancament']): ?>
                                                <?= htmlspecialchars((string)$t['data_tancament']) ?>
                                            <?php else: ?>
                                                <span style="color: grey; font-style: italic;">Pendent de tancament</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                    <?php endforeach; ?>
                    </fieldset>
                <?php endforeach; ?>
            <?php endif; ?>               
    </fieldset>

    </div>
        <br>
        <a href="administrador.php" class="botones" > Salir </a>

</body>
</html>
