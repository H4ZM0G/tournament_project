<div class="row">
    <div class="col">
        <form action="<?= isset($tournois) ? base_url("/admin/tournament/update") : base_url("/admin/tournament/create") ?>"
              method="POST" enctype="multipart/form-data">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">
                        <?= isset($tournois) ? "Editer " . $tournois['name'] : "Créer un tournois" ?>
                    </h4>
                    <?php
                    if (isset($tournois) && $tournois['deleted_at'] == null) { ?>
                        <a title="Désactiver le tournois"
                           href="<?= base_url('admin/tournament/deactivate/') . $tournois['id']; ?>">
                            <i class="fa-solid fa-xl fa-toggle-on text-success"></i>
                        </a>
                        <?php
                    } elseif (isset($tournois)) { ?>
                        <a title="Activer le jeu"
                           href="<?= base_url('admin/tournament/activate/') . $tournois['id']; ?>">
                            <i class="fa-solid fa-toggle-off fa-xl text-danger"></i>
                        </a>
                        <?php
                    }
                    ?>
                </div>
                <div class="card-body">
                    <div class="card-body">
                        <!--                Onglet des tournois-->
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="tournament-tab" data-bs-toggle="tab"
                                        data-bs-target="#tournament" type="button" role="tab" aria-controls="tournament"
                                        aria-selected="true">Tournois
                                </button>
                            </li>

                            <?php if (isset($tournois)): ?>
                                <!-- Onglets affichés uniquement sur la page de mise à jour -->
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="participant-tab" data-bs-toggle="tab"
                                            data-bs-target="#participant" type="button" role="tab"
                                            aria-controls="participant"
                                            aria-selected="false">Participant
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="scoreboard-tab" data-bs-toggle="tab"
                                            data-bs-target="#scoreboard" type="button" role="tab"
                                            aria-controls="scoreboard"
                                            aria-selected="false">Classement
                                    </button>
                                </li>
                            <?php endif; ?>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content border p-3">
                            <div class="tab-pane active" id="tournament" role="tabpanel"
                                 aria-labelledby="tournament-tab"
                                 tabindex="0">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nom du Tournois</label>
                                    <input type="text" class="form-control" id="name" placeholder="Nom du tournois"
                                           value="<?= isset($tournois) ? $tournois['name'] : ""; ?>" name="name">
                                </div>
                                <div class="mb-3">
                                    <label for="game" class="form-label">Nom du Jeu</label>
                                    <select id="game" name="id_game" class="form-select">
                                        <option value="">Sélectionnez un jeu</option>
                                        <?php foreach ($games as $game): ?>
                                            <option value="<?= $game['id']; ?>" <?= isset($tournois) && $tournois['id_game'] == $game['id'] ? 'selected' : ''; ?>>
                                                <?= htmlspecialchars($game['name']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="number" class="form-label">Sélectionner un nombre de participant</label>
                                    <input type="number" id="number"
                                           value="<?= isset($tournois) ? $tournois['nb_player'] : ""; ?>"
                                           name="nb_player" class="form-control" placeholder="Choisir un nombre"/>
                                </div>
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="tournament" class="form-label">Date de début du tournois</label>
                                            <input type="date" id="tournament" name="date_start" class="form-control"
                                                   value="<?= isset($tournois) ? $tournois['date_start'] : ''; ?>"/>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="tournament" class="form-label">Date de fin du tournois</label>
                                            <input type="date" id="tournament" name="date_end" class="form-control"
                                                   value="<?= isset($tournois) ? $tournois['date_end'] : ''; ?>"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 d-flex align-items-center">
                                    <label for="image" class="form-label me-2">Avatar</label>
                                    <div id="preview">
                                        <?php
                                        $profileImageUrl = isset($tournois['avatar_url']) ? base_url($tournois['avatar_url']) : "#";
                                        ?>
                                        <img class="img-thumbnail me-2" alt="Aperçu de l'image"
                                             style="display: <?= isset($tournois['avatartournament_url']) ? "block" : "none" ?>; max-width: 100px;"
                                             src="<?= $profileImageUrl ?>">
                                    </div>

                                    <input class="form-control" type="file" name="tournament_image" id="image">
                                </div>
                            </div>
                            <?php if (isset($tournois)): ?>
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
                                                <th>Nom su tournois</th>
                                                <th>ID user</th>
                                                <th>Pseudo</th>
                                                <th>Actif</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php foreach ($participants as $participant): ?>
                                                <tr>
                                                    <td><?= $participant['id_tournament']; ?></td>
                                                    <td><?= $participant['name']; ?></td>
                                                    <td><?= $participant['id_user']; ?></td>
                                                    <td><?= $participant['username']; ?></td>
                                                    <td>
                                                        <a href="<?= base_url('/admin/tournament/delete/'. $participant['id_user']); ?>" class="delete-product">
                                                            <i class="fa-solid fa-trash" style="color: red"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="scoreboard" role="tabpanel" aria-labelledby="scoreboard-tab"
                                 tabindex="0">
                                bonjour
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="card-footer text-end">
                        <?php if (isset($tournois)): ?>
                            <input type="hidden" name="id" value="<?= $tournois['id']; ?>">
                        <?php endif; ?>
                        <button type="submit" class="btn btn-primary">
                            <?= isset($tournois) ? "Sauvegarder" : "Enregistrer" ?>
                        </button>
                    </div>
                </div>
        </form>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#game').select2({
                theme: 'bootstrap-5',
                placeholder: 'Rechercher un jeu',
                allowClear: true
            }
        );
    });
</script>
