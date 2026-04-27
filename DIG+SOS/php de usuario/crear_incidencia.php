<?php include_once "header.php";  ?>

<style>
    <?php 
    
    echo file_get_contents("../css/crear.css"); 
    ?>
</style>
        
    <h2 class="h1">Nova Incidència</h2>
            
        <form action="incidencies.php" method="POST">    
               
         <div class="cuerpo">
            <label for="tipus">Tipus d'incidència</label>
                <select name="tipus" id="tipus" class="form-control" required>
                        <option value="">Selecciona una opció...</option>
                        <option value="hardware">Hardware </option>
                        <option value="software">Software</option>
                        <option value="xarxa">Xarxa i Internet</option>
                        <option value="altres">Altres</option>
                </select>
        <br>
        <br>
           
            <label for="departament_id">Departament</label>
                    <select name="tipus" id="tipus" class="form-control" required>
                            <option value="">Selecciona una opció...</option>
                            <option value="info">Informàtica </option>
                            <option value="fisica">Fisica</option>
                            <option value="mates">Mates</option>
                            <option value="profe">Profesores</option>
                    </select>
        <br>
        <br>
        
            <label for="data" >Data i Hora de registre</label>
                <input type="text"  name="data" id="data"  value="<?php echo date('d-m-Y H:i'); ?>"  readonly>
                    
        <br>
        <br>

            <label for="data" >Titol de l'incidència</label>
                <input type="text" placeholder="Un titol curta" riquired>

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


<?php  ?>