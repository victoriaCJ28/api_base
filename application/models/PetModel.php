<?php
class PetModel extends CI_Model{

    public function __construct() {
        parent::__construct();
    }

    // Devuelve todos los registros
    public function findAll(){

        $this->db->select('*');
        $this->db->from('pet');
        //$this->db->order_by("id_pet", "asc");
        $query = $this->db->get();

         if ($query->num_rows() > 0) {
            return $query->result_array();
         } else {
            return 0;
         }
    }

    // Devuelve un registro al mandar su ID
    public function findById($id){

        $this->db->select('*');
        $this->db->from('pet');
        $this->db->where('id_pet',$id);
        $query = $this->db->get(); 
        if($query->num_rows() == 1){
            return $query->result_array();
        }
        else
        {
            return 0;
        }
    }

    // Insertar mascota
    public function insertData($data){
       
        if($this->db->insert('pet',$data)){
            $lastId = $this->db->insert_id();
            // $this->db->select_max('id_pet');
            // $this->db->from('pet');
            
            // $query=$this->db->get_where("pet",['id_pet'=>$query['id_pet']])->result();
            $query=$this->db->get_where("pet",array('id_pet'=> $lastId));
            // return $lastId;
            return $query->row();
        }else{
            return false;
        }

        
         
    }

    // Actualizar mascota
    public function update($id, $data){
        
        //$data=$this->put();
        //$this->db->where('id_pet', $id);
        // Cambiando el metodo por uno donde se llame el id en la sentencia
        $this->db->update('pet',$data, array('id_pet'=>$id));
        // Que evalue si filas se vieron afectadas
        if($this->db->affected_rows()>0){
           return true;
         }else{
           return false;
         }
     }

     // Eliminar mascota
    public function delete($id){ 

         $this->db->delete('pet', array('id_pet'=>$id));
         // Ya que al evaluar siempre es true que registre filas afectadas
         if($this->db->affected_rows()>0){
             return true;
         }else{
             return false;
         }        
    }


}
