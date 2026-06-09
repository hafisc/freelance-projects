import { useState, useEffect } from 'react';
import {
  Box,
  Card,
  CardContent,
  Table,
  TableBody,
  TableCell,
  TableContainer,
  TableHead,
  TableRow,
  TablePagination,
  TextField,
  InputAdornment,
  Select,
  MenuItem,
  FormControl,
  InputLabel,
  IconButton,
  Tooltip,
  Avatar,
  Chip,
  Button,
  Typography,
  alpha,
  Dialog,
  DialogTitle,
  DialogContent,
  DialogActions,
} from '@mui/material';
import {
  Search as SearchIcon,
  FilterList as FilterIcon,
  Visibility as VisibilityIcon,
  Edit as EditIcon,
  Add as AddIcon,
  People as PeopleIcon,
  Delete as DeleteIcon,
} from '@mui/icons-material';
import PageHeader from '../components/PageHeader';
import { apiService } from '../services/api';

interface Member {
  id: string;
  name: string;
  email: string;
  phone: string;
  points: number;
  status: 'active' | 'inactive' | 'pending';
  joinDate: string;
}

// Mock data
const mockMembers: Member[] = [
  { id: '1', name: 'Budi Santoso', email: 'budi.santoso@email.com', phone: '081234567890', points: 12500, status: 'active', joinDate: '15 Jan 2026' },
  { id: '2', name: 'Siti Rahayu', email: 'siti.rahayu@email.com', phone: '081234567891', points: 8500, status: 'active', joinDate: '12 Jan 2026' },
  { id: '3', name: 'Ahmad Wijaya', email: 'ahmad.wijaya@email.com', phone: '081234567892', points: 3200, status: 'pending', joinDate: '10 Jan 2026' },
  { id: '4', name: 'Dewi Lestari', email: 'dewi.lestari@email.com', phone: '081234567893', points: 15800, status: 'active', joinDate: '08 Jan 2026' },
  { id: '5', name: 'Rudi Hermawan', email: 'rudi.hermawan@email.com', phone: '081234567894', points: 5600, status: 'inactive', joinDate: '05 Jan 2026' },
  { id: '6', name: 'Wati Susilowati', email: 'wati.susilowati@email.com', phone: '081234567895', points: 9200, status: 'active', joinDate: '03 Jan 2026' },
  { id: '7', name: 'Joko Pramono', email: 'joko.pramono@email.com', phone: '081234567896', points: 4100, status: 'active', joinDate: '01 Jan 2026' },
  { id: '8', name: 'Nina Marlina', email: 'nina.marlina@email.com', phone: '081234567897', points: 2300, status: 'pending', joinDate: '28 Dec 2025' },
  { id: '9', name: 'Hendra Wijaya', email: 'hendra.wijaya@email.com', phone: '081234567898', points: 7800, status: 'active', joinDate: '20 Dec 2025' },
  { id: '10', name: 'Rina Susilowati', email: 'rina.susilowati@email.com', phone: '081234567899', points: 15200, status: 'active', joinDate: '15 Dec 2025' },
];

const statusConfig = {
  active: { label: 'Aktif', color: 'success' },
  inactive: { label: 'Nonaktif', color: 'default' },
  pending: { label: 'Menunggu', color: 'warning' },
};

const Members = () => {
  const [members, setMembers] = useState<Member[]>([]);
  const [loading, setLoading] = useState(true);
  const [page, setPage] = useState(0);
  const [rowsPerPage, setRowsPerPage] = useState(5);
  const [search, setSearch] = useState('');
  const [statusFilter, setStatusFilter] = useState('all');

  // Dialog State
  const [openDialog, setOpenDialog] = useState(false);
  const [editingMember, setEditingMember] = useState<Member | null>(null);
  const [formName, setFormName] = useState('');
  const [formEmail, setFormEmail] = useState('');
  const [formPhone, setFormPhone] = useState('');
  const [formRole, setFormRole] = useState('member');
  const [formStatus, setFormStatus] = useState<'active' | 'inactive'>('active');

  const getInitials = (name: string) => {
    return name.split(' ').map((n) => n[0]).join('').toUpperCase().slice(0, 2);
  };

  const fetchMembers = async () => {
    setLoading(true);
    try {
      const res = await apiService.getMembers();
      if (res.success && res.data) {
        const mapped: Member[] = res.data.map((user: any) => ({
          id: user.id.toString(),
          name: user.name,
          email: user.email || '',
          phone: user.phone || '',
          points: 0,
          status: user.active ? 'active' : 'inactive',
          joinDate: 'Baru',
        }));
        setMembers(mapped);
      }
    } catch (e) {
      console.error("Fetch members error:", e);
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    fetchMembers();
  }, []);

  const handleOpenAdd = () => {
    setEditingMember(null);
    setFormName('');
    setFormEmail('');
    setFormPhone('');
    setFormRole('member');
    setFormStatus('active');
    setOpenDialog(true);
  };

  const handleOpenEdit = (member: Member) => {
    setEditingMember(member);
    setFormName(member.name);
    setFormEmail(member.email);
    setFormPhone(member.phone);
    setFormRole('member');
    setFormStatus(member.status === 'active' ? 'active' : 'inactive');
    setOpenDialog(true);
  };

  const handleDelete = async (id: string) => {
    if (window.confirm('Apakah Anda yakin ingin menghapus member ini?')) {
      try {
        await apiService.deleteMember(id);
        fetchMembers();
      } catch (e) {
        console.error(e);
      }
    }
  };

  const handleSave = async () => {
    try {
      if (editingMember) {
        await apiService.updateMember(editingMember.id, {
          name: formName,
          email: formEmail,
          phone: formPhone,
          role: formRole,
          active: formStatus === 'active',
        });
      } else {
        await apiService.createMember({
          name: formName,
          email: formEmail,
          phone: formPhone,
          role: formRole,
        });
      }
      setOpenDialog(false);
      fetchMembers();
    } catch (e) {
      console.error(e);
    }
  };

  const filteredMembers = members.filter((member) => {
    const matchesSearch = member.name.toLowerCase().includes(search.toLowerCase()) ||
      member.email.toLowerCase().includes(search.toLowerCase()) ||
      member.phone.includes(search);
    const matchesStatus = statusFilter === 'all' || member.status === statusFilter;
    return matchesSearch && matchesStatus;
  });

  const paginatedMembers = filteredMembers.slice(page * rowsPerPage, page * rowsPerPage + rowsPerPage);

  return (
    <Box>
      <PageHeader
        title="Kelola Member"
        subtitle="Kelola dan lihat data member TPS3R"
        actions={
          <Button
            variant="contained"
            startIcon={<AddIcon />}
            onClick={handleOpenAdd}
            sx={{
              px: 3,
              background: 'linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%)',
              boxShadow: '0 4px 14px rgba(46, 125, 50, 0.3)',
              '&:hover': {
                background: 'linear-gradient(135deg, #1B5E20 0%, #2E7D32 100%)',
              },
            }}
          >
            Tambah Member
          </Button>
        }
      />

      {/* Stats Cards */}
      <Box sx={{ display: 'grid', gridTemplateColumns: { xs: '1fr', sm: '1fr 1fr', md: 'repeat(4, 1fr)' }, gap: 2.5, mb: 3 }}>
        {[
          { label: 'Total Member', value: members.length.toString(), color: '#2E7D32' },
          { label: 'Member Aktif', value: members.filter(m => m.status === 'active').length.toString(), color: '#10B981' },
          { label: 'Menunggu Verifikasi', value: members.filter(m => m.status === 'pending').length.toString(), color: '#F59E0B' },
          { label: 'Total Poin', value: members.reduce((acc, m) => acc + m.points, 0).toLocaleString(), color: '#6366F1' },
        ].map((stat, i) => (
          <Card key={i} sx={{ '&:hover': { transform: 'translateY(-2px)' } }}>
            <CardContent sx={{ p: 2.5 }}>
              <Typography variant="caption" sx={{ color: '#8898AA', fontWeight: 500, textTransform: 'uppercase', letterSpacing: '0.05em' }}>
                {stat.label}
              </Typography>
              <Typography variant="h4" sx={{ fontWeight: 700, color: '#1A1A2E', mt: 0.5 }}>
                {stat.value}
              </Typography>
            </CardContent>
          </Card>
        ))}
      </Box>

      {/* Search & Filter */}
      <Card sx={{ mb: 3 }}>
        <CardContent sx={{ p: 2.5 }}>
          <Box sx={{ display: 'flex', gap: 2, flexWrap: 'wrap', alignItems: 'center' }}>
            <TextField
              placeholder="Cari nama, email, atau telepon..."
              value={search}
              onChange={(e) => setSearch(e.target.value)}
              size="small"
              sx={{ flex: 1, minWidth: 280 }}
              slotProps={{
                input: {
                  startAdornment: <InputAdornment position="start"><SearchIcon sx={{ color: '#9CA3AF' }} /></InputAdornment>,
                },
              }}
            />
            <FormControl size="small" sx={{ minWidth: 150 }}>
              <InputLabel>Status</InputLabel>
              <Select value={statusFilter} label="Status" onChange={(e) => setStatusFilter(e.target.value)}>
                <MenuItem value="all">Semua</MenuItem>
                <MenuItem value="active">Aktif</MenuItem>
                <MenuItem value="pending">Menunggu</MenuItem>
                <MenuItem value="inactive">Nonaktif</MenuItem>
              </Select>
            </FormControl>
            <Tooltip title="Filter Lanjutan">
              <IconButton sx={{ border: '1px solid #E8ECEF', borderRadius: '10px', '&:hover': { bgcolor: '#F8FAF8' } }}>
                <FilterIcon sx={{ color: '#5A6978' }} />
              </IconButton>
            </Tooltip>
          </Box>
        </CardContent>
      </Card>

      {/* Members Table */}
      <Card>
        <TableContainer>
          <Table>
            <TableHead>
              <TableRow>
                <TableCell sx={{ color: '#8898AA', fontWeight: 600, fontSize: '0.6875rem', textTransform: 'uppercase', letterSpacing: '0.05em' }}>Nama</TableCell>
                <TableCell sx={{ color: '#8898AA', fontWeight: 600, fontSize: '0.6875rem', textTransform: 'uppercase', letterSpacing: '0.05em' }}>Email</TableCell>
                <TableCell sx={{ color: '#8898AA', fontWeight: 600, fontSize: '0.6875rem', textTransform: 'uppercase', letterSpacing: '0.05em' }}>No HP</TableCell>
                <TableCell sx={{ color: '#8898AA', fontWeight: 600, fontSize: '0.6875rem', textTransform: 'uppercase', letterSpacing: '0.05em' }} align="right">Poin</TableCell>
                <TableCell sx={{ color: '#8898AA', fontWeight: 600, fontSize: '0.6875rem', textTransform: 'uppercase', letterSpacing: '0.05em' }}>Status</TableCell>
                <TableCell sx={{ color: '#8898AA', fontWeight: 600, fontSize: '0.6875rem', textTransform: 'uppercase', letterSpacing: '0.05em' }}>Bergabung</TableCell>
                <TableCell sx={{ color: '#8898AA', fontWeight: 600, fontSize: '0.6875rem', textTransform: 'uppercase', letterSpacing: '0.05em' }} align="center">Aksi</TableCell>
              </TableRow>
            </TableHead>
            <TableBody>
              {paginatedMembers.map((member) => {
                const status = statusConfig[member.status] || { label: member.status, color: 'default' };
                return (
                  <TableRow key={member.id} sx={{ '&:hover': { bgcolor: '#F8FAF8' }, '&:last-child td': { borderBottom: 0 } }}>
                    <TableCell>
                      <Box sx={{ display: 'flex', alignItems: 'center', gap: 1.5 }}>
                        <Avatar sx={{ width: 40, height: 40, fontSize: '0.8125rem', fontWeight: 600, bgcolor: '#F5F7F5', color: '#5A6978' }}>
                          {getInitials(member.name)}
                        </Avatar>
                        <Typography variant="body2" sx={{ fontWeight: 500, color: '#1A1A2E' }}>{member.name}</Typography>
                      </Box>
                    </TableCell>
                    <TableCell><Typography variant="body2" sx={{ color: '#5A6978' }}>{member.email}</Typography></TableCell>
                    <TableCell><Typography variant="body2" sx={{ color: '#5A6978' }}>{member.phone}</Typography></TableCell>
                    <TableCell align="right"><Typography variant="body2" sx={{ fontWeight: 600, color: '#2E7D32' }}>{member.points.toLocaleString()}</Typography></TableCell>
                    <TableCell>
                      <Chip label={status.label} size="small" color={status.color as 'success' | 'warning' | 'default'} sx={{ height: 24, fontSize: '0.6875rem', fontWeight: 500 }} />
                    </TableCell>
                    <TableCell><Typography variant="caption" sx={{ color: '#AAB5C2' }}>{member.joinDate}</Typography></TableCell>
                    <TableCell align="center">
                      <Box sx={{ display: 'flex', gap: 0.5, justifyContent: 'center' }}>
                        <Tooltip title="Edit">
                          <IconButton
                            size="small"
                            onClick={() => handleOpenEdit(member)}
                            sx={{ borderRadius: '8px', '&:hover': { bgcolor: alpha('#2E7D32', 0.08) } }}
                          >
                            <EditIcon sx={{ fontSize: 18, color: '#8898AA' }} />
                          </IconButton>
                        </Tooltip>
                        <Tooltip title="Hapus">
                          <IconButton
                            size="small"
                            onClick={() => handleDelete(member.id)}
                            sx={{ borderRadius: '8px', '&:hover': { bgcolor: alpha('#EF4444', 0.08) } }}
                          >
                            <DeleteIcon sx={{ fontSize: 18, color: '#EF4444' }} />
                          </IconButton>
                        </Tooltip>
                      </Box>
                    </TableCell>
                  </TableRow>
                );
              })}
              {paginatedMembers.length === 0 && (
                <TableRow>
                  <TableCell colSpan={7} align="center" sx={{ py: 6 }}>
                    <PeopleIcon sx={{ fontSize: 48, color: '#D1D5DB', mb: 1 }} />
                    <Typography variant="body2" sx={{ color: '#8898AA' }}>Tidak ada data member</Typography>
                  </TableCell>
                </TableRow>
              )}
            </TableBody>
          </Table>
        </TableContainer>
        <TablePagination component="div" count={filteredMembers.length} page={page} onPageChange={(_, p) => setPage(p)} rowsPerPage={rowsPerPage} onRowsPerPageChange={(e) => { setRowsPerPage(parseInt(e.target.value, 10)); setPage(0); }} rowsPerPageOptions={[5, 10, 25]} sx={{ borderTop: '1px solid #F0F2F5' }} />
      </Card>

      {/* Add/Edit Dialog */}
      <Dialog open={openDialog} onClose={() => setOpenDialog(false)} maxWidth="xs" fullWidth>
        <DialogTitle sx={{ fontWeight: 700 }}>
          {editingMember ? 'Edit Member' : 'Tambah Member'}
        </DialogTitle>
        <DialogContent sx={{ display: 'flex', flexDirection: 'column', gap: 2, pt: 1 }}>
          <TextField
            label="Nama Lengkap"
            value={formName}
            onChange={(e) => setFormName(e.target.value)}
            fullWidth
            size="small"
            margin="dense"
          />
          <TextField
            label="Email"
            value={formEmail}
            onChange={(e) => setFormEmail(e.target.value)}
            fullWidth
            size="small"
            margin="dense"
          />
          <TextField
            label="Nomor Telepon"
            value={formPhone}
            onChange={(e) => setFormPhone(e.target.value)}
            fullWidth
            size="small"
            margin="dense"
          />
          <FormControl fullWidth size="small" margin="dense">
            <InputLabel>Peran</InputLabel>
            <Select
              value={formRole}
              label="Peran"
              onChange={(e) => setFormRole(e.target.value)}
            >
              <MenuItem value="member">Member</MenuItem>
              <MenuItem value="petugas">Petugas</MenuItem>
              <MenuItem value="admin">Admin</MenuItem>
            </Select>
          </FormControl>
          {editingMember && (
            <FormControl fullWidth size="small" margin="dense">
              <InputLabel>Status</InputLabel>
              <Select
                value={formStatus}
                label="Status"
                onChange={(e) => setFormStatus(e.target.value as 'active' | 'inactive')}
              >
                <MenuItem value="active">Aktif</MenuItem>
                <MenuItem value="inactive">Nonaktif</MenuItem>
              </Select>
            </FormControl>
          )}
        </DialogContent>
        <DialogActions sx={{ px: 3, pb: 3 }}>
          <Button onClick={() => setOpenDialog(false)} color="inherit">Batal</Button>
          <Button onClick={handleSave} variant="contained" color="success">Simpan</Button>
        </DialogActions>
      </Dialog>
    </Box>
  );
};

export default Members;