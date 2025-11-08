<?php require_once INCLUDES . 'inc_header.php'; ?>

<?= Toast::flash() ?>

<div class="row">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1><?= $data['page_title'] ?? 'Lista de Proyectos' ?></h1>
            <a href="<?= URL ?>projects/add" class="btn btn-primary">Nuevo Proyecto</a>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Proyectos</h5>
            </div>
            <div class="card-body p-0">
                <?php if (!empty($data['projects'])): ?>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Nombre</th>
                                    <th>Descripción</th>
                                    <th>Fecha Inicio</th>
                                    <th>Fecha Fin</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data['projects'] as $project): ?>

                                    <tr>

                                        <td>

                                            <span class="badge bg-<?= $project['color'] ?> me-2">
                                                <i class="fas fa-folder"></i>
                                            </span>
                                            <strong><?= htmlspecialchars($project['name']) ?></strong>

                                        </td>

                                        <td>

                                            <?= htmlspecialchars(substr($project['description'], 0, 50)) ?>
                                            <?= strlen($project['description']) > 50 ? '...' : '' ?>

                                        </td>

                                        <td>
                                            <?= $project['start_date'] ? date('d/m/Y', strtotime($project['start_date'])) : '-' ?>
                                        </td>
                                        <td>
                                            <?= $project['end_date'] ? date('d/m/Y', strtotime($project['end_date'])) : '-' ?>
                                        </td>

                                        <td>
                                            <?php

                                            $statusColors = [
                                                'activo' => 'success',
                                                'pausado' => 'warning',
                                                'completado' => 'secondary'
                                            ];

                                            $statusColor = $statusColors[$project['status']] ?? 'secondary';

                                            ?>

                                            <span class="badge bg-<?= $statusColor ?>">
                                                <?= ucfirst($project['status']) ?>
                                            </span>

                                        </td>

                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="<?= URL ?>projects/edit?id=<?= $project['id'] ?>"
                                                    class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-edit"></i> Editar
                                                </a>

                                                <a href="#" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal"
                                                    data-project-id="<?= $project['id'] ?>">
                                                                        
                                                    <i class="fas fa-trash"></i> Eliminar
                                                </a>

                                            </div>

                                        </td>

                                    </tr>

                                <?php endforeach; ?>

                            </tbody>

                        </table>

                    </div>

                <?php else: ?>
                    <div class="text-center text-muted py-5">

                        <i class="fas fa-folder-open fa-3x mb-3"></i>
                        <h5>No hay proyectos</h5>
                        <p>¡Crea tu primer proyecto!</p>
                        <a href="<?= URL ?>projects/add" class="btn btn-primary">
                            Nuevo Proyecto
                        </a>

                    </div>

                <?php endif; ?>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">¿Eliminar proyecto?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                
            </div>
            <div class="modal-body">
                <p>Esta acción no se puede deshacer. ¿Estás seguro de eliminar este proyecto?</p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <a href="#" id="confirmDelete" class="btn btn-danger">Eliminar</a>
            </div>

        </div>

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteModal = document.getElementById('deleteModal');
        deleteModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const projectId = button.getAttribute('data-project-id');
            const confirmButton = document.getElementById('confirmDelete');
            confirmButton.href = '<?= URL ?>projects/delete?id=' + projectId;
        });
    });
</script>

<?php require_once INCLUDES . 'inc_footer.php'; ?>