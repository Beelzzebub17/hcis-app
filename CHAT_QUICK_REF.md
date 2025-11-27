# SmartHCIS Chat — Developer Quick Reference

## 🎯 One-Minute Start

```bash
# Terminal 1: PHP Dev Server
cd C:\laragon\www\hcis-app
php spark serve

# Terminal 2: Socket.IO Server (should already be running)
cd socket-server
node server.js

# Terminal 3: Optional - DB Migrations
php spark migrate
```

**Open**: http://localhost:8080 → Login: `admin / 12345` → Click "Chatbot" or "Admin Chat"

---

## 📡 Architecture

| Layer | Technology | Port | Status |
|-------|-----------|------|--------|
| Frontend | HTML/Bootstrap/JS/Socket.IO CDN | 8080 | ✅ Running |
| Socket.IO | Node.js Express + Socket.IO | 3001 | ✅ Running |
| API | CodeIgniter REST endpoints | 8080 | ✅ Ready |
| Database | MySQL chats/messages tables | N/A | ⏳ Migration ready |

---

## 🔗 Key URLs & Endpoints

### Browser
- **User Chat**: http://localhost:8080/All?menu=chatbot
- **Admin Chat**: http://localhost:8080/All?menu=admin_chat
- **API Base**: http://localhost:8080/api

### Socket.IO Events
- **Emit**: `socket.emit('send_message', {division, sender, text, attachments})`
- **Listen**: `socket.on('new_message', (payload) => {})`
- **Room**: `division:Finance`, `division:HCIS`, `division:LDD`

### REST API
```
POST   /api/chats                 - Create chat
GET    /api/chats?division=X      - List chats
POST   /api/messages              - Send message
GET    /api/messages/{id}         - Get chat history
POST   /api/chats/assign/{id}     - Assign chat
POST   /api/chats/status/{id}     - Set status (open/pending/solved)
POST   /api/chats/read/{id}       - Mark messages as read
```

---

## 📂 File Structure

```
app/
  ├── Controllers/Chat.php ..................... API endpoints
  ├── Models/ChatModel.php ..................... DB queries
  ├── Views/All.php ........................... Frontend UI + Socket client
  ├── Config/Routes.php ........................ API route definitions
  └── Database/Migrations/
      └── 20251127_create_chat_tables.php ..... DB schema

socket-server/
  ├── server.js ............................... Socket.IO server
  ├── package.json ............................ Node dependencies
  └── node_modules/ ........................... npm packages (installed)

writable/
  └── uploads/chat/ ........................... File upload directory
```

---

## 🧪 Quick Tests

### Test 1: Real-Time Message (2 Tabs)
```
Tab A: http://localhost:8080 → Chatbot → Finance → Send "Hello"
Tab B: http://localhost:8080 → Admin Chat → Finance → Should see "Hello" instantly
```

### Test 2: API Call (PowerShell)
```powershell
$body = @{division='Finance'; user_name='TestUser'} | ConvertTo-Json
Invoke-WebRequest -Uri 'http://localhost:8080/api/chats' `
  -Method Post -Body $body -ContentType 'application/json' | Select-Object -ExpandProperty Content
```

### Test 3: Offline Mode (Stop Socket Server)
```
Ctrl+C in Terminal 2 → Open http://localhost:8080 → Chatbot → Send message
Expected: Message stored + bot replies automatically
```

---

## 💾 localStorage Structure

Messages stored in browser localStorage under key `smarthcis_chat`:

```javascript
{
  "Division": {
    "messages": [
      {
        "id": "msg_1",
        "division": "Finance",
        "userName": "User1",
        "text": "Hello",
        "attachments": null,
        "sender": "user",
        "timestamp": 1696000000000,
        "status": "sent",
        "rating": 0
      }
    ],
    "meta": {
      "unread": 0,
      "lastMessage": "Hello",
      "status": "open"
    }
  }
}
```

**Clear localStorage**: `localStorage.removeItem('smarthcis_chat')`

---

## 🔑 Key Functions in All.php

```javascript
initSocket()                    // Connect to Socket.IO server
handleSocketMessage(payload)    // Receive broadcasts, update UI
sendChat()                      // Emit message via socket (or localStorage fallback)
renderChat()                    // Display user chat messages
renderAdminList()               // Display admin chat list
openAdminSession(division)      // Open admin chat view for division
```

---

## 🛠️ Database Schema (After Migration)

### Table: `chats`
```sql
id              INT PRIMARY KEY AUTO_INCREMENT
division        VARCHAR(50)     'Finance', 'HCIS', 'LDD'
user_name       VARCHAR(255)    User display name
status          VARCHAR(50)     'open', 'pending', 'solved'
assigned        VARCHAR(255)    NULL or admin name
created_at      TIMESTAMP       Auto
updated_at      TIMESTAMP       Auto
```

### Table: `messages`
```sql
id              INT PRIMARY KEY AUTO_INCREMENT
chat_id         INT FOREIGN KEY references chats(id)
sender          VARCHAR(50)     'user', 'admin', 'system'
text            LONGTEXT        Message content
attachments     JSON            [{"name": "...", "path": "..."}]
status          VARCHAR(50)     'sent', 'read'
created_at      TIMESTAMP       Auto
```

---

## 🚨 Common Issues

| Problem | Cause | Fix |
|---------|-------|-----|
| 404 /api/chats | Routes not loaded | Restart PHP server `php spark serve` |
| Socket not connecting | Server down | Check `node server.js` running in Terminal 2 |
| File upload 404 | Directory missing | Create `/writable/uploads/chat/` folder |
| Messages not saving | DB not migrated | Run `php spark migrate` |
| Cors errors | Socket server CORS | Check `socket-server/server.js` cors config |

---

## 📝 Logs & Debugging

### Browser Console (F12)
```javascript
// Check socket connection
socket.connected     // true = connected to server

// View localStorage
localStorage.getItem('smarthcis_chat')

// Clear for testing
localStorage.clear()
```

### Terminal (Node Socket Server)
```
Socket connected: socket_id
join {division: Finance}
send_message {division: Finance, text: Hello}
```

### PHP Error Log
```
writable/logs/log-*.log
```

---

## 🔐 Security Checklist (Pre-Production)

- [ ] Add JWT authentication to API endpoints
- [ ] Add session validation to Socket.IO
- [ ] Validate file uploads (type, size)
- [ ] Sanitize message text (XSS prevention)
- [ ] Implement CORS whitelist
- [ ] Enable HTTPS/WSS for Socket.IO
- [ ] Rate limit API endpoints
- [ ] Encrypt database sensitive data

---

## 📚 Full Documentation

- **CHAT_SETUP.md** — Features, troubleshooting, architecture
- **CHAT_API_TESTING.md** — API examples (PowerShell/Postman)
- **CHAT_STATUS.md** — Current status, verification, pending work

---

## 🎓 Learning Path

1. **Understand Flow**: Read "Architecture" section above
2. **Test UI**: Open app, send message in Chatbot + Admin Chat
3. **Test Socket**: Stop node server, see fallback to localStorage
4. **Test API**: Run curl examples from CHAT_API_TESTING.md
5. **Explore Code**: Check `app/Views/All.php` for socket integration
6. **Extend**: Add new divisions, modify quick replies, add auth

---

**Need Help?** Check the troubleshooting sections in CHAT_SETUP.md or CHAT_STATUS.md.

**Last Updated**: 2025-11-27  
**Version**: 1.0.0 (Beta)
