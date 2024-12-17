<div class="row">
    <div class="col">
        <form action="<?= isset($category) ? base_url("/admin/CategorySchool/update") : base_url("/admin/CategorySchool/create") ?>"
              method="POST" enctype="multipart/form-data">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title"> <?= isset($category) ? "Editer " . $category['name'] : "Créer une Catégorie" ?></h4>
                </div>
                <div class="card-body">
                    <!-- Tab panes -->
                    <div class="tab-content border p-3">
                        <div class="tab-pane active" id="profil" role="tabpanel" aria-labelledby="profil-tab"
                             tabindex="0">
                            <div class="mb-3"><label for="name" class="form-label">Nom</label>
                                <input type="text" class="form-control" id="name" placeholder="Nom" value="<?= isset($category) ? $category['name'] : ""; ?>" name="name">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <?php if (isset($category)): ?>
                        <input type="hidden" name="id" value="<?= $category['id']; ?>">
                    <?php endif; ?>
                    <button type="submit" class="btn btn-primary"> <?= isset($category) ? "Sauvegarder" : "Enregistrer" ?> </button>
                </div>
            </div>
        </form>
    </div>
</div>