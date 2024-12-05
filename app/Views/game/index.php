<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4>Liste des Jeux</h4>
        <a href="<?= base_url('/admin/game/new'); ?>"><i class="fa-solid fa-user-plus"></i></a>
    </div>
    <div class="card-body">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="profil-tab" data-bs-toggle="tab" data-bs-target="#profil"
                        type="button" role="tab" aria-controls="profil" aria-selected="true">Écoles
                </button>
            </li>
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
                <th>Ville</th>
                <th>Modifier</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($schools as $school): ?>
                <tr>
                    <td><?= $school['id']; ?></td>
                    <td><?= $school['name']; ?></td>
                    <td><?= $school['city']; ?></td>
                    <td><a href="<?= base_url('/admin/school/' . $school['id']); ?>"> <i
                                class="fa-solid fa-pen"></i></a></td>
                    <td> <?= $school['deleted_at'] === null ? '<span class="text-success">Actif</span>' : '<span class="text-danger">Supprimé</span>'; ?></td>
                    <td> <?php if ($school['deleted_at'] === null): ?>
                            <!-- Bouton pour désactiver -->
                            <a href="<?= base_url("admin/school/deactivate/{$school['id']}"); ?>" title="Désactiver"><i
                                    class="fa-solid fa-toggle-on text-success"></i></a>
                        <?php else: ?>
                            <!-- Bouton pour activer -->
                            <a href="<?= base_url("admin/school/activate/{$school['id']}"); ?>" title="Activer"><i
                                    class="fa-solid fa-toggle-off text-danger"></i></a>
                        <?php endif; ?>
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