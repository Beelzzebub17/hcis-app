# SmartHCIS Chat — Troubleshooting Decision Tree

## 🔧 Quick Diagnostic Flowchart

```
                        Is there a problem?
                              |
                    Yes ← ─ ─ ─ ┴ ─ ─ ─ → No
                    |                      |
            What's the symptom?      You're all set!
                    |                    ✅
        ┌───────────┼───────────┬──────────┴──────────┐
        |           |           |                     |
   ┌────▼─────┐ ┌──▼────┐ ┌───▼────┐ ┌────────┴──────┐
   │ Can't     │ │ Chat  │ │API 404 │ │ File upload  │
   │connect to │ │ blank │ │errors  │ │ not working  │
   │app        │ │ page  │ │        │ │              │
   └─┬────────┘ └──┬────┘ └───┬────┘ └────┬─────────┘
     |             |          |            |
  [→ 1]         [→ 2]      [→ 3]       [→ 4]
```

---

## Issue 1: Can't Connect to App (http://localhost:8080)

### Symptom
- Browser shows "Connection refused" or timeout
- Page won't load at all
- DNS lookup fails

### Diagnostic Steps

**Step 1A**: Check if PHP server is running
```powershell
netstat -tulpn | findstr 8080
# OR
Get-NetTCPConnection -LocalPort 8080 -ErrorAction SilentlyContinue
```
- ✅ **Port 8080 listening** → Go to Step 1B
- ❌ **Port 8080 NOT listening** → Go to Solution 1C

**Step 1B**: Verify correct URL in browser
- [ ] URL is exactly: `http://localhost:8080`
- [ ] Not `http://localhost:8080/app`
- [ ] Not `https://` (should be http)
- ✅ **URL correct** → Go to Step 1C
- ❌ **URL incorrect** → Fix URL, reload

**Step 1C**: Check PHP error logs
```powershell
tail -f C:\laragon\www\hcis-app\writable\logs\log-*.log
# OR manually check:
explorer "C:\laragon\www\hcis-app\writable\logs\"
```
- ✅ **No errors shown** → Go to Solution 1D
- ❌ **Errors visible** → Read error message, jump to relevant issue

### Solutions

**1D**: Restart PHP server
```powershell
# Terminal 1 - Stop current server (Ctrl+C)
# Then restart:
cd C:\laragon\www\hcis-app
php spark serve
```
Wait 5 seconds, reload browser. Should work now.

**1E**: Check .env configuration
```powershell
# Edit .env file:
code C:\laragon\www\hcis-app\.env

# Verify these are set:
# APP_NAME = SmartHCIS
# CI_ENVIRONMENT = development
# app.baseURL = http://localhost:8080/
```
Save, restart PHP server.

**1F**: Check if another service is using port 8080
```powershell
# Find what's using port 8080
Get-NetTCPConnection -LocalPort 8080 -ErrorAction SilentlyContinue | 
  Select-Object -ExpandProperty OwningProcess | 
  Get-Process

# Kill the process (replace PID with actual)
Stop-Process -Id <PID> -Force
```
Restart PHP server on a different port if needed:
```powershell
php spark serve --port 9090
# Then access: http://localhost:9090
```

**1G**: Firewall is blocking port
- Open Windows Firewall
- Allow PHP (php.exe) through firewall
- Or use `netsh` command:
```powershell
netsh advfirewall firewall add rule name="PHP Dev" dir=in action=allow program="C:\laragon\bin\php\php8.1.10\php.exe" enable=yes
```

---

## Issue 2: Chat Page Loads But Blank (No Messages Showing)

### Symptom
- Page loads successfully
- "Chatbot" tab opens
- Division selector shows Finance/HCIS/LDD
- But no messages displayed
- No error in console

### Diagnostic Steps

**Step 2A**: Check browser console for errors
```
Press F12 → Console tab → Look for red errors
```
- ✅ **No red errors** → Go to Step 2B
- ❌ **Red errors visible** → Read error, jump to Issue 3/4 as needed

**Step 2B**: Check if localStorage has data
```javascript
// Open browser console and run:
localStorage.getItem('smarthcis_chat')
```
- ✅ **Shows data like `{"Finance":{...}` → Go to Step 2C
- ❌ **Returns `null` or empty** → Go to Solution 2D

**Step 2C**: Check if socket is connected
```javascript
// In console:
socket.connected
```
- ✅ **Returns `true`** → Go to Step 2E
- ❌ **Returns `false`** → Go to Issue 5 (Socket Not Connecting)

**Step 2D**: Check if renderChat() is being called
```javascript
// In console, trigger refresh:
renderChat()
```
- ✅ **Messages appear after calling** → Chat functions exist, just not rendering
- ❌ **Still blank** → Function might not exist

**Step 2E**: Verify All.php loaded completely
```javascript
// Check if global variable exists:
typeof SOCKET_URL
```
- ✅ **Returns "string"** → Socket URL defined, proceed to diagnosis
- ❌ **Returns "undefined"** → All.php may not be loading

### Solutions

**2F**: Manually test localStorage
```javascript
// In console, add test data:
localStorage.setItem('smarthcis_chat', JSON.stringify({
  Finance: {
    messages: [{
      id: 'test_1',
      division: 'Finance',
      userName: 'TestUser',
      text: 'Test message',
      sender: 'user',
      timestamp: Date.now(),
      status: 'sent',
      rating: 0
    }],
    meta: { unread: 0, status: 'open' }
  }
}))

// Then reload page
location.reload()
```
If messages appear after reload, the issue is data not being stored, not rendering.

**2G**: Check All.php file exists and is served
```powershell
# Verify file exists
Test-Path "C:\laragon\www\hcis-app\app\Views\All.php"

# Check if it's being served:
curl http://localhost:8080/All | head -50
# Look for: "id="chatbot-container"" or "socket.io"
```

**2H**: Clear browser cache and reload
```javascript
// In console:
localStorage.clear()
sessionStorage.clear()
location.reload()
```

**2I**: Check PHP session
```javascript
// If session needed, verify in console:
fetch('http://localhost:8080/api/chats')
  .then(r => r.json())
  .then(d => console.log(d))
```
If you get 403 or 401, session issue. Check login first.

---

## Issue 3: API Endpoints Returning 404 Errors

### Symptom
- Sending message shows: "POST /api/messages 404 Not Found"
- Admin chat can't load: "GET /api/chats 404 Not Found"
- API endpoints don't exist

### Diagnostic Steps

**Step 3A**: Check if routes are registered
```powershell
# Look for routes in config:
grep -n "api/messages" "C:\laragon\www\hcis-app\app\Config\Routes.php"
```
- ✅ **Routes found in output** → Go to Step 3B
- ❌ **No output** → Go to Solution 3C

**Step 3B**: Check if Chat controller exists
```powershell
Test-Path "C:\laragon\www\hcis-app\app\Controllers\Chat.php"
```
- ✅ **File exists** → Go to Step 3D
- ❌ **File missing** → Go to Solution 3F

**Step 3D**: Check if routes are correctly formatted
```powershell
code "C:\laragon\www\hcis-app\app\Config\Routes.php"
# Look for lines like:
# $routes->post('api/messages', 'Chat::sendMessage');
# $routes->get('api/chats', 'Chat::listChats');
```
- ✅ **Routes look correct** → Go to Step 3E
- ❌ **Routes have typos** → Fix them, restart PHP

**Step 3E**: Check PHP namespace matches
```
In Routes.php, verify:
$routes->post('api/messages', 'Chat::sendMessage');

Should match Chat.php:
namespace App\Controllers;
class Chat extends BaseController { ... }
```
- ✅ **Matches** → Go to Solution 3G
- ❌ **Mismatch** → Fix namespace or route

### Solutions

**3C**: Routes file missing or config not loaded
```powershell
# Verify routes file exists:
Test-Path "C:\laragon\www\hcis-app\app\Config\Routes.php"

# Check if routes are cached (CI4 development mode shouldn't cache):
ls "C:\laragon\www\hcis-app\writable\cache"
# If files exist, delete them:
rm "C:\laragon\www\hcis-app\writable\cache\*" -Force
```
Restart PHP server.

**3F**: Chat controller missing
```powershell
# Verify controller exists:
Test-Path "C:\laragon\www\hcis-app\app\Controllers\Chat.php"

# If missing, check if it was created:
# If not, create from CHAT_SETUP.md or reinstall
```

**3G**: Cache or routing issue
```powershell
# Clear all caches:
rm "C:\laragon\www\hcis-app\writable\cache\*" -Force
rm "C:\laragon\www\hcis-app\writable\debugbar\*" -Force

# Restart PHP:
# (Ctrl+C in Terminal 1)
php spark serve
```

Try API again: `curl http://localhost:8080/api/chats`

---

## Issue 4: File Upload Not Working

### Symptom
- Click file button, nothing happens
- Upload gives error 500 or 400
- Files don't save to disk
- File appears as "undefined" in chat

### Diagnostic Steps

**Step 4A**: Check if directory exists
```powershell
Test-Path "C:\laragon\www\hcis-app\writable\uploads\chat"
```
- ✅ **Directory exists** → Go to Step 4B
- ❌ **Directory missing** → Go to Solution 4C

**Step 4B**: Check directory permissions (Windows)
```powershell
# Right-click folder → Properties → Security → Edit
# Ensure "Users" group has "Modify" permission
# OR run as admin:
icacls "C:\laragon\www\hcis-app\writable\uploads\chat" /grant:r "Users:(OI)(CI)M"
```

**Step 4C**: Test with small file
```javascript
// In browser, select a small text file (1KB)
// Upload and check console for errors
// Also check PHP error log:
tail -f "C:\laragon\www\hcis-app\writable\logs\log-*.log"
```

**Step 4D**: Check file size limit
```
Look for errors like "file_uploads disabled" or "upload_max_filesize"
Check PHP.ini: /laragon/bin/php/php8.1.10/php.ini
```

### Solutions

**4C**: Create directory
```powershell
# Create if missing:
mkdir "C:\laragon\www\hcis-app\writable\uploads\chat" -Force
```

**4D**: Set permissions
```powershell
# Give PHP write access:
icacls "C:\laragon\www\hcis-app\writable\uploads\chat" /grant:r "Users:(OI)(CI)F"
# OR for IIS/FastCGI:
icacls "C:\laragon\www\hcis-app\writable\uploads\chat" /grant:r "IIS_IUSRS:(OI)(CI)M"
```

**4E**: Check PHP file upload settings
```
In PHP.ini:
file_uploads = On
upload_max_filesize = 100M
post_max_size = 100M
```
Restart PHP if changed.

**4F**: Test upload endpoint directly
```powershell
# Create test file
"test content" | Out-File "C:\temp\test.txt" -Encoding UTF8

# Upload via API (simplest curl multipart):
curl -X POST `
  -F "chat_id=1" `
  -F "sender=user" `
  -F "text=Test file" `
  -F "file=@C:\temp\test.txt" `
  http://localhost:8080/api/messages
```
Check response for errors.

---

## Issue 5: Socket Not Connecting (Real-time Not Working)

### Symptom
- Browser console shows "Socket disconnected" toast
- Messages don't appear in real-time
- Admin chat doesn't update instantly
- Socket.IO tab shows "disconnected"

### Diagnostic Steps

**Step 5A**: Check if Socket.IO server is running
```powershell
netstat -tulpn | findstr 3001
# OR
Get-NetTCPConnection -LocalPort 3001 -ErrorAction SilentlyContinue
```
- ✅ **Port 3001 listening** → Go to Step 5B
- ❌ **Not listening** → Go to Solution 5C

**Step 5B**: Check browser console for socket errors
```javascript
// F12 → Console → Look for:
// "WebSocket connection to... failed"
// "XMLHttpRequest error"
// "CORS policy: No 'Access-Control-Allow-Origin'"
```
- ✅ **No errors** → Go to Step 5D
- ❌ **Error message** → Go to Solution based on error

**Step 5C**: Check if Socket.IO server is accessible
```powershell
curl http://localhost:3001
# Expected: Timeout or connection error (normal)
# Can also try telnet:
telnet localhost 3001
# Expected: "Escape character is '^]'"
```

**Step 5D**: Verify Socket.IO CDN link in HTML
```javascript
// In browser console, check if Socket.IO loaded:
typeof io
```
- ✅ **Returns "function"** → Socket.IO library loaded
- ❌ **Returns "undefined"** → CDN link broken or blocked

### Solutions

**5C**: Socket server not running
```powershell
# Check if already running:
Get-Process | ? { $_.ProcessName -like "*node*" }

# If not running, start it:
cd "C:\laragon\www\hcis-app\socket-server"
node server.js

# Or if it crashed, check logs:
tail -f "C:\laragon\www\hcis-app\socket-server\logs\*.log"
```

**5D**: Port 3001 in use by another process
```powershell
# Find what's using port:
Get-NetTCPConnection -LocalPort 3001 | Select-Object -ExpandProperty OwningProcess | Get-Process

# Kill it and restart socket server:
Stop-Process -Id <PID> -Force
node server.js
```

**5E**: CORS error from Socket.IO
```
Check error message. If CORS, update server.js:

const io = require('socket.io')(server, {
  cors: {
    origin: '*',  // Temporarily allow all
    methods: ['GET', 'POST']
  }
});

Then restart socket server.
```

**5F**: Socket.IO CDN blocked
```javascript
// In browser console:
typeof io

// If undefined, CDN may be blocked.
// Check if you need to update CDN URL or use local copy
```

**5G**: Firewall blocking port 3001
```powershell
# Add firewall rule:
netsh advfirewall firewall add rule name="Node Socket" dir=in action=allow `
  program="C:\Program Files\nodejs\node.exe" enable=yes
```

---

## Issue 6: Database Not Saving Messages

### Symptom
- Messages appear in chat but disappear on reload
- Admin can't see user messages
- "Chat not saving to DB" message visible
- Chats table is empty

### Diagnostic Steps

**Step 6A**: Check if migration has been run
```powershell
php spark migrate:status
# Look for: "20251127_create_chat_tables"
# Status should be "✓" (completed), not "x" (pending)
```
- ✅ **Migration status OK** → Go to Step 6B
- ❌ **Pending or failed** → Go to Solution 6C

**Step 6B**: Check if tables exist in database
```sql
-- In MySQL client:
USE <your_database>;
SHOW TABLES;
-- Look for: chats, messages
```
- ✅ **Both tables visible** → Go to Step 6D
- ❌ **Tables missing** → Go to Solution 6E

**Step 6D**: Check if frontend is calling API
```javascript
// Open browser Network tab (F12 → Network)
// Send a message
// Look for POST to /api/messages
```
- ✅ **POST request visible** → Check response for errors
- ❌ **No POST request** → Frontend using localStorage only

### Solutions

**6C**: Run migrations
```powershell
# First, check for conflicts:
php spark migrate:status

# If all OK, run:
php spark migrate

# If there are conflicts, rollback and retry:
php spark migrate:rollback
php spark migrate
```

**6E**: Create tables manually
```sql
-- Run this SQL in MySQL client:
USE smarthcis_db;

CREATE TABLE chats (
  id INT PRIMARY KEY AUTO_INCREMENT,
  division VARCHAR(50),
  user_name VARCHAR(255),
  status VARCHAR(50) DEFAULT 'open',
  assigned VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE messages (
  id INT PRIMARY KEY AUTO_INCREMENT,
  chat_id INT,
  sender VARCHAR(50),
  text LONGTEXT,
  attachments JSON,
  status VARCHAR(50) DEFAULT 'sent',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (chat_id) REFERENCES chats(id)
);
```

**6F**: Wire frontend to API
Edit `app/Views/All.php`, find `sendChat()` function and uncomment API call:
```javascript
// Instead of:
botReply();

// Do:
fetch('/api/messages', {
  method: 'POST',
  headers: {'Content-Type': 'application/json'},
  body: JSON.stringify({chat_id, sender: 'user', text: msg.text})
})
.then(r => r.json())
.then(d => console.log(d))
.catch(e => console.error(e))
```

---

## Quick Decision Tree (TL;DR)

```
PROBLEM                          SOLUTION
─────────────────────────────────────────────────────
Can't open app                → Check PHP running, port 8080
Chat page blank              → Check localStorage, socket connected
API 404 errors               → Check routes.php, Chat.php exists
File upload fails            → Check /writable/uploads/chat/ exists
Socket not connecting        → Check Node running, port 3001
Messages not in DB           → Run php spark migrate
Messages disappear on reload → Wire frontend to API
```

---

## Emergency Restart Sequence

If everything is broken:

```powershell
# Terminal 1: Stop everything
Get-Process | ? { $_.ProcessName -like "*php*" } | Stop-Process -Force
Get-Process | ? { $_.ProcessName -like "*node*" } | Stop-Process -Force

# Terminal 2: Clear caches
rm "C:\laragon\www\hcis-app\writable\cache\*" -Force -Recurse
rm "C:\laragon\www\hcis-app\writable\debugbar\*" -Force -Recurse

# Terminal 3: Restart PHP
cd "C:\laragon\www\hcis-app"
php spark serve

# Terminal 4: Restart Socket
cd "C:\laragon\www\hcis-app\socket-server"
node server.js

# Terminal 5: Restart DB (if using Laragon)
# Use Laragon UI: Start > MySQL

# Browser: Open http://localhost:8080
```

---

**Troubleshooting Guide Version**: 1.0  
**Last Updated**: 2025-11-27
