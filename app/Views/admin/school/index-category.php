<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4>Liste des Ecoles</h4>
        <a href="<?= base_url('/admin/CategorySchool/new'); ?>"><i class="fa-solid fa-plus"></i></a>
    </div>
    <div class="card-body">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="onglet-tab" data-bs-toggle="tab"
                        data-bs-target="#onglet" type="button" role="tab" aria-controls="onglet"
                        aria-selected="false">Catégories
                </button>
            </li>
        </ul>
        <table class="table table-hover">
            <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
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
                        <a href="<?= base_url('/admin/CategorySchool/'. $category['id']); ?>"> <i class="fa-solid fa-pen" style="color: green"></i>
                    </td>
                    <td>
                        <a href="<?= base_url('/admin/CategorySchool/delete/'. $category['id']); ?>" class="delete">
                            <i class="fa-solid fa-trash" style="color: red"></i>
                        </a>
                    </td>

                </tr>
            <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    $(document).ready(function () {
        var baseUrl = "<?= base_url(); ?>";
        var dataTable = $('#tableUsers').DataTable({
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "pageLength": 10,
            "language": {
                url: baseUrl + 'js/datatable/datatable-2.1.4-fr-FR.json',
            },
            "ajax": {
                "url": baseUrl + "admin/user/SearchUser",
                "type": "POST"
            },
            "columns": [
                {"data": "id"},
                {
                    data : 'avatar_url',
                    sortable : false,
                    render:function (data) {
                if (data) {
                    return `<img src="${baseUrl}${data}" alt="Avatar" style="max-width: 20px; height: auto;">`;
                } else {
                // Retourne une image par défaut si data est vide
                return '<img src="' + baseUrl + 'assets/img/avatars/1.jpg" alt="Default Avatar" style="max-width: 20px; height: auto;">';
                }
             }
        },
        {"data": "username"},
        {"data": "email"},
        {"data": "permission_name"},
        {
            data : 'id',
            bsortable:false,
            render:function (data) {
                return `<a href="${baseUrl}admin/user/${data}"><i class="fa-solid fa-pencil"></i></a>`;
            }
        },
        {
            data : 'id',
            sortable:false,
            render:function (data, type, row) {
                return (row.deleted_at === null ?
                    `<a title="Désactiver l'utilisateur" href="${baseUrl}admin/user/deactivate/${row.id}"><i class="fa-solid fa-xl fa-toggle-on text-success"></i>
                    </a>`:`< a title = "Activer un utilisateur" href = "${baseUrl}admin/user/activate/${row.id}" > <i class= "fa-solid fa-toggle-off fa-xl text-danger" > < /i></a> `);
            }
        }
        ]
        });
    });
</script>