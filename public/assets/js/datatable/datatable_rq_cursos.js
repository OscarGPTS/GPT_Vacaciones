$(document).ready(function () {

    $("#tabla-mis-rq").DataTable({
           language: {
               url: "//cdn.datatables.net/plug-ins/1.11.4/i18n/es_es.json",
           },
           responsive: true,
           order: [], // Evita que se ordene de forma alfabetica la columna id
       })

});
