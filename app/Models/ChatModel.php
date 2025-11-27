<?php namespace App\Models;

use CodeIgniter\Model;

class ChatModel extends Model
{
    protected $table = 'chats';
    protected $primaryKey = 'id';
    protected $allowedFields = ['division','user_name','status','assigned','created_at','updated_at'];

    protected $db;

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }

    public function createChat($division = 'Finance', $userName = null)
    {
        $now = date('Y-m-d H:i:s');
        $this->db->table('chats')->insert(['division'=>$division,'user_name'=>$userName,'status'=>'open','created_at'=>$now]);
        return $this->db->insertID();
    }

    public function getChats($division = null)
    {
        $builder = $this->db->table('chats');
        if($division && $division !== 'all') $builder->where('division', $division);
        $rows = $builder->orderBy('updated_at','DESC')->get()->getResultArray();
        // attach last message and unread count
        foreach($rows as &$r){
            $msg = $this->db->table('messages')->where('chat_id',$r['id'])->orderBy('created_at','DESC')->limit(1)->get()->getRowArray();
            $r['last_message'] = $msg ? $msg['text'] : null;
            $r['unread'] = (int)$this->db->table('messages')->where('chat_id',$r['id'])->where('status','sent')->countAllResults();
        }
        return $rows;
    }

    public function addMessage($chatId, $sender, $text = null, $attachments = null)
    {
        $now = date('Y-m-d H:i:s');
        $data = ['chat_id'=>$chatId,'sender'=>$sender,'text'=>$text,'attachments'=>$attachments ? json_encode($attachments) : null,'status'=>'sent','created_at'=>$now];
        $this->db->table('messages')->insert($data);
        $this->db->table('chats')->where('id',$chatId)->update(['updated_at'=>$now]);
        return $this->db->insertID();
    }

    public function getMessages($chatId)
    {
        $rows = $this->db->table('messages')->where('chat_id',$chatId)->orderBy('created_at','ASC')->get()->getResultArray();
        foreach($rows as &$r){ if($r['attachments']) $r['attachments'] = json_decode($r['attachments'], true); }
        return $rows;
    }

    public function setAssigned($chatId, $assigned)
    {
        return $this->db->table('chats')->where('id',$chatId)->update(['assigned'=>$assigned,'updated_at'=>date('Y-m-d H:i:s')]);
    }

    public function setStatus($chatId, $status)
    {
        return $this->db->table('chats')->where('id',$chatId)->update(['status'=>$status,'updated_at'=>date('Y-m-d H:i:s')]);
    }

    public function markRead($chatId)
    {
        return $this->db->table('messages')->where('chat_id',$chatId)->where('status','sent')->update(['status'=>'read']);
    }
}
