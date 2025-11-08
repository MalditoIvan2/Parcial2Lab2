<?php

class projectsController extends Controller
{
    protected $title = 'Gestion de proyectos';

    function index()
    {
        $projects = projectsModel::all();
        $data = [
            'projects' => $projects,
            'page_title' => 'Lista de proyectos'
        ];

        View::render('projectsList', $data);
    }

    function add()
    {
        $data = [
            'page_title' => 'Nuevo proyecto'
        ];
        View::render('addProject', $data);
    }

    function store()
    {
        if (!$this->validatePost(['name'])) {
            $this->redirectWithMessage('projects/add', 'Tienes que ingresar un nombre de proyecto', 'warning');
            return;
        }

        $projectData = [
            'name' => trim($_POST['name']),
            'description' => trim($_POST['description'] ?? ''),
            'start_date' => $_POST['start_date'] ?? null,
            'end_date' => $_POST['end_date'] ?? null,
            'status' => $_POST['status'] ?? 'activo',
            'color' => $_POST['color'] ?? 'primary'
        ];

        projectsModel::create($projectData);

        $this->redirectWithMessage('projects', 'Proyecto creado exitosamente', 'success');
    }

    function edit()
    {
        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {

            $this->redirectWithMessage('projects', 'ID de proyecto inválido', 'danger');
            return;
        }

        $id = $_GET['id'];
        $project = projectsModel::find($id);

        if (!$project) {
            $this->redirectWithMessage('projects', 'Proyecto no encontrado', 'danger');
            return;
        }
        $data = [
            'page_title' => 'Editar proyecto',
            'project' => $project
        ];
        View::render('editProject', $data);
    }

    function update()
    {
        if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
            $this->redirectWithMessage('projects', 'ID de proyecto inválido', 'danger');
            return;
        }

        if (!$this->validatePost(['name'])) {
            $this->redirectWithMessage('projects/edit?id=' . $_POST['id'], 'Debe ingresar un nombre de proyecto', 'warning');
            return;
        }

        $id = $_POST['id'];

        $project = projectsModel::find($id);
        if (!$project) {
            $this->redirectWithMessage('projects', 'Proyecto no encontrado', 'danger');
            return;
        }

        $projectData = [
            'name' => trim($_POST['name']),
            'description' => trim($_POST['description'] ?? ''),
            'start_date' => $_POST['start_date'] ?? null,
            'end_date' => $_POST['end_date'] ?? null,
            'status' => $_POST['status'] ?? 'activo',
            'color' => $_POST['color'] ?? 'primary'
        ];

        projectsModel::update($id, $projectData);

        $this->redirectWithMessage('projects', 'Proyecto actualizado exitosamente', 'success');
    }

    function delete()
    {
        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            $this->redirectWithMessage('projects', 'ID de proyecto inválido', 'danger');
            return;
        }

        $id = $_GET['id'];
        $project = projectsModel::find($id);
        if (!$project) {
            $this->redirectWithMessage('projects', 'Proyecto no encontrado', 'danger');
            return;
        }
        projectsModel::delete($id);
        $this->redirectWithMessage('projects', 'Proyecto eliminado exitosamente', 'info');
    }
}

?>