<?php namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ChatModel;

class Chat extends BaseController
{
    protected $chatModel;

    public function __construct()
    {
        $this->chatModel = new ChatModel();
    }

    public function index()
    {
        return $this->response->setJSON(['ok'=>true,'msg'=>'Chat API']);
    }

    public function listChats()
    {
        $division = $this->request->getGet('division') ?? null;
        $rows = $this->chatModel->getChats($division);
        return $this->response->setJSON($rows);
    }

    public function createChat()
    {
        $division = $this->request->getVar('division') ?? 'Finance';
        $userName = $this->request->getVar('user_name') ?? null;
        $id = $this->chatModel->createChat($division, $userName);
        return $this->response->setJSON(['id'=>$id]);
    }

    public function sendMessage()
    {
        $chatId = $this->request->getVar('chat_id');
        $sender = $this->request->getVar('sender') ?? 'user';
        $text = $this->request->getVar('text') ?? null;
        $attachments = null;
        // handle uploaded files
        $files = $this->request->getFiles();
        if($files){
            $attachments = [];
            foreach($files as $file){
                if(!$file->isValid()) continue;
                $name = $file->getRandomName();
                $file->move(WRITEPATH . 'uploads/chat', $name);
                $attachments[] = ['name'=>$file->getClientName(),'path'=>'/writable/uploads/chat/'.$name,'size'=>$file->getSize(),'type'=>$file->getClientMimeType()];
            }
        }
        if(!$chatId){
            // create a chat for convenience
            $division = $this->request->getVar('division') ?? 'Finance';
            $chatId = $this->chatModel->createChat($division, $this->request->getVar('user_name') ?? null);
        }
        $id = $this->chatModel->addMessage($chatId, $sender, $text, $attachments);
        return $this->response->setJSON(['ok'=>true,'message_id'=>$id]);
    }

    public function getMessages($chatId = null)
    {
        if(!$chatId) return $this->response->setStatusCode(400)->setJSON(['error'=>'missing chat id']);
        $msgs = $this->chatModel->getMessages($chatId);
        return $this->response->setJSON($msgs);
    }

    public function assign($chatId = null)
    {
        if(!$chatId) return $this->response->setStatusCode(400)->setJSON(['error'=>'missing chat id']);
        $user = $this->request->getVar('assigned') ?? 'Admin';
        $this->chatModel->setAssigned($chatId, $user);
        return $this->response->setJSON(['ok'=>true]);
    }

    public function setStatus($chatId = null)
    {
        if(!$chatId) return $this->response->setStatusCode(400)->setJSON(['error'=>'missing chat id']);
        $status = $this->request->getVar('status') ?? 'open';
        $this->chatModel->setStatus($chatId, $status);
        return $this->response->setJSON(['ok'=>true]);
    }

    public function markRead($chatId = null)
    {
        if(!$chatId) return $this->response->setStatusCode(400)->setJSON(['error'=>'missing chat id']);
        $this->chatModel->markRead($chatId);
        return $this->response->setJSON(['ok'=>true]);
    }
}
