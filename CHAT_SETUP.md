# SmartHCIS Chat — Complete Setup & Testing Guide

## Overview
SmartHCIS now includes a full-featured chat system with:
- **Frontend**: User chat UI (send/receive, file upload, ratings) + Admin chat management panel
- **Backend**: CodeIgniter REST API for persistence (chats, messages, file uploads, status/assign)
- **Real-time**: Node.js Socket.IO server for instant message delivery across clients
- **Fallback**: localStorage demo mode when backend/socket unavailable

## Architecture

```
┌─────────────────────────────────────────────────────────────┐
│ Browser Client (All.php)                                    │
│ - User Chat UI (Chatbot page)                               │
│ - Admin Chat Management (Admin Chat page)                   │
│ - Socket.IO client (port 3001)                              │
└─────────────────────────────────────────────────────────────┘
              ↓ Socket.IO & HTTP ↓
         ┌────────────────────────────┐
         │ Socket.IO Server (Node.js) │
         │ Port: 3001                 │
         │ socket-server/server.js    │
         └────────────────────────────┘
              ↓ HTTP (optional API save) ↓
         ┌────────────────────────────┐
         │ CodeIgniter Backend        │
         │ /api/chats (REST)          │
         │ /api/messages              │
         │ Database (MySQL)           │
         │ File uploads: writable/    │
         │   uploads/chat             │
         └────────────────────────────┘
```

## Quick Start

### 1. Prerequisites
- PHP 8.1+ (Laragon)
- Node.js 16+ (npm)
- MySQL/MariaDB (for persistence, optional)

### 2. Install & Start Services

#### Option A: Socket Server + localStorage (Demo Mode - NO DB needed)
This is currently running. Just open the app:
```bash
# Terminal 1: Start PHP dev server
cd C:\laragon\www\hcis-app
php spark serve

# Terminal 2: Socket server (already running on port 3001)
# If stopped, restart with:
cd socket-server
node server.js
```

#### Option B: Full Backend (With DB Persistence)
```bash
# Terminal 1: Start PHP dev server
php spark serve

# Terminal 2: Socket server
cd socket-server
node server.js

# Terminal 3: Run migrations to create DB tables
php spark migrate

# Optional: Check migration status
php spark migrate:status
```

### 3. Access the App
- **URL**: http://localhost:8080 (or your Laragon URL)
- **Demo Login**: `admin / 12345`
- **Chat**: Click "Chatbot" menu (user chat page)
- **Admin**: Click "Admin Chat" menu (admin management page)

## Features & Test Scenarios

### User Chat (Chatbot Page)
1. **Send Text Message**
   - Select division (Finance, HCIS, LDD)
   - Type message
   - Press Enter or click "Kirim"
   - Expected: Message appears in chat, toast notification

2. **Upload File**
   - Click file input next to text input
   - Select an image or document
   - Type optional text
   - Click "Kirim"
   - Expected: File + message appear with attachment link

3. **Receive Message**
   - If socket server running: message appears instantly
   - If socket down: bot auto-replies after ~1 second
   - Other browser tab (admin) will see it realtime

4. **Mark as Read**
   - When you view messages, they mark as "read"
   - Admin unread count decrements

5. **Close & Rate**
   - Admin marks chat as "solved"
   - User sees rating UI (1–5 stars)
   - Click star to rate
   - Rating persists

### Admin Chat (Admin Chat Page)
1. **List Chats**
   - See all divisions + unread count
   - Last message preview
   - Click to open

2. **View Messages**
   - Expand chat to see full history
   - See "User" vs "Admin" vs "System" labels
   - Download attachments

3. **Assign & Status**
   - Click "Assign to me" → marks assigned to "Admin Demo"
   - Change status dropdown: open/pending/solved
   - Click save

4. **Reply & Upload**
   - Type message in reply input
   - Select file (optional)
   - Click "Kirim"
   - Appears in chat + sent realtime to user

5. **Quick Reply**
   - Select template from "Quick reply..." dropdown
   - Click "Use" to populate reply field

## API Endpoints (for advanced integration)

All endpoints return JSON. Base: `http://localhost:8080/api/`

### Chats
- **GET `/chats?division=Finance`** — List chats (optional filter by division)
- **POST `/chats`** — Create chat  
  ```
  division=Finance&user_name=DemoUser
  ```
- **POST `/chats/assign/1`** — Assign chat  
  ```
  assigned=Admin Name
  ```
- **POST `/chats/status/1`** — Set status  
  ```
  status=solved
  ```

### Messages
- **POST `/messages`** — Send message  
  ```
  chat_id=1&sender=user&text=Hello&file=@/path/to/file
  ```
- **GET `/messages/1`** — Get messages for chat  
- **POST `/chats/read/1`** — Mark messages as read  

### File Upload
Files upload to: `writable/uploads/chat/`  
Response includes file path: `/writable/uploads/chat/randomname.ext`

## Troubleshooting

### Socket Server Not Connecting
- **Symptom**: Toast says "Socket disconnected"
- **Fix**: 
  - Check socket server is running: `curl http://localhost:3001`
  - Check firewall allows port 3001
  - Browser console (F12) shows WebSocket errors?
  - Fallback mode (localStorage) works but no realtime

### Chat Not Saving to DB
- **Symptom**: Messages appear in UI but don't persist on page reload
- **Fix**:
  - Run migrations: `php spark migrate`
  - Check DB credentials in `.env`
  - API may not be wired yet (see "Roadmap" below)

### File Upload Not Working
- **Symptom**: Upload button does nothing
- **Fix**:
  - Check `writable/uploads/chat/` folder exists
  - Check folder is writable: `chmod 755 writable/uploads/chat/` (Linux/Mac)
  - Try smaller file size
  - Browser console errors?

### No Bot Reply (Offline Mode)
- **Symptom**: Send message, no reply
- **Fix**: Socket server must be off. Expected behavior — restart socket server for realtime, or the app falls back to localStorage only.

## Resetting Data

### Clear localStorage (Browser)
```javascript
// In browser console (F12):
localStorage.removeItem('smarthcis_chat');
location.reload();
```

### Reset DB (PHP)
```bash
php spark migrate:rollback
php spark migrate
```

### Clear Uploaded Files
```bash
rm -r writable/uploads/chat/*
```

## Roadmap / Next Steps

### [ ] Persistence to Backend
Currently frontend saves to localStorage and socket server broadcasts to clients, but does NOT persist to MySQL. To enable:
- Update `socket-server/server.js` to call CodeIgniter API with file uploads
- Or: have frontend call API directly for persistence, socket for realtime
- Wire admin panel to load chats from DB instead of localStorage

### [ ] Authentication
- Add JWT tokens to API endpoints
- Secure socket.io with session validation
- Per-user chat visibility

### [ ] Notifications
- Email alerts on new message
- SMS via Twilio (optional)
- Desktop notifications (browser)

### [ ] Advanced Admin
- Chat search & filters
- Bulk actions (mark solved, assign)
- Chat history export
- Analytics dashboard

## File Structure

```
hcis-app/
├── app/
│   ├── Controllers/Chat.php          [REST API endpoints]
│   ├── Models/ChatModel.php          [DB queries]
│   ├── Database/Migrations/
│   │   └── 20251127_create_chat_tables.php
│   ├── Views/All.php                 [Frontend chat UI + socket client]
│   └── Config/Routes.php             [API routes]
├── socket-server/
│   ├── package.json
│   ├── server.js                     [Socket.IO server]
│   └── node_modules/
├── writable/
│   └── uploads/
│       └── chat/                     [Uploaded files saved here]
└── database.sql                      [DB schema (auto-created by migration)]
```

## Support & Notes

- **Demo**: Works completely offline (localStorage only) if socket + DB unavailable
- **Realtime**: Socket server broadcasts messages instantly across all connected clients
- **Persistence**: Optional via DB + API (not yet wired in frontend, but backend ready)
- **Files**: Stored on disk in `writable/uploads/chat/`; serve via secure route for production
- **Security**: Add auth, CORS restrictions, input validation before production use

---

**Last Updated**: 2025-11-27  
**Version**: 1.0.0 (Beta)
