<!DOCTYPE html>
<html lang="es">
<head>
    <style>
        .crea_incidencia {
  /* Colors i fons */
  background: linear-gradient(135deg, #6e8efb, #a777e3);
  color: white;
  
  /* Mida i text */
  padding: 15px 35px;
  font-size: 18px;
  font-weight: 600;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  
  /* Bordes i forma */
  border: none;
  border-radius: 50px; /* Fa que sigui totalment arrodonit */
  cursor: pointer;
  
  /* Ombra i transició */
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
  transition: all 0.3s ease; /* Fa que el moviment sigui suau */
  outline: none;


    letter-spacing: 2px;  /* Espacio entre letras */
    padding: 15px 30px; 
    word-spacing: 5px;    /* Espacio entre palabras */
    line-height: 1.8;     /* Espacio entre renglones (interlineado) */

}
    </style>
    
</head>
<body>

<?php
// Comprobamos si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Obtenemos el valor del botón presionado
    $accion = $_POST['operacion'];

    switch ($accion) {
        case 'Guardar':
            echo "✅ Los datos han sido guardados correctamente.";
            break;
        case 'Eliminar':
            echo "⚠️ ¿Estás seguro de que quieres eliminar este registro?";
            break;
        case 'Cancelar':
            echo "❌ Operación cancelada.";
            break;
        default:
            echo "Acción no reconocida.";
    }
}
?>

<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <h1><b>BIENVENIDO A LA PAGINA DE INCIDENCIA DE LA EMPRESA</b></h1>
    
   <a  class="crea_incidencia">Crear una incidencia <br></a>
    <br> 
    <br>
   <a  class="crea_incidencia">Para ver estado de incidencia <br></a>
    <br>
    <br>
   <a  class="crea_incidencia">Consumo por departamento <br></a>
    <br>
    <br>
   <a  class="crea_incidencia">Estadistica de acceso <br></a>
        
</form>

</body>
</html>