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
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="profil-tab" data-bs-toggle="tab"
                                    data-bs-target="#profil" type="button" role="tab" aria-controls="profil"
                                    aria-selected="true">Tournois
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="onglet-tab" data-bs-toggle="tab"
                                    data-bs-target="#onglet" type="button" role="tab" aria-controls="onglet"
                                    aria-selected="false">ONGLET
                            </button>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content border p-3">
                        <div class="tab-pane active" id="profil" role="tabpanel" aria-labelledby="profil-tab"
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
                                <label for="number" class="form-label">Sélectionner un nombre</label>
                                <input type="number" id="number" name="number" class="form-control"
                                       min="1" max="100" step="1" placeholder="Choisir un nombre" />
                            </div>
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="tournament" class="form-label">Date de début du tournois</label>
                                        <input type="date" id="tournament" name="date_deb" class="form-control"
                                               value="<?= isset($tournois) ? $tournois['date_deb'] : ''; ?>"/>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="tournament" class="form-label">Date de fin du tournois</label>
                                        <input type="date" id="tournament" name="date_fin" class="form-control"
                                               value="<?= isset($tournois) ? $tournois['date_fin'] : ''; ?>"/>
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
                                     style="display: <?= isset($tournois['avatar_url']) ? "block" : "none" ?>; max-width: 100px;"
                                     src="<?= $profileImageUrl ?>">
                            </div>

                            <input class="form-control" type="file" name="profile_image" id="image">
                        </div>
                    </div>

                    <div class="tab-pane" id="onglet" role="tabpanel" aria-labelledby="onglet-tab" tabindex="0">

                    </div>

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