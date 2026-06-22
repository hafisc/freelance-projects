const mongoose = require('mongoose');

// Skema data untuk Transaksi Perjalanan (Trip)
const TripSchema = new mongoose.Schema({
  customerId: {
    type: String,
    required: true
  },
  customerName: {
    type: String,
    required: true
  },
  driverId: {
    type: String,
    default: null // Kosong di awal sampai ada driver yang menerima orderan
  },
  driverName: {
    type: String,
    default: null
  },
  pickup: {
    name: { type: String, required: true }, // Nama lokasi jemput (contoh: "Stasiun Sudirman")
    lat: { type: Number, required: true },  // Koordinat latitude untuk simulator
    lng: { type: Number, required: true }   // Koordinat longitude untuk simulator
  },
  destination: {
    name: { type: String, required: true }, // Nama tujuan (contoh: "Grand Indonesia")
    lat: { type: Number, required: true },
    lng: { type: Number, required: true }
  },
  status: {
    type: String,
    enum: ['searching', 'accepted', 'ongoing', 'completed', 'cancelled'],
    default: 'searching'
  },
  price: {
    type: Number,
    required: true
  },
  createdAt: {
    type: Date,
    default: Date.now
  }
});

module.exports = mongoose.model('Trip', TripSchema);
