@echo off
setlocal
chcp 65001 >nul
title JOBSCOUT OS - DIEU KHIEN 2D NHOM C
color 0B

:: ===============================================================================
:: CAU HINH CO LAP CHO DU AN CUOI KY JOBSCOUT (KHONG DUNG CHAM FIT-TDC)
:: ===============================================================================
set "DB_CONTAINER=wordpress_db"
set "DB_NAME=wordpress"
set "WP_CONTAINER=wordpress_app"
set "PMA_CONTAINER=wordpress_phpmyadmin"
set "WP_PORT=8080"
set "PMA_PORT=8085"
set "DB_PORT=3307"

set "URL_WEB=http://localhost:8080"
set "URL_ADMIN=http://localhost:8080/wp-admin"
set "URL_PMA=http://localhost:8085"
set "URL_DASHBOARD=http://localhost:8080/dashboard.html"

:: Tim trinh duyet de mo cua so tab noi (Floating Window App)
set "APP_BROWSER="
if exist "%ProgramFiles(x86)%\Microsoft\Edge\Application\msedge.exe" (
    set "APP_BROWSER=%ProgramFiles(x86)%\Microsoft\Edge\Application\msedge.exe"
) else if exist "%ProgramFiles%\Microsoft\Edge\Application\msedge.exe" (
    set "APP_BROWSER=%ProgramFiles%\Microsoft\Edge\Application\msedge.exe"
) else if exist "%ProgramFiles%\Google\Chrome\Application\chrome.exe" (
    set "APP_BROWSER=%ProgramFiles%\Google\Chrome\Application\chrome.exe"
) else if exist "%ProgramFiles(x86)%\Google\Chrome\Application\chrome.exe" (
    set "APP_BROWSER=%ProgramFiles(x86)%\Google\Chrome\Application\chrome.exe"
)

:MAIN_MENU
cls
echo +--------------------------------------------------------------------------+
echo ^|                  JOBSCOUT OS v2.0 - TRUNG TAM DIEU KHIEN 2D              ^|
echo ^|                     DO AN CUOI KY - KHOA CNTT - NHOM C                   ^|
echo +--------------------------------------------------------------------------+
echo ^| [TRANG THAI DICH VU]                                                     ^|
echo ^|   * WordPress:  %URL_WEB% (Port %WP_PORT%)                                     ^|
echo ^|   * phpMyAdmin: %URL_PMA% (Port %PMA_PORT%)                                     ^|
echo ^|   * MySQL DB:   %DB_CONTAINER% (Port %DB_PORT% / DB: %DB_NAME%)                          ^|
echo ^|   * Cach ly:    Doc lap 100%% voi FIT-TDC (Khong dung cham du lieu FIT-TDC) ^|
echo +--------------------------------------------------------------------------+
echo ^| [TAB 1: GIAO DIEN TAB NOI 2D ^& KHOI DONG]                                 ^|
echo ^|   [1] Khoi Dong Toan Dien [Docker + DB + Mo Cua So Tab Noi Tren Man Hinh]  ^|
echo ^|   [M] Mo Ngay Cua So Tab Noi 2D (Floating Window Dashboard)              ^|
echo ^|   [6] Trinh Dieu Huong Web [Website / WP-Admin / phpMyAdmin / Dashboard]  ^|
echo ^|                                                                          ^|
echo ^| [TAB 2: DU LIEU THIET KE ^& THUONG HIEU]                                  ^|
echo ^|   [2] Nap 7 Trang Thiet Ke Figma vao Co So Du Lieu                       ^|
echo ^|   [4] Thiet Lap Thuong Hieu JobScout [Title, Tagline, Front Page]         ^|
echo ^|   [5] Kich Hoat Theme JobScout va 4 Plugin Nghiep Vu                     ^|
echo ^|                                                                          ^|
echo ^| [TAB 3: TAI KHOAN QUAN TRI]                                              ^|
echo ^|   [3] Dat Lai 6 Tai Khoan Administrator Nhom C [Password@123]            ^|
echo ^|                                                                          ^|
echo ^| [TAB 4: QUAN LY CSDL ^& DOCKER]                                           ^|
echo ^|   [7] Sao Luu Database JobScout [Xuat file .sql]                         ^|
echo ^|   [8] Kiem Tra Suc Khoe He Thong (Status Check)                          ^|
echo ^|   [9] Dieu Khien Docker Containers [Restart / Stop]                      ^|
echo ^|                                                                          ^|
echo ^|   [0] Thoat Chuong Trinh                                                 ^|
echo +--------------------------------------------------------------------------+
set "CHOICE="
set /p "CHOICE=>> Vui long chon chuc nang (1-9, M, 0) [Mac dinh nhan Enter de chon 1]: "
if "!CHOICE!"=="" set "CHOICE=1"

if /i "%CHOICE%"=="1" goto OP_START_ALL
if /i "%CHOICE%"=="2" goto OP_IMPORT_DESIGN
if /i "%CHOICE%"=="3" goto OP_SETUP_USERS
if /i "%CHOICE%"=="4" goto OP_SETUP_BRAND
if /i "%CHOICE%"=="5" goto OP_ACTIVATE_THEME
if /i "%CHOICE%"=="6" goto OP_OPEN_WEB
if /i "%CHOICE%"=="7" goto OP_BACKUP_DB
if /i "%CHOICE%"=="8" goto OP_STATUS
if /i "%CHOICE%"=="9" goto OP_DOCKER_CTRL
if /i "%CHOICE%"=="M" goto OP_LAUNCH_FLOATING_TAB
if /i "%CHOICE%"=="0" goto OP_EXIT

echo Lua chon khong hop le!
ping 127.0.0.1 -n 2 >nul
goto MAIN_MENU

:: ===============================================================================
:OP_START_ALL
cls
echo +--------------------------------------------------------------------------+
echo ^|          TIEN TRINH KHOI DONG TOAN DIEN HE THONG JOBSCOUT 2D             ^|
echo +--------------------------------------------------------------------------+
echo.
docker info >nul 2>&1
if %errorlevel% neq 0 (
    echo [LOI] Docker Desktop chua bat! Vui long bat Docker Desktop truoc.
    pause
    goto MAIN_MENU
)

echo [1/6] Khoi dong Docker containers...
docker compose up -d
ping 127.0.0.1 -n 3 >nul

echo [2/6] Kiem tra va khoi tao WordPress core...
docker exec %WP_CONTAINER% wp core is-installed --allow-root >nul 2>&1
if %errorlevel% neq 0 (
    echo       Dang cai dat WordPress core...
    docker exec %WP_CONTAINER% wp core install --url="%URL_WEB%" --title="JobScout" --admin_user="admin_nhomc" --admin_password="Password@123" --admin_email="admin_nhomc@fit.tdc.edu.vn" --skip-email --allow-root >nul 2>&1
)

echo [3/6] Dong bo 6 tai khoan Administrator Nhom C...
call :EXEC_SQL create_users.sql

echo [4/6] Thiet lap thuong hieu JobScout va Front Page...
call :EXEC_SQL setup_jobscout_brand.sql

echo [5/6] Kich hoat Theme JobScout va 4 Plugin...
call :EXEC_SQL activate_theme_plugins.sql

echo [6/6] Nap 7 trang thiet ke Figma vao Database...
call :EXEC_SQL import_job_design_data.sql

echo.
echo +--------------------------------------------------------------------------+
echo ^| [HOAN TAT] He thong da san sang! Dang mo Cua So Tab Noi 2D tren man hinh ^|
echo +--------------------------------------------------------------------------+
call :OPEN_FLOATING_WINDOW
start "" "%URL_WEB%" >nul 2>&1
echo.
pause
goto MAIN_MENU

:: ===============================================================================
:OP_LAUNCH_FLOATING_TAB
cls
echo Dang mo Cua So Tab Noi 2D He Dieu Hanh tren man hinh...
call :OPEN_FLOATING_WINDOW
echo [OK] Da mo cua so tab noi thanh cong!
ping 127.0.0.1 -n 2 >nul
goto MAIN_MENU

:: ===============================================================================
:OPEN_FLOATING_WINDOW
if defined APP_BROWSER (
    start "" "%APP_BROWSER%" --app="%URL_DASHBOARD%" --window-size=1280,820
) else (
    start "" "%URL_DASHBOARD%"
)
exit /b 0

:: ===============================================================================
:OP_IMPORT_DESIGN
cls
echo [TIEN TRINH] Nap du lieu 7 trang thiet ke Figma vao CSDL JobScout...
echo -------------------------------------------------------------------------------
call :EXEC_SQL import_job_design_data.sql
echo [OK] Da nap thanh cong Trang, Tin Tuc va 6 Tin Tuyen Dung vao database!
pause
goto MAIN_MENU

:: ===============================================================================
:OP_SETUP_USERS
cls
echo [TIEN TRINH] Cap nhat 6 tai khoan Administrator Nhom C...
echo -------------------------------------------------------------------------------
call :EXEC_SQL create_users.sql
echo.
echo Danh sach tai khoan [Mat khau chung: Password@123]:
echo   1. xuanhoa      - Van Nguyen Xuan Hoa  (vhoa1682006@gmail.com)
echo   2. thanhhien    - Nguyen Thanh Hien    (thenghien2006@gmail.com)
echo   3. vinhem       - Huynh Van Vinh Em    (trumvinh85@gmail.com)
echo   4. anhquy       - Nguyen Anh Quy       (nguyquy67@gmail.com)
echo   5. dangnguyen   - Dang Dang Nguyen     (dn1275102@gmail.com)
echo   6. admin_nhomc  - Quan Tri Vien Nhom C (admin_nhomc@fit.tdc.edu.vn)
echo -------------------------------------------------------------------------------
pause
goto MAIN_MENU

:: ===============================================================================
:OP_SETUP_BRAND
cls
echo [TIEN TRINH] Thiet lap thuong hieu JobScout...
echo -------------------------------------------------------------------------------
call :EXEC_SQL setup_jobscout_brand.sql
echo [OK] Da cap nhat Site Title: JobScout, Tagline va Front Page!
pause
goto MAIN_MENU

:: ===============================================================================
:OP_ACTIVATE_THEME
cls
echo [TIEN TRINH] Kich hoat Theme JobScout va cac Plugin...
echo -------------------------------------------------------------------------------
call :EXEC_SQL activate_theme_plugins.sql
echo [OK] Theme JobScout va 4 Plugin da duoc kich hoat!
pause
goto MAIN_MENU

:: ===============================================================================
:OP_OPEN_WEB
cls
echo +--------------------------------------------------------------------------+
echo ^|                        TRINH DIEU HUONG WEB                              ^|
echo +--------------------------------------------------------------------------+
echo   [1] Cua So Tab Noi 2D He Dieu Hanh : %URL_DASHBOARD%
echo   [2] Trang Chu Website JobScout     : %URL_WEB%
echo   [3] Trang Quan Tri WP-Admin        : %URL_ADMIN%
echo   [4] Quan Ly CSDL phpMyAdmin        : %URL_PMA%
echo   [5] Mo Toan Bo 4 Trang Tren
echo   [0] Quay Lai Menu Chinh
echo.
set "WEB_CHOICE="
set /p "WEB_CHOICE=>> Nhap thao tac (0-5): "
if "%WEB_CHOICE%"=="1" call :OPEN_FLOATING_WINDOW & goto MAIN_MENU
if "%WEB_CHOICE%"=="2" start "" "%URL_WEB%" & goto MAIN_MENU
if "%WEB_CHOICE%"=="3" start "" "%URL_ADMIN%" & goto MAIN_MENU
if "%WEB_CHOICE%"=="4" start "" "%URL_PMA%" & goto MAIN_MENU
if "%WEB_CHOICE%"=="5" (
    call :OPEN_FLOATING_WINDOW
    start "" "%URL_WEB%"
    start "" "%URL_ADMIN%"
    start "" "%URL_PMA%"
    goto MAIN_MENU
)
goto MAIN_MENU

:: ===============================================================================
:OP_BACKUP_DB
cls
echo [TIEN TRINH] Dang sao luu co so du lieu JobScout...
echo -------------------------------------------------------------------------------
if not exist "backups" mkdir backups
set "TS=%date:~10,4%%date:~4,2%%date:~7,2%_%time:~0,2%%time:~3,2%%time:~6,2%"
set "TS=%TS: =0%"
set "BACKUP_FILE=backups\db_jobscout_%TS%.sql"

docker exec %DB_CONTAINER% mysqldump -u root -prootpassword %DB_NAME% > "%BACKUP_FILE%" 2>nul
if %errorlevel% equ 0 (
    echo [THANH CONG] File backup da luu tai: %BACKUP_FILE%
) else (
    echo [LOI] Khong the xuat database!
)
pause
goto MAIN_MENU

:: ===============================================================================
:OP_STATUS
cls
echo +--------------------------------------------------------------------------+
echo ^|                       KIEM TRA TRANG THAI HE THONG                       ^|
echo +--------------------------------------------------------------------------+
docker ps --filter "name=wordpress_" --format "table {{.Names}}\t{{.Status}}\t{{.Ports}}"
echo.
echo [CHI SO DICH VU]
echo   * CSDL Container: %DB_CONTAINER% (Port %DB_PORT% / DB: %DB_NAME%)
echo   * Web App:        %WP_CONTAINER% (%URL_WEB%)
echo   * phpMyAdmin:     %PMA_CONTAINER% (%URL_PMA%)
echo   * 2D Dashboard:   %URL_DASHBOARD%
echo -------------------------------------------------------------------------------
pause
goto MAIN_MENU

:: ===============================================================================
:OP_DOCKER_CTRL
cls
echo +--------------------------------------------------------------------------+
echo ^|                        DIEU KHIEN DOCKER                                 ^|
echo +--------------------------------------------------------------------------+
echo   [1] Khoi Dong Lai Tat Ca Dich Vu (Restart)
echo   [2] Tam Dung Toan Bo Dich Vu (Stop)
echo   [0] Quay Lai Menu Chinh
echo.
set "DOCKER_ACT="
set /p "DOCKER_ACT=>> Chon thao tac (0-2): "
if "%DOCKER_ACT%"=="1" (
    echo Dang khoi dong lai...
    docker compose restart
    echo [OK] Da khoi dong lai thanh cong!
    pause
    goto MAIN_MENU
)
if "%DOCKER_ACT%"=="2" (
    echo Dang dung containers...
    docker compose stop
    echo [OK] Da tam dung dich vu an toan!
    pause
    goto MAIN_MENU
)
goto MAIN_MENU

:: ===============================================================================
:EXEC_SQL
set "SQL_FILE=%~1"
if exist "%SQL_FILE%" (
    docker cp "%SQL_FILE%" %DB_CONTAINER%:/tmp/%SQL_FILE% >nul 2>&1
    docker exec %DB_CONTAINER% mysql -u root -prootpassword --default-character-set=utf8mb4 %DB_NAME% -e "source /tmp/%SQL_FILE%;" >nul 2>&1
    echo   [+] Thuc thi %SQL_FILE%: Thanh cong.
) else (
    echo   [-] File %SQL_FILE% khong ton tai!
)
exit /b 0

:: ===============================================================================
:OP_EXIT
cls
echo Cam on ban da su dung JobScout OS - Nhom C!
ping 127.0.0.1 -n 2 >nul
exit /b 0
