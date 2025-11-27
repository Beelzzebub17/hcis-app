# SmartHCIS Chat System — Visual Architecture & Data Flow

## 1. System Architecture Diagram

```
┌─────────────────────────────────────────────────────────────────────────┐
│                          USER BROWSER                                   │
│  ┌────────────────────────────────────────────────────────────────────┐ │
│  │ All.php View (Bootstrap 5 + Bootstrap Icons + Chart.js)           │ │
│  │                                                                    │ │
│  │  ┌─────────────────────────┬─────────────────────────────────┐  │ │
│  │  │ USER CHAT UI            │ ADMIN CHAT UI                   │  │ │
│  │  ├─────────────────────────┼─────────────────────────────────┤  │ │
│  │  │ • Select Division       │ • Division Tabs (Finance/HCIS)  │  │ │
│  │  │ • Message Input         │ • Chat List (unread counts)     │  │ │
│  │  │ • File Upload (drag)    │ • Message History              │  │ │
│  │  │ • Chat History          │ • Reply Input + File Upload     │  │ │
│  │  │ • Notifications (toast) │ • Assign / Status / Quick Reply │  │ │
│  │  │ • Rating UI (1-5 stars) │ • Save Button                   │  │ │
│  │  └─────────────────────────┴─────────────────────────────────┘  │ │
│  │                                                                    │ │
│  │  ┌──────────────────────────────────────────────────────────┐   │ │
│  │  │ Socket.IO Client (CDN: v4.6.1)                           │   │ │
│  │  │ • Connection: ws://localhost:3001                        │   │ │
│  │  │ • Emit: send_message → {division, sender, text, ...}   │   │ │
│  │  │ • Listen: new_message → Handle & Update UI             │   │ │
│  │  │ • Fallback: localStorage if socket unavailable          │   │ │
│  │  └──────────────────────────────────────────────────────────┘   │ │
│  │                                                                    │ │
│  │  ┌──────────────────────────────────────────────────────────┐   │ │
│  │  │ localStorage (Demo Storage)                              │   │ │
│  │  │ • Key: 'smarthcis_chat'                                  │   │ │
│  │  │ • Format: {Division: {messages: [], meta: {...}}}      │   │ │
│  │  │ • Persists on page reload                               │   │ │
│  │  │ • Auto-bot replies when socket unavailable             │   │ │
│  │  └──────────────────────────────────────────────────────────┘   │ │
│  │                                                                    │ │
│  └────────────────────────────────────────────────────────────────────┘ │
│                                                                         │
│  WebSocket                    HTTP APIs                                │
│  (Port 3001)                  (Port 8080)                              │
└────────────┬──────────────────────────────┬──────────────────────────────┘
             │                              │
             ↓                              ↓
    ┌────────────────────────┐   ┌──────────────────────────────┐
    │  Socket.IO Server      │   │  CodeIgniter REST API        │
    │  (Node.js Express)     │   │  (/api/chats, /api/messages) │
    │  Port: 3001            │   │  Port: 8080                  │
    │                        │   │                              │
    │ • Join room events     │   │ • POST /chats                │
    │ • Broadcast messages   │   │ • POST /messages (multipart) │
    │ • Room per division    │   │ • GET /chats, /messages      │
    │ • Best-effort DB save  │   │ • POST /assign, /status      │
    │   (via axios)          │   │ • Multipart file support     │
    │                        │   │ • Response: JSON             │
    └────────────────────────┘   └──────────────────────────────┘
             │                              │
             └──────────────┬───────────────┘
                            │
                            ↓
                   ┌────────────────────┐
                   │   MySQL Database   │
                   │                    │
                   │ • chats table      │
                   │ • messages table   │
                   │ • Persistent       │
                   │   storage          │
                   └────────────────────┘
                            ↑
                            │
                   ┌────────────────────┐
                   │  File Uploads      │
                   │  writable/uploads/ │
                   │  chat/             │
                   │                    │
                   │  • Images          │
                   │  • Documents       │
                   │  • Base64 (demo)   │
                   │  • Disk (API)      │
                   └────────────────────┘
```

---

## 2. Message Flow Diagram

### Real-Time Message (Socket.IO Path)

```
User Browser                  Socket.IO Server            Admin Browser
     │                               │                          │
     │ "Chatbot" page                │                          │
     │ Select Finance division       │                          │
     │ Type "Hello"                  │                          │
     │ Press Enter                   │                          │
     │                               │                          │
     ├─ socket.emit(                 │                          │
     │   'send_message',             │                          │
     │   {division,sender,text}      │                          │
     │ )                             │                          │
     │                               │                          │
     │─────────────────────────────→ │                          │
     │   WebSocket Frame             │                          │
     │                               │ Store in memory          │
     │                               │ Find room: 'division:...'│
     │                               │                          │
     │                               ├─ socket.emit(            │
     │                               │   'new_message',         │
     │                               │   {payload}              │
     │                               │ )  to room               │
     │                               │                          │
     │                               │ (broadcast to all)       │
     │                               │                          │
     │                               │─────────────────────────→│
     │                               │   WebSocket Frame        │ "Admin Chat" page
     │                               │                          │ Finance tab open
     │                               │                          │
     │                               │                          │ socket.on('new_message')
     │                               │                          │ {payload}
     │                               │                          │
     │                               │                          │ Update UI:
     │                               │                          │ - Add to message list
     │                               │                          │ - Show message bubble
     │                               │                          │ - Toast notification
     │                               │                          │ - Unread count--
     │                               │                          │
     │ (also receives broadcast)     │                          │
     │                               │                          │
     ← ──────────────────────────────│────────────────────────  ←
     │   (if in same room)           │     WebSocket            │
     │                               │                          │
     │ socket.on('new_message')      │                          │
     │ Update UI (if admin reply)    │                          │
     │                               │                          │
```

### Fallback Message (localStorage Path - Socket Down)

```
User Browser                                        Admin Browser
     │                                                    │
     │ "Chatbot" page                                     │
     │ Socket NOT connected                              │
     │ Type "Hello offline"                              │
     │ Press Enter                                        │
     │                                                    │
     ├─ socket NOT available                             │
     │ Fall back to:                                      │
     │ • Store in localStorage                           │
     │ • Trigger botReply()                              │
     │ • Show message in UI                              │
     │ • Toast: "Message stored locally"                 │
     │                                                    │
     │ After ~1 second:                                   │
     │ ├─ botReply() runs                                │
     │ ├─ Generate bot response                          │
     │ ├─ Add to localStorage                            │
     │ ├─ Show reply in UI                               │
     │ └─ Toast: "Bot replied"                           │
     │                                                    │
     │ Both messages persist in                           │
     │ localStorage['smarthcis_chat']                     │
     │                                                    │
     │ Refresh page:                                      │
     │ ├─ Chat history restored from localStorage         │
     │ └─ Messages reappear!                              │
     │                                                    │
     │ Note: Admin won't see these                        │
     │ (unless DB wired to API)                           │
     │                                                    │
```

---

## 3. Admin Reply Flow

```
Admin Browser              Socket.IO Server            User Browser
     │                             │                        │
     │ "Admin Chat" page           │                        │
     │ Finance tab open            │                        │
     │ See user message            │                        │
     │ Type reply: "Got it!"       │                        │
     │ Click "Kirim"               │                        │
     │                             │                        │
     ├─ socket.emit(               │                        │
     │   'send_message',           │                        │
     │   {division, sender:'admin',│                        │
     │    text:'Got it!', ...}     │                        │
     │ )                           │                        │
     │                             │                        │
     │─────────────────────────────→│                        │
     │  WebSocket Frame            │                        │
     │                             │ Broadcast to room      │
     │                             │ 'division:Finance'     │
     │                             │                        │
     │                             ├─ socket.emit('new_msg')
     │                             │ to all in room         │
     │                             │                        │
     │                             │─────────────────────→ │
     │                             │  WebSocket Frame       │
     │                             │                        │ "Chatbot" page
     │                             │                        │ Finance tab
     │                             │                        │ 
     │                             │                        │ socket.on('new_message')
     │                             │                        │ {sender:'admin', text:'Got it!'}
     │                             │                        │
     │                             │                        │ Update UI:
     │                             │                        │ • Add admin reply to chat
     │                             │                        │ • Show in blue bubble
     │                             │                        │ • Toast: "Admin replied"
     │                             │                        │
     │  (both receive broadcast)   │                        │
     │  socket.on('new_message')   │                        │
     │  Update chat (admin sees    │                        │
     │  own reply appear)          │                        │
     │                             │                        │
```

---

## 4. Data Storage Layers

```
┌─────────────────────────────────────────────────────────────────┐
│  Layer 1: Browser (SESSION)                                     │
│  • Temporary: JavaScript variables                              │
│  • Socket connection state                                      │
│  • Current active chat                                          │
│  • Lost on page reload                                          │
└─────────────────────────────────────────────────────────────────┘
                              ↓
┌─────────────────────────────────────────────────────────────────┐
│  Layer 2: Browser (PERSISTENT)                                  │
│  • localStorage['smarthcis_chat']                               │
│  • Survives page reload                                         │
│  • Can be cleared by user (Settings → Clear Cache)             │
│  • ~5-10MB limit per domain                                    │
│  • Supports chat history + messages in demo mode               │
└─────────────────────────────────────────────────────────────────┘
                              ↓
┌─────────────────────────────────────────────────────────────────┐
│  Layer 3: Socket.IO Server (IN-MEMORY)                          │
│  • Active connections + room subscriptions                      │
│  • Temporary message queue for delivery                         │
│  • Lost on server restart                                       │
│  • Attempts to save to Layer 4 (best-effort)                   │
│  • Handles real-time delivery                                  │
└─────────────────────────────────────────────────────────────────┘
                              ↓
┌─────────────────────────────────────────────────────────────────┐
│  Layer 4: MySQL Database (PERSISTENT)                           │
│  • Tables: chats, messages                                      │
│  • Survives server restarts                                     │
│  • Accessible via REST API                                      │
│  • Migration ready (not yet wired in frontend)                  │
│  • Unlimited storage capacity                                   │
│  • Can query historical data                                    │
└─────────────────────────────────────────────────────────────────┘
                              ↓
┌─────────────────────────────────────────────────────────────────┐
│  Layer 5: File System (/writable/uploads/chat/)                │
│  • Uploaded files (images, documents)                           │
│  • Base64 in localStorage (demo)                                │
│  • Disk storage via API (production)                            │
│  • Served to users via secure routes                            │
└─────────────────────────────────────────────────────────────────┘
```

---

## 5. Deployment Layers

```
DEVELOPMENT (Current)
├── PHP: localhost:8080 (php spark serve)
├── Node: localhost:3001 (node server.js)
├── DB: MySQL/MariaDB (Laragon)
└── Storage: /writable/uploads/chat/ (local disk)

STAGING
├── PHP: staging.example.com:8080
├── Node: staging-socket.example.com:3001
├── DB: RDS/Cloud MySQL
└── Storage: Cloud storage (S3/CDN)

PRODUCTION
├── PHP: app.example.com (Apache/Nginx)
├── Node: socket.example.com:3001 (separate server)
├── DB: Managed DB cluster (RDS/Aurora)
└── Storage: CDN + Backup (S3/Backup service)
```

---

## 6. Division & Room Structure

```
Socket.IO Rooms (by division):

division:Finance
  │
  ├─ User browser 1 (socket_id_abc)
  ├─ User browser 2 (socket_id_def)
  ├─ Admin browser 1 (socket_id_ghi)
  └─ Admin browser 2 (socket_id_jkl)
       ↓
       Message broadcast to ALL in room
       (All users + all admins see it instantly)

division:HCIS
  │
  ├─ User browser 1 (socket_id_mno)
  └─ Admin browser 1 (socket_id_pqr)

division:LDD
  │
  ├─ User browser 1 (socket_id_stu)
  └─ Admin browser 1 (socket_id_vwx)

Note: Each user/admin can be in multiple rooms
      (e.g., browsing multiple divisions simultaneously)
```

---

## 7. Data Model (JSON)

### localStorage Format
```javascript
{
  "Finance": {
    "messages": [
      {
        "id": "msg_1_1732687200000",
        "division": "Finance",
        "userName": "User1",
        "text": "I need a PO",
        "attachments": null,
        "sender": "user",
        "timestamp": 1732687200000,
        "status": "sent",
        "rating": 0
      },
      {
        "id": "msg_2_1732687201000",
        "division": "Finance",
        "userName": "System",
        "text": "Thank you for your message...",
        "attachments": null,
        "sender": "system",
        "timestamp": 1732687201000,
        "status": "sent",
        "rating": 0
      }
    ],
    "meta": {
      "unread": 0,
      "lastMessage": "Thank you for your message...",
      "status": "open",
      "lastUpdate": 1732687201000,
      "assigned": null,
      "rating": 0
    }
  },
  "HCIS": { /* similar */ },
  "LDD": { /* similar */ }
}
```

### Socket.IO Event Payload
```javascript
// send_message event
{
  division: "Finance",
  sender: "user" | "admin",
  text: "Message content",
  attachments: [
    {
      name: "document.pdf",
      path: "/writable/uploads/chat/abc123.pdf",
      size: 2048,
      type: "application/pdf"
    }
  ],
  timestamp: 1732687200000,
  userId: "user_123" // (optional, for auth)
}
```

### Database Schema (MySQL)
```javascript
// chats table
{
  id: 1,
  division: "Finance",
  user_name: "John Doe",
  status: "open", // open, pending, solved
  assigned: "Admin Demo", // NULL or admin name
  created_at: "2025-11-27 10:30:00",
  updated_at: "2025-11-27 10:35:00"
}

// messages table
{
  id: 1,
  chat_id: 1,
  sender: "user", // user, admin, system
  text: "I need a PO for office supplies",
  attachments: JSON.stringify([{name: "...", path: "..."}]),
  status: "sent", // sent, read
  created_at: "2025-11-27 10:30:00"
}
```

---

## 8. State Transitions

```
CHAT LIFECYCLE
┌─────────┐
│  NEW    │ (Just created, no messages)
└────┬────┘
     │ User sends first message
     ↓
┌─────────────┐
│   OPEN      │ (Active conversation)
└────┬────────┘
     │ Admin marks as "pending"
     ↓
┌─────────────┐
│  PENDING    │ (Awaiting response)
└────┬────────┘
     │ Admin resolves / marks "solved"
     ↓
┌─────────────┐
│   SOLVED    │ (Closed, can rate)
└────┬────────┘
     │ User submits 1-5 star rating
     ↓
┌─────────────┐
│   RATED     │ (Archived)
└─────────────┘
```

---

**Diagram Version**: 1.0  
**Last Updated**: 2025-11-27  
**For**: SmartHCIS Chat System v1.0.0 (Beta)
