$(document).ready(function () {
    $('#table').DataTable({
        responsive: true,
        paging: true,
        ordering: true,
        info: true,
        language: {
            lengthMenu: "Nombre d'éléments par page: _MENU_",
            zeroRecords: "Aucun résultat ...",
            info: "Page _PAGE_ sur _PAGES_",
            infoEmpty: "",
            infoFiltered: "(Filtrer à partir de _MAX_ total enregistrés)",
            paginate: {
                "next": "Suivant",
                "previous": "Précédent"
            },
            search: "",
            searchPlaceholder: "Rechercher"
        }
    });
});