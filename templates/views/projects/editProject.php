<?php require_once INCLUDES . 'inc_header.php'; ?>

<?= Toast::flash() ?>

<div class="row">

    <div class="col-md-8 mx-auto">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1><?= $data['page_title'] ?? 'Editar Proyecto' ?></h1>
            <a href="<?= URL ?>projects" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>

        <div class="card">

            <div class="card-header">
                <h5 class="mb-0">Información del Proyecto</h5>
            </div>

            <div class="card-body">
                <form method="POST" action="<?= URL ?>projects/update">
                    
                    <input type="hidden" name="id" value="<?= $data['project']['id'] ?>">

                    <div class="mb-3">
                        <label for="name" class="form-label">
                            Nombre del Proyecto <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control" 
                               id="name" 
                               name="name" 
                               value="<?= htmlspecialchars($data['project']['name']) ?>"
                               placeholder="Ej: Desarrollo de una App Móvil"
                               required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Descripción</label>
                        <textarea class="form-control" 
                                  id="description" 
                                  name="description" 
                                  rows="3"
                                  placeholder="Describe brevemente el proyecto..."><?= htmlspecialchars($data['project']['description']) ?></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="start_date" class="form-label">Fecha de Inicio</label>
                            <input type="date" 
                                   class="form-control" 
                                   id="start_date" 
                                   name="start_date"
                                   value="<?= $data['project']['start_date'] ?>">
                        </div>

                        <div class="col-md-6 mb-3">

                            <label for="end_date" class="form-label">Fecha de Fin</label>
                            <input type="date" 
                                   class="form-control" 
                                   id="end_date" 
                                   name="end_date"
                                   value="<?= $data['project']['end_date'] ?>">
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label">Estado</label>
                            <select class="form-select" id="status" name="status">
                                <option value="activo" <?= $data['project']['status'] == 'activo' ? 'selected' : '' ?>>Activo</option>
                                <option value="pausado" <?= $data['project']['status'] == 'pausado' ? 'selected' : '' ?>>Pausado</option>
                                <option value="completado" <?= $data['project']['status'] == 'completado' ? 'selected' : '' ?>>Completado</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">

                            <label for="color" class="form-label">Color</label>

                            <select class="form-select" id="color" name="color">
                                <option value="primary" <?= $data['project']['color'] == 'primary' ? 'selected' : '' ?>>Azul (Primary)</option>
                                <option value="success" <?= $data['project']['color'] == 'success' ? 'selected' : '' ?>>Verde (Success)</option>
                                <option value="info" <?= $data['project']['color'] == 'info' ? 'selected' : '' ?>>Celeste (Info)</option>
                                <option value="warning" <?= $data['project']['color'] == 'warning' ? 'selected' : '' ?>>Amarillo (Warning)</option>
                                <option value="danger" <?= $data['project']['color'] == 'danger' ? 'selected' : '' ?>>Rojo (Danger)</option>
                                <option value="secondary" <?= $data['project']['color'] == 'secondary' ? 'selected' : '' ?>>Gris (Secondary)</option>
                            </select>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2">

                        <a href="<?= URL ?>projects" class="btn btn-secondary">
                            Cancelar
                        </a>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Actualizar Proyecto
                        </button>

                    </div>
                </form>

            </div>

        </div>
    </div>

</div>

<?php require_once INCLUDES . 'inc_footer.php'; ?>