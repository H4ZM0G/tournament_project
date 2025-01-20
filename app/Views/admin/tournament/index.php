<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4>Liste des Tournois</h4>
                <a href="<?= base_url('/admin/tournament/new'); ?>"><i class="fa-solid fa-plus"></i></a>
            </div>

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
                {
                    "data": "date_start",
                    "className": "text-center",
                    "render": function (data) {
                        return formatDateToEuropean(data);
                    }
                },
                {
                    "data": "date_end",
                    "className": "text-center",
                    "render": function (data) {
                        return formatDateToEuropean(data);
                    }
                },
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

        // Fonction pour formater une date en format européen (dd/mm/yyyy)
        function formatDateToEuropean(dateString) {
            if (!dateString) return '';
            const date = new Date(dateString);
            if (isNaN(date)) return dateString; // Si la date est invalide, retourner telle quelle
            const day = String(date.getDate()).padStart(2, '0');
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const year = date.getFullYear();
            return `${day}/${month}/${year}`;
        }
    });
</script>