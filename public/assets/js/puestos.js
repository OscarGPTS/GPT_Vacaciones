// $(document).ready(function() {

//     $('#formNuevoPuesto').submit(function(e) {
//         e.preventDefault();
//           $('#formNuevoPuesto').validate();
//     })

// });

let btnGuardar = document.getElementById('btnGuardar');

btnGuardar.addEventListener('click', function(){
     $("#formNuevoPuesto").submit();
})

let btnCoordinacion = document.getElementById("btnCoordinacion");
let btnCoordinacionExterna = document.getElementById("btnCoordinacionExterna");


let tableCoordinacionExterna = document.getElementById(
    "tableCoordinacionExterna"
);

btnCoordinacion.addEventListener("click", function () {
    let newRow = tableCoordinacion.insertRow(-1);

    newRow.insertCell().innerHTML =
        " <input type='text' class='form-control' id='coordinacion' name='coordinacion[coordina]'  required></input>";
    newRow.insertCell(1).innerHTML =
        " <input type='text' class='form-control' id='coordinacion' name='coordinacion[depto]'  required></input>";
    newRow.insertCell(-1).innerHTML =
        "<button class='btn btn-xs btn-primary' type='button' id='btnCoordinacion' onclick='borrarFilaCorrdinacion(this)'>Borrar fila</button>";
});

btnCoordinacionExterna.addEventListener("click", function () {
    let newRow = tableCoordinacionExterna.insertRow(-1);

    newRow.insertCell().innerHTML =
        " <input type='text' class='form-control' id='externo' name='externo[empresa]'  required></input>";
    newRow.insertCell(1).innerHTML =
        " <input type='text' class='form-control' id='externo' name='externo[motivo]'  required></input>";
    newRow.insertCell(-1).innerHTML =
        "<button class='btn btn-xs btn-primary' type='button' id='btnCoordinacion' onclick='borrarFilaExterna(this)'>Borrar fila</button>";
});

function borrarFilaCorrdinacion(fila){

     let i = fila.parentNode.parentNode.rowIndex;
     document.getElementById("tableCoordinacion").deleteRow(i);
}

function borrarFilaExterna(fila){

     let i = fila.parentNode.parentNode.rowIndex;
     document.getElementById("tableCoordinacionExterna").deleteRow(i);
}
