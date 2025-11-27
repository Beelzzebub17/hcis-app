# SmartHCIS Chat — API Testing Guide

## Quick Test Scenarios

Run these in PowerShell or Postman to verify API functionality.

### 1. Create a Chat Session
```powershell
# POST /api/chats
$body = @{
    division = 'Finance'
    user_name = 'TestUser123'
} | ConvertTo-Json

Invoke-WebRequest -Uri 'http://localhost:8080/api/chats' `
    -Method Post `
    -Body $body `
    -ContentType 'application/json' | Select-Object -ExpandProperty Content
```

**Expected Response:**
```json
{
    "status": "success",
    "chat_id": 1,
    "division": "Finance",
    "user_name": "TestUser123",
    "created_at": "2025-11-27 10:30:00"
}
```

### 2. Send a Message (No File)
```powershell
# POST /api/messages
$body = @{
    chat_id = 1
    sender = 'user'
    text = 'Hello from API test'
} | ConvertTo-Json

Invoke-WebRequest -Uri 'http://localhost:8080/api/messages' `
    -Method Post `
    -Body $body `
    -ContentType 'application/json' | Select-Object -ExpandProperty Content
```

**Expected Response:**
```json
{
    "status": "success",
    "message_id": 1,
    "chat_id": 1,
    "sender": "user",
    "text": "Hello from API test",
    "created_at": "2025-11-27 10:31:00"
}
```

### 3. Send Message with File Upload (Multipart)
```powershell
# POST /api/messages with file
# Create a test file
'Test file content' | Out-File -FilePath 'C:\temp\test.txt' -Encoding UTF8

$fileBytes = [System.IO.File]::ReadAllBytes('C:\temp\test.txt')
$boundary = [System.Guid]::NewGuid().ToString()
$LF = "`r`n"

$body = (
    "--$boundary$LF" +
    "Content-Disposition: form-data; name=`"chat_id`"$LF$LF" +
    "1$LF" +
    "--$boundary$LF" +
    "Content-Disposition: form-data; name=`"sender`"$LF$LF" +
    "user$LF" +
    "--$boundary$LF" +
    "Content-Disposition: form-data; name=`"text`"$LF$LF" +
    "Uploaded test file$LF" +
    "--$boundary$LF" +
    "Content-Disposition: form-data; name=`"file`"; filename=`"test.txt`"$LF" +
    "Content-Type: text/plain$LF$LF"
) + [System.Text.Encoding]::UTF8.GetString($fileBytes) + "$LF--$boundary--"

Invoke-WebRequest -Uri 'http://localhost:8080/api/messages' `
    -Method Post `
    -Body $body `
    -ContentType "multipart/form-data; boundary=$boundary" | Select-Object -ExpandProperty Content
```

**Expected Response:**
```json
{
    "status": "success",
    "message_id": 2,
    "file_path": "/writable/uploads/chat/abc123def.txt"
}
```

### 4. Get Messages for Chat
```powershell
# GET /api/messages/1
Invoke-WebRequest -Uri 'http://localhost:8080/api/messages/1' `
    -Method Get | Select-Object -ExpandProperty Content
```

**Expected Response:**
```json
{
    "status": "success",
    "chat_id": 1,
    "messages": [
        {
            "id": 1,
            "chat_id": 1,
            "sender": "user",
            "text": "Hello from API test",
            "attachments": null,
            "status": "sent",
            "created_at": "2025-11-27 10:31:00"
        }
    ]
}
```

### 5. List Chats
```powershell
# GET /api/chats?division=Finance
Invoke-WebRequest -Uri 'http://localhost:8080/api/chats?division=Finance' `
    -Method Get | Select-Object -ExpandProperty Content
```

**Expected Response:**
```json
{
    "status": "success",
    "chats": [
        {
            "id": 1,
            "division": "Finance",
            "user_name": "TestUser123",
            "status": "open",
            "assigned": null,
            "unread_count": 1,
            "last_message": "Hello from API test",
            "created_at": "2025-11-27 10:30:00"
        }
    ]
}
```

### 6. Assign Chat to Admin
```powershell
# POST /api/chats/assign/1
$body = @{
    assigned = 'Admin Demo'
} | ConvertTo-Json

Invoke-WebRequest -Uri 'http://localhost:8080/api/chats/assign/1' `
    -Method Post `
    -Body $body `
    -ContentType 'application/json' | Select-Object -ExpandProperty Content
```

**Expected Response:**
```json
{
    "status": "success",
    "message": "Chat assigned to Admin Demo"
}
```

### 7. Set Chat Status
```powershell
# POST /api/chats/status/1
$body = @{
    status = 'solved'
} | ConvertTo-Json

Invoke-WebRequest -Uri 'http://localhost:8080/api/chats/status/1' `
    -Method Post `
    -Body $body `
    -ContentType 'application/json' | Select-Object -ExpandProperty Content
```

**Expected Response:**
```json
{
    "status": "success",
    "message": "Chat status updated to solved"
}
```

### 8. Mark Messages as Read
```powershell
# POST /api/chats/read/1
Invoke-WebRequest -Uri 'http://localhost:8080/api/chats/read/1' `
    -Method Post | Select-Object -ExpandProperty Content
```

**Expected Response:**
```json
{
    "status": "success",
    "message": "Messages marked as read"
}
```

---

## Testing Workflow (Step-by-Step)

1. **Create Chat**: Run test #1, copy the `chat_id`
2. **Send Messages**: Use `chat_id` from step 1 in tests #2 and #3
3. **Verify**: Run test #5 to see your chat in the list
4. **Assign & Status**: Run tests #6 and #7
5. **Check Messages**: Run test #4 to see all messages with status

## Postman Import (Alternative)

If you prefer Postman, create a new collection:

**Collection Name**: SmartHCIS Chat API

**Requests**:
1. POST `{{baseUrl}}/api/chats`
2. POST `{{baseUrl}}/api/messages`
3. GET `{{baseUrl}}/api/messages/:id`
4. GET `{{baseUrl}}/api/chats`
5. POST `{{baseUrl}}/api/chats/assign/:id`
6. POST `{{baseUrl}}/api/chats/status/:id`
7. POST `{{baseUrl}}/api/chats/read/:id`

**Variables**:
- `baseUrl`: `http://localhost:8080`

---

## Common Issues & Fixes

| Issue | Cause | Fix |
|-------|-------|-----|
| 404 Not Found | Routes not registered | Check `app/Config/Routes.php` |
| 500 Server Error | DB not migrated | Run `php spark migrate` |
| File not saving | No write permission | `chmod 755 writable/` (Linux/Mac) |
| Connection refused | PHP server down | Run `php spark serve` |

