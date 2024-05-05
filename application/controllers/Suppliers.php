<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class Suppliers extends REST_Controller {
    function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->database();
    }

    // Menampilkan data kontak
    function index_get() {
        $id = $this->get('SupplierID');
        if ($id == ''){
            $kontak = $this->db->get('suppliers')->result();       
        } else {
            $this->db->where('SupplierID', $id);
            $kontak = $this->db->get('suppliers')->result();
        }
        $this->response($kontak, 200);
    }

    // Mengirim atau menambah data kontak baru
    function index_put() {
        $id = $this->put('SupplierID');
        $data = array(
            'CompanyName' => $this->put('CompanyName'),
            'ContactName' => $this->put('ContactName'),
            'ContactTitle' => $this->put('ContactTitle'),
            'Address' => $this->put('Address'),
            'City' => $this->put('City'),
            'Region' => $this->put('Region'),
            'PostalCode' => $this->put('PostalCode'),
            'Country' => $this->put('Country'),
            'Phone' => $this->put('Phone'),
            'Fax' => $this->put('Fax'),
            'HomePage' => $this->put('HomePage')
        );
        $this->db->where('SupplierID', $id);
        $update = $this->db->update('suppliers', $data);
        if ($update) {
            $this->response($data, 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }   
    }

    function index_post() {
        $data = array(
            'CompanyName' => $this->post('CompanyName'),
            'ContactName' => $this->post('ContactName'),
            'ContactTitle' => $this->post('ContactTitle'),
            'Address' => $this->post('Address'),
            'City' => $this->post('City'),
            'Region' => $this->post('Region'),
            'PostalCode' => $this->post('PostalCode'),
            'Country' => $this->post('Country'),
            'Phone' => $this->post('Phone'),
            'Fax' => $this->post('Fax'),
            'HomePage' => $this->post('HomePage')
        );
        $insert = $this->db->insert('suppliers', $data);
        if ($insert) {
            $this->response($data, 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }

    function index_delete() {
        $id = $this->delete('id');
        $this->db->where('SupplierID', $id);
        $delete = $this->db->delete('suppliers');
       // echo $this->db->last_query();die();
        if ($delete) {
            $this->response(array('status' => 'success'), 204);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
        }   
}
?>