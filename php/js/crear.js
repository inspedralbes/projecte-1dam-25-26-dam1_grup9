
        // Función de JavaScript para comprobar que los campos no estén vacíos
        //( si esta vacio muestra un mensaje de error) antes de enviar a PHP
        function validarForm(){

            let dept = document.getElementById("departament_id").value;
            let desc = document.getElementById("descripcio").value;

            let error = "";

            // Si no ha elegido ningún departamento de la lista
            if(dept == ""){
                error += "Has de seleccionar un departament<br>";
            }

            // Si la descripción tiene menos de 5 letras 
            if(desc.trim().length < 5){
                error += "La descripció és massa curta o no hi ha cap descripció<br>";
            }

            // Si existe algún error saldrá un mensaje de color rojo y los datos no se envia
            if(error != ""){
                document.getElementById("error").innerHTML = error;
                return false;  // Al devolver false, el formulario NO se envía
            }

            return true; // Al devolver true, el formulario se envía al PHP 
        }

