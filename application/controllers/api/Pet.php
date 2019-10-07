<?php
require APPPATH. 'libraries/REST_Controller.php';
// use Restserver\Libraries\REST_Controller;

class Pet extends REST_Controller{
    //constructor principal
    function __construct() {
        parent::__construct('rest');
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        header("Allow: GET, POST, OPTIONS, PUT, DELETE");
        $this->load->model('PetModel'); // llamada al modelo
    }
    //respuesta del servidor
    public function index_options(){                          
        return $this->response(NULL,REST_Controller::HTTP_OK);
    }
    //Obtener todos los registros y por id
    public function index_get($id = 0){

        //Dandole un valor a id inicial para evitar el error
        //Si su valor no es vacio que busque por id
        if(!empty($id)){
            //Guardando una variable que cuente cuantos registros encuentra
            $conteo = $this->PetModel->findById($id);
            //Validando que exista al menos 1 un registro
            if ($conteo > 0) {
                $this->response($this->PetModel->findById($id), 200);
            } else {
                $this->response(array('error' => 'No se encontro el registro buscado'), 404);
            }
        }else{
            //Si esta vacio que busque todos los registros
            $conteo = $this->PetModel->findAll();
             //Validando que exista al menos 1 un registro
            if ($conteo > 0) {
                $this->response($this->PetModel->findAll(), 200);
            } else {
                $this->response(array('error' => 'No existen registros'), 404);
            }
        }      

    }
  
    // ingresar registros no pude validar la url 
    public function index_post(){
        if (!empty($data)){
        // if ($this->post('name')) {
            $data = array(   
                'name' => $this->post('name'),
                'type' => $this->post('type'),
                'age' => $this->post('age')        
            );
            
                $result = $this->PetModel->insertData($data);
                if($result){
                    $this->response($result, 201);
                }else{
                    $this->response(array('error' => 'No se puede crear el registro'), 400);
                }
            }else{
                $this->response(array('error' => 'Debe agregar los campos necesarios'), 400);
            }
           
                // if ($this->PetModel->insertData($data)==true) {
                 
                //     $this->response($data , 201);
                // } else {
                //     $this->response(array('error' => 'No se puede crear el registro'), 400);
                // }
                

//    }
}

public function index_put($id){

    $data = array(
        'name' => $this->put('name'),
        'type' => $this->put('type'),
        'age' => $this->put('age')
    
    );

    if ($this->PetModel->update($id, $data)==true){
        if(!empty($data)){
            $this->response("Registro Actualizado",REST_Controller::HTTP_OK);
        }else{
        
            }

    } else {
        
        $this->response("El registro con esta id no existe.", 404);
    }
    
    }
    //eliminando registro
    function index_delete($id){   
          
        if($id){
            $result = $this->PetModel->delete($id);
            if($result){
                $this->response("Registro eliminado", 200);
            }else{
                $this->response("El registro con esa id no existe", 400);
            }
        } else{
            $this->response("No ingreso numero", 404);
        }         
    }
   



}