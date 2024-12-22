<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4>Liste des écoles</h4>
        <a href="<?= base_url('/admin/school/new'); ?>"><i class="fa-solid fa-plus"></i></a>
    </div>
    <div class="card-body">
        <table class="table table-hover">
            <thead>
            <tr>
                <th>ID</th>
                <th>Nom de l'école</th>
                <th>Ville</th>
                <th>Catégorie</th>
                <th>Modifier</th>
                <th>Actif</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($schools as $school): ?>
                <tr>
                    <td><?= htmlspecialchars($school['id']); ?></td>
                    <td><?= htmlspecialchars($school['name']); ?></td>
                    <td><?= htmlspecialchars($school['city']); ?></td>
                    <td><?= htmlspecialchars($school['category_name']); ?></td>
                    <td>
                        <a href="<?= base_url('/admin/school/edit/'. $school['id']); ?>"><i class="fa-solid fa-pencil"></i></a>
                    </td>
                    <td>
                        <?= ($school['deleted_at'] === null) ?
                            "<a title='Désactiver lécole' href='" . base_url("admin/school/deactivate/{$school['id']}") . "'><i class='fa-solid fa-xl fa-toggle-on text-success'></i></a>" :
                            "<a title='Activer lécole' href='" . base_url("admin/school/activate/{$school['id']}") . "'><i class='fa-solid fa-toggle-off fa-xl text-danger'></i></a>";
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