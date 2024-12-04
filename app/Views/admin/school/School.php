<?php print_r("TEST") ?>
<div class="row">
    <div class="col">
        <form action="<?= isset($ecole) ? base_url("/admin/school/update") : base_url("/admin/school/create") ?>" method="POST" enctype="multipart/form-data">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">
                        <?= isset($ecole) ? "Editer " . $ecole['username'] : "Créer une Ecole" ?>
                    </h4>
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="profil-tab" data-bs-toggle="tab" data-bs-target="#profil" type="button" role="tab" aria-controls="profil" aria-selected="true">Profil</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="onglet-tab" data-bs-toggle="tab"
                                    data-bs-target="#onglet" type="button" role="tab" aria-controls="onglet"
                                    aria-selected="false">ONGLET</button>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content border p-3">
                        <div class="tab-pane active" id="profil" role="tabpanel" aria-labelledby="profil-tab" tabindex="0">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nom</label>
                                <input type="text" class="form-control" id="name" placeholder="Nom" value="<?= isset($ecole) ? $ecole['name'] : ""; ?>" name="name">
                            </div>
                            <div class="mb-3">
                                <label for="city" class="form-label">Ville</label>
                                <input type="city" class="form-control" id="city" placeholder="Ville" value="<?= isset
                                ($ecole) ? $ecole['email'] : "" ?>" <?= isset($ecole) ? "readonly"
                                    : "" ?> <?= isset($ecole) ? "" : "name='city'" ?> >
                            </div>
                        </div>

                        <div class="tab-pane" id="onglet" role="tabpanel" aria-labelledby="onglet-tab" tabindex="0">

                        </div>

                    </div>
                </div>

                <div class="card-footer text-end">
                    <?php if (isset($ecole)): ?>
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