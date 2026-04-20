<?php include_once " "; ?>
<div class="row">
    <div class="col-12">
        <h1>Creació d'incidencia</h1>
        <form action=" " method="POST">
            <div class="form-group">
                <label for="departament">Departament</label>
                <input placeholder="Departament on s'ha produit l'incidencia " class="form-control" type="text" name="departament" id="departament" required>
            </div>

            <div class="form-group">
                <label for="data">Data de l'incidencia</label>
                <input type="date" class="form-control" name="data" id="data" required>
            </div>
            <div class="form-group"><button class="btn btn-success">Guardar</button></div>
        </form>
    </div>
</div>
<?php include_once " "; ?>