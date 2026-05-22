package parkingmall.model;

import java.util.Date;

public class Petugas {
    private int idPetugas;
    private int idUser;
    private String namaPetugas;
    private String noHp;
    private String alamat;
    private Date createdAt;

    public Petugas() {}

    public Petugas(int idPetugas, int idUser, String namaPetugas, String noHp, String alamat, Date createdAt) {
        this.idPetugas = idPetugas;
        this.idUser = idUser;
        this.namaPetugas = namaPetugas;
        this.noHp = noHp;
        this.alamat = alamat;
        this.createdAt = createdAt;
    }

    public int getIdPetugas() {
        return idPetugas;
    }

    public void setIdPetugas(int idPetugas) {
        this.idPetugas = idPetugas;
    }

    public int getIdUser() {
        return idUser;
    }

    public void setIdUser(int idUser) {
        this.idUser = idUser;
    }

    public String getNamaPetugas() {
        return namaPetugas;
    }

    public void setNamaPetugas(String namaPetugas) {
        this.namaPetugas = namaPetugas;
    }

    public String getNoHp() {
        return noHp;
    }

    public void setNoHp(String noHp) {
        this.noHp = noHp;
    }

    public String getAlamat() {
        return alamat;
    }

    public void setAlamat(String alamat) {
        this.alamat = alamat;
    }

    public Date getCreatedAt() {
        return createdAt;
    }

    public void setCreatedAt(Date createdAt) {
        this.createdAt = createdAt;
    }
}
