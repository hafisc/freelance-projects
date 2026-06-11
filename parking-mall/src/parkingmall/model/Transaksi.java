package parkingmall.model;

import java.util.Date;

public class Transaksi {
    private int idTransaksi;
    private String kodeTransaksi;
    private Integer idKendaraan; // bisa null
    private Integer idBooking; // bisa null
    private Date waktuMasuk;
    private Date waktuKeluar; // bisa null
    private int durasiJam;
    private int totalBayar;
    private String status; // berjalan, selesai
    private Date createdAt;

    // Transient attributes untuk laporan / view
    private String platNomor;
    private String jenisKendaraan;
    private String kodeSlot;
    private String namaLantai;
    private String kodeBooking;

    public Transaksi() {}

    public Transaksi(int idTransaksi, String kodeTransaksi, Integer idKendaraan, Integer idBooking, Date waktuMasuk, Date waktuKeluar, int durasiJam, int totalBayar, String status, Date createdAt) {
        this.idTransaksi = idTransaksi;
        this.kodeTransaksi = kodeTransaksi;
        this.idKendaraan = idKendaraan;
        this.idBooking = idBooking;
        this.waktuMasuk = waktuMasuk;
        this.waktuKeluar = waktuKeluar;
        this.durasiJam = durasiJam;
        this.totalBayar = totalBayar;
        this.status = status;
        this.createdAt = createdAt;
    }

    public int getIdTransaksi() {
        return idTransaksi;
    }

    public void setIdTransaksi(int idTransaksi) {
        this.idTransaksi = idTransaksi;
    }

    public String getKodeTransaksi() {
        return kodeTransaksi;
    }

    public void setKodeTransaksi(String kodeTransaksi) {
        this.kodeTransaksi = kodeTransaksi;
    }

    public Integer getIdKendaraan() {
        return idKendaraan;
    }

    public void setIdKendaraan(Integer idKendaraan) {
        this.idKendaraan = idKendaraan;
    }

    public Integer getIdBooking() {
        return idBooking;
    }

    public void setIdBooking(Integer idBooking) {
        this.idBooking = idBooking;
    }

    public Date getWaktuMasuk() {
        return waktuMasuk;
    }

    public void setWaktuMasuk(Date waktuMasuk) {
        this.waktuMasuk = waktuMasuk;
    }

    public Date getWaktuKeluar() {
        return waktuKeluar;
    }

    public void setWaktuKeluar(Date waktuKeluar) {
        this.waktuKeluar = waktuKeluar;
    }

    public int getDurasiJam() {
        return durasiJam;
    }

    public void setDurasiJam(int durasiJam) {
        this.durasiJam = durasiJam;
    }

    public int getTotalBayar() {
        return totalBayar;
    }

    public void setTotalBayar(int totalBayar) {
        this.totalBayar = totalBayar;
    }

    public String getStatus() {
        return status;
    }

    public void setStatus(String status) {
        this.status = status;
    }

    public Date getCreatedAt() {
        return createdAt;
    }

    public void setCreatedAt(Date createdAt) {
        this.createdAt = createdAt;
    }

    public String getPlatNomor() {
        return platNomor;
    }

    public void setPlatNomor(String platNomor) {
        this.platNomor = platNomor;
    }

    public String getJenisKendaraan() {
        return jenisKendaraan;
    }

    public void setJenisKendaraan(String jenisKendaraan) {
        this.jenisKendaraan = jenisKendaraan;
    }

    public String getKodeSlot() {
        return kodeSlot;
    }

    public void setKodeSlot(String kodeSlot) {
        this.kodeSlot = kodeSlot;
    }

    public String getNamaLantai() {
        return namaLantai;
    }

    public void setNamaLantai(String namaLantai) {
        this.namaLantai = namaLantai;
    }

    public String getKodeBooking() {
        return kodeBooking;
    }

    public void setKodeBooking(String kodeBooking) {
        this.kodeBooking = kodeBooking;
    }
}
