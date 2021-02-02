$(document).ready(function () {
    $('#table').DataTable({
        responsive: true,
        "paging": true,
        "ordering": true,
        "info": true,
        "language": {
            "lengthMenu": "Affiche _MENU_ entrées par page",
            "zeroRecords": "Aucun résultat ...",
            "info": "Montre la page _PAGE_ sur _PAGES_",
            "infoEmpty": "",
            "infoFiltered": "(Filtrer à partir de _MAX_ total enregistrés)",
            "paginate": {
                "next": "Suivant",
                "previous": "Précédent"
            },
            "search": "Rechercher"
        }
    });
});