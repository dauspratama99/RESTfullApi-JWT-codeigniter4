<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\ModelMatakuliah;

class Matakuliah extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        $model = new ModelMatakuliah();
        
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
        $model = new ModelMatakuliah();
        $data = $model->orLike('kodemtk_2110062', $cari)
                       ->orLike('namamtk_2110062', $cari)
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
        $model = new ModelMatakuliah();
        
            $kodemtk_2110062 = $this->request->getPost('kodemtk_2110062');
            $namamtk_2110062 = $this->request->getPost('namamtk_2110062');
            $sksmtk_2110062 = $this->request->getPost('sksmtk_2110062');

        $validation = \Config\Services::validation();

        $valid = $this->validate([
            'kodemtk_2110062' => [
                'rules' => 'is_unique[tb_matakuliah_2110062.kodemtk_2110062]',
                'label' => 'Kode MTK',
                'errors' => [
                    'is_unique' => '{field} sudah terdaftar'
                ]
            ]
        ]);

        if(!$valid){
            $response = [
                'status' => 500,
                'error' => true,
                'message' => $validation->getErrors("kodemtk"),
            ];

            return $this->respond($response, 500);
        } else {

            $model->insert([
                'kodemtk_2110062' => $kodemtk_2110062,
                'namamtk_2110062' => $namamtk_2110062,
                'sksmtk_2110062' => $sksmtk_2110062,
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
    public function update($kodemtk = null)
    {
        $model = new ModelMatakuliah();

        $data = [
            'namamtk_2110062' => $this->request->getVar('kodemtk'),
            'sksmtk_2110062' => $this->request->getVar('namamtk'),
        ];

        $data = $this->request->getRawInput();
        $model->update($kodemtk, $data);
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
    public function delete($kodemtk = null)
    {
        $model = new ModelMatakuliah();
        $cekData = $model->find($kodemtk);

        if($cekData){
            $model->delete($kodemtk);
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
