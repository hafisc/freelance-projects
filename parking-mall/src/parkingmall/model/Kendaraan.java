package parkingmall.model;

import java.util.Date;

public class Kendaraan {
    private int idKendaraan;
    private String platNomor;
    private String jenisKendaraan; // motor, mobil
    private Integer idSlot; // bisa null
    private Date waktuMasuk;
    private Date waktuKeluar; // bisa null
    private String status; // masuk, keluar
    private Date createdAt;

    // Transient attributes untuk UI
    private String kodeSlot;
    private String namaLantai;

    public Kendaraan() {}

    public Kendaraan(int idKendaraan, String platNomor, String jenisKendaraan, Integer idSlot, Date waktuMasuk, Date waktuKeluar, String status, Date createdAt) {
        this.idKendaraan = idKendaraan;
        this.platNomor = platNomor;
        this.jenisKendaraan = jenisKendaraan;
        this.idSlot = idSlot;
        this.waktuMasuk = waktuMasuk;
        this.waktuKeluar = waktuKeluar;
        this.status = status;
        this.createdAt = createdAt;
    }

    public int getIdKendaraan() {
        return idKendaraan;
    }

    public void setIdKendaraan(int idKendaraan) {
        this.idKendaraan = idKendaraan;
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

    public Integer getIdSlot() {
        return idSlot;
    }

    public void setIdSlot(Integer idSlot) {
        this.idSlot = idSlot;
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
}
