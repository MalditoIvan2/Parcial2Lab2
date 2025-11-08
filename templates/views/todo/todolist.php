<?php require_once INCLUDES . 'inc_header.php'; ?>

<!-- Mostrar notificaciones toast -->
<?= Toast::flash() ?>

<div class="row">
    <div class="col-md-8">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1><?= $data['page_title'] ?? 'Mi Lista de Tareas' ?></h1>
            <a href="<?= URL ?>todo/add" class="btn btn-primary">Nueva Tarea</a>
        </div>

        <!-- Barra de búsqueda -->
        <div class="mb-4">
            <form method="GET" action="<?= URL ?>todo/search" class="d-flex">
                <input type="text" class="form-control me-2" name="q"
                    placeholder="Buscar tareas..." value="<?= $data['search_term'] ?? '' ?>">
                <button type="submit" class="btn btn-outline-secondary">Buscar</button>
            </form>
        </div>

        <!-- Lista de tareas -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Tareas</h5>
            </div>
            <div class="card-body p-0">
                <?php if (!empty($data['todos'])): ?>
                    <?php foreach ($data['todos'] as $todo): ?>
                        <div class="todo-item p-3 border-bottom <?= $todo['completed'] ? 'completed-task' : '' ?>">
                            <div class="d-flex align-items-start">
                                <div class="flex-grow-1">
                                    <div class="d-flex align-items-center mb-2">
                                        <h6 class="mb-0 me-2 <?= $todo['completed'] ? 'text-decoration-line-through text-muted' : '' ?>">
                                            <?= htmlspecialchars($todo['task']) ?>
                                        </h6>
                                        <span class="badge priority-badge bg-<?= $todo['priority_color'] ?>">
                                            <?= $todo['priority_text'] ?>
                                        </span>
                                        <?php if ($todo['completed']): ?>
                                            <span class="badge bg-success ms-1">✓ Completada</span>
                                        <?php endif; ?>
                                        <?php if (!empty($todo['project_name'])): ?>
                                            <span class="badge bg-<?= $todo['project_color'] ?? 'secondary' ?> ms-1">
                                                <i class="fas fa-folder"></i> <?= htmlspecialchars($todo['project_name']) ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>

                                    <?php if ($todo['description']): ?>
                                        <p class="text-muted mb-2 small">
                                            <?= htmlspecialchars($todo['description']) ?>
                                        </p>
                                    <?php endif; ?>

                                    <small class="text-muted">
                                        <?= $todo['formatted_date'] ?>
                                    </small>
                                </div>

                                <div class="d-flex gap-2">
                                    <a href="<?= URL ?>todo/edit?id=<?= $todo['id'] ?>"
                                        class="btn btn-sm btn-outline-primary">
                                        Editar
                                    </a>
                                    <a href="#" 
                                        class="btn btn-sm btn-outline-danger"
                                        data-bs-toggle="modal" 
                                        data-bs-target="#deleteModal"
                                        data-todo-id="<?= $todo['id'] ?>">
                                        Eliminar
                                    </a>
                                    <a href="<?= URL ?>todo/toggle?id=<?= $todo['id'] ?>"
                                        class="btn btn-sm <?= $todo['completed'] ? 'btn-outline-success' : 'btn-success' ?>">
                                        <?= $todo['completed'] ? '✓ Completada' : 'Marcar Completada' ?>
                                    </a>

                                    <a href="<?= URL ?>todo/toggleImportant?id=<?= $todo['id'] ?>"
                                        class="btn btn-sm <?= $todo['important'] ? 'btn-warning' : 'btn-outline-warning' ?>">
                                        <?= $todo['important'] ? 'Desmarcar' : 'Importante' ?>
                                    </a>

                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="text-center text-muted py-5">
                        <i class="fas fa-clipboard-list fa-3x mb-3"></i>
                        <h5>No hay tareas</h5>
                        <p>
                            <?php if (isset($data['search_term'])): ?>
                                No se encontraron tareas para "<?= htmlspecialchars($data['search_term']) ?>"
                            <?php else: ?>
                                ¡Agrega tu primera tarea!
                            <?php endif; ?>
                        </p>
                        <a href="<?= URL ?>todo/add" class="btn btn-primary">
                            Nueva Tarea
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="mb-3">Tareas Importantes</h5>
                <?php if (!empty($data['important_tasks'])): ?>
                    <div class="list-group list-group-flush">
                        <?php foreach ($data['important_tasks'] as $task): ?>
                            <a href="<?= URL ?>todo/edit?id=<?= $task['id'] ?>" class="list-group-item list-group-item-action p-2">
                                <div class="d-flex align-items-center">
                                    <small class="flex-grow-1"><?= htmlspecialchars($task['task']) ?></small>
                                </div>
                                <?php if (!empty($task['project_name'])): ?>
                                    <small class="badge bg-<?= $task['project_color'] ?? 'secondary' ?> mt-1">
                                        <?= htmlspecialchars($task['project_name']) ?>
                                    </small>
                                <?php endif; ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="text-muted text-center py-3">
                        No hay tareas importantes pendientes
                    </p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">¿Eliminar tarea?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Esta acción no se puede deshacer. ¿Estás seguro de eliminar esta tarea?</p>
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
        const todoId = button.getAttribute('data-todo-id');
        const confirmButton = document.getElementById('confirmDelete');
        confirmButton.href = '<?= URL ?>todo/delete?id=' + todoId;
    });
});
</script>

<?php require_once INCLUDES . 'inc_footer.php'; ?>