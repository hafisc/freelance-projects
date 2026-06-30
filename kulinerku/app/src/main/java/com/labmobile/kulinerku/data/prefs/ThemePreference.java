package com.labmobile.kulinerku.data.prefs;

import android.content.Context;
import android.content.SharedPreferences;

// Mengelola penyimpanan preferensi tema aplikasi (Dark/Light mode) menggunakan SharedPreferences
public class ThemePreference {
    private static final String PREF_NAME = "theme_pref";
    private static final String KEY_THEME_MODE = "theme_mode";
    private final SharedPreferences preferences;

    // Inisialisasi ThemePreference menggunakan Context
    public ThemePreference(Context context) {
        this.preferences = context.getSharedPreferences(PREF_NAME, Context.MODE_PRIVATE);
    }

    // Menyimpan preferensi status Dark Mode
    public void setDarkMode(boolean isDarkMode) {
        preferences.edit().putBoolean(KEY_THEME_MODE, isDarkMode).apply();
    }

    // Membaca status preferensi Dark Mode saat ini
    public boolean isDarkMode() {
        return preferences.getBoolean(KEY_THEME_MODE, false);
    }
}
