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

:: Khoi tao tab mac dinh
set "CURRENT_TAB=1"

:RENDER_MENU
cls
echo +=============================================================================+
echo ^|            JOBSCOUT OS v2.0 - BANG DIEU KHIEN 2D CO TAB RIENG BIET        ^|
echo ^|                   DO AN CUOI KY - KHOA CNTT - NHOM C                      ^|
echo +=============================================================================+
echo ^| Ports: Web :8080 ^| PMA :8085 ^| MySQL :3307 ^| DB: %DB_NAME%                  ^|
echo ^| Cach ly FIT-TDC: 100%% Doc Lap (Khong dung cham du lieu FIT-TDC)           ^|
echo +=============================================================================+

if "%CURRENT_TAB%"=="1" goto SHOW_TAB_1
if "%CURRENT_TAB%"=="2" goto SHOW_TAB_2
if "%CURRENT_TAB%"=="3" goto SHOW_TAB_3
if "%CURRENT_TAB%"=="4" goto SHOW_TAB_4
goto SHOW_TAB_1

:SHOW_TAB_1
echo ^| == [TAB 1: TONG QUAN] == ^|    TAB 2: DU LIEU    ^|    TAB 3: ADMIN       ^|
echo ^|                          ^|    TAB 4: CSDL ^& DOCKER                      ^|
echo +-----------------------------------------------------------------------------+
echo ^|                                                                             ^|
echo ^|  [A] KHOI DONG TOAN DIEN [Docker + CSDL + Mo Tab Noi 2D Tren Man Hinh]      ^|
echo ^|  [M] MO NGAY CUA SO TAB NOI 2D (Floating 2D OS Dashboard)                   ^|
echo ^|  [W] Mo Trang Chu Website JobScout (%URL_WEB%)                              ^|
echo ^|  [P] Mo phpMyAdmin Quan Ly CSDL (%URL_PMA%)                                 ^|
echo ^|  [S] Kiem Tra Suc Khoe ^& Trang Thai Containers                             ^|
echo ^|                                                                             ^|
goto SHOW_TAB_FOOTER

:SHOW_TAB_2
echo ^|     TAB 1: TONG QUAN     ^| == [TAB 2: DU LIEU] == ^|    TAB 3: ADMIN     ^|
echo ^|                          ^|     TAB 4: CSDL ^& DOCKER                     ^|
echo +-----------------------------------------------------------------------------+
echo ^|                                                                             ^|
echo ^|  [F] Nap 7 Trang Thiet Ke Figma vao Database (Home, About, News, Jobs...)   ^|
echo ^|  [B] Thiet Lap Nhan Dien Thuong Hieu JobScout ^& Front Page                  ^|
echo ^|  [K] Kich Hoat Theme JobScout va 4 Plugin Nghiep Vu                         ^|
echo ^|  [V] Mo Xem Trang Du Lieu Thiet Ke Tren Trinh Duyet                         ^|
echo ^|                                                                             ^|
goto SHOW_TAB_FOOTER

:SHOW_TAB_3
echo ^|     TAB 1: TONG QUAN     ^|     TAB 2: DU LIEU     ^| == [TAB 3: ADMIN] == ^|
echo ^|                          ^|     TAB 4: CSDL ^& DOCKER                     ^|
echo +-----------------------------------------------------------------------------+
echo ^|                                                                             ^|
echo ^|  [U] Cap Nhat ^& Dat Lai 6 Tai Khoan Administrator [Password@123]            ^|
echo ^|  [L] Xem Danh Sach 6 Quan Tri Vien (Ho ten, Username, Email, Mat khau)      ^|
echo ^|  [G] Mo Trang Dang Nhap WP-Admin (%URL_ADMIN%)                              ^|
echo ^|                                                                             ^|
goto SHOW_TAB_FOOTER

:SHOW_TAB_4
echo ^|     TAB 1: TONG QUAN     ^|     TAB 2: DU LIEU     ^|     TAB 3: ADMIN     ^|
echo ^|                          ^| == [TAB 4: CSDL ^& DOCKER] ==                 ^|
echo +-----------------------------------------------------------------------------+
echo ^|                                                                             ^|
echo ^|  [X] Sao Luu Co So Du Lieu (.sql vao thu muc backups/)                      ^|
echo ^|  [R] Khoi Dong Lai Tat Ca Containers (Restart Docker)                       ^|
echo ^|  [Q] Tam Dung Tat Ca Dich Vu Containers (Stop Docker)                       ^|
echo ^|  [S] Kiem Tra Chi Tiet Cong ^& Trinh Trang Container                         ^|
echo ^|                                                                             ^|
goto SHOW_TAB_FOOTER

:SHOW_TAB_FOOTER

echo +-----------------------------------------------------------------------------+
echo ^|  CHUYEN TAB : Go [1] Tong Quan ^| [2] Du Lieu ^| [3] Admin ^| [4] Docker ^& DB ^|
echo ^|  THAO TAC   : Go ma chu cai [A, M, W, P, F, U, X...] hoac [0] Thoat          ^|
echo +-----------------------------------------------------------------------------+

set "CHOICE="
if "%CURRENT_TAB%"=="1" (
    set /p "CHOICE=>> Nhap lua chon (Chon Tab 1-4 / Thao tac / Enter de Khoi dong [A]): "
    if "!CHOICE!"=="" set "CHOICE=A"
) else (
    set /p "CHOICE=>> Nhap lua chon (Chon Tab 1-4 / Thao tac ma chu cai / [0] Thoat): "
    if "!CHOICE!"=="" goto RENDER_MENU
)

:: Chuyen tab
if "%CHOICE%"=="1" set "CURRENT_TAB=1" & goto RENDER_MENU
if "%CHOICE%"=="2" set "CURRENT_TAB=2" & goto RENDER_MENU
if "%CHOICE%"=="3" set "CURRENT_TAB=3" & goto RENDER_MENU
if "%CHOICE%"=="4" set "CURRENT_TAB=4" & goto RENDER_MENU

:: Thao tac chuc nang
if /i "%CHOICE%"=="A" goto OP_START_ALL
if /i "%CHOICE%"=="M" goto OP_LAUNCH_FLOATING_TAB
if /i "%CHOICE%"=="W" start "" "%URL_WEB%" & goto RENDER_MENU
if /i "%CHOICE%"=="P" start "" "%URL_PMA%" & goto RENDER_MENU
if /i "%CHOICE%"=="S" goto OP_STATUS
if /i "%CHOICE%"=="F" goto OP_IMPORT_DESIGN
if /i "%CHOICE%"=="B" goto OP_SETUP_BRAND
if /i "%CHOICE%"=="K" goto OP_ACTIVATE_THEME
if /i "%CHOICE%"=="V" start "" "%URL_WEB%/about-us" & start "" "%URL_WEB%/all-jobs" & goto RENDER_MENU
if /i "%CHOICE%"=="U" goto OP_SETUP_USERS
if /i "%CHOICE%"=="L" goto OP_LIST_USERS
if /i "%CHOICE%"=="G" start "" "%URL_ADMIN%" & goto RENDER_MENU
if /i "%CHOICE%"=="X" goto OP_BACKUP_DB
if /i "%CHOICE%"=="R" goto OP_DOCKER_RESTART
if /i "%CHOICE%"=="Q" goto OP_DOCKER_STOP
if /i "%CHOICE%"=="0" goto OP_EXIT

echo Lua chon khong hop le!
ping 127.0.0.1 -n 2 >nul
goto RENDER_MENU

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
    goto RENDER_MENU
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
goto RENDER_MENU

:: ===============================================================================
:OP_LAUNCH_FLOATING_TAB
cls
echo Dang mo Cua So Tab Noi 2D He Dieu Hanh tren man hinh...
call :OPEN_FLOATING_WINDOW
echo [OK] Da mo cua so tab noi thanh cong!
ping 127.0.0.1 -n 2 >nul
goto RENDER_MENU

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
goto RENDER_MENU

:: ===============================================================================
:OP_SETUP_USERS
cls
echo [TIEN TRINH] Cap nhat 6 tai khoan Administrator Nhom C...
echo -------------------------------------------------------------------------------
call :EXEC_SQL create_users.sql
echo [OK] Da cap nhat 6 tai khoan Administrator thanh cong!
pause
goto RENDER_MENU

:: ===============================================================================
:OP_LIST_USERS
cls
echo +--------------------------------------------------------------------------+
echo ^|                DANH SACH 6 TAI KHOAN QUAN TRI VIEN NHOM C                ^|
echo +--------------------------------------------------------------------------+
echo.
echo   1. xuanhoa      - Van Nguyen Xuan Hoa  (vhoa1682006@gmail.com)
echo   2. thanhhien    - Nguyen Thanh Hien    (thenghien2006@gmail.com)
echo   3. vinhem       - Huynh Van Vinh Em    (trumvinh85@gmail.com)
echo   4. anhquy       - Nguyen Anh Quy       (nguyquy67@gmail.com)
echo   5. dangnguyen   - Dang Dang Nguyen     (dn1275102@gmail.com)
echo   6. admin_nhomc  - Quan Tri Vien Nhom C (admin_nhomc@fit.tdc.edu.vn)
echo.
echo   * Mat khau dang nhap chung: Password@123
echo -------------------------------------------------------------------------------
pause
goto RENDER_MENU

:: ===============================================================================
:OP_SETUP_BRAND
cls
echo [TIEN TRINH] Thiet lap thuong hieu JobScout...
echo -------------------------------------------------------------------------------
call :EXEC_SQL setup_jobscout_brand.sql
echo [OK] Da cap nhat Site Title: JobScout, Tagline va Front Page!
pause
goto RENDER_MENU

:: ===============================================================================
:OP_ACTIVATE_THEME
cls
echo [TIEN TRINH] Kich hoat Theme JobScout va cac Plugin...
echo -------------------------------------------------------------------------------
call :EXEC_SQL activate_theme_plugins.sql
echo [OK] Theme JobScout va 4 Plugin da duoc kich hoat!
pause
goto RENDER_MENU

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
goto RENDER_MENU

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
goto RENDER_MENU

:: ===============================================================================
:OP_DOCKER_RESTART
cls
echo Dang khoi dong lai cac containers...
docker compose restart
echo [OK] Da khoi dong lai thanh cong!
pause
goto RENDER_MENU

:: ===============================================================================
:OP_DOCKER_STOP
cls
echo Dang tam dung cac containers...
docker compose stop
echo [OK] Da tam dung dich vu an toan!
pause
goto RENDER_MENU

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
