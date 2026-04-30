<?php include_once "header.php";
require_once "connexio.php";

function crear_incidencia($conn)
{
    //$nom = $_POST["nom_incidencia"];
    $departament_id = $_POST["departament_id"];
    $descripcio = $_POST["descripcio"];
    $sentencia = $conn->prepare("INSERT INTO incidencies (departament_id, descripcio) VALUES ( ?, ?)");
    $sentencia->bind_param("is", $departament_id, $descripcio);
      if ($sentencia->execute()) {
        echo "<p class='info'>Incidencia creada amb èxit!</p>";
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
<style>
    <?php
        echo file_get_contents("../css/crear.css"); 
    ?>
</style>
<!DOCTYPE html>
<html>
    <body>
    <h2 class="h1">Nova Incidència</h2>
<form action="crear_incidencia.php" method="POST">     
         <div class="cuerpo">
            <label for="tipus">Tipus d'incidència</label>
                <select name="tipus_incidencia" id="tipus" class="form-control" required>
                        <option value="">Selecciona una opció...</option>
                        <option value="hardware">Hardware </option>
                        <option value="software">Software</option>
                        <option value="xarxa">Xarxa i Internet</option>
                        <option value="altres">Altres</option>
                </select>
        <br>
        <br>
           
            <label for="departament_id">Departament</label>
                    <select name="departament_id" id="departament_id" class="form-control" required>
                            <option value="">Selecciona el id del teu departament</option>
                            <option value="1">1 </option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                    </select>
        <br>
        <br>
        
            <label for="data" >Data i Hora de registre</label>
                <input type="text"  name="data" id="data"  value="<?php echo date('d-m-Y H:i'); ?>"  readonly>
                    
        <br>
        <br>

           <!--<label for="nom_incidencia" >Titol de l'incidència</label>
                <input type="text" placeholder="Un titol curta" required> -->

        <br>
        <br>
          
        <fieldset>
            <legend for="descripcio" >Descripció detallada</legend><br>
            <textarea name="descripcio" id="descripcio"  style="height: 150px; width: 500px;" placeholder="Explica què ha passat..." required></textarea>
        </fieldset>
                    

        <br>
               
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