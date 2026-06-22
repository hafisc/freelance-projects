const express = require('express');
const mongoose = require('mongoose');
const bcrypt = require('bcryptjs');
const jwt = require('jsonwebtoken');
const cors = require('cors');
const User = require('./models/User');

const app = express();
const PORT = process.env.PORT || 3000;
const JWT_SECRET = process.env.JWT_SECRET || 'afl3_secret_key_123';
const MONGO_URI = process.env.MONGO_URI || 'mongodb://db-auth:27017/authdb';

// Enable CORS & JSON Parsing
app.use(cors());
app.use(express.json());

// Hubungkan ke Database MongoDB
mongoose.connect(MONGO_URI)
  .then(() => console.log('Terhubung ke database MongoDB (Auth)'))
  .catch((err) => console.error('Gagal terhubung ke MongoDB (Auth):', err));

// ==========================================
// ENDPOINT: Health Check
// ==========================================
app.get('/api/auth/health', (req, res) => {
  res.status(200).json({ status: 'OK', service: 'Auth Service' });
});

// ==========================================
// ENDPOINT: Register Pengguna Baru
// ==========================================
app.post('/api/auth/register', async (req, res) => {
  try {
    const { name, email, password, role } = req.body;

    // Validasi input dasar
    if (!name || !email || !password || !role) {
      return res.status(400).json({ message: 'Semua field wajib diisi' });
    }

    // Cek apakah email sudah terdaftar
    const existingUser = await User.findOne({ email });
    if (existingUser) {
      return res.status(400).json({ message: 'Email sudah terdaftar' });
    }

    // Hash password demi keamanan
    const salt = await bcrypt.genSalt(10);
    const hashedPassword = await bcrypt.hash(password, salt);

    // Simpan user baru ke database
    const newUser = new User({
      name,
      email,
      password: hashedPassword,
      role
    });

    await newUser.save();

    res.status(201).json({
      message: 'Registrasi berhasil',
      user: {
        id: newUser._id,
        name: newUser.name,
        email: newUser.email,
        role: newUser.role
      }
    });
  } catch (error) {
    console.error('Error saat registrasi:', error);
    res.status(500).json({ message: 'Terjadi kesalahan pada server' });
  }
});

// ==========================================
// ENDPOINT: Login Pengguna
// ==========================================
app.post('/api/auth/login', async (req, res) => {
  try {
    const { email, password } = req.body;

    if (!email || !password) {
      return res.status(400).json({ message: 'Email dan password wajib diisi' });
    }

    // Cari user berdasarkan email
    const user = await User.findOne({ email });
    if (!user) {
      return res.status(400).json({ message: 'Email atau password salah' });
    }

    // Validasi password
    const isMatch = await bcrypt.compare(password, user.password);
    if (!isMatch) {
      return res.status(400).json({ message: 'Email atau password salah' });
    }

    // Buat JWT Token
    const token = jwt.sign(
      { id: user._id, name: user.name, email: user.email, role: user.role },
      JWT_SECRET,
      { expiresIn: '24h' } // Token berlaku 24 jam
    );

    res.status(200).json({
      message: 'Login berhasil',
      token,
      user: {
        id: user._id,
        name: user.name,
        email: user.email,
        role: user.role
      }
    });
  } catch (error) {
    console.error('Error saat login:', error);
    res.status(500).json({ message: 'Terjadi kesalahan pada server' });
  }
});

// ==========================================
// ENDPOINT: Verifikasi Token (Internal / Middleware)
// ==========================================
app.get('/api/auth/me', async (req, res) => {
  try {
    const authHeader = req.headers.authorization;
    if (!authHeader || !authHeader.startsWith('Bearer ')) {
      return res.status(401).json({ message: 'Akses ditolak. Token tidak disediakan.' });
    }

    const token = authHeader.split(' ')[1];
    const decoded = jwt.verify(token, JWT_SECRET);

    const user = await User.findById(decoded.id).select('-password');
    if (!user) {
      return res.status(404).json({ message: 'Pengguna tidak ditemukan' });
    }

    res.status(200).json({ user });
  } catch (error) {
    res.status(401).json({ message: 'Token tidak valid' });
  }
});

// ==========================================
// ENDPOINT INTERNAL: Verifikasi JWT untuk Service Lain
// ==========================================
app.post('/api/auth/verify', (req, res) => {
  try {
    const { token } = req.body;
    if (!token) {
      return res.status(400).json({ valid: false, message: 'Token wajib dikirim' });
    }

    const decoded = jwt.verify(token, JWT_SECRET);
    res.status(200).json({ valid: true, user: decoded });
  } catch (error) {
    res.status(200).json({ valid: false, message: 'Token tidak valid' });
  }
});

// Jalankan Server Express
app.listen(PORT, () => {
  console.log(`Auth Service berjalan di port ${PORT}`);
});
