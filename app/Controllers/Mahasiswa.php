<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\ModelMahasiswa;

class Mahasiswa extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */

    public function index()
    {
        $model = new ModelMahasiswa();
        
        $data = $model->findAll();
        $response = [
            'status' => 200,
            'error' => false,
            'message' => '',
            'totaldata' => count($data),
            'data' => $data,
        ];

        return $this->respond($response, 200);
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */

    public function show($cari = null)
    {
        $model = new ModelMahasiswa();
        $data = $model->orLike('mhsnobp', $cari)
                       ->orLike('mhsnama', $cari)
                       ->get()
                       ->getResult();
        
        if(count($data) > 1 ){
            $response = [
                'status' => 200,
                'error' => "false",
                'message' => '',
                'totaldata' => count($data),
                'data' => $data,
            ];

            return $this->respond($response, 200);
        } else if (count($data) === 1 ){
            $response = [
                'status' => 200,
                'error' => "false",
                'message' => '',
                'totaldata' => count($data),
                'data' => $data,
            ];
            return $this->respond($response, 200);
        } else {
            return $this->failNotFound('Maaf data' . $cari . 'tidak ditemukan');
        }
    }

    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function new()
    {
        //
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create()
    {
        $model = new ModelMahasiswa();
        
            $mhsnobp = $this->request->getPost('mhsnobp');
            $mhsnama = $this->request->getPost('mhsnama');
            $mhsalamat = $this->request->getPost('mhsalamat');
            $prodinama = $this->request->getPost('prodinama');
            $mhstgllhr = $this->request->getPost('mhstgllhr');
            

        $validation = \Config\Services::validation();

        $valid = $this->validate([
            'mhsnobp' => [
                'rules' => 'is_unique[tb_mahasiswa.mhsnobp]',
                'label' => 'Nobp',
                'errors' => [
                    'is_unique' => '{field} sudah terdaftar'
                ]
            ]
        ]);

        if(!$valid){
            $response = [
                'status' => 500,
                'error' => true,
                'message' => $validation->getErrors("mhsnobp"),
            ];

            return $this->respond($response, 500);
        } else {

            $model->insert([
                'mhsnobp' => $mhsnobp,
                'mhsnama' => $mhsnama,
                'mhsalamat' => $mhsalamat,
                'prodinama' => $prodinama,
                'mhstgllhr' => $mhstgllhr,
            ]);

            $response = [
                'status' => 200,
                'error' => false,
                'message' => 'success !',
            ];

            return $this->respondCreated($response, 200);
        }

    }

    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($nobp = null)
    {
        $model = new ModelMahasiswa();

        $data = [
            'mhsnama' => $this->request->getVar('mhsnama'),
            'mhsalamat' => $this->request->getVar('mhsalamat'),
            'prodinama' => $this->request->getVar('prodinama'),
            'mhstgllhr' => $this->request->getVar('mhstgllhr'),
        ];

        $data = $this->request->getRawInput();
        $model->update($nobp, $data);
        $response = [
            'status' => 200,
            'error' => false,
            'message' => "Data berhasil di update!",
        ];
        return $this->respond($response);
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($nobp = null)
    {
        $model = new ModelMahasiswa();
        $cekData = $model->find($nobp);

        if($cekData){
            $model->delete($nobp);
            $response = [
                'status' => 200,
                'error' => null,
                'message' => 'Data berhasil dihapus',
            ];
            return $this->respondDeleted($response, 200);
        } else {
            return $this->failNotFound('Not found');
        }

    }
}
