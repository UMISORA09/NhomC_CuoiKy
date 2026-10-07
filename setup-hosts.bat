@echo off
chcp 65001 >nul
title Cấu hình Virtual Host WordPressC

:: Kiem tra quyen Administrator
net session >nul 2>&1
if %errorLevel% neq 0 (
    echo [!] Dang yeu cau quyen Administrator de cap nhat file hosts...
    powershell -Command "Start-Process '%~f0' -Verb RunAs"
    exit /b
)

set "HOSTS_FILE=%SystemRoot%\System32\drivers\etc\hosts"
echo [*] Dang kiem tra file hosts tai: %HOSTS_FILE%

findstr /i "wordpressc" "%HOSTS_FILE%" >nul
if %errorLevel% neq 0 (
    echo.>> "%HOSTS_FILE%"
    echo 127.0.0.1   wordpressc>> "%HOSTS_FILE%"
    echo 127.0.0.1   www.wordpressc>> "%HOSTS_FILE%"
    echo 127.0.0.1   wordpressc.local>> "%HOSTS_FILE%"
    echo 127.0.0.1   WordpressC.local>> "%HOSTS_FILE%"
    echo 127.0.0.1   www.WordpressC.local>> "%HOSTS_FILE%"
    echo [+] Da them thanh cong cac ten mien vao file hosts!
) else (
    echo [*] Ten mien wordpressc da ton tai trong file hosts.
)

ipconfig /flushdns >nul
echo.
echo ==============================================================
echo   DA CAU HINH XONG TEN MIEN VIRTUAL HOST CHO WINDOWS!
echo   - http://wordpressc:8080
echo   - http://wordpressc.local:8080
echo   - http://WordpressC.local:8080
echo ==============================================================
timeout /t 3 >nul
