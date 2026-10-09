@echo off
chcp 65001 >nul
setlocal enabledelayedexpansion
cd /d "%~dp0"
title JOBSCOUT OS - DIEU KHIEN 2D NHOM C

echo ================================================================================
echo    JOBSCOUT OS v2.0 - HE THONG KHOI DONG TU DONG DA MAY [FIT - TDC]
echo    DU AN: CONG TUYEN DUNG VIEC LAM JOBSCOUT [DO AN CUOI KY - NHOM C]
echo ================================================================================
echo.

:: 1. KIEM TRA VA KHOI TAO WP-CONFIG.PHP
if not exist "wp-config.php" (
    echo [*] Thieu file wp-config.php. Dang tu dong khoi tao tu wp-config-docker.php...
    if exist "wp-config-docker.php" (
        copy /y "wp-config-docker.php" "wp-config.php" >nul
        echo [+] Da tao xong wp-config.php!
    ) else if exist "wp-config-sample.php" (
        copy /y "wp-config-sample.php" "wp-config.php" >nul
        echo [+] Da tao xong wp-config.php tu mau sample!
    )
)

:: 2. KIEM TRA DOCKER DA CAI DAT CHUA
where docker >nul 2>&1
if errorlevel 1 (
    echo.
    echo ================================================================================
    echo  [LOI] KHONG TIM THAY DOCKER TREN MAY TINH NAY!
    echo.
    echo  Vui long tai va cai dat Docker Desktop tai:
    echo  https://www.docker.com/products/docker-desktop/
    echo.
    echo  Sau khi cai dat xong, hay khoi dong Docker Desktop roi chay lai start.bat!
    echo ================================================================================
    echo.
    pause
    exit /b 1
)

:: 3. KIEM TRA DOCKER DAEMON
docker info >nul 2>&1
if errorlevel 1 goto :start_docker_daemon
goto :docker_is_ready

:start_docker_daemon
echo [*] Docker daemon chua chay. Dang tim va bat Docker Desktop...
if exist "%ProgramFiles%\Docker\Docker\Docker Desktop.exe" (
    start "" "%ProgramFiles%\Docker\Docker\Docker Desktop.exe"
) else if exist "%LOCALAPPDATA%\Programs\Docker\Docker Desktop.exe" (
    start "" "%LOCALAPPDATA%\Programs\Docker\Docker Desktop.exe"
) else if exist "%ProgramFiles(x86)%\Docker\Docker\Docker Desktop.exe" (
    start "" "%ProgramFiles(x86)%\Docker\Docker\Docker Desktop.exe"
)

echo [*] Dang doi Docker Desktop san sang [co the mat 15-30 giay]...
set "DOCKER_COUNT=0"
:docker_wait_loop
timeout /t 2 /nobreak >nul
docker info >nul 2>&1
if not errorlevel 1 goto :docker_is_ready
set /a DOCKER_COUNT+=1
if !DOCKER_COUNT! lss 25 goto :docker_wait_loop

echo.
echo [CANH BAO] Docker Desktop chua san sang.
echo Vui long mo Docker Desktop va doi bieu tuong Docker chuyen sang mau xanh,
echo sau do nhan phim bat ky de tiep tuc...
pause

:docker_is_ready
echo [+] Docker daemon da san sang!

:: 4. KIEM TRA VIRTUAL HOST
set "HOSTS_FILE=%SystemRoot%\System32\drivers\etc\hosts"
findstr /i "wordpressc" "%HOSTS_FILE%" >nul 2>&1
if errorlevel 1 (
    echo [*] May chua co ten mien Virtual Host 'wordpressc' / 'wordpress.local'.
    echo [*] Dang goi setup-hosts.bat de cap nhat file hosts...
    if exist "%~dp0setup-hosts.bat" (
        powershell.exe -NoProfile -Command "Start-Process '%~dp0setup-hosts.bat' -Verb RunAs -Wait" 2>nul
    )
)

:: 5. KHOI DONG DOCKER CONTAINERS
echo [*] Dang khoi dong cac containers [wordpress_db, wordpress_app, wordpress_phpmyadmin]...
docker compose up -d
if errorlevel 1 (
    echo [LOI] Khong the khoi dong docker compose!
    pause
    exit /b 1
)

:: 6. DOI MYSQL ENGINE SAN SANG
echo [*] Dang kiem tra ket noi CSDL MySQL [Port 3307]...
set "DB_COUNT=0"
:mysql_wait_loop
docker exec wordpress_db mysqladmin ping -u root -prootpassword --silent >nul 2>&1
if not errorlevel 1 goto :mysql_is_ready
timeout /t 1 /nobreak >nul
set /a DB_COUNT+=1
if !DB_COUNT! lss 35 goto :mysql_wait_loop
echo [CANH BAO] MySQL mat nhieu thoi gian hon de khoi dong. Dang tiep tuc...
goto :check_db_content

:mysql_is_ready
echo [+] Co so du lieu MySQL da san sang!

:check_db_content
:: 7. KIEM TRA VA NAP CSDL LAN DAU NEU CLONE VE MAY MOI
docker exec wordpress_db mysql -u root -prootpassword -e "USE wordpress; SELECT COUNT(*) FROM wp_posts;" >nul 2>&1
if not errorlevel 1 (
    echo [+] CSDL JobScout da ton tai day du, du lieu duoc bao toan.
    goto :launch_menu
)

echo.
echo ================================================================================
echo  [+] PHAT HIEN LAN DAU KHOI CHAY TREN MAY MOI!
echo  [+] TU DONG NAP CSDL: 7 TRANG FIGMA, 25 VIEC LAM, 5 CONG TY, 6 ADMINS
echo ================================================================================
echo  [1/5] Dang nap du lieu CSDL goc [import_job_design_data.sql]...
docker cp "%~dp0import_job_design_data.sql" wordpress_db:/tmp/import_job_design_data.sql >nul 2>&1
docker exec wordpress_db mysql -u root -prootpassword --default-character-set=utf8mb4 wordpress -e "source /tmp/import_job_design_data.sql;" >nul 2>&1

echo  [2/5] Dang dong bo 6 tai khoan Administrator Nhom C [create_users.sql]...
docker cp "%~dp0create_users.sql" wordpress_db:/tmp/create_users.sql >nul 2>&1
docker exec wordpress_db mysql -u root -prootpassword --default-character-set=utf8mb4 wordpress -e "source /tmp/create_users.sql;" >nul 2>&1

echo  [3/5] Dang thiet lap thuong hieu JobScout va Front Page [setup_jobscout_brand.sql]...
docker cp "%~dp0setup_jobscout_brand.sql" wordpress_db:/tmp/setup_jobscout_brand.sql >nul 2>&1
docker exec wordpress_db mysql -u root -prootpassword --default-character-set=utf8mb4 wordpress -e "source /tmp/setup_jobscout_brand.sql;" >nul 2>&1

echo  [4/5] Dang kich hoat Theme JobScout va 5 Plugins [activate_theme_plugins.sql]...
docker cp "%~dp0activate_theme_plugins.sql" wordpress_db:/tmp/activate_theme_plugins.sql >nul 2>&1
docker exec wordpress_db mysql -u root -prootpassword --default-character-set=utf8mb4 wordpress -e "source /tmp/activate_theme_plugins.sql;" >nul 2>&1

echo  [5/5] Dang dong bo 5 Ho So Doanh Nghiep va lien ket 25 viec lam...
docker exec wordpress_app php sync_company_profiles.php >nul 2>&1

echo [+] Khoi tao CSDL lan dau hoan tat 100%!
echo.

:launch_menu
:: 8. KHOI DONG MENU TERMINAL 2D OS
echo [*] Dang mo Bang Dieu Khien JobScout OS 2D...
if exist "%~dp0menu.ps1" (
    powershell.exe -NoProfile -ExecutionPolicy Bypass -File "%~dp0menu.ps1"
    exit /b %errorlevel%
)

echo [LOI] Khong tim thay menu.ps1!
pause
exit /b 1
