<?php include_once "header.php";
require_once "connexio.php";

function crear_incidencia($conn)
{
    $departament_id = $_POST["departament_id"];
    $descripcio = $_POST["descripcio"];
    $estat = $_POST["estat"];
    $data = date["Y-m-d H:i:s"];
    $sentencia = $conn->prepare("INSERT INTO incidencies (departament_id, descripcio, data_incidencia, estat) VALUES ( ?, ?, ?, ?)");
    $sentencia->bind_param("isss", $departament_id, $descripcio, $data, $estat);
      if ($sentencia->execute()) {
        echo "<h1 style='text-align:center;' class='info'>Incidencia creada amb èxit!</h1>";
        ?>
            <a href="index.php" class="botones">Retornar</a>
        <?php
    } else {
        echo "<p class='error'>Error al crear la teva incidencia: " . htmlspecialchars($sentencia->error) . "</p>";
    }

    // Tancar la declaració i la connexió
    $sentencia->close();
}


if ($_SERVER["REQUEST_METHOD"] == "POST"){
    crear_incidencia($conn);
}else{
?>

<!DOCTYPE html>
<html>
    <body>
    <h2 class="h1">Nova Incidència</h2>
<form action="crear_incidencia.php" method="POST">     
         <div class="cuerpo">
           
            <label for="departament_id">Departament</label>
                    <select name="departament_id" id="departament_id" class="form-control" required>
                            <option value="">Selecciona el teu departament</option>
                            <option value="1">Matematiques</option>
                            <option value="2">Informatica</option>
                            <option value="3">Historia</option>
                            <option value="4">Llengua</option>
                            <option value="5">Ciencies</option>
                    </select>
        <br>
        <br>
        
            
            <input type="hidden"  name="data_incidencia" id="data_incidencia"  value="<?php echo date('d/m/y'); ?>"  readonly>

           <!--<label for="nom_incidencia" >Titol de l'incidència</label>
                <input type="text" placeholder="Un titol curta" required> -->

        <br>
        <br>
          
        <fieldset>
            <legend for="descripcio" >Descripció detallada</legend><br>
            <textarea name="descripcio" id="descripcio"  style="height: 150px; width: 500px;" placeholder="Explica què ha passat..." required></textarea>
        </fieldset>
                    

        <br>
        <input type="hidden" name="estat" value="En revisio">     
        <div >
            <a href="index.php" class="botones">Sortir sense guardar</a>
                    
            <button type="submit" class="botones">Enviar Incidència</button>
        </div>

    </form>
</body>
</html>
<?php
}
?>