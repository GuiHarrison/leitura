jQuery(document).ready(function ($) {
  // Formatando a data para ordenação correta
  $.fn.dataTable.moment('DD/MM/YYYY');

  // Inicializando DataTables
  $('#rh_table').DataTable({
    "order": [[0, "desc"]], // Ordenar por data decrescente
    "language": {
      "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Portuguese-Brasil.json"
    }
  });
});
