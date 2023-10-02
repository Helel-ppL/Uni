//FUNCIÓN PARA VALIDAR CAMPOS DE TEXTO.
function validarCampoDeTexto(idCampo){
    const campoTexto = document.getElementById(idCampo);
    campoTexto.addEventListener('input', function(event) {
        const texto = campoTexto.value;
  if (/[^a-zA-Záéíóú ]/.test(texto)) {
    campoTexto.value = texto.replace(/[^a-zA-Záéíóú ]/g, '');
  }

  const maxLength = 16; // Máximo de caracteres permitidos
  if (texto.length > maxLength) {
    campoTexto.value = texto.slice(0, maxLength);
  }
});
}

validarCampoDeTexto('idNombre')
validarCampoDeTexto('idApellido')

//VALIDACIÓN DE CAMPO DE EDAD.
const campoNumero = document.getElementById('idEdad');

campoNumero.addEventListener('input', function(event) {
  const numero = parseInt(campoNumero.value, 10);
  
  if (!isNaN(numero) && numero > 99) {
    campoNumero.value = '99';
  }
  if (!isNaN(numero) && numero < 0) {
    campoNumero.value = '0';
  }
});

//ENTRADA DE DATOS QUE SERÁN ENVIADOS AL PHP.
function insertar() {
    let opcionSexo = $('input[name="sexo"]:checked').val();
    let opcionEdo = $('input[name="estado_civil"]:checked').val();
    let sueldo = $('#sueldo').val();

        let params = {
            'Nombre' : document.getElementById('idNombre').value,
            'Apellido' : document.getElementById('idApellido').value,
            'Edad' : document.getElementById('idEdad').value,
            'Sexo' : opcionSexo,
            'Estado': opcionEdo,
            'Sueldo':sueldo
        };
    
        console.log(params);
        $.ajax({
            type: "POST",
            url: "assets/php/insertar.php",
            dataType: "json",
            data: params,
            beforeSend: function () {
                console.log("Insertando los datos del BACK");
            },
            success: function (resp) {
               console.log(resp);
               if(resp[0].resp == "success"){
                document.getElementById("resp").innerHTML = `<div class="alert alert-success" role="alert">
                ${resp[0].message}
              </div>`;
              
              resumen();
               }
               if(resp[0].resp == "error"){
                document.getElementById("resp").innerHTML = `<div class="alert alert-danger" role="alert">
                ${resp[0].message}
              </div>`;
               }
            },
            fail: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus);
                console.log(errorThrown)
            }
        });
    
}
   
//REPORTES DE LA BDD.
function resumen(){
    $.ajax({
        type: "GET",
        url: "assets/php/resumen.php",
        dataType: "json",
        beforeSend: function () {
            console.log("Esperando los datos del BACK");
        },
        success: function (resp) {
            console.log(resp);
            
            res1.innerHTML = "Total de empleados del sexo femenino:  " + resp[0].res1;

            res2.innerHTML = "Total de hombres casados que ganan más de 2500Bs: " + resp[0].res2;

            res3.innerHTML = "Total de mujeres viudas que ganan más de 1000Bs: " + resp[0].res3;

            res4.innerHTML = "Edad promedio de los hombres: " + resp[0].res4;
        },
        fail: function (jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(textStatus);
            console.log(errorThrown)
        }
    })
}

resumen();