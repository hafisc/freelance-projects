@echo off
echo ====================================================
echo      Menjalankan Aplikasi - Laura Printing
echo ====================================================
if not exist bin\com\lauraprinting\App.class (
    echo File kompilasi tidak ditemukan. Menjalankan kompilasi terlebih dahulu...
    call compile.bat
    if %errorlevel% neq 0 (
        echo.
        echo [ERROR] Gagal menjalankan aplikasi karena kompilasi gagal.
        pause
        exit /b %errorlevel%
    )
)
echo Menjalankan aplikasi dengan JRE 21...
"C:\Program Files\Android\Android Studio\jbr\bin\java.exe" -cp "bin;lib/*" com.lauraprinting.App
if %errorlevel% neq 0 (
    echo.
    echo [ERROR] Aplikasi berhenti dengan error code: %errorlevel%
    pause
)
