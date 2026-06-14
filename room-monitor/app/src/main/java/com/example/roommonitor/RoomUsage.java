package com.example.roommonitor;

/**
 * ============================================================
 * KELAS RoomUsage (Model Data)
 * ============================================================
 * Kelas ini berfungsi sebagai MODEL atau "wadah" untuk menyimpan
 * data penggunaan ruangan. Setiap objek RoomUsage merepresentasikan
 * satu record/baris data di database.
 *
 * Atribut yang disimpan:
 * - id : ID unik (auto increment dari database)
 * - roomName : Nama ruangan (contoh: "Lab Komputer 1")
 * - userName : Nama pengguna ruangan (contoh: "Dr. Budi")
 * - date : Tanggal penggunaan (format: dd/MM/yyyy)
 * - timeStart : Waktu mulai (format: HH:mm)
 * - timeEnd : Waktu selesai (format: HH:mm)
 * - purpose : Keperluan/tujuan penggunaan
 * - category : Kategori (Kuliah/Rapat/Seminar/Lainnya)
 * ============================================================
 */
public class RoomUsage {

    // ========== DEKLARASI VARIABEL (ATRIBUT) ==========
    private int id; // ID unik dari database
    private String roomName; // Nama ruangan
    private String userName; // Nama pengguna
    private String date; // Tanggal penggunaan
    private String timeStart; // Waktu mulai
    private String timeEnd; // Waktu selesai
    private String purpose; // Keperluan
    private String category; // Kategori

    // ========== KONSTRUKTOR (CONSTRUCTOR) ==========

    /**
     * Konstruktor kosong (default).
     * Digunakan ketika ingin membuat objek kosong terlebih dahulu,
     * lalu mengisi datanya nanti menggunakan setter.
     */
    public RoomUsage() {
    }

    /**
     * Konstruktor lengkap dengan ID.
     * Digunakan ketika mengambil data dari database (karena sudah punya ID).
     */
    public RoomUsage(int id, String roomName, String userName, String date,
            String timeStart, String timeEnd, String purpose, String category) {
        this.id = id;
        this.roomName = roomName;
        this.userName = userName;
        this.date = date;
        this.timeStart = timeStart;
        this.timeEnd = timeEnd;
        this.purpose = purpose;
        this.category = category;
    }

    /**
     * Konstruktor tanpa ID.
     * Digunakan ketika ingin MENAMBAH data baru ke database
     * (ID akan di-generate otomatis oleh database).
     */
    public RoomUsage(String roomName, String userName, String date,
            String timeStart, String timeEnd, String purpose, String category) {
        this.roomName = roomName;
        this.userName = userName;
        this.date = date;
        this.timeStart = timeStart;
        this.timeEnd = timeEnd;
        this.purpose = purpose;
        this.category = category;
    }

    // ========== GETTER DAN SETTER ==========
    // Getter = untuk MENGAMBIL nilai dari variabel
    // Setter = untuk MENGUBAH/MENGISI nilai variabel

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public String getRoomName() {
        return roomName;
    }

    public void setRoomName(String roomName) {
        this.roomName = roomName;
    }

    public String getUserName() {
        return userName;
    }

    public void setUserName(String userName) {
        this.userName = userName;
    }

    public String getDate() {
        return date;
    }

    public void setDate(String date) {
        this.date = date;
    }

    public String getTimeStart() {
        return timeStart;
    }

    public void setTimeStart(String timeStart) {
        this.timeStart = timeStart;
    }

    public String getTimeEnd() {
        return timeEnd;
    }

    public void setTimeEnd(String timeEnd) {
        this.timeEnd = timeEnd;
    }

    public String getPurpose() {
        return purpose;
    }

    public void setPurpose(String purpose) {
        this.purpose = purpose;
    }

    public String getCategory() {
        return category;
    }

    public void setCategory(String category) {
        this.category = category;
    }

    // ========== METHOD TAMBAHAN ==========

    /**
     * Mengembalikan ikon emoji berdasarkan kategori.
     * Contoh: Kuliah = 📚, Rapat = 🤝, dll.
     */
    public String getCategoryIcon() {
        if (category == null)
            return "🏫";

        switch (category) {
            case "Kuliah":
                return "📚";
            case "Rapat":
                return "🤝";
            case "Seminar":
                return "🎤";
            default:
                return "🏫";
        }
    }

    /**
     * Mengembalikan string rentang waktu.
     * Contoh output: "08:00 - 10:00"
     */
    public String getTimeRange() {
        return timeStart + " - " + timeEnd;
    }

    /**
     * Method toString untuk menampilkan isi objek (berguna untuk debugging).
     */
    @Override
    public String toString() {
        return "RoomUsage{" +
                "id=" + id +
                ", roomName='" + roomName + '\'' +
                ", userName='" + userName + '\'' +
                ", date='" + date + '\'' +
                ", timeStart='" + timeStart + '\'' +
                ", timeEnd='" + timeEnd + '\'' +
                ", purpose='" + purpose + '\'' +
                ", category='" + category + '\'' +
                '}';
    }
}
