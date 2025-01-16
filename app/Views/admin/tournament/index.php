<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4>Liste des Tournois</h4>
                <a href="<?= base_url('/admin/tournament/new'); ?>"><i class="fa-solid fa-plus"></i></a>
            </div>
            <div class="card-body">
                <!--                Onglet des tournois-->
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="tournament-tab" data-bs-toggle="tab"
                                data-bs-target="#tournament" type="button" role="tab" aria-controls="tournament"
                                aria-selected="true">Tournois
                        </button>
                    </li>
                    <!--                    Onglet des participant-->
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="participant-tab" data-bs-toggle="tab"
                                data-bs-target="#participant" type="button" role="tab" aria-controls="participant"
                                aria-selected="false">Participant
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="scoreboard-tab" data-bs-toggle="tab"
                                data-bs-target="#scoreboard" type="button" role="tab" aria-controls="scoreboard"
                                aria-selected="false">Classement
                        </button>
                    </li>
                </ul>
                <div class="tab-content border p-3">
                    <!--                    Onglet des tournois-->
                    <div class="tab-pane active" id="tournament" role="tabpanel" aria-labelledby="tournament-tab"
                         tabindex="0">
                        <table id="tableTournaments" class="table table-hover">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Nom du Tournois</th>
                                <th>Id du jeu</th>
                                <th>Nombre de participants</th>
                                <th>Date de Début</th>
                                <th>Date de Fin</th>
                                <th>Voir les participants</th>
                                <th>Modifier</th>
                                <th>Actif</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <!--                    Onglet des participant-->
                    <div class="tab-pane" id="participant" role="tabpanel" aria-labelledby="participant-tab"
                         tabindex="0">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4>Liste des participant inscrit au tournois</h4>
                                <a href="<?= base_url('/admin/participant/new'); ?>"><i
                                            class="fa-solid fa-plus"></i></a>
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
<!--                                    <tr>-->
<!--                                        <td>--><?php //= $participant['id_tournament']; ?><!--</td>-->
<!--                                        <td>--><?php //= $participant['id_user']; ?><!--</td>-->
<!--                                        <td>-->
<!--                                            <a href="--><?php //= base_url('/' . $participant['id']); ?><!--">-->
<!--                                                <button class="btn btn-primary"><i class="fa-solid fa-eye"></i></i></button>-->
<!--                                            </a>-->
<!--                                        </td>-->
<!--                                    </tr>-->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="scoreboard" role="tabpanel" aria-labelledby="scoreboard-tab" tabindex="0">
                        bonjour
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        var baseUrl = "<?= base_url(); ?>";

        // Initialisation du tableau des tournois
        $('#tableTournaments').DataTable({
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "pageLength": 10,
            "language": {
                url: baseUrl + 'js/datatable/datatable-2.1.4-fr-FR.json',
            },
            "ajax": {
                "url": baseUrl + "admin/tournament/SearchTournament",
                "type": "POST"
            },
            "columns": [
                {"data": "id", "className": "text-center"},
                {
                    data: 'avatartournament_url',
                    sortable: false,
                    render: function (data) {
                        if (data) {
                            return `<img src="${baseUrl}${data}" alt="Avatar" style="max-width: 20px; height: auto;">`;
                        } else {
                            return `<img src="${baseUrl}assets/img/avatars/1.jpg" alt="Default Avatar" style="max-width: 20px; height: auto;">`;
                        }
                    },
                    "className": "text-center"
                },
                {"data": "name", "className": "text-center"},
                {"data": "id_game", "className": "text-center"},
                {"data": "nb_player", "className": "text-center"},
                {"data": "date_start", "className": "text-center"},
                {"data": "date_end", "className": "text-center"},
                {
                    data: 'id',
                    sortable: false,
                    render: function (data) {
                        return `<a href="${baseUrl}admin/participant"><i class="fa-solid fa-eye"></i></a>`;
                    },
                    "className": "text-center"
                },
                {
                    data: 'id',
                    sortable: false,
                    render: function (data) {
                        return `<a href="${baseUrl}admin/tournament/edit/${data}"><i class="fa-solid fa-pencil"></i></a>`;
                    },
                    "className": "text-center"
                },
                {
                    data: 'id',
                    sortable: false,
                    render: function (data, type, row) {
                        return (row.deleted_at === null ?
                            `<a title="Désactiver le jeu" href="${baseUrl}admin/tournament/deactivate/${row.id}"><i class="fa-solid fa-xl fa-toggle-on text-success"></i></a>` :
                            `<a title="Activer un jeu" href="${baseUrl}admin/tournament/activate/${row.id}"><i class="fa-solid fa-toggle-off fa-xl text-danger"></i></a>`);
                    },
                    "className": "text-center"
                }
            ]
        });

    });
</script>