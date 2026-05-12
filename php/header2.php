<style>
   
    .fondo {
        background: linear-gradient(135deg, #0648c4, #25117e);
        font-family: arial;
        color: white;
        width: 100%;
    }

    .menu {
        display: flex;
        justify-content: center;
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .submenu {
        position: relative;
    }

    .boton {
        display: block;
        color: white;
        text-decoration: none;
        padding: 15px 25px;
        font-size: 14px;
        font-weight: 600;
        transition: 0.3s;
    }

    .boton:hover {
        background: rgba(255, 255, 255, 0.1);
        color: #23e2c2;
    }


    .inicio {
        background: #2d59e9;
        margin: 8px 10px;
        padding: 10px 20px 10px;
        border-radius: 4px;
    }


    .opciones {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        background: #ffffff;
        min-width: 200px;
        box-shadow: 0 8px 20px black;
    }

    .opciones a {
        color: #000000;
        padding: 12px 20px;
        display: block;
        text-decoration: none; 
    }

    .opciones a:hover {
        background: #f8f9fa;
        color: #2f00ff;
        padding-left: 25px;
    }

    .submenu:hover .opciones {
        display: block;
    }

   
</style>

<nav class="fondo">
   
    <ul class="menu">
        <li class="submenu">
            <a href="index.php" class="boton inicio">Inici</a>
        </li>

        <li class="submenu">
            <a href="elegir_tecnico.php" class="boton"> Tècnic</a>
        </li>

        <li class="submenu">
            <a class="boton">Admin <span>▼</span></a>
            <div class="opciones">
                <a href="informe.php">Informe de Tècnics</a>
                <a href="lista_prioritat.php">Modificar incidència</a>
                <a href="consumo.php">Consum per departaments</a>
                <a href="estadistica.php">Estadístiques d'Accés</a>
            </div>
        </li>

        <li class="submenu">
            <a class="boton">Usuari <span>▼</span></a>
            <div class="opciones">
                <a href="crear_incidencia.php">Registrar nova incidència</a>
                <a href="ver_estado.php">Veure estat incidència</a>
            </div>
        </li>

       
    </ul>
</nav>
