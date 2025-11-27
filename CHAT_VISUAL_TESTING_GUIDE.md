# SmartHCIS Chat — Visual Testing & Demo Guide

**Purpose**: Step-by-step visual walkthrough of all features  
**Time Required**: 10 minutes  
**Prerequisites**: PHP server + Socket.IO server both running

---

## 🎬 Demo Walkthrough

### Setup (Prerequisites)

```
Terminal 1: PHP Dev Server Running?
  ┌─────────────────────────────┐
  │ PS> cd C:\laragon\www\hcis-app
  │ PS> php spark serve
  │ → CodeIgniter development server started...
  │ → Listening on http://localhost:8080
  └─ ✅ Ready
  
Terminal 2: Socket.IO Server Running?
  ┌─────────────────────────────┐
  │ PS> cd C:\laragon\www\hcis-app\socket-server
  │ PS> node server.js
  │ → Socket server listening on 3001
  │ → (Should see "Socket connected: <id>" after browser loads)
  └─ ✅ Ready
```

**If either is NOT running, start it now!**

---

## 🧪 Test 1: Open Application & Login

### Step 1A: Browser
```
┌─────────────────────────────────────────────────────┐
│  Open: http://localhost:8080                        │
│        (or http://127.0.0.1:8080)                   │
│                                                     │
│  ✓ Page should load within 2 seconds                │
│  ✓ Should see login form                            │
│  ✓ No red errors in console (F12)                   │
└─────────────────────────────────────────────────────┘
```

### Step 1B: Login
```
┌─────────────────────────────────────────────────────┐
│ Username: admin                                     │
│ Password: 12345                                     │
│ Click: Login                                        │
│                                                     │
│ ✓ Should redirect to dashboard                      │
│ ✓ Should see "Dashboard" or main menu               │
│ ✓ Sidebar menu visible                              │
└─────────────────────────────────────────────────────┘
```

### Step 1C: Verify Socket Connected
```
┌─────────────────────────────────────────────────────┐
│ Browser Top-Right: Should show green toast:         │
│                                                     │
│ ┌─────────────────────────────────────┐             │
│ │ ✓ Realtime                          │             │
│ │ Connected to socket server          │             │
│ │ ✓ (dismiss in 1.2 seconds)          │             │
│ └─────────────────────────────────────┘             │
│                                                     │
│ OR if Socket server NOT running:                   │
│                                                     │
│ ┌─────────────────────────────────────┐             │
│ │ ⚠ Socket                            │             │
│ │ Not available (using demo mode)     │             │
│ └─────────────────────────────────────┘             │
│                                                     │
│ ✓ Either is OK (socket is optional)                │
└─────────────────────────────────────────────────────┘
```

---

## 🧪 Test 2: User Chat Feature

### Step 2A: Navigate to Chatbot
```
┌─────────────────────────────────────────────────────┐
│ Left Sidebar Menu:                                  │
│ ┌──────────────────────────────────────────────┐   │
│ │ ☰ Menu                                       │   │
│ ├──────────────────────────────────────────────┤   │
│ │ • Dashboard          📊                      │   │
│ │ • Chatbot            💬  ← CLICK HERE        │   │
│ │ • Admin Chat         ⚙️                       │   │
│ │ • Performance        📈                      │   │
│ │ • Training           🎓                      │   │
│ │ • Logout             🚪                      │   │
│ └──────────────────────────────────────────────┘   │
│                                                     │
│ ✓ Should navigate to chat page                      │
└─────────────────────────────────────────────────────┘
```

### Step 2B: Chatbot Page Layout
```
┌──────────────────────────────────────────────────────────┐
│ CHATBOT PAGE                                             │
├──────────────────────────────────────────────────────────┤
│                                                          │
│  Left Sidebar           │  Main Chat Area                │
│  ───────────────────────┼────────────────────────────    │
│  Chat List:             │  ┌─────────────────────────┐  │
│  • Finance              │  │ Select Division:        │  │
│  • HCIS                 │  │ [Finance ▼]             │  │
│  • LDD                  │  │ (Unread: 0)             │  │
│                         │  └─────────────────────────┘  │
│                         │                                │
│                         │  ┌─────────────────────────┐  │
│                         │  │ [Chat messages area]    │  │
│                         │  │ (empty first time)      │  │
│                         │  └─────────────────────────┘  │
│                         │                                │
│                         │  ┌─────────────────────────┐  │
│                         │  │ [📎] Type message...    │  │
│                         │  │ [           Kirim  ]    │  │
│                         │  └─────────────────────────┘  │
│                         │                                │
└──────────────────────────────────────────────────────────┘
```

### Step 2C: Send First Message
```
┌──────────────────────────────────────────────────┐
│ 1. Verify "Finance" is selected in dropdown      │
│    [Finance ▼]  ← Should say "Finance"           │
│                                                  │
│ 2. Click in message input box                    │
│    [📎] [Type message...]                        │
│         ↑ Click here                             │
│                                                  │
│ 3. Type message:                                 │
│    "Hello, I need help with my PO"               │
│                                                  │
│ 4. Press ENTER or click [Kirim]                  │
│                                                  │
│ ✓ Expected Result:                               │
│   • Message appears in chat (blue bubble, right) │
│   • Message shows timestamp                      │
│   • Message shows "sent" status                  │
│   • Input box clears                             │
│   • After ~1 second, bot replies (if socket off) │
└──────────────────────────────────────────────────┘
```

### Step 2D: Chat History View
```
┌─────────────────────────────────────────────────┐
│ EXPECTED CHAT VIEW:                             │
│                                                 │
│ ┌───────────────────────────────────────────┐  │
│ │ [Chat messages area]                      │  │
│ │                                           │  │
│ │ 10:30 AM                                  │  │
│ │            You: Hello, I need help        │  │
│ │            with my PO               ✓    │  │
│ │                                           │  │
│ │ 10:31 AM                                  │  │
│ │ System: Thank you for your message...     │  │
│ │         Our team will respond shortly.    │  │
│ │                                           │  │
│ │                                           │  │
│ │ [📎 icon] [Input field...         Kirim] │  │
│ └───────────────────────────────────────────┘  │
│                                                 │
│ ✓ Message displays correctly                    │
│ ✓ Bot replied automatically                     │
│ ✓ Timestamp visible                             │
│ ✓ Status "✓" shown (message sent)               │
└─────────────────────────────────────────────────┘
```

### Step 2E: Test File Upload
```
┌──────────────────────────────────────────────────┐
│ 1. Click 📎 (paperclip) icon                     │
│    [📎] [Type message...]   ← Click 📎           │
│                                                  │
│ 2. File dialog opens                             │
│    Choose any file:                              │
│    • C:\laragon\www\hcis-app\README.md           │
│    • Or your own document/image                  │
│                                                  │
│ 3. Type optional message:                        │
│    "Please review this document"                 │
│                                                  │
│ 4. Click [Kirim]                                 │
│                                                  │
│ ✓ Expected: Message + file link appears         │
│   10:32 AM                                       │
│            You: Please review this document      │
│            📄 README.md (5 KB)          ✓        │
│                                                  │
│ ✓ File name is clickable                         │
│ ✓ File size shown                                │
└──────────────────────────────────────────────────┘
```

### Step 2F: Test Rating (After Admin Marks Solved)
```
┌──────────────────────────────────────────────────┐
│ (This appears after admin marks chat "solved")   │
│                                                  │
│ ┌────────────────────────────────────────────┐  │
│ │ Chat marked as SOLVED                      │  │
│ │                                            │  │
│ │ How would you rate this conversation?      │  │
│ │                                            │  │
│ │ ★ ☆ ☆ ☆ ☆  1 star                         │  │
│ │ ★ ★ ☆ ☆ ☆  2 stars                        │  │
│ │ ★ ★ ★ ☆ ☆  3 stars                        │  │
│ │ ★ ★ ★ ★ ☆  4 stars                        │  │
│ │ ★ ★ ★ ★ ★  5 stars  ← Click here          │  │
│ │                                            │  │
│ │ [Thank you for your feedback!]             │  │
│ └────────────────────────────────────────────┘  │
│                                                  │
│ ✓ Click any star to submit rating               │
│ ✓ Toast appears: "Rating submitted"             │
│ ✓ Rating persists on page reload                │
└──────────────────────────────────────────────────┘
```

---

## 🧪 Test 3: Admin Chat Feature

### Step 3A: Navigate to Admin Chat
```
┌──────────────────────────────────────────────────┐
│ Click Menu → Admin Chat:                         │
│                                                  │
│ Left Sidebar:                                    │
│ • Dashboard                                      │
│ • Chatbot                                        │
│ • Admin Chat        ⚙️ ← CLICK HERE              │
│ • Performance                                    │
│                                                  │
│ ✓ Should navigate to admin chat page             │
└──────────────────────────────────────────────────┘
```

### Step 3B: Admin Chat Layout
```
┌────────────────────────────────────────────────────────┐
│ ADMIN CHAT PAGE                                        │
├────────────────────────────────────────────────────────┤
│                                                        │
│  Division Tabs    │  Chat List           │  Details   │
│  ───────────────  ├──────────────────────┼────────    │
│  [Finance] HCIS   │  User1: Hello...     │            │
│  LDD              │  [1] unread          │ ┌────────┐ │
│                   │                      │ │Message │ │
│                   │  User2: Help needed  │ │List    │ │
│                   │  [0] unread          │ │(expand)│ │
│                   │                      │ └────────┘ │
│                   │  User3: PO Request   │            │
│                   │  [2] unread          │ ┌────────┐ │
│                   │                      │ │Reply   │ │
│                   │                      │ │Input   │ │
│                   │                      │ └────────┘ │
│                   │                      │            │
└────────────────────────────────────────────────────────┘

Labels:
✓ [1] = unread message count badge
✓ Can switch division tabs (Finance/HCIS/LDD)
✓ List shows all chats with last message preview
✓ Click chat to expand details
```

### Step 3C: View Chat Messages
```
┌──────────────────────────────────────────────────┐
│ 1. Click on a chat in the list:                  │
│                                                  │
│    User1: Hello, I need help...   [1]            │
│    ↑ Click here                                  │
│                                                  │
│ 2. Chat expands to show:                         │
│    ┌─────────────────────────────────────────┐  │
│    │ User1 (Finance)     Status: [open ▼]    │  │
│    │ Assigned: [Assign to me]                │  │
│    │                                         │  │
│    │ 10:30 AM                                │  │
│    │ User: Hello, I need help                │  │
│    │       with my PO                    ✓   │  │
│    │                                         │  │
│    │ 10:31 AM                                │  │
│    │ System: Thank you for your message...   │  │
│    │                                         │  │
│    │ ┌─────────────────────────────────────┐│  │
│    │ │ [📎] Reply here...       [Kirim]    ││  │
│    │ └─────────────────────────────────────┘│  │
│    │                                         │  │
│    │ Quick reply: [Select template... ▼]    │  │
│    │              [Use]                     │  │
│    │                                         │  │
│    │ [Save Changes]                          │  │
│    └─────────────────────────────────────────┘  │
│                                                  │
│ ✓ Full chat history visible                     │
│ ✓ Can see each message separately                │
│ ✓ Status/Assign buttons available                │
│ ✓ Reply input shows                              │
└──────────────────────────────────────────────────┘
```

### Step 3D: Assign Chat to Admin
```
┌──────────────────────────────────────────────────┐
│ 1. Click [Assign to me] button:                  │
│                                                  │
│    Assigned: [Assign to me]  ← Click             │
│                                                  │
│ 2. Button changes to:                            │
│    Assigned: ✓ Admin Demo  [Unassign]            │
│                                                  │
│ 3. Click [Save Changes]:                         │
│    [Save Changes]  ← Click                       │
│                                                  │
│ ✓ Toast appears: "Changes saved successfully"   │
│ ✓ Status persists on reload                      │
│ ✓ Other admins see assignment update             │
└──────────────────────────────────────────────────┘
```

### Step 3E: Change Chat Status
```
┌──────────────────────────────────────────────────┐
│ 1. Click Status dropdown:                        │
│                                                  │
│    Status: [open ▼]  ← Click dropdown            │
│                                                  │
│ 2. Options appear:                               │
│    □ open                                        │
│    □ pending                                     │
│    □ solved          ← Select this               │
│                                                  │
│ 3. Click [Save Changes]:                         │
│                                                  │
│ ✓ Toast: "Status updated to solved"              │
│ ✓ User sees rating UI in their chat              │
│ ✓ Status reflects in chat list [solved badge]    │
└──────────────────────────────────────────────────┘
```

### Step 3F: Send Admin Reply
```
┌──────────────────────────────────────────────────┐
│ 1. Click reply input:                            │
│    [📎] [Reply here...]          [Kirim]         │
│         ↑ Click                                  │
│                                                  │
│ 2. Type reply:                                   │
│    "Thank you for your request. Your PO is      │
│    approved and will be processed shortly."      │
│                                                  │
│ 3. (Optional) Upload file:                       │
│    Click 📎, select file                         │
│                                                  │
│ 4. Click [Kirim]:                                │
│                                                  │
│ ✓ Reply appears in chat:                         │
│   10:33 AM                                       │
│   Admin: Thank you for your request...       ✓   │
│                                                  │
│ ✓ (If socket connected) User sees reply         │
│   immediately in their Chatbot                   │
│                                                  │
│ ✓ (If socket NOT connected) User sees it        │
│   when they refresh or when socket reconnects   │
└──────────────────────────────────────────────────┘
```

### Step 3G: Use Quick Reply
```
┌──────────────────────────────────────────────────┐
│ 1. Click Quick reply dropdown:                   │
│                                                  │
│    Quick reply: [Select template... ▼]           │
│                 ↑ Click                          │
│                                                  │
│ 2. Options appear:                               │
│    □ "Thank you. We will review your request"    │
│    □ "Your request is being processed"           │
│    □ "Please provide more information"           │
│                                                  │
│ 3. Click [Use] next to a template:               │
│                                                  │
│ ✓ Template text appears in reply input:          │
│   [📎] [Thank you. We will review...]  [Kirim]   │
│                                                  │
│ 4. Can edit if needed, then [Kirim]              │
│                                                  │
│ ✓ Saves time for common responses                │
└──────────────────────────────────────────────────┘
```

---

## 🧪 Test 4: Real-Time Features

### Test 4A: Real-Time Messaging (Two Tabs)

```
TAB A: User Browser              TAB B: Admin Browser
───────────────────────────────────────────────────────────
                                                          
Open http://localhost:8080      Open http://localhost:8080
Login: admin / 12345            Login: admin / 12345
                                                          
Go to: Chatbot → Finance        Go to: Admin Chat → Finance
                                                          
(Ready to send)                 (Ready to receive)         
                                                          
───────────────────────────────────────────────────────────

Step 1: User sends message
├─ Type: "Can you help with this?"
├─ Click: [Kirim]
└─ Message appears in Tab A (blue bubble)

Step 2: Admin receives instantly (if socket connected)
├─ Tab B: Message appears in chat list
├─ Tab B: Unread count [1]
├─ Toast: "New message from User"
└─ ✓ Appeared within 500ms (real-time!)

Step 3: Admin sends reply
├─ Tab B: Type: "Of course, what do you need?"
├─ Tab B: Click: [Kirim]
└─ Reply appears in Tab B chat

Step 4: User receives instantly (if socket connected)
├─ Tab A: Admin reply appears (gray bubble)
├─ Toast: "Admin replied"
└─ ✓ Appeared within 500ms (real-time!)

SUCCESS CRITERIA:
✓ Messages appear instantly (not on refresh)
✓ No lag or delay
✓ Both tabs stay in sync
✓ Toast notifications appear
```

### Test 4B: Offline Fallback (No Real-Time)

```
Step 1: Stop Socket Server
├─ Terminal 2: Press Ctrl+C
├─ Wait 5 seconds
└─ Socket should disconnect

Step 2: User sends message (without socket)
├─ Tab A: Type message
├─ Tab A: Click [Kirim]
└─ Expected:
   • Message appears locally
   • Toast: "Socket not available (using demo mode)"
   • Bot replies after ~1 second

Step 3: Refresh page
├─ Tab A: Press F5 to reload
└─ Expected:
   • Chat history still visible (from localStorage)
   • Messages didn't disappear
   • ✓ Data persists locally

Step 4: Admin doesn't see message (expected)
├─ Tab B: Still shows no new message
├─ NOT connected to user's local storage
└─ ✓ This is expected behavior (DB not wired yet)

Step 5: Restart Socket Server
├─ Terminal 2: node server.js
├─ Wait 5 seconds
└─ Tab A should show: "Realtime connected" toast

SUCCESS CRITERIA:
✓ Works without socket server (fallback mode)
✓ Messages persist on page reload
✓ Bot auto-replies
✓ When socket back, new messages are real-time
```

---

## 🧪 Test 5: API Endpoints (PowerShell)

### Test 5A: Create Chat
```powershell
# Copy-paste this into PowerShell:

$body = @{
    division = 'Finance'
    user_name = 'Test User 123'
} | ConvertTo-Json

$response = Invoke-WebRequest -Uri 'http://localhost:8080/api/chats' `
    -Method Post `
    -Body $body `
    -ContentType 'application/json'

$response.Content | ConvertFrom-Json | ConvertTo-Json

# Expected output:
# {
#   "status": "success",
#   "chat_id": 1,
#   "division": "Finance",
#   "user_name": "Test User 123",
#   "created_at": "2025-11-27 ..."
# }

✓ Test PASSED if chat_id returned (e.g., 1, 2, 3...)
```

### Test 5B: Send Message
```powershell
# Replace chat_id (from Test 5A) with actual value:

$body = @{
    chat_id = 1
    sender = 'user'
    text = 'Hello from API'
} | ConvertTo-Json

$response = Invoke-WebRequest -Uri 'http://localhost:8080/api/messages' `
    -Method Post `
    -Body $body `
    -ContentType 'application/json'

$response.Content | ConvertFrom-Json | ConvertTo-Json

# Expected:
# {
#   "status": "success",
#   "message_id": 1,
#   "chat_id": 1,
#   "sender": "user",
#   "text": "Hello from API",
#   "created_at": "..."
# }

✓ Test PASSED if message_id returned
```

### Test 5C: List Chats
```powershell
# List all Finance chats:

$response = Invoke-WebRequest -Uri 'http://localhost:8080/api/chats?division=Finance' `
    -Method Get

$response.Content | ConvertFrom-Json | ConvertTo-Json

# Expected:
# {
#   "status": "success",
#   "chats": [
#     {
#       "id": 1,
#       "division": "Finance",
#       "user_name": "Test User 123",
#       "status": "open",
#       ...
#     }
#   ]
# }

✓ Test PASSED if chats array contains your created chat
```

---

## 📊 Test Results Summary

### Checklist Template

```
FUNCTIONALITY TEST RESULTS
═══════════════════════════════════════════════

Date: ________
Tester: ________
Environment: localhost:8080

USER CHAT TESTS
─────────────────────────────────────────────
□ ✓ Can login successfully
□ ✓ Can select division (Finance/HCIS/LDD)
□ ✓ Can send text message
□ ✓ Message appears in chat with timestamp
□ ✓ Can upload file with message
□ ✓ File appears as downloadable link
□ ✓ Chat persists on page reload
□ ✓ Can switch divisions without losing history
□ ✓ Unread count displays and updates
□ ✓ Notification toast appears on new message
□ ✓ Can rate closed chat (1-5 stars)

ADMIN CHAT TESTS
─────────────────────────────────────────────
□ ✓ Can view all chats per division
□ ✓ Unread badge shows count
□ ✓ Can click to expand chat
□ ✓ Can see full message history
□ ✓ Can assign chat to self
□ ✓ Can change status (open/pending/solved)
□ ✓ Can send reply message
□ ✓ Can upload file with reply
□ ✓ Can use quick reply templates
□ ✓ Changes persist on reload
□ ✓ Can download attached files

REAL-TIME TESTS
─────────────────────────────────────────────
□ ✓ Socket connects on page load (green toast)
□ ✓ Messages appear instantly (2-tab test)
□ ✓ Admin sees user message in <500ms
□ ✓ User sees admin reply in <500ms
□ ✓ Works in fallback mode (no socket)
□ ✓ Messages persist in localStorage (offline)
□ ✓ Bot replies automatically (no socket)

API TESTS
─────────────────────────────────────────────
□ ✓ POST /api/chats creates chat
□ ✓ GET /api/chats lists chats
□ ✓ POST /api/messages sends message
□ ✓ GET /api/messages/{id} retrieves history
□ ✓ POST /api/chats/assign/{id} assigns
□ ✓ POST /api/chats/status/{id} changes status
□ ✓ POST /api/chats/read/{id} marks read

FILE UPLOAD TESTS
─────────────────────────────────────────────
□ ✓ Can select file via dialog
□ ✓ File uploads without error
□ ✓ File appears in message
□ ✓ Can download file from link
□ ✓ Large files (>10MB) handled
□ ✓ Multiple file types supported (images, docs)

PERFORMANCE TESTS
─────────────────────────────────────────────
□ ✓ Page loads in <2 seconds
□ ✓ Message sends in <500ms
□ ✓ File upload shows progress
□ ✓ No console errors (F12)
□ ✓ No memory leaks (dev tools)

ISSUES FOUND
─────────────────────────────────────────────
1. _________________________________
   Severity: [ ] Critical [ ] High [ ] Medium [ ] Low
   Steps: _________________________
   
2. _________________________________
   Severity: [ ] Critical [ ] High [ ] Medium [ ] Low
   Steps: _________________________

SIGN-OFF
─────────────────────────────────────────────
Overall Status: [ ] ✓ PASS [ ] FAIL [ ] NEEDS FIXES

Tested By: ________________
Date: ________________
Notes: _________________________________
```

---

## 🏁 Next Steps After Testing

✅ **All tests PASSED?**
- System is ready for development/production
- Proceed to `CHAT_SETUP.md` → Roadmap section
- Next: Wire frontend to API for DB persistence

⚠️ **Some tests FAILED?**
- Check `CHAT_TROUBLESHOOTING.md` for your issue
- Most common: Socket not connecting, API 404
- See troubleshooting flowchart

🚀 **Ready for Production?**
- Review `CHAT_DEPLOYMENT_CHECKLIST.md`
- Run all checklist items
- Get team sign-off
- Deploy to staging first

---

**Testing Guide Version**: 1.0  
**Last Updated**: 2025-11-27  
**Created for**: SmartHCIS Chat System v1.0.0 (Beta)
