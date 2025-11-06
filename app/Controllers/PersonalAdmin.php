<?php

namespace App\Controllers;

use App\Models\PersonalAdminModel;

class PersonalAdmin extends BaseController
{
    protected $personalAdminModel;

    public function __construct()
    {
        $this->personalAdminModel = new PersonalAdminModel();
    }

    public function index()
    {
        $data['personal'] = $this->personalAdminModel->findAll();
        return view('personal_admin/index', $data);
    }

    public function create()
    {
        return view('personal_admin/create');
    }

    public function store()
    {
        $this->personalAdminModel->save([
            'nik' => $this->request->getPost('nik'),
            'nama' => $this->request->getPost('nama'),
            'divisi' => $this->request->getPost('divisi'),
            'jabatan' => $this->request->getPost('jabatan'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
            'status' => $this->request->getPost('status') ?? 'Active',
        ]);

        session()->setFlashdata('success', 'Data karyawan berhasil ditambahkan.');
        return redirect()->to('/personal-admin');
    }

    public function edit($id)
    {
        $data['personal'] = $this->personalAdminModel->find($id);
        if (!$data['personal']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data tidak ditemukan');
        }
        return view('personal_admin/edit', $data);
    }

    public function update($id)
    {
        $this->personalAdminModel->update($id, [
            'nik' => $this->request->getPost('nik'),
            'nama' => $this->request->getPost('nama'),
            'divisi' => $this->request->getPost('divisi'),
            'jabatan' => $this->request->getPost('jabatan'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
            'status' => $this->request->getPost('status'),
        ]);

        session()->setFlashdata('success', 'Data karyawan berhasil diperbarui.');
        return redirect()->to('/personal-admin');
    }

    public function delete($id)
    {
        $this->personalAdminModel->delete($id);
        session()->setFlashdata('success', 'Data karyawan berhasil dihapus.');
        return redirect()->to('/personal-admin');
    }
}

