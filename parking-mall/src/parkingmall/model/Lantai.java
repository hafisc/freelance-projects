package parkingmall.model;

import java.util.Date;

public class Lantai {
    private int idLantai;
    private String namaLantai;
    private String keterangan;
    private Date createdAt;

    public Lantai() {}

    public Lantai(int idLantai, String namaLantai, String keterangan, Date createdAt) {
        this.idLantai = idLantai;
        this.namaLantai = namaLantai;
        this.keterangan = keterangan;
        this.createdAt = createdAt;
    }

    public int getIdLantai() {
        return idLantai;
    }

    public void setIdLantai(int idLantai) {
        this.idLantai = idLantai;
    }

    public String getNamaLantai() {
        return namaLantai;
    }

    public void setNamaLantai(String namaLantai) {
        this.namaLantai = namaLantai;
    }

    public String getKeterangan() {
        return keterangan;
    }

    public void setKeterangan(String keterangan) {
        this.keterangan = keterangan;
    }

    public Date getCreatedAt() {
        return createdAt;
    }

    public void setCreatedAt(Date createdAt) {
        this.createdAt = createdAt;
    }
}
