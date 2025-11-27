# SmartHCIS Chat — Deployment & Testing Checklist

## Pre-Deployment Checklist

### Environment Setup
- [ ] PHP 8.1+ installed and working (`php -v`)
- [ ] MySQL/MariaDB running and accessible
- [ ] Node.js 16+ installed (`node -v`)
- [ ] npm 7+ installed (`npm -v`)
- [ ] Git for version control (optional)

### Project Setup
- [ ] CodeIgniter 4.6.3+ installed and running
- [ ] `.env` file configured with database credentials
- [ ] `composer install` completed
- [ ] Base URL set correctly in `.env`
- [ ] Session storage configured (database or file)

### Socket.IO Server
- [ ] Node dependencies installed: `npm install` in `socket-server/`
- [ ] Node package.json has: express, socket.io, cors, axios
- [ ] Server listens on port 3001 (configurable)
- [ ] CORS enabled for frontend domain
- [ ] Environment variables for API URL set (if needed)

### File Permissions
- [ ] `/writable/` directory is writable by PHP
- [ ] `/writable/uploads/chat/` directory exists
- [ ] `/writable/logs/` has write permissions
- [ ] `/app/Database/Migrations/` is readable

### Database Setup
- [ ] MySQL database created and accessible
- [ ] `chats` table created (via migration)
- [ ] `messages` table created (via migration)
- [ ] Database user has SELECT, INSERT, UPDATE, DELETE permissions
- [ ] Foreign key constraints enabled (if using InnoDB)

### Frontend Assets
- [ ] Bootstrap 5.3.3 CDN link in `app/Views/All.php` is valid
- [ ] Bootstrap Icons CDN link is valid
- [ ] Chart.js CDN link is valid
- [ ] Socket.IO CDN link (v4.6.1) is valid
- [ ] No JavaScript console errors on page load

---

## Functionality Testing Checklist

### User Chat (Chatbot Page)
- [ ] **Division Selection**: Can select Finance, HCIS, LDD
- [ ] **Text Message**: Type and send message successfully
- [ ] **Message Display**: Message appears in chat history with timestamp
- [ ] **Notification**: Toast notification appears on new message
- [ ] **File Upload**: Can select and upload file with message
- [ ] **File Display**: Uploaded file appears as link/attachment in message
- [ ] **Chat Persistence**: Refresh page → messages still visible
- [ ] **Multiple Chats**: Create separate chats per division
- [ ] **Unread Count**: Unread messages tracked correctly
- [ ] **Rating UI**: After admin marks "solved", rating stars appear
- [ ] **Rating Submit**: Can click stars and submit rating
- [ ] **Keyboard Enter**: Can press Enter to send message

### Admin Chat (Admin Chat Page)
- [ ] **List Chats**: All divisions show chat lists
- [ ] **Unread Badge**: Shows count of unread messages
- [ ] **Last Message Preview**: Shows last message text
- [ ] **Chat Expansion**: Click to expand and see full history
- [ ] **Message History**: See all messages with sender labels
- [ ] **Timestamps**: Each message shows creation time
- [ ] **File Access**: Can download attached files
- [ ] **Reply Input**: Can type and send reply message
- [ ] **File Upload in Reply**: Can attach file to reply
- [ ] **Assign Button**: "Assign to me" marks chat as assigned
- [ ] **Status Change**: Can change status to open/pending/solved
- [ ] **Quick Replies**: Template dropdown works and populates text
- [ ] **Save Changes**: Changes persist on refresh
- [ ] **Real-time Updates**: See new user messages instantly (if socket connected)

### Socket.IO Real-Time
- [ ] **Connection**: Browser console shows "Connected to socket server"
- [ ] **Join Room**: Socket joins correct division room on chat open
- [ ] **Send Message**: Message appears instantly in connected browsers
- [ ] **Receive Broadcast**: Admin receives user message in real-time
- [ ] **Two-way**: User receives admin reply instantly
- [ ] **Multiple Rooms**: Can switch divisions and messages appear in correct room
- [ ] **Offline Fallback**: If socket disconnects, messages still send via localStorage
- [ ] **Reconnect**: If socket goes down then comes back up, new messages arrive

### REST API Endpoints
- [ ] **POST /api/chats**: Can create new chat
- [ ] **GET /api/chats**: Can list chats (filter by division optional)
- [ ] **POST /api/messages**: Can send message with text
- [ ] **POST /api/messages (multipart)**: Can upload file with message
- [ ] **GET /api/messages/{id}**: Can retrieve chat history
- [ ] **POST /api/chats/assign/{id}**: Can assign chat
- [ ] **POST /api/chats/status/{id}**: Can change status
- [ ] **POST /api/chats/read/{id}**: Can mark messages as read
- [ ] **API Errors**: 404 for missing chat, 400 for invalid data, 500 for errors

### File Uploads
- [ ] **File Save**: Uploaded files saved to `/writable/uploads/chat/`
- [ ] **File Permissions**: Files readable by web server
- [ ] **File Cleanup**: Old files can be deleted
- [ ] **Large Files**: Can upload reasonably large files (>10MB)
- [ ] **File Types**: Can upload images and documents
- [ ] **File Download**: Can download via file link
- [ ] **Base64 Demo**: localStorage stores file as base64 when socket unavailable

### Database Persistence
- [ ] **Create Chat**: Chat appears in database `chats` table
- [ ] **Save Message**: Message appears in database `messages` table
- [ ] **File Path**: File path stored in attachments JSON
- [ ] **Timestamps**: created_at and updated_at set correctly
- [ ] **Status Update**: Chat status updates in database
- [ ] **Assigned Admin**: Assigned name saves to database
- [ ] **Message Status**: Message status (sent/read) updates
- [ ] **Query Performance**: No slow queries (check logs)

### Offline Mode (localStorage Fallback)
- [ ] **Stop Socket Server**: Kill node process
- [ ] **Send Message**: Message still sends and stores locally
- [ ] **Bot Reply**: Automatic bot reply appears
- [ ] **Persistence**: Refresh page → messages visible
- [ ] **No Admin Sync**: Admin won't see messages (until socket online again)
- [ ] **Toast Message**: Shows "offline" or "bot replied" message
- [ ] **Resume Connection**: When socket comes back, new messages sync

### Security
- [ ] **Input Sanitization**: No XSS when sending `<script>` tags
- [ ] **SQL Injection**: API endpoints resistant to SQL injection
- [ ] **CSRF Protection**: Forms have CSRF tokens if needed
- [ ] **File Validation**: Only allowed file types can be uploaded
- [ ] **File Size Limit**: Large files rejected if over limit
- [ ] **CORS**: Socket server only accepts connections from allowed origins
- [ ] **Session Auth**: Only logged-in users can access chat
- [ ] **Rate Limiting**: Repeated requests don't crash server

### UI/UX
- [ ] **Responsive Design**: Works on desktop, tablet, mobile
- [ ] **Dark Mode**: (Optional) UI readable in dark theme
- [ ] **Accessibility**: Can use keyboard to navigate (Tab, Enter)
- [ ] **Notifications**: Toast messages clear after timeout
- [ ] **Loading States**: Spinners show during async operations
- [ ] **Error Messages**: Clear error messages for failures
- [ ] **Empty States**: "No messages" shown when appropriate
- [ ] **Scrolling**: Chat scrolls to bottom on new message

### Performance
- [ ] **Page Load**: All.php loads in <2 seconds
- [ ] **Message Send**: Message sends and appears in <500ms
- [ ] **File Upload**: Large file uploads show progress
- [ ] **Memory**: No memory leaks (browser dev tools)
- [ ] **CPU**: Socket server CPU usage low (<50%) at idle
- [ ] **Database**: Query times < 100ms for typical queries
- [ ] **Network**: WebSocket connection stable, no constant re-connects

---

## Deployment Checklist

### Pre-Deployment
- [ ] Code review completed
- [ ] All tests passing (if test suite exists)
- [ ] No sensitive data in `.env` or config files
- [ ] Database backups created
- [ ] Rollback plan documented

### Server Setup (Staging/Production)
- [ ] Web server (Apache/Nginx) configured and running
- [ ] PHP-FPM or Apache mod_php configured
- [ ] Node.js and npm installed on separate server (if socket server separate)
- [ ] MySQL/MariaDB installed and running
- [ ] SSL/TLS certificates installed
- [ ] Firewall rules allow ports 80, 443, 3001 (internal only for socket)
- [ ] Load balancer configured (if multiple servers)

### Application Deployment
- [ ] Pull code from git repository
- [ ] Run `composer install` (production flags)
- [ ] Run `npm install` in socket-server/ (production flags)
- [ ] Copy `.env.example` to `.env` and update values
- [ ] Run database migrations: `php spark migrate`
- [ ] Create required directories with proper permissions
- [ ] Set up cron job for log rotation (if needed)
- [ ] Test all endpoints work on production

### Monitoring Setup
- [ ] Error logging enabled and monitored
- [ ] Performance metrics tracked (response time, error rate)
- [ ] Uptime monitoring configured
- [ ] Alert notifications set up for critical errors
- [ ] Socket server status monitored (restart on crash)
- [ ] Database backup schedule configured
- [ ] Disk space monitoring active

### Post-Deployment Validation
- [ ] Access application on production domain
- [ ] Test user chat flow end-to-end
- [ ] Test admin chat flow end-to-end
- [ ] Verify WebSocket connection works
- [ ] Confirm database tables populated
- [ ] Check file uploads save correctly
- [ ] Review error logs for issues
- [ ] Performance metrics within acceptable range

---

## Rollback Procedure

If deployment fails or major issues occur:

```bash
# 1. Stop services
kill $(lsof -t -i :3001)           # Socket server
systemctl stop php-fpm             # PHP

# 2. Restore previous code version
git checkout <previous_commit_hash>

# 3. Rollback database
php spark migrate:rollback         # Undo last migration(s)

# 4. Restart services
npm start &                         # Socket server
systemctl start php-fpm             # PHP

# 5. Verify
curl https://yourapp.com/api/chats
# Should show chats (or error, but page accessible)
```

---

## Monitoring Commands (Post-Deployment)

```bash
# Check if PHP server is running
curl http://yourapp.com/

# Check if Socket.IO server is running
lsof -i :3001
# OR
netstat -tulpn | grep 3001

# View Socket.IO server logs
tail -f /var/log/socket-server.log

# View PHP error logs
tail -f /var/log/php-fpm.log

# Check database connections
mysql -u root -p
SHOW PROCESSLIST;

# Monitor CPU/Memory usage
top              # Linux/Mac
Get-Process      # PowerShell (Windows)

# Check disk space
df -h            # Linux/Mac
Get-PSDrive      # PowerShell (Windows)
```

---

## Performance Benchmarks (Targets)

| Metric | Target | Acceptable |
|--------|--------|-----------|
| Page Load Time | <1s | <2s |
| Message Send | <500ms | <1s |
| File Upload (10MB) | <5s | <10s |
| Socket Connection | <100ms | <500ms |
| Database Query | <100ms | <500ms |
| API Response | <200ms | <1s |
| Memory (server) | <500MB | <1GB |
| CPU (idle) | <5% | <20% |
| Disk Space Free | >10GB | >5GB |
| Max Concurrent Users | 100+ | 50+ |

---

## Sign-Off

- [ ] All checklist items reviewed
- [ ] No blockers identified
- [ ] Deployment approved by team lead
- [ ] Date: ________________
- [ ] Deployed by: ________________
- [ ] Verified by: ________________

---

**Checklist Version**: 1.0  
**Last Updated**: 2025-11-27  
**For**: SmartHCIS Chat System v1.0.0 (Beta)
