package com.labmobile.kulinerku.util;

import android.os.Handler;
import android.os.Looper;
import java.util.concurrent.ExecutorService;
import java.util.concurrent.Executors;

// Kelas utility untuk mempermudah eksekusi tugas di background thread dan callback ke UI thread secara asinkron
public class ThreadExecutor {
    private static ThreadExecutor instance;
    private final ExecutorService executorService;
    private final Handler mainThreadHandler;

    // Konstruktor private untuk inisialisasi ExecutorService dengan fixed thread pool
    private ThreadExecutor() {
        this.executorService = Executors.newFixedThreadPool(3);
        this.mainThreadHandler = new Handler(Looper.getMainLooper());
    }

    // Mendapatkan instance tunggal (singleton) dari ThreadExecutor
    public static synchronized ThreadExecutor getInstance() {
        if (instance == null) {
            instance = new ThreadExecutor();
        }
        return instance;
    }

    // Menjalankan tugas sederhana di background thread
    public void execute(Runnable task) {
        executorService.execute(task);
    }

    // Menjalankan tugas di background thread, lalu mengembalikan hasilnya ke main thread (UI Thread)
    public void execute(Runnable backgroundTask, Runnable mainThreadCallback) {
        executorService.execute(() -> {
            try {
                backgroundTask.run();
                if (mainThreadCallback != null) {
                    mainThreadHandler.post(mainThreadCallback);
                }
            } catch (Exception e) {
                e.printStackTrace();
            }
        });
    }
}
