<?php

namespace App\Controllers;

use App\Models\TrainingDevModel;

class TrainingDev extends BaseController
{
    protected $trainingModel;

    public function __construct()
    {
        $this->trainingModel = new TrainingDevModel();
    }

    public function index()
    {
        $data['trainings'] = $this->trainingModel->findAll();
        return view('training_dev/index', $data);
    }

    public function create()
    {
        return view('training_dev/create');
    }

    public function store()
    {
        $this->trainingModel->save([
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'duration' => $this->request->getPost('duration'),
            'instructor' => $this->request->getPost('instructor'),
            'start_date' => $this->request->getPost('start_date'),
            'end_date' => $this->request->getPost('end_date'),
            'status' => $this->request->getPost('status') ?? 'Scheduled',
        ]);

        session()->setFlashdata('success', 'Training berhasil ditambahkan.');
        return redirect()->to('/training-dev');
    }

    public function edit($id)
    {
        $data['training'] = $this->trainingModel->find($id);
        if (!$data['training']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data tidak ditemukan');
        }
        return view('training_dev/edit', $data);
    }

    public function update($id)
    {
        $this->trainingModel->update($id, [
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'duration' => $this->request->getPost('duration'),
            'instructor' => $this->request->getPost('instructor'),
            'start_date' => $this->request->getPost('start_date'),
            'end_date' => $this->request->getPost('end_date'),
            'status' => $this->request->getPost('status'),
        ]);

        session()->setFlashdata('success', 'Training berhasil diperbarui.');
        return redirect()->to('/training-dev');
    }

    public function delete($id)
    {
        $this->trainingModel->delete($id);
        session()->setFlashdata('success', 'Training berhasil dihapus.');
        return redirect()->to('/training-dev');
    }
}

