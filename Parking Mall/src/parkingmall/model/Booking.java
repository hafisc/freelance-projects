package parkingmall.model;

import java.util.Date;

public class Booking {
    private int idBooking;
    private String kodeBooking;
    private int idUser;
    private int idSlot;
    private String platNomor;
    private String jenisKendaraan; // motor, mobil
    private Date waktuBooking;
    private String status; // menunggu, diverifikasi, selesai, dibatalkan
    private Date createdAt;

    // Transient attributes untuk UI
    private String namaPengguna;
    private String kodeSlot;
    private String namaLantai;

    public Booking() {}

    public Booking(int idBooking, String kodeBooking, int idUser, int idSlot, String platNomor, String jenisKendaraan, Date waktuBooking, String status, Date createdAt) {
        this.idBooking = idBooking;
        this.kodeBooking = kodeBooking;
        this.idUser = idUser;
        this.idSlot = idSlot;
        this.platNomor = platNomor;
        this.jenisKendaraan = jenisKendaraan;
        this.waktuBooking = waktuBooking;
        this.status = status;
        this.createdAt = createdAt;
    }

    public int getIdBooking() {
        return idBooking;
    }

    public void setIdBooking(int idBooking) {
        this.idBooking = idBooking;
    }

    public String getKodeBooking() {
        return kodeBooking;
    }

    public void setKodeBooking(String kodeBooking) {
        this.kodeBooking = kodeBooking;
    }

    public int getIdUser() {
        return idUser;
    }

    public void setIdUser(int idUser) {
        this.idUser = idUser;
    }

    public int getIdSlot() {
        return idSlot;
    }

    public void setIdSlot(int idSlot) {
        this.idSlot = idSlot;
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

    public Date getWaktuBooking() {
        return waktuBooking;
    }

    public void setWaktuBooking(Date waktuBooking) {
        this.waktuBooking = waktuBooking;
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

    public String getNamaPengguna() {
        return namaPengguna;
    }

    public void setNamaPengguna(String namaPengguna) {
        this.namaPengguna = namaPengguna;
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
