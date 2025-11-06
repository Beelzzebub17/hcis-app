<?php

namespace App\Controllers;

use App\Models\SystemSettingModel;

class SystemSetting extends BaseController
{
    protected $settingModel;

    public function __construct()
    {
        $this->settingModel = new SystemSettingModel();
    }

    public function index()
    {
        $data['settings'] = $this->settingModel->findAll();
        return view('system_setting/index', $data);
    }

    public function create()
    {
        return view('system_setting/create');
    }

    public function store()
    {
        $this->settingModel->save([
            'setting_key' => $this->request->getPost('setting_key'),
            'setting_value' => $this->request->getPost('setting_value'),
            'description' => $this->request->getPost('description'),
        ]);

        session()->setFlashdata('success', 'System setting berhasil ditambahkan.');
        return redirect()->to('/system-setting');
    }

    public function edit($id)
    {
        $data['setting'] = $this->settingModel->find($id);
        if (!$data['setting']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data tidak ditemukan');
        }
        return view('system_setting/edit', $data);
    }

    public function update($id)
    {
        $this->settingModel->update($id, [
            'setting_key' => $this->request->getPost('setting_key'),
            'setting_value' => $this->request->getPost('setting_value'),
            'description' => $this->request->getPost('description'),
        ]);

        session()->setFlashdata('success', 'System setting berhasil diperbarui.');
        return redirect()->to('/system-setting');
    }

    public function delete($id)
    {
        $this->settingModel->delete($id);
        session()->setFlashdata('success', 'System setting berhasil dihapus.');
        return redirect()->to('/system-setting');
    }
}

