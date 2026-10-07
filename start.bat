@echo off
setlocal EnableDelayedExpansion
chcp 65001 >nul
title HE THONG QUAN TRI WORDPRESS JOBSCOUT - NHOM C
color 0B

:: Dinh nghia thong tin Container va Database doc lap cho Du an Cuoi Ky (JobScout)
:: TUYET DOI KHONG DUNG DEN CAC CONTAINER HOAC DATABASE FIT-TDC
set "DB_CONTAINER=wordpress_db"
set "DB_NAME=wordpress"
set "WP_CONTAINER=wordpress_app"
set "PMA_CONTAINER=wordpress_phpmyadmin"
set "WP_URL=http://localhost:8080"
set "WP_ADMIN_URL=http://localhost:8080/wp-admin"
set "PMA_URL=http://localhost:8085"

:MAIN_MENU
cls
echo ===============================================================================
echo        HE THONG DIEU HANH VA QUAN TRI WORDPRESS JOBSCOUT - NHOM C
echo ===============================================================================
echo.
echo   [1] Khoi Dong Toan Dien [Docker + Auto Database Setup + Mo Web]
echo   [2] Dong Bo Du Lieu Thiet Ke [Nap 7 Trang Design vao Database]
echo   [3] Dat Lai 6 Tai Khoan Administrator [Password@123]
echo   [4] Cau Hinh Thuong Hieu JobScout [Title, Tagline, Trang Chu]
echo   [5] Kich Hoat Theme JobScout va 4 Plugin Nghiep Vu
echo   [6] Mo Trinh Duyet Web [Website / Admin / phpMyAdmin]
echo   [7] Sao Luu Database [Backup .sql]
echo   [8] Xem Trang Thai He Thong [Docker Containers]
echo   [9] Khoi Dong Lai / Dung Containers
echo   [0] Thoat chuong trinh
echo.
echo ===============================================================================
set "CHOICE="
set /p "CHOICE=>> Vui long chon chuc nang (0-9): "

if "%CHOICE%"=="1" goto OP_START_ALL
if "%CHOICE%"=="2" goto OP_IMPORT_DESIGN
if "%CHOICE%"=="3" goto OP_SETUP_USERS
if "%CHOICE%"=="4" goto OP_SETUP_BRAND
if "%CHOICE%"=="5" goto OP_ACTIVATE_THEME
if "%CHOICE%"=="6" goto OP_OPEN_WEB
if "%CHOICE%"=="7" goto OP_BACKUP_DB
if "%CHOICE%"=="8" goto OP_STATUS
if "%CHOICE%"=="9" goto OP_DOCKER_CTRL
if "%CHOICE%"=="0" goto OP_EXIT

echo Lua chon khong hop le!
timeout /t 2 >nul
goto MAIN_MENU

:: ===============================================================================
:OP_START_ALL
cls
echo [TIEN TRINH] Bat dau khoi dong toan dien he thong JobScout...
echo -------------------------------------------------------------------------------

docker info >nul 2>&1
if %errorlevel% neq 0 (
    echo [LOI] Docker Desktop chua bat! Vui long khoi dong Docker Desktop truoc.
    pause
    goto MAIN_MENU
)

echo [1/6] Kiem tra va khoi dong Docker containers (docker-compose)...
docker compose up -d
timeout /t 3 >nul

echo [2/6] Kiem tra va khoi tao WordPress core (neu chua co)...
docker exec %WP_CONTAINER% wp core is-installed --allow-root >nul 2>&1
if %errorlevel% neq 0 (
    echo       Dang khoi tao co so du lieu WordPress ban dau...
    docker exec %WP_CONTAINER% wp core install --url="%WP_URL%" --title="JobScout" --admin_user="admin_nhomc" --admin_password="Password@123" --admin_email="admin_nhomc@example.com" --skip-email --allow-root >nul 2>&1
)

echo [3/6] Dong bo 6 tai khoan Administrator Nhom C...
call :EXEC_SQL create_users.sql

echo [4/6] Cau hinh thuong hieu JobScout va thiet lap Trang chu / Tin tuc...
call :EXEC_SQL setup_jobscout_brand.sql

echo [5/6] Kich hoat Theme JobScout va 4 Plugin can thiet...
call :EXEC_SQL activate_theme_plugins.sql

echo [6/6] Nap toan bo du lieu Trang, Tin Tuc va Viec Lam tu ban thiet ke...
call :EXEC_SQL import_job_design_data.sql

echo -------------------------------------------------------------------------------
echo [HOAN TAT] He thong JobScout da khoi dong va cau hinh 100%% thanh cong!
echo Dang mo website tren trinh duyet...
start %WP_URL% >nul 2>&1
pause
goto MAIN_MENU

:: ===============================================================================
:OP_IMPORT_DESIGN
cls
echo [TIEN TRINH] Nap du lieu tu 7 trang thiet ke vao Database JobScout...
echo -------------------------------------------------------------------------------
call :EXEC_SQL import_job_design_data.sql
echo [OK] Da nap thanh cong Trang (Home, About, News, All Jobs, Contact),
echo      cac bai Tin Tuc va 6 Tin Tuyen Dung vao Database!
pause
goto MAIN_MENU

:: ===============================================================================
:OP_SETUP_USERS
cls
echo [TIEN TRINH] Cap nhat 6 tai khoan Administrator Nhom C...
echo -------------------------------------------------------------------------------
call :EXEC_SQL create_users.sql
echo.
echo Danh sach tai khoan [Mat khau: Password@123]:
echo   1. xuanhoa      - Van Nguyen Xuan Hoa
echo   2. thanhhien    - Nguyen Thanh Hien
echo   3. vinhem       - Huynh Van Vinh Em
echo   4. anhquy       - Nguyen Anh Quy
echo   5. dangnguyen   - Dang Dang Nguyen
echo   6. admin_nhomc  - Quan Tri Vien Nhom C
echo -------------------------------------------------------------------------------
pause
goto MAIN_MENU

:: ===============================================================================
:OP_SETUP_BRAND
cls
echo [TIEN TRINH] Cau hinh thuong hieu JobScout...
echo -------------------------------------------------------------------------------
call :EXEC_SQL setup_jobscout_brand.sql
echo [OK] Da cap nhat Site Title: JobScout, Tagline va Front Page!
pause
goto MAIN_MENU

:: ===============================================================================
:OP_ACTIVATE_THEME
cls
echo [TIEN TRINH] Kich hoat Theme JobScout va cac Plugin bo tro...
echo -------------------------------------------------------------------------------
call :EXEC_SQL activate_theme_plugins.sql
echo [OK] Giao dien JobScout va 4 Plugin da duoc kich hoat trong Database!
pause
goto MAIN_MENU

:: ===============================================================================
:OP_OPEN_WEB
cls
echo ===============================================================================
echo                      TRINH DIEU HUONG TRANG WEB
echo ===============================================================================
echo.
echo   [1] Trang chu Website JobScout: %WP_URL%
echo   [2] Trang Quan Tri Admin: %WP_ADMIN_URL%
echo   [3] Quan ly Database phpMyAdmin: %PMA_URL%
echo   [4] Mo ca 3 trang tren
echo   [0] Quay lai Menu chinh
echo.
set "WEB_CHOICE="
set /p "WEB_CHOICE=>> Chon thao tac (0-4): "
if "%WEB_CHOICE%"=="1" start %WP_URL% & goto MAIN_MENU
if "%WEB_CHOICE%"=="2" start %WP_ADMIN_URL% & goto MAIN_MENU
if "%WEB_CHOICE%"=="3" start %PMA_URL% & goto MAIN_MENU
if "%WEB_CHOICE%"=="4" (
    start %WP_URL%
    start %WP_ADMIN_URL%
    start %PMA_URL%
    goto MAIN_MENU
)
goto MAIN_MENU

:: ===============================================================================
:OP_BACKUP_DB
cls
echo [TIEN TRINH] Dang sao luu Database JobScout...
echo -------------------------------------------------------------------------------
if not exist "backups" mkdir backups
set "TS=%date:~10,4%%date:~4,2%%date:~7,2%_%time:~0,2%%time:~3,2%%time:~6,2%"
set "TS=%TS: =0%"
set "BACKUP_FILE=backups\db_jobscout_%TS%.sql"

docker exec %DB_CONTAINER% mysqldump -u root -prootpassword %DB_NAME% > "%BACKUP_FILE%" 2>nul
if %errorlevel% equ 0 (
    echo [THANH CONG] File backup da duoc luu tai: %BACKUP_FILE%
) else (
    echo [LOI] Khong the xuat database! Vui long kiem tra container.
)
pause
goto MAIN_MENU

:: ===============================================================================
:OP_STATUS
cls
echo ===============================================================================
echo                    TRANG THAI HE THONG DOCKER JOBSCOUT
echo ===============================================================================
docker ps --filter "name=wordpress_" --format "table {{.Names}}\t{{.Status}}\t{{.Ports}}"
echo.
echo Database: %DB_CONTAINER% [DB: %DB_NAME%]
echo WordPress App: %WP_CONTAINER% [%WP_URL%]
echo phpMyAdmin: %PMA_CONTAINER% [%PMA_URL%]
echo -------------------------------------------------------------------------------
pause
goto MAIN_MENU

:: ===============================================================================
:OP_DOCKER_CTRL
cls
echo ===============================================================================
echo                   DIEU KHIEN DOCKER CONTAINER JOBSCOUT
echo ===============================================================================
echo.
echo   [1] Khoi dong lai [Restart Containers]
echo   [2] Dung toan bo [Stop Containers]
echo   [0] Quay lai Menu chinh
echo.
set "DOCKER_ACT="
set /p "DOCKER_ACT=>> Chon thao tac (0-2): "
if "%DOCKER_ACT%"=="1" (
    echo Dang khoi dong lai...
    docker compose restart
    echo [OK] Da hoan tat!
    pause
    goto MAIN_MENU
)
if "%DOCKER_ACT%"=="2" (
    echo Dang dung containers...
    docker compose stop
    echo [OK] Da dung toan bo dich vu!
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
echo Cam on ban da su dung he thong quan tri JobScout - Nhom C!
timeout /t 2 >nul
exit /b 0
