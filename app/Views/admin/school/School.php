<div class="row">
    <div class="col">
        <form action="<?= isset($ecole) ? base_url('/admin/school/update') : base_url('/admin/school/create') ?>" method="POST" enctype="multipart/form-data">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">
                        <?= isset($jeu) ? "Éditer " . htmlspecialchars($ecole['name']) : "Inscrire une nouvelle école" ?>
                    </h4>
                    <?php
                    if (isset($ecole) && $ecole['deleted_at'] == null) { ?>
                        <a title="Désactiver lécole" href="<?= base_url('admin/school/deactivate/') . $ecole['id']; ?>">
                            <i class="fa-solid fa-xl fa-toggle-on text-success"></i>
                        </a>
                        <?php
                    } elseif (isset($jeu)) { ?>
                        <a title="Activer lécole" href="<?= base_url('admin/school/activate/') . $ecole['id']; ?>">
                            <i class="fa-solid fa-toggle-off fa-xl text-danger"></i>
                        </a>
                        <?php
                    }
                    ?>
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="profil-tab" data-bs-toggle="tab" data-bs-target="#profil" type="button" role="tab" aria-controls="profil" aria-selected="true">Profil</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="onglet-tab" data-bs-toggle="tab" data-bs-target="#onglet" type="button" role="tab" aria-controls="onglet" aria-selected="false">Onglet</button>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content border p-3">
                        <div class="tab-pane active" id="profil" role="tabpanel" aria-labelledby="profil-tab" tabindex="0">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nom de l'école</label>
                                <input type="text" class="form-control" id="name" placeholder="Nom de lécole" value="<?= isset($ecole) ? htmlspecialchars($ecole['name']) : ''; ?>" name="name">
                            </div>
                            <div class="mb-3">
                                <label for="city" class="form-label">Ville</label>
                                <input type="text" class="form-control" id="city" placeholder="Ville" value="<?= isset($ecole) ? htmlspecialchars($ecole['city']) : ''; ?>" name="city">
                            </div>
                            <div class="mb-3">
                                <label for="category" class="form-label">Catégorie</label>
                                <select id="category" name="id_category" class="form-select">
                                    <option value="">Sélectionnez une catégorie d'école</option>
                                    <?php foreach ($categories as $category): ?>
                                        <option value="<?= $category['id']; ?>" <?= isset($ecole) && $ecole['id_category'] == $category['id'] ? 'selected' : ''; ?>>
                                            <?= htmlspecialchars($category['name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="tab-pane" id="onglet" role="tabpanel" aria-labelledby="onglet-tab" tabindex="0">

                        </div>
                    </div>
                </div>

                <div class="card-footer text-end">
                    <?php if (isset($jeu)): ?>
                        <input type="hidden" name="id" value="<?= $ecole['id']; ?>">
                    <?php endif; ?>
                    <button type="submit" class="btn btn-primary">
                        <?= isset($ecole) ? "Sauvegarder" : "Enregistrer" ?>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
