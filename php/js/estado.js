
                // Función de JavaScript para comprobar que los campos no estén vacíos
                //( si esta vacio muestra un mensaje de error) antes de enviar a PHP
                function validarForm(){

                let codi = document.getElementById("codi").value;
                let error = "";

                // Da error si está vacío, si no es un número (isNaN) o si es menor o igual a 0
                if(codi == "" || isNaN(codi) || parseInt(codi) <= 0){
                    error += "Id invàlid<br>";
                }

                // Si existe algún error saldrá un mensaje de color rojo y los datos no se envia
                if(error != ""){
                    document.getElementById("error").innerHTML = error;
                    return false; // Al devolver false, el formulario NO se envía
                }

                return true; // Al devolver true, el formulario se envía al PHP 
            }
