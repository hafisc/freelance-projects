const express = require('express');
const http = require('http');
const socketIo = require('socket.io');
const mongoose = require('mongoose');
const cors = require('cors');
const jwt = require('jsonwebtoken');
const Message = require('./models/Message');

const app = express();
const server = http.createServer(app);
const PORT = process.env.PORT || 3000;
const MONGO_URI = process.env.MONGO_URI || 'mongodb://db-trip:27017/tripdb';
const JWT_SECRET = process.env.JWT_SECRET || 'afl3_secret_key_123';

// Enable CORS & JSON Parsing
app.use(cors());
app.use(express.json());

// Hubungkan ke Database MongoDB (berbagi cluster dengan Trip DB)
mongoose.connect(MONGO_URI)
  .then(() => console.log('Terhubung ke database MongoDB (Chat)'))
  .catch((err) => console.error('Gagal terhubung ke MongoDB (Chat):', err));

// Configure Socket.io with CORS
const io = socketIo(server, {
  cors: {
    origin: "*",
    methods: ["GET", "POST"]
  }
});

// ==========================================
// ENDPOINT: Health Check & History Chat
// ==========================================
app.get('/api/chat/health', (req, res) => {
  res.status(200).json({ status: 'OK', service: 'Chat Service' });
});

// Mengambil riwayat chat berdasarkan ID Trip
app.get('/api/chat/history/:tripId', async (req, res) => {
  try {
    const { tripId } = req.params;
    const messages = await Message.find({ tripId }).sort({ createdAt: 1 });
    res.status(200).json({ messages });
  } catch (error) {
    console.error('Error saat mengambil riwayat chat:', error);
    res.status(500).json({ message: 'Gagal mengambil riwayat chat' });
  }
});

// ==========================================
// MIDDLEWARE: Autentikasi JWT Socket.io
// ==========================================
io.use((socket, next) => {
  const token = socket.handshake.auth.token || socket.handshake.query.token;

  if (!token) {
    return next(new Error('Akses ditolak. Token tidak disediakan.'));
  }

  try {
    // Verifikasi JWT token
    const decoded = jwt.verify(token, JWT_SECRET);
    socket.user = decoded; // Tempel data user terverifikasi ke socket
    next();
  } catch (err) {
    return next(new Error('Token tidak valid'));
  }
});

// ==========================================
// SOCKET.IO: Real-Time Event Handlers
// ==========================================
io.on('connection', (socket) => {
  console.log(`User terhubung ke WebSocket: ${socket.user.name} (${socket.user.role})`);

  // Event: Masuk ke room perjalanan tertentu
  socket.on('join_trip', (data) => {
    const { tripId } = data;
    socket.join(tripId);
    console.log(`User ${socket.user.name} bergabung ke room trip: ${tripId}`);
  });

  // Event: Kirim pesan chat
  socket.on('send_message', async (data) => {
    try {
      const { tripId, message } = data;

      if (!tripId || !message) return;

      // Simpan pesan ke database
      const newMessage = new Message({
        tripId,
        senderId: socket.user.id,
        senderName: socket.user.name,
        message
      });
      await newMessage.save();

      // Broadcast pesan ke seluruh anggota room trip tersebut
      io.to(tripId).emit('receive_message', {
        tripId,
        senderId: socket.user.id,
        senderName: socket.user.name,
        message,
        createdAt: newMessage.createdAt
      });
    } catch (error) {
      console.error('Gagal mengirim/menyimpan pesan:', error);
    }
  });

  // Event: Update status trip (untuk disinkronisasi ke penumpang secara real-time)
  socket.on('update_trip_status', (data) => {
    const { tripId, status, trip } = data;
    // Broadcast status baru ke room trip tersebut
    io.to(tripId).emit('trip_status_changed', { tripId, status, trip });
    console.log(`Trip ${tripId} diperbarui statusnya ke: ${status}`);
  });

  // Event: Disconnect
  socket.on('disconnect', () => {
    console.log(`User terputus dari WebSocket: ${socket.user.name}`);
  });
});

// Jalankan Server HTTP + WebSockets
server.listen(PORT, () => {
  console.log(`Chat Service berjalan di port ${PORT}`);
});
