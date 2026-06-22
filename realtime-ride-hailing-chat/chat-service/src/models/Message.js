const mongoose = require('mongoose');

// Skema data untuk Pesan Chat (Message)
const MessageSchema = new mongoose.Schema({
  tripId: {
    type: String,
    required: true,
    index: true // Diindeks agar pencarian history chat per trip cepat
  },
  senderId: {
    type: String,
    required: true
  },
  senderName: {
    type: String,
    required: true
  },
  message: {
    type: String,
    required: true
  },
  createdAt: {
    type: Date,
    default: Date.now
  }
});

module.exports = mongoose.model('Message', MessageSchema);
