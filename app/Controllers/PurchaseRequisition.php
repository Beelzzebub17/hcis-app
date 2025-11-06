<?php

namespace App\Controllers;

use App\Models\PurchaseRequisitionModel;

class PurchaseRequisition extends BaseController
{
    protected $prModel;

    public function __construct()
    {
        $this->prModel = new PurchaseRequisitionModel();
    }

    public function index()
    {
        $data['purchase_requisitions'] = $this->prModel->findAll();
        return view('purchase_requisition/index', $data);
    }

    public function create()
    {
        return view('purchase_requisition/create');
    }

    public function store()
    {
        // Generate PR Number
        $prNumber = 'PR-' . date('Ymd') . '-' . str_pad(count($this->prModel->findAll()) + 1, 4, '0', STR_PAD_LEFT);
        
        $this->prModel->save([
            'pr_number' => $prNumber,
            'description' => $this->request->getPost('description'),
            'requester' => $this->request->getPost('requester'),
            'department' => $this->request->getPost('department'),
            'total_price' => $this->request->getPost('total_price'),
            'status' => $this->request->getPost('status') ?? 'Pending',
        ]);

        session()->setFlashdata('success', 'Purchase Requisition berhasil ditambahkan.');
        return redirect()->to('/purchase-requisition');
    }

    public function edit($id)
    {
        $data['pr'] = $this->prModel->find($id);
        if (!$data['pr']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data tidak ditemukan');
        }
        return view('purchase_requisition/edit', $data);
    }

    public function update($id)
    {
        $this->prModel->update($id, [
            'description' => $this->request->getPost('description'),
            'requester' => $this->request->getPost('requester'),
            'department' => $this->request->getPost('department'),
            'total_price' => $this->request->getPost('total_price'),
            'status' => $this->request->getPost('status'),
        ]);

        session()->setFlashdata('success', 'Purchase Requisition berhasil diperbarui.');
        return redirect()->to('/purchase-requisition');
    }

    public function delete($id)
    {
        $this->prModel->delete($id);
        session()->setFlashdata('success', 'Purchase Requisition berhasil dihapus.');
        return redirect()->to('/purchase-requisition');
    }
}

