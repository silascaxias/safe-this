<?php 

class OcurrencesController extends MainController {
    public function __construct() {
        parent::__construct();
        $this->load_model('VwSectorListInfoModel');
        $this->load_model('PrioritiesModel');
        $this->load_model('OcurrencesModel');
        $this->load_model('OcurrenceUpdateModel');
        $this->load_model('OcurrenceStatusModel');
        $this->load_model('OcurrenceFileModel');
    }

    public function index() {
        $this->title = 'Registro de Ocorrências';
        $this->model->ocurrences = OcurrencesModel::all();
        $this->load_page('ocurrences/index.php');
    }

    public function create() {
        $this->title = "Nova Ocorrência";
        $this->model->ocurrences = VwSectorListInfoModel::all();
        $this->model->priorities = PrioritiesModel::all();
        $this->load_page('ocurrences/create.php');
    }

    public function save() {
        $parameters = (func_num_args() >= 1 ) ? func_get_arg(0) : array();
        $data = $_POST;
        $id = $parameters[0];
        if ($id) { 
            $data['Ocurrence_Id'] = $id;
        }

        if (!OcurrencesModel::has_required_fields($data)) {
            $this->goto_page(HOME_URI . '/ocurrences/create');
        }

        $ocurrence = new OcurrencesModel($data);
        $results = $ocurrence->save();
        if (!$results->id) {
            $this->goto_page(HOME_URI . '/ocurrences/create');
        }

        $id = $results->id;
        $statusData = array(
            "Ocurrence_Id" => $id,
            "Status_Feedback" => "A ocorrência foi registrada",
            "Ocurrence_Status_Id" => OcurrenceStatusModel::Statuses()->Waiting
        );
        $initial_status = new OcurrenceUpdateModel($statusData);
        $initial_status_result = $initial_status->save();

        if (!$initial_status_result->id) {
          $this->goto_page(HOME_URI . '/ocurrences/create');
        }

        $dirToSavePics = UP_ABSPATH . '/' . $id;
        $this->create_dir_if_no_exists($dirToSavePics);
        for ($i = 0; $i < count($_FILES['Image']['name']); $i++) {
            $this->save_file($initial_status_result->id, $_FILES['Image']['name'][$i], $_FILES['Image']['tmp_name'][$i], $dirToSavePics);
        }
        $this->set_message('Ocorrência registrada com sucesso', 'success');
        $this->goto_page(HOME_URI . '/ocurrences');
    }

    private function save_file($ocurrenceUpdateId, $fileName, $filePath, $dir) {
        $uniq = uniqid();
        $exploded = explode('.', $fileName);
        $extension = $exploded[count($exploded) - 1];
        $uploadFileName = $uniq . '.' .$extension;
        $upload_file = $dir . '/'. $uploadFileName;
        if (!move_uploaded_file($filePath, $upload_file)) return;
        $fileData = array(
            'Title' => 'Imagem inserida pelo relator',
            'FileName' => $uploadFileName,
            'Ocurrence_Update_Id' => $ocurrenceUpdateId
        );
        $file = new OcurrenceFileModel($fileData);
        $file->save();
    }
}


?>