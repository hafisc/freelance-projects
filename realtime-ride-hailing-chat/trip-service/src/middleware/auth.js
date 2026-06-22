const jwt = require('jsonwebtoken');
const JWT_SECRET = process.env.JWT_SECRET || 'afl3_secret_key_123';

// Middleware untuk memverifikasi token JWT dari request client
module.exports = function(req, res, next) {
  // Ambil token dari header Authorization
  const authHeader = req.headers.authorization;
  
  if (!authHeader || !authHeader.startsWith('Bearer ')) {
    return res.status(401).json({ message: 'Akses ditolak. Token tidak disediakan.' });
  }

  const token = authHeader.split(' ')[1];

  try {
    // Verifikasi token JWT
    const decoded = jwt.verify(token, JWT_SECRET);
    // Masukkan data user terverifikasi ke object request
    req.user = decoded;
    next();
  } catch (error) {
    return res.status(401).json({ message: 'Token tidak valid' });
  }
};
