<div class="row">
    <div class="col">
        <form action="<?= isset($participant) ? base_url("/admin/participant/update") : base_url("/admin/participant/create") ?>"
              method="POST" enctype="multipart/form-data">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">
                        <?= isset($participant) ? "Editer " . $participant['id_user'] : "Créer un tournois" ?>
                    </h4>
                    <?php
                    if (isset($participant) && $participant['deleted_at'] == null) { ?>
                        <a title="Désactiver le tournois"
                           href="<?= base_url('admin/participant/deactivate/') . $participant['id']; ?>">
                            <i class="fa-solid fa-xl fa-toggle-on text-success"></i>
                        </a>
                        <?php
                    } elseif (isset($participant)) { ?>
                        <a title="Activer le jeu"
                           href="<?= base_url('admin/participant/activate/') . $participant['id']; ?>">
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
<!--                            <div class="mb-3">-->
<!--                                <label for="name" class="form-label">Nom du Tournois</label>-->
<!--                                <input type="text" class="form-control" id="name" placeholder="Nom du jeu"-->
<!--                                       value="--><?php //= isset($participant) ? $participant['name'] : ""; ?><!--" name="name">-->
<!--                            </div>-->
                            <div class="mb-3">
                                <label for="game" class="form-label"></label>
                                <select id="game" name="id_game" class="form-select">
                                    <option value="">Sélectionnez un jeu</option>
                                    <?php foreach ($participants as $participant): ?>
                                        <option value="<?= $participant['id']; ?>" <?= isset($participant) && $participant['id_game'] == $participant['id'] ? 'selected' : ''; ?>>
                                            <?= htmlspecialchars($participant['name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3 d-flex align-items-center">
                                <label for="image" class="form-label me-2">Avatar</label>
                                <div id="preview">
                                    <?php
                                    $profileImageUrl = isset($participant['avatar_url']) ? base_url($participant['avatar_url']) : "#";
                                    ?>
                                    <img class="img-thumbnail me-2" alt="Aperçu de l'image"
                                         style="display: <?= isset($participant['avatar_url']) ? "block" : "none" ?>; max-width: 100px;"
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
                    <?php if (isset($participant)): ?>
                        <input type="hidden" name="id" value="<?= $participant['id']; ?>">
                    <?php endif; ?>
                    <button type="submit" class="btn btn-primary">
                        <?= isset($participant) ? "Sauvegarder" : "Enregistrer" ?>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
