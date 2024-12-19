<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4>Liste des jeux</h4>
        <a href="<?= base_url('/admin/game/new'); ?>"><i class="fa-solid fa-plus"></i></a>
    </div>
    <div class="card-body">
        <table id="tableGames" class="table table-hover">
            <thead>
            <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Nom du jeu</th>
                <th>Catégorie</th>
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
        var dataTable = $('#tableGames').DataTable({
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "pageLength": 10,
            "language": {
                url: baseUrl + 'js/datatable/datatable-2.1.4-fr-FR.json',
            },
            "ajax": {
                "url": baseUrl + "admin/game/SearchGame",
                "type": "POST"
            },
            "columns": [
                {"data": "id"},
                {
                    data : 'avatargame_url',
                    sortable : false,
                    render : function(data) {
                        if (data) {
                            return `<img src="${baseUrl}${data}" alt="Avatar" style="max-width: 20px; height: auto;">`;
                        } else {
                            // Retourne une image par défaut si data est vide
                            return '<img src="' + baseUrl + 'assets/img/avatars/1.jpg" alt="Default Avatar" style="max-width: 20px; height: auto;">';
                        }
                    }
                },
                {"data": "name"},
                {"data": "id_category"},
                {
                    data : 'id',
                    sortable : false,
                    render : function(data) {
                        return `<a href="${baseUrl}admin/game/${data}"><i class="fa-solid fa-pencil"></i></a>`;
                    }
                },
                {
                    data : 'id',
                    sortable : false,
                    render : function(data, type, row) {
                        return (row.deleted_at === null ?
                            `<a title="Désactiver le jeu" href="${baseUrl}admin/game/deactivate/${row.id}"><i class="fa-solid fa-xl fa-toggle-on text-success"></i></a>`: `<a title="Activer un jeu"href="${baseUrl}admin/game/activate/${row.id}"><i class="fa-solid fa-toggle-off fa-xl text-danger"></i></a>`);
                    }
                }
            ]
        });
    });

</script>