<?php  
require_once "connexion.php";

$id = intval($_GET["codi"]);
$result = $conn->query("SELECT data_actuacio, descripcio, visible FROM actuacions Where incidencia_id = $id");

$actuacions = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Consultar incidència</title>

    <style>
         body {
            font-family: Arial;
            
        }

        table {
            
            border-collapse: collapse;
            width: 90%;
        }

        th, td {
            border: 1px solid black;
            padding: 8px;
        }

        th {
            background-color: #8270e7;
        }

        .botones {
            padding: 10px 20px;
            background-color: #49c4c9;
            text-decoration: none;
            color: black;
            
        }

        .botones:hover {
            background-color: #2091d3;
        }
    </style>
</head>

<body>

<div class="box">

    <h2>Consultar incidència</h2>

    <div class="form-box">
        <form method="GET">
            Codi incidència:
            <input type="number" name="codi" value="<?= htmlspecialchars($id ?? '') ?>">
            <button type="submit">Buscar</button>
        </form>
    </div>

    <h3>Actuacions visibles</h3>

    <table>
        <tr>
            <th>Data</th>
            <th>Descripció</th>
        </tr>
        
        <?php if ($id && count($actuacions) > 0): ?>
                <?php foreach ($actuacions as $a): ?>
                   <?php if ($a['visible'] == 1) { ?>
                        <tr>
                            <td><?= $a['data_actuacio'] ?></td>
                            <td><?= htmlspecialchars($a['descripcio']) ?></td>
                        </tr> 
                    <?php
                    }?>
                    
                <?php endforeach; ?>
        <?php elseif ($id): ?>
            <tr>
                <td colspan="3">No hi ha actuacions visibles</td>
            </tr>
        <?php endif; ?>

    </table>

<br><br>
<div style="text-align: left;">
    <a href="index.php" class="botones">Sortir</a>
</div>


</div>

</body>
</html>