<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4>Liste des participant inscrit au tournois</h4>
        <a href="<?= base_url('/admin/participant/new'); ?>"><i class="fa-solid fa-plus"></i></a>
    </div>
    <div class="card-body">
        <table id="tableParticipants" class="table table-hover">
            <thead>
                <tr>
                    <th>ID tournois</th>
                    <th>ID user</th>
                    <th>Modifier</th>
                    <th>Actif</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
<script>
    $(document).ready(function () {
        var baseUrl = "<?= base_url(); ?>";
        var dataTable = $('#tableTournaments').DataTable({
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "pageLength": 10,
            "language": {
                url: baseUrl + 'js/datatable/datatable-2.1.4-fr-FR.json',
            },
            "ajax": {
                "url": baseUrl + "admin/participant/SearchParticipant",
                "type": "POST"
            },
            "columns": [
                {"data": "id", "className": "text-center"},
                // {
                //     data: 'avatar_url',
                //     sortable: false,
                //     render: function (data) {
                //         if (data) {
                //             return `<img src="${baseUrl}${data}" alt="Avatar" style="max-width: 20px; height: auto;">`;
                //         } else {
                //             return '<img src="' + baseUrl + 'assets/img/avatars/1.jpg" alt="Default Avatar" style="max-width: 20px; height: auto;">';
                //         }
                //     },
                //     "className": "text-center"
                // },
                {"data": "id_tournament", "className": "text-center"},
                {"data": "id_game", "className": "text-center"},
                // {
                //     data: 'id',
                //     sortable: false,
                //     render: function (data) {
                //         return `<a href="${baseUrl}admin/participant"><i class="fa-solid fa-eye"></i></a>`;
                //     },
                //     "className": "text-center"
                // },
                {
                    data: 'id',
                    sortable: false,
                    render: function (data) {
                        return `<a href="${baseUrl}admin/participant/edit/${data}"><i class="fa-solid fa-pencil"></i></a>`;
                    },
                    "className": "text-center"
                },
                {
                    data: 'id',
                    sortable: false,
                    render: function (data, type, row) {
                        return (row.deleted_at === null ?
                            `<a title="Désactiver le jeu" href="${baseUrl}admin/participant/deactivate/${row.id}"><i class="fa-solid fa-xl fa-toggle-on text-success"></i></a>` :
                            `<a title="Activer un jeu" href="${baseUrl}admin/participant/activate/${row.id}"><i class="fa-solid fa-toggle-off fa-xl text-danger"></i></a>`);
                    },
                    "className": "text-center"
                }
            ]
        });
    });
</script>