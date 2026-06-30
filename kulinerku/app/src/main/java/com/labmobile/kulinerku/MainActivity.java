package com.labmobile.kulinerku;

import android.os.Bundle;
import android.view.Menu;
import android.view.MenuItem;
import androidx.annotation.NonNull;
import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.app.AppCompatDelegate;
import androidx.core.view.ViewCompat;
import androidx.core.view.WindowInsetsCompat;
import androidx.constraintlayout.widget.ConstraintLayout;
import androidx.navigation.NavController;
import androidx.navigation.fragment.NavHostFragment;
import androidx.navigation.ui.NavigationUI;
import com.labmobile.kulinerku.databinding.ActivityMainBinding;
import com.labmobile.kulinerku.data.prefs.ThemePreference;

// Activity utama yang bertindak sebagai host NavHostFragment, bottom navigation, dan theme switcher
public class MainActivity extends AppCompatActivity {

    private ActivityMainBinding binding;
    private ThemePreference themePreference;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        // Inisialisasi preferensi tema sebelum memanggil super.onCreate
        themePreference = new ThemePreference(this);
        if (themePreference.isDarkMode()) {
            AppCompatDelegate.setDefaultNightMode(AppCompatDelegate.MODE_NIGHT_YES);
        } else {
            AppCompatDelegate.setDefaultNightMode(AppCompatDelegate.MODE_NIGHT_NO);
        }

        super.onCreate(savedInstanceState);
        binding = ActivityMainBinding.inflate(getLayoutInflater());
        setContentView(binding.getRoot());

        // Setup custom toolbar sebagai support action bar
        setSupportActionBar(binding.toolbar);

        // Setup Jetpack Navigation Component dengan Bottom Navigation View
        NavHostFragment navHostFragment = (NavHostFragment) getSupportFragmentManager()
                .findFragmentById(R.id.nav_host_fragment);
        if (navHostFragment != null) {
            NavController navController = navHostFragment.getNavController();
            NavigationUI.setupWithNavController(binding.bottomNavigation, navController);
            NavigationUI.setupActionBarWithNavController(this, navController);
        }

        // Mengatur margin bawah bottom navigation secara dinamis agar pas di atas system navigation bar
        ViewCompat.setOnApplyWindowInsetsListener(binding.bottomNavigation, (v, insets) -> {
            int bottomInset = insets.getInsets(WindowInsetsCompat.Type.navigationBars()).bottom;
            ConstraintLayout.LayoutParams params = (ConstraintLayout.LayoutParams) v.getLayoutParams();
            int margin12dp = (int) (12 * v.getResources().getDisplayMetrics().density);
            params.bottomMargin = bottomInset + margin12dp;
            v.setLayoutParams(params);
            return WindowInsetsCompat.CONSUMED;
        });
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate menu toolbar untuk menampilkan tombol switch tema
        getMenuInflater().inflate(R.menu.toolbar_menu, menu);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(@NonNull MenuItem item) {
        // Handle klik tombol switch tema pada toolbar
        if (item.getItemId() == R.id.action_toggle_theme) {
            boolean isDark = themePreference.isDarkMode();
            themePreference.setDarkMode(!isDark);
            if (!isDark) {
                AppCompatDelegate.setDefaultNightMode(AppCompatDelegate.MODE_NIGHT_YES);
            } else {
                AppCompatDelegate.setDefaultNightMode(AppCompatDelegate.MODE_NIGHT_NO);
            }
            return true;
        }
        return super.onOptionsItemSelected(item);
    }

    @Override
    public boolean onSupportNavigateUp() {
        // Handle navigasi back up di action bar
        NavHostFragment navHostFragment = (NavHostFragment) getSupportFragmentManager()
                .findFragmentById(R.id.nav_host_fragment);
        if (navHostFragment != null) {
            NavController navController = navHostFragment.getNavController();
            return navController.navigateUp() || super.onSupportNavigateUp();
        }
        return super.onSupportNavigateUp();
    }
}