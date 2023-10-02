//FUNCIÓN PARA VALIDAR CAMPOS DE TEXTO.
function validarCampoDeTexto(idCampo, maximo){
    const campoTexto = document.getElementById(idCampo);
    campoTexto.addEventListener('input', function(event) {
        const texto = campoTexto.value;
  if (/[^a-zA-Záéíóú ]/.test(texto)) {
    campoTexto.value = texto.replace(/[^a-zA-Záéíóú ]/g, '');
  }

  const maxLength = maximo; // Máximo de caracteres permitidos
  if (texto.length > maxLength) {
    campoTexto.value = texto.slice(0, maxLength);
  }
});
}

validarCampoDeTexto('idNombre', 48)

//VALIDACIÓN DE CAMPOS NUMÉRICOS.
function validarCampoNumerico(idCampo, maximo){
  const campoNumero = document.getElementById(idCampo);
  
  campoNumero.addEventListener('input', function(event) {
    const numero = parseInt(campoNumero.value, 10);
    
    if (!isNaN(numero) && numero > maximo) {
      campoNumero.value = maximo;
    }
    if (!isNaN(numero) && numero < 0) {
      campoNumero.value = '0';
    }
  });
}

validarCampoNumerico('idCedula', 999999999)
validarCampoNumerico('idMate', 20)
validarCampoNumerico('idFisica', 20)
validarCampoNumerico('idProg', 20)

//ENTRADA DE DATOS QUE SERÁN ENVIADOS AL PHP.
function insertar() {

        let params = {
            'Nombre' : document.getElementById('idNombre').value,
            'Cedula' : document.getElementById('idCedula').value,
            'Mate' : document.getElementById('idMate').value,
            'Fis' : document.getElementById('idFisica').value,
            'Prog': document.getElementById('idProg').value,
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
              
              //Para actualizar los datos del resumen:
              resumen()
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
          
            //MOSTRAR EN HTML DATOS DE MATEMÁTICAS
            const res_mat1 = document.getElementById('promedio_mat'),
                  res_mat2 = document.getElementById('aprobados_mat'),
                  res_mat3 = document.getElementById('reprobados_mat'),
                  res_mat4 = document.getElementById('max_mat');
            res_mat1.innerHTML = "Promedio: " + resp[0].promedio_mat;
            res_mat2.innerHTML = "Alumnos aprobados: " + resp[0].aprobados_mat;
            res_mat3.innerHTML = "Alumnos reprobados: " + resp[0].reprobados_mat;
            res_mat4.innerHTML = "Nota máxima: " + resp[0].max_mat;

            //MOSTRAR EN HTML DATOS DE FÍSICA
            const res_fis1 = document.getElementById('promedio_fis'),
                  res_fis2 = document.getElementById('aprobados_fis'),
                  res_fis3 = document.getElementById('reprobados_fis'),
                  res_fis4 = document.getElementById('max_fis');
            res_fis1.innerHTML = "Promedio: " + resp[0].promedio_fis;
            res_fis2.innerHTML = "Alumnos aprobados: " + resp[0].aprobados_fis;
            res_fis3.innerHTML = "Alumnos reprobados: " + resp[0].reprobados_fis;
            res_fis4.innerHTML = "Nota máxima: " + resp[0].max_fis;

            //MOSTRAR EN HTML DATOS DE PROGRAMACIÓN
            const res_prog1 = document.getElementById('promedio_prog'),
                  res_prog2 = document.getElementById('aprobados_prog'),
                  res_prog3 = document.getElementById('reprobados_prog'),
                  res_prog4 = document.getElementById('max_prog');
            res_prog1.innerHTML = "Promedio: " + resp[0].promedio_prog;
            res_prog2.innerHTML = "Alumnos aprobados: " + resp[0].aprobados_prog;
            res_prog3.innerHTML = "Alumnos reprobados: " + resp[0].reprobados_prog;
            res_prog4.innerHTML = "Nota máxima: " + resp[0].max_prog;

            const res_resumen1 = document.getElementById('pasaron_todos'),
                  res_resumen2 = document.getElementById('pasaron_una'),
                  res_resumen3 = document.getElementById('pasaron_dos');
            res_resumen1.innerHTML = "Pasaron todas las materias: " + resp[0].pasaron_todo;
            res_resumen2.innerHTML = "Pasaron una materia: " + resp[0].pasaron_una;
            res_resumen3.innerHTML = "Pasaron dos materias: " + resp[0].pasaron_dos;
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