import { useEffect, useState } from 'react';
import { apiService } from '../services/api';
import './Verification.css'; // <--- Impor file CSS di sini

export default function Verification() {
  const [reports, setReports] = useState<any[]>([]);

  useEffect(() => { loadReports(); }, []);

  const loadReports = async () => {
    try {
      const res = await apiService.getReports();
      setReports(res.data);
    } catch (err) { console.error(err); }
  };

  const handleVerify = async (id: number, status: 'verified' | 'rejected') => {
    await apiService.verifyReport(id, status);
    loadReports();
  };

  return (
    <div className="verification-container">
      <h2>Verifikasi Laporan</h2>
      <table className="verification-table">
        <thead>
          <tr>
            <th>Pelapor</th>
            <th>Foto</th>
            <th>Lokasi</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          {reports.map((r) => (
            <tr key={r.id}>
              <td>{r.user?.name}</td>
              <td>
                <img 
                  src={r.photo_url || `http://127.0.0.1:8000/storage/${r.photo_path}`} 
                  className="report-img"
                  alt="Bukti"
                />
              </td>
              <td>{r.location}</td>
              <td>
                <span className={`status-badge ${r.status === 'verified' ? 'status-verified' : 'status-pending'}`}>
                  {r.status.toUpperCase()}
                </span>
              </td>
              <td>
                {r.status === 'pending' && (
                  <>
                    <button onClick={() => handleVerify(r.id, 'verified')} className="action-btn btn-accept">Terima</button>
                    <button onClick={() => handleVerify(r.id, 'rejected')} className="action-btn btn-reject">Tolak</button>
                  </>
                )}
              </td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
}