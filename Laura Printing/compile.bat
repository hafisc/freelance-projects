@echo off
echo ====================================================
echo      Kompilasi Aplikasi - Laura Printing
echo ====================================================
if not exist bin mkdir bin
echo Sedang mengompilasi file Java...
"C:\Program Files\Android\Android Studio\jbr\bin\javac.exe" -d bin -cp "lib/*" -sourcepath src src/com/lauraprinting/App.java
if %errorlevel% neq 0 (
    echo.
    echo [ERROR] Kompilasi GAGAL! Silakan periksa kesalahan kode di atas.
    pause
    exit /b %errorlevel%
)
echo.
echo [SUKSES] Kompilasi Berhasil! File class disimpan di folder 'bin'.
echo ====================================================
