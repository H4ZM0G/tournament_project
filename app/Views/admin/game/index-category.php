<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4>Liste des catégories</h4>
        <a href="<?= base_url('/admin/categorygame/new'); ?>"><i class="fa-solid fa-plus"></i></a>
    </div>
    <div class="card-body">
        <table class="table table-hover">
            <thead>
            <tr>
                <th>ID</th>
                <th>Nom de la catégorie</th>
                <th>Slug</th>
                <th>Modifier</th>
                <th>Supprimer</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($categories as $category): ?>
                <tr>
                    <td><?= $category['id']; ?></td>
                    <td><?= $category['name']; ?></td>
                    <td><?= $category['slug']; ?></td>
                    <td>
                        <a href="<?= base_url('/admin/CategoryGame/'. $category['id']); ?>"> <i class="fa-solid fa-pen" style="color: green"></i>
                    </td>
                    <td>
                        <a href="<?= base_url('/admin/CategoryGame/delete/'. $category['id']); ?>" class="delete">
                            <i class="fa-solid fa-trash" style="color: red"></i>
                        </a>
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
        var dataTable = $('#categoryTable').DataTable({
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": baseUrl + "admin/categorygame/SearchGameCategory", // Assurez-vous que cette route est correcte
                "type": "POST"
            },
            "columns": [
                {"data": "id"},
                {"data": "name"},
                {
                    "data": "id",
                    "sortable": false,
                    "render": function (data) {
                        return `<a href="${baseUrl}admin/categorygame/edit/${data}"><i class="fa-solid fa-pencil"></i></a>`;
                    }
                },
                {
                    "data": "id",
                    "sortable": false,
                    "render": function (data, type, row) {
                        return (row.deleted_at === null ?
                            `<a title="Désactiver les catégorie" href="${baseUrl}admin/categorygame/deactivate/${data}"><i class="fa-solid fa-xl fa-toggle-on text-success"></i></a>` :
                            `<a title="Activer les catégrorie" href="${baseUrl}admin/categorygame/activate/${data}"><i class="fa-solid fa-toggle-off fa-xl text-danger"></i></a>`);
                    }
                }
            ],
            "language": {
                "url": baseUrl + 'js/datatable/datatable-2.1.4-fr-FR.json',
            }
        });
    });
</script>