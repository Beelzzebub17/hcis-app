const express = require('express');
const http = require('http');
const { Server } = require('socket.io');
const axios = require('axios');
const cors = require('cors');

const app = express();
app.use(cors());
app.use(express.json());
const server = http.createServer(app);
const io = new Server(server, { cors: { origin: '*' } });

const PORT = process.env.PORT || 3001;

io.on('connection', (socket) => {
  console.log('Socket connected:', socket.id);

  socket.on('join', (payload) => {
    // payload: { division, chatId }
    if(payload?.chatId) socket.join('chat:'+payload.chatId);
    if(payload?.division) socket.join('division:'+payload.division);
    console.log('join', payload);
  });

  socket.on('leave', (payload) => {
    if(payload?.chatId) socket.leave('chat:'+payload.chatId);
    if(payload?.division) socket.leave('division:'+payload.division);
  });

  socket.on('send_message', async (payload) => {
    // payload: { chatId, division, sender, text, attachments }
    console.log('send_message', payload);
    // Try to persist via Chat API if available (best-effort)
    try{
      // attempt POST to local PHP API
      await axios.post('http://localhost/api/messages', payload, { headers: { 'Content-Type': 'multipart/form-data' } });
    }catch(e){
      // ignore errors (API may be on different base path)
      // console.warn('api save failed', e.message);
    }

    // broadcast to room(s)
    if(payload.chatId) io.to('chat:'+payload.chatId).emit('new_message', payload);
    if(payload.division) io.to('division:'+payload.division).emit('new_message', payload);
    // also broadcast globally
    io.emit('new_message', payload);
  });

  socket.on('disconnect', () => console.log('Socket disconnected:', socket.id));
});

app.get('/', (req, res) => res.send('HCIS Chat Socket Server'));

server.listen(PORT, () => console.log('Socket server listening on', PORT));
