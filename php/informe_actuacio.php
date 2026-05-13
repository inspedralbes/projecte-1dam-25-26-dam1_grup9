<?php
require_once 'connexion.php';
include_once "logger.php";

$query = " SELECT
        t.nom AS nom,
        i.id AS incidencia_id, 
        a.data_actuacio, 
        a.descripcio, 
        a.temps, 
        a.visible
    FROM incidencies i
    LEFT JOIN actuacions a ON i.id = a.incidencia_id
    LEFT JOIN tecnics t ON i.tecnic_id = t.id
    ORDER BY nom ASC, i.id DESC, a.data_actuacio ASC
";

$resultat = $conn->query($query);

if (!$resultat) {
    die("Error a la consulta: " . $conn->error);
}


$tecnics = [];
while ($fila = $resultat->fetch_assoc()) {
    $tecnic = $fila['nom'] ?? 'Sense Tècnic Assignat';
    $td = $fila['incidencia_id'];
    
    if (!isset($tecnics[$tecnic])) {
        $tecnics[$tecnic] = [];
    }
    
    if (!isset($tecnics[$tecnic][$td])) {
        $tecnics[$tecnic][$td] = [
            'id' => $td,
            'data_tancament' => $fila['data_tancament'] ?? null,
            'data_obertura' => $fila['data_obertura'] ?? null,
            'actuacions' => []
        ];
    }
    
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
<style>
    header {
                background: linear-gradient(to right, #23e2c2, #6a8bf0);
                color: white;
                padding: 20px;
                font-family: Arial;
                text-align: center;
    }
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
        color : white;
    }
    input{
        padding: 8px;  
        border: 1px solid #000000;
    }

    .botones {
        padding: 10px 15px;
        background: #8270e7;
        border: none;
        text-decoration: none;
        color: white;
        border-radius: 5px;
        margin: 10px 20px;
    }

    .botones:hover {
        background: #a27ee7;
    }
    fieldset {
        margin: 20px;
        padding: 20px ;
        border: 2px solid #000000;
        border-radius: 5px;
        
    }
    

</style>
</head>

<body>

    <header>
        <h1>Informe d'actuació</h1>
    </header>
    <?php include "header2.php" ?>
    <fieldset>

        <h2>Historial d'actuacions</h2>

            <?php if (count($tecnics) > 0): ?>  
                <?php foreach ($tecnics as $nom => $incidencies): ?>
                 <h3>Tècnic assignat:  <span style="color: blue;"><?= htmlspecialchars((string)$nom) ?></span></h3>
                    
                    <fieldset>
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