<?php

namespace App\Controllers;

use App\Models\DataValidationModel;

class DataValidation extends BaseController
{
    protected $validationModel;

    public function __construct()
    {
        $this->validationModel = new DataValidationModel();
    }

    public function index()
    {
        $data['validations'] = $this->validationModel->findAll();
        return view('data_validation/index', $data);
    }

    public function create()
    {
        return view('data_validation/create');
    }

    public function store()
    {
        $this->validationModel->save([
            'check_item' => $this->request->getPost('check_item'),
            'description' => $this->request->getPost('description'),
            'total' => $this->request->getPost('total') ?? 0,
            'status' => $this->request->getPost('total') > 0 ? 'Not OK' : 'OK',
            'last_check' => date('Y-m-d H:i:s'),
        ]);

        session()->setFlashdata('success', 'Data validation berhasil ditambahkan.');
        return redirect()->to('/data-validation');
    }

    public function edit($id)
    {
        $data['validation'] = $this->validationModel->find($id);
        if (!$data['validation']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data tidak ditemukan');
        }
        return view('data_validation/edit', $data);
    }

    public function update($id)
    {
        $total = (int) $this->request->getPost('total');
        $status = $total > 0 ? 'Not OK' : 'OK';

        $this->validationModel->update($id, [
            'check_item' => $this->request->getPost('check_item'),
            'description' => $this->request->getPost('description'),
            'total' => $total,
            'status' => $status,
            'last_check' => date('Y-m-d H:i:s'),
        ]);

        session()->setFlashdata('success', 'Data validation berhasil diperbarui.');
        return redirect()->to('/data-validation');
    }

    public function delete($id)
    {
        $this->validationModel->delete($id);
        session()->setFlashdata('success', 'Data validation berhasil dihapus.');
        return redirect()->to('/data-validation');
    }
}

