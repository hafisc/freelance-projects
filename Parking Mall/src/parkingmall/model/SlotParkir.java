package parkingmall.model;

import java.util.Date;

public class SlotParkir {
    private int idSlot;
    private int idLantai;
    private String kodeSlot;
    private String status; // tersedia, dibooking, terisi
    private Date createdAt;

    // Tambahan atribut transient untuk memudahkan join data di view
    private String namaLantai;

    public SlotParkir() {}

    public SlotParkir(int idSlot, int idLantai, String kodeSlot, String status, Date createdAt) {
        this.idSlot = idSlot;
        this.idLantai = idLantai;
        this.kodeSlot = kodeSlot;
        this.status = status;
        this.createdAt = createdAt;
    }

    public int getIdSlot() {
        return idSlot;
    }

    public void setIdSlot(int idSlot) {
        this.idSlot = idSlot;
    }

    public int getIdLantai() {
        return idLantai;
    }

    public void setIdLantai(int idLantai) {
        this.idLantai = idLantai;
    }

    public String getKodeSlot() {
        return kodeSlot;
    }

    public void setKodeSlot(String kodeSlot) {
        this.kodeSlot = kodeSlot;
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

    public String getNamaLantai() {
        return namaLantai;
    }

    public void setNamaLantai(String namaLantai) {
        this.namaLantai = namaLantai;
    }
}
