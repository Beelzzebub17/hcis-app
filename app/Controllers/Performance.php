<?php

namespace App\Controllers;

use App\Models\PerformanceModel;

class Performance extends BaseController
{
    protected $performanceModel;

    public function __construct()
    {
        $this->performanceModel = new PerformanceModel();
    }

    public function index()
    {
        $data['performances'] = $this->performanceModel->findAll();
        return view('performance/index', $data);
    }

    public function create()
    {
        return view('performance/create');
    }

    public function store()
    {
        $score = (float) $this->request->getPost('score');
        $rating = $this->getRating($score);

        $this->performanceModel->save([
            'employee_id' => $this->request->getPost('employee_id'),
            'employee_name' => $this->request->getPost('employee_name'),
            'period' => $this->request->getPost('period'),
            'score' => $score,
            'rating' => $rating,
            'notes' => $this->request->getPost('notes'),
        ]);

        session()->setFlashdata('success', 'Data performance berhasil ditambahkan.');
        return redirect()->to('/performance');
    }

    public function edit($id)
    {
        $data['performance'] = $this->performanceModel->find($id);
        if (!$data['performance']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data tidak ditemukan');
        }
        return view('performance/edit', $data);
    }

    public function update($id)
    {
        $score = (float) $this->request->getPost('score');
        $rating = $this->getRating($score);

        $this->performanceModel->update($id, [
            'employee_id' => $this->request->getPost('employee_id'),
            'employee_name' => $this->request->getPost('employee_name'),
            'period' => $this->request->getPost('period'),
            'score' => $score,
            'rating' => $rating,
            'notes' => $this->request->getPost('notes'),
        ]);

        session()->setFlashdata('success', 'Data performance berhasil diperbarui.');
        return redirect()->to('/performance');
    }

    public function delete($id)
    {
        $this->performanceModel->delete($id);
        session()->setFlashdata('success', 'Data performance berhasil dihapus.');
        return redirect()->to('/performance');
    }

    private function getRating($score)
    {
        if ($score >= 90) return 'Excellent';
        if ($score >= 80) return 'Very Good';
        if ($score >= 70) return 'Good';
        if ($score >= 60) return 'Fair';
        return 'Poor';
    }
}

