<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class orders extends REST_Controller {
    function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->database();
    }

    // Menampilkan data kontak
    public function index_get() {

        $id = $this->get('OrderDate');
        $orders=[];
        if ($id == ''){
            $data = $this->db->get('orders')->result();       
            foreach($data as $row=>$key):
                $orders[]=["OrderID"=>$key->OrderID,
                            "OrderDate"=>$key->OrderDate,
                            "_links"=>[(object)["href"=>"customers/{$key->CustomerID}",
                            "rel"=>"customers",
                            "type"=>"GET"],
                            (object)["href"=>"employees/{$key->EmployeeID}",
                            "rel"=>"employees",
                            "type"=>"GET"]],
                            "RequiredDate"=>$key->RequiredDate,
                            "ShippedDate"=>$key->ShippedDate,
                            "ShipVia"=>$key->ShipVia
                            
            ];
        endforeach;
        } else {
            $this->db->where('OrderDate', $id);
            $data = $this->db->get('orders')->result();       
            foreach($data as $row=>$key):
                $orders[]=["OrderID"=>$key->OrderID,
                            "OrderDate"=>$key->OrderDate,
                            "_links"=>[(object)["href"=>"customers/{$key->CustomerID}",
                            "rel"=>"customers",
                            "type"=>"GET"],
                            (object)["href"=>"employees/{$key->EmployeeID}",
                            "rel"=>"employees",
                            "type"=>"GET"]],
                            "RequiredDate"=>$key->RequiredDate,
                            "ShippedDate"=>$key->ShippedDate,
                            "ShipVia"=>$key->ShipVia
                            
            ];
        endforeach;
        }
        $result = ["took"=>$_SERVER["REQUEST_TIME_FLOAT"],
        "code"=>200,
        "message"=>"Response successfully",
        "data"=>$orders];
        $this->response($result, 200);
    }

    // Mengirim atau menambah data kontak baru
    function index_put() {
        $id = $this->put('CategoryID');
        $data = array(
            'CategoryName' => $this->put('CategoryName'),
            'Description' => $this->put('Description'),
            'Picture' => $this->put('Picture'),
            
        );
        $this->db->where('CategoryID', $id);
        $update = $this->db->update('Categories', $data);
        if ($update) {
            $this->response($data, 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }   
    }

    function index_post() {
        $id = $this->post('CategoryID');
        $data = array(
            'CategoryName' => $this->post('CategoryName'),
            'Description' => $this->post('Description'),
            'Picture' => $this->post('Picture'),
        );
        $insert = $this->db->insert('Categories', $data);
        if ($insert) {
            $this->response($data, 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }

    function index_delete() {
        $id = $this->delete('id');
        $this->db->where('CategoryID', $id);
        $delete = $this->db->delete('Categories');
       // echo $this->db->last_query();die();
        if ($delete) {
            $this->response(array('status' => 'success'), 204);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
        }   
}
?>