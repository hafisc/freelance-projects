const express = require('express');
const mongoose = require('mongoose');
const cors = require('cors');
const Trip = require('./models/Trip');
const authMiddleware = require('./middleware/auth');

const app = express();
const PORT = process.env.PORT || 3000;
const MONGO_URI = process.env.MONGO_URI || 'mongodb://db-trip:27017/tripdb';

// Enable CORS & JSON Parsing
app.use(cors());
app.use(express.json());

// Hubungkan ke Database MongoDB (Trip DB)
mongoose.connect(MONGO_URI)
  .then(() => console.log('Terhubung ke database MongoDB (Trip)'))
  .catch((err) => console.error('Gagal terhubung ke MongoDB (Trip):', err));

// ==========================================
// ENDPOINT: Health Check
// ==========================================
app.get('/api/trips/health', (req, res) => {
  res.status(200).json({ status: 'OK', service: 'Trip Service' });
});

// ==========================================
// ENDPOINT: Buat Order Perjalanan Baru (Hanya untuk Customer)
// ==========================================
app.post('/api/trips', authMiddleware, async (req, res) => {
  try {
    const { pickup, destination, price } = req.body;

    // Pastikan user adalah customer
    if (req.user.role !== 'customer') {
      return res.status(403).json({ message: 'Hanya customer yang dapat membuat order perjalanan' });
    }

    if (!pickup || !destination || !price) {
      return res.status(400).json({ message: 'Data jemput, tujuan, dan harga wajib diisi' });
    }

    // Buat objek trip baru
    const newTrip = new Trip({
      customerId: req.user.id,
      customerName: req.user.name,
      pickup: {
        name: pickup.name,
        lat: Number(pickup.lat),
        lng: Number(pickup.lng)
      },
      destination: {
        name: destination.name,
        lat: Number(destination.lat),
        lng: Number(destination.lng)
      },
      price: Number(price),
      status: 'searching' // Default mencari driver
    });

    await newTrip.save();

    res.status(201).json({
      message: 'Order perjalanan berhasil dibuat',
      trip: newTrip
    });
  } catch (error) {
    console.error('Error saat membuat trip:', error);
    res.status(500).json({ message: 'Terjadi kesalahan pada server' });
  }
});

// ==========================================
// ENDPOINT: Ambil Semua Trip Pengguna (Riwayat / Aktif)
// ==========================================
app.get('/api/trips', authMiddleware, async (req, res) => {
  try {
    let trips = [];
    
    // Filter berdasarkan role
    if (req.user.role === 'customer') {
      trips = await Trip.find({ customerId: req.user.id }).sort({ createdAt: -1 });
    } else if (req.user.role === 'driver') {
      trips = await Trip.find({ driverId: req.user.id }).sort({ createdAt: -1 });
    }

    res.status(200).json({ trips });
  } catch (error) {
    console.error('Error saat mengambil trip:', error);
    res.status(500).json({ message: 'Terjadi kesalahan pada server' });
  }
});

// ==========================================
// ENDPOINT: Ambil Orderan yang Sedang Mencari Driver (Untuk Driver)
// ==========================================
app.get('/api/trips/searching', authMiddleware, async (req, res) => {
  try {
    if (req.user.role !== 'driver') {
      return res.status(403).json({ message: 'Akses ditolak. Hanya untuk driver.' });
    }

    // Cari trip dengan status searching
    const activeTrips = await Trip.find({ status: 'searching' }).sort({ createdAt: -1 });
    res.status(200).json({ trips: activeTrips });
  } catch (error) {
    console.error('Error saat mengambil orderan aktif:', error);
    res.status(500).json({ message: 'Terjadi kesalahan pada server' });
  }
});

// ==========================================
// ENDPOINT: Terima Order Perjalanan (Hanya untuk Driver)
// ==========================================
app.put('/api/trips/:id/accept', authMiddleware, async (req, res) => {
  try {
    if (req.user.role !== 'driver') {
      return res.status(403).json({ message: 'Akses ditolak. Hanya untuk driver.' });
    }

    const trip = await Trip.findById(req.id || req.params.id);
    if (!trip) {
      return res.status(404).json({ message: 'Order perjalanan tidak ditemukan' });
    }

    if (trip.status !== 'searching') {
      return res.status(400).json({ message: 'Order ini sudah diambil oleh driver lain' });
    }

    // Update status dan pasang pengemudi
    trip.status = 'accepted';
    trip.driverId = req.user.id;
    trip.driverName = req.user.name;

    await trip.save();

    res.status(200).json({
      message: 'Order berhasil diambil',
      trip
    });
  } catch (error) {
    console.error('Error saat menerima trip:', error);
    res.status(500).json({ message: 'Terjadi kesalahan pada server' });
  }
});

// ==========================================
// ENDPOINT: Update Status Perjalanan (Oleh Driver)
// ==========================================
app.put('/api/trips/:id/status', authMiddleware, async (req, res) => {
  try {
    const { status } = req.body;
    
    if (req.user.role !== 'driver') {
      return res.status(403).json({ message: 'Akses ditolak. Hanya untuk driver.' });
    }

    if (!['ongoing', 'completed', 'cancelled'].includes(status)) {
      return res.status(400).json({ message: 'Status tidak valid' });
    }

    const trip = await Trip.findById(req.id || req.params.id);
    if (!trip) {
      return res.status(404).json({ message: 'Order perjalanan tidak ditemukan' });
    }

    // Pastikan driver yang bersangkutan yang mengubah status
    if (trip.driverId !== req.user.id) {
      return res.status(403).json({ message: 'Anda tidak memiliki hak akses untuk perjalanan ini' });
    }

    trip.status = status;
    await trip.save();

    res.status(200).json({
      message: `Status perjalanan diperbarui menjadi ${status}`,
      trip
    });
  } catch (error) {
    console.error('Error saat update status:', error);
    res.status(500).json({ message: 'Terjadi kesalahan pada server' });
  }
});

// Jalankan Server Express
app.listen(PORT, () => {
  console.log(`Trip Service berjalan di port ${PORT}`);
});
