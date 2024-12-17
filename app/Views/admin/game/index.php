<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4>Liste des jeux</h4>
        <a href="<?= base_url('/admin/game/new'); ?>"><i class="fa-solid fa-plus"></i></a>
    </div>
    <div class="card-body">
        <table class="table table-hover">
            <thead>
            <tr>
                <th>ID</th>
                <th>Nom du jeu</th>
                <th>Catégorie</th>
                <th>Modifier</th>
                <th>Actif</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($games as $game): ?>
                <tr>
                    <td><?= htmlspecialchars($game['id']); ?></td>
                    <td><?= htmlspecialchars($game['name']); ?></td>
                    <td><?= htmlspecialchars($game['category_name']); ?></td>
                    <td>
                        <a href="<?= base_url("admin/game/edit/{$game['id']}"); ?>"><i class="fa-solid fa-pencil"></i></a>
                    </td>
                    <td>
                        <?= ($game['deleted_at'] === null) ?
                            "<a title='Désactiver le jeu' href='" . base_url("admin/game/deactivate/{$game['id']}") . "'><i class='fa-solid fa-xl fa-toggle-on text-success'></i></a>" :
                            "<a title='Activer le jeu' href='" . base_url("admin/game/activate/{$game['id']}") . "'><i class='fa-solid fa-toggle-off fa-xl text-danger'></i></a>";
                        ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<script>
    $(document).ready(function () {
        var baseUrl = "<?= base_url(); ?>";
        var dataTable = $('#gameTable').DataTable({
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": baseUrl + "admin/game/SearchGame", // Assurez-vous que cette route est correcte
                "type": "POST"
            },
            "columns": [
                {"data": "id"},
                {"data": "name"},
                {
                    "data": "id",
                    "sortable": false,
                    "render": function(data) {
                        return `<a href="${baseUrl}admin/game/edit/${data}"><i class="fa-solid fa-pencil"></i></a>`;
                    }
                },
                {
                    "data": "id",
                    "sortable": false,
                    "render": function(data, type, row) {
                        return (row.deleted_at === null ?
                            `<a title="Désactiver le jeu" href="${baseUrl}admin/game/deactivate/${data}"><i class="fa-solid fa-xl fa-toggle-on text-success"></i></a>` :
                            `<a title="Activer le jeu" href="${baseUrl}admin/game/activate/${data}"><i class="fa-solid fa-toggle-off fa-xl text-danger"></i></a>`);
                    }
                }
            ],
            "language": {
                "url": baseUrl + 'js/datatable/datatable-2.1.4-fr-FR.json',
            }
        });
    });
</script>