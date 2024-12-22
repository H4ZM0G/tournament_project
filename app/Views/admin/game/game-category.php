<div class="row">
    <div class="col">
        <form action="<?= isset($categorie) ? base_url("/admin/categorygame/update") : base_url("/admin/categorygame/create") ?>" method="POST" enctype="multipart/form-data">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">
                        <?= isset($categorie) ? "Éditer " . $categorie['name'] : "Inscrire une catégorie" ?>
                    </h4>
                    <?php if (isset($categorie) && $categorie['deleted_at'] == null): ?>
                        <a title="Désactiver la catégorie" href="<?= base_url('admin/categorygame/deactivate/') . $categorie['id']; ?>">
                            <i class="fa-solid fa-xl fa-toggle-on text-success"></i>
                        </a>
                    <?php elseif (isset($categorie)): ?>
                        <a title="Activer la catégorie" href="<?= base_url('admin/categorygame/activate/') . $categorie['id']; ?>">
                            <i class="fa-solid fa-toggle-off fa-xl text-danger"></i>
                        </a>
                    <?php endif; ?>
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

                    <div class="tab-content border p-3">
                        <div class="tab-pane active" id="profil" role="tabpanel" aria-labelledby="profil-tab" tabindex="0">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nom de la catégorie</label>
                                <input type="text" class="form-control" id="name" placeholder="Nom de la catégorie"
                                       value="<?= isset($categorie) ? htmlspecialchars($categorie['name']) : ''; ?>" name="name">
                            </div>
                        </div>

                        <div class="tab-pane" id="onglet" role="tabpanel" aria-labelledby="onglet-tab" tabindex="0">
                            <!-- Onglet content -->
                        </div>
                    </div>
                </div>

                <div class="card-footer text-end">
                    <?php if (isset($categorie)): ?>
                        <input type="hidden" name="id" value="<?= $categorie['id']; ?>">
                    <?php endif; ?>
                    <button type="submit" class="btn btn-primary">
                        <?= isset($categorie) ? "Sauvegarder" : "Enregistrer" ?>
                    </button>
                </div>
            </div>
        </form>

    </div>
</div>
