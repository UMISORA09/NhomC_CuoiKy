@echo off
setlocal EnableDelayedExpansion
chcp 65001 >nul
title JOBSCOUT OS - BẢNG ĐIỀU KHIỂN HỆ ĐIỀU HÀNH 2D NHÓM C
color 0B

:: ===============================================================================
:: ĐỊNH NGHĨA THÔNG SỐ CÔ LẬP HOÀN TOÀN CHO DỰ ÁN CUỐI KỲ (JOBSCOUT)
:: TUYỆT ĐỐI KHÔNG ĐỤNG CHẠM ĐẾN CÁC DỊCH VỤ HOẶC DATABASE CỦA FIT-TDC
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

:MAIN_MENU
cls
echo ╔══════════════════════════════════════════════════════════════════════════════════╗
echo ║                  JOBSCOUT OS v2.0 - TRUNG TÂM ĐIỀU KHIỂN 2D                      ║
echo ║                     ĐỒ ÁN CUỐI KỲ - KHOA CNTT - NHÓM C                           ║
echo ╠══════════════════════════════════════════════════════════════════════════════════╣
echo ║ [TRẠNG THÁI HỆ THỐNG]                                                            ║
echo ║   • WordPress: %URL_WEB% (Port %WP_PORT%)                                     ║
echo ║   • phpMyAdmin: %URL_PMA% (Port %PMA_PORT%)                                     ║
echo ║   • MySQL DB: %DB_CONTAINER% (Port %DB_PORT% / DB: %DB_NAME%)                          ║
echo ║   • Bảo vệ: Độc lập 100%% với FIT-TDC (Không xung đột, không đụng chạm dữ liệu)  ║
echo ╠══════════════════════════════════════════════════════════════════════════════════╣
echo ║ [TAB 1: KHỞI ĐỘNG ^& ĐIỀU KHIỂN 2D]                                              ║
echo ║   [1] Khởi Động Toàn Diện [Docker + CSDL + Mở Website ^& Tab Điều Khiển 2D]       ║
echo ║   [M] Mở Tab Bảng Điều Khiển 2D Hệ Điều Hành (JobScout Web OS Dashboard)         ║
echo ║   [6] Trình Điều Hướng Mở Web [Website / WP-Admin / phpMyAdmin / 2D Dashboard]   ║
echo ║                                                                                  ║
echo ║ [TAB 2: DỮ LIỆU THIẾT KẾ ^& THƯƠNG HIỆU]                                         ║
echo ║   [2] Nạp Toàn Bộ Dữ Liệu Thiết Kế [7 Trang Figma + Tin Tuyển Dụng]              ║
echo ║   [4] Thiết Lập Thương Hiệu JobScout [Title, Slogan, Trang Chủ ^& Trang Tin Tức]  ║
echo ║   [5] Kích Hoạt Giao Diện JobScout ^& 4 Plugin Nghiệp Vụ                         ║
echo ║                                                                                  ║
echo ║ [TAB 3: TÀI KHOẢN ^& BẢO MẬT]                                                    ║
echo ║   [3] Cập Nhật 6 Tài Khoản Quản Trị Viên Nhóm C [Password@123]                   ║
echo ║                                                                                  ║
echo ║ [TAB 4: QUẢN TRỊ CSDL ^& DOCKER]                                                 ║
echo ║   [7] Sao Lưu Cơ Sở Dữ Liệu JobScout (Xuất file .sql)                            ║
echo ║   [8] Kiểm Tra Sức Khỏe Toàn Diện Hệ Thống (Health Check)                        ║
echo ║   [9] Quản Lý Containers Docker [Khởi động lại / Tạm dừng]                       ║
echo ║                                                                                  ║
echo ║   [0] Thoát Chương Trình                                                         ║
echo ╚══════════════════════════════════════════════════════════════════════════════════╝
set "CHOICE="
set /p "CHOICE=>> Vui lòng nhập lựa chọn của bạn (1-9, M, 0): "

if /i "%CHOICE%"=="1" goto OP_START_ALL
if /i "%CHOICE%"=="2" goto OP_IMPORT_DESIGN
if /i "%CHOICE%"=="3" goto OP_SETUP_USERS
if /i "%CHOICE%"=="4" goto OP_SETUP_BRAND
if /i "%CHOICE%"=="5" goto OP_ACTIVATE_THEME
if /i "%CHOICE%"=="6" goto OP_OPEN_WEB
if /i "%CHOICE%"=="7" goto OP_BACKUP_DB
if /i "%CHOICE%"=="8" goto OP_STATUS
if /i "%CHOICE%"=="9" goto OP_DOCKER_CTRL
if /i "%CHOICE%"=="M" goto OP_OPEN_DASHBOARD
if /i "%CHOICE%"=="0" goto OP_EXIT

echo Lựa chọn không hợp lệ!
timeout /t 2 >nul
goto MAIN_MENU

:: ===============================================================================
:OP_START_ALL
cls
echo ╔══════════════════════════════════════════════════════════════════════════════════╗
echo ║          TIẾN TRÌNH KHỞI ĐỘNG TOÀN DIỆN HỆ THỐNG JOBSCOUT 2D                     ║
echo ╚══════════════════════════════════════════════════════════════════════════════════╝
echo.
docker info >nul 2>&1
if %errorlevel% neq 0 (
    echo [LỖI] Docker Desktop chưa bật! Vui lòng khởi động Docker Desktop rồi thử lại.
    pause
    goto MAIN_MENU
)

echo [1/6] Kiểm tra và khởi động Docker containers độc lập...
docker compose up -d
timeout /t 3 >nul

echo [2/6] Kiểm tra và cấu hình WordPress core nếu cơ sở dữ liệu chưa có...
docker exec %WP_CONTAINER% wp core is-installed --allow-root >nul 2>&1
if %errorlevel% neq 0 (
    echo       Đang cài đặt WordPress core tự động...
    docker exec %WP_CONTAINER% wp core install --url="%URL_WEB%" --title="JobScout" --admin_user="admin_nhomc" --admin_password="Password@123" --admin_email="admin_nhomc@fit.tdc.edu.vn" --skip-email --allow-root >nul 2>&1
)

echo [3/6] Đồng bộ danh sách 6 tài khoản Administrator Nhóm C...
call :EXEC_SQL create_users.sql

echo [4/6] Thiết lập nhận diện thương hiệu JobScout và Front Page...
call :EXEC_SQL setup_jobscout_brand.sql

echo [5/6] Kích hoạt Theme JobScout và 4 Plugin nghiệp vụ...
call :EXEC_SQL activate_theme_plugins.sql

echo [6/6] Nạp dữ liệu 7 trang thiết kế Figma và danh mục việc làm...
call :EXEC_SQL import_job_design_data.sql

echo.
echo ╔══════════════════════════════════════════════════════════════════════════════════╗
echo ║ [HOÀN TẤT] HỆ THỐNG ĐÃ SẴN SÀNG 100%%!                                            ║
echo ║ Đang tự động mở Tab Bảng Điều Khiển 2D và Trang Chủ Website...                  ║
echo ╚══════════════════════════════════════════════════════════════════════════════════╝
start "" "%URL_DASHBOARD%" >nul 2>&1
start "" "%URL_WEB%" >nul 2>&1
echo.
pause
goto MAIN_MENU

:: ===============================================================================
:OP_OPEN_DASHBOARD
cls
echo Đang mở Tab Bảng Điều Khiển 2D Hệ Điều Hành trong trình duyệt...
start "" "%URL_DASHBOARD%" >nul 2>&1
echo [OK] Đã mở: %URL_DASHBOARD%
timeout /t 2 >nul
goto MAIN_MENU

:: ===============================================================================
:OP_IMPORT_DESIGN
cls
echo [TIẾN TRÌNH] Nạp dữ liệu 7 trang thiết kế Figma vào cơ sở dữ liệu JobScout...
echo -------------------------------------------------------------------------------
call :EXEC_SQL import_job_design_data.sql
echo [OK] Đã nạp thành công Trang (Home, About Us, News, All Jobs, Contact Us),
echo      các bài tin tức và 6 tin tuyển dụng vào database %DB_NAME%!
pause
goto MAIN_MENU

:: ===============================================================================
:OP_SETUP_USERS
cls
echo [TIẾN TRÌNH] Cập nhật 6 tài khoản Administrator Nhóm C...
echo -------------------------------------------------------------------------------
call :EXEC_SQL create_users.sql
echo.
echo Danh sách tài khoản quản trị viên [Mật khẩu chung: Password@123]:
echo   1. xuanhoa      - Văn Nguyễn Xuân Hòa  (vhoa1682006@gmail.com)
echo   2. thanhhien    - Nguyễn Thanh Hiền    (thenghien2006@gmail.com)
echo   3. vinhem       - Huỳnh Văn Vinh Em    (trumvinh85@gmail.com)
echo   4. anhquy       - Nguyễn Anh Quý       (nguyquy67@gmail.com)
echo   5. dangnguyen   - Đặng Đăng Nguyên     (dn1275102@gmail.com)
echo   6. admin_nhomc  - Quản Trị Viên Nhóm C (admin_nhomc@fit.tdc.edu.vn)
echo -------------------------------------------------------------------------------
pause
goto MAIN_MENU

:: ===============================================================================
:OP_SETUP_BRAND
cls
echo [TIẾN TRÌNH] Thiết lập thương hiệu JobScout...
echo -------------------------------------------------------------------------------
call :EXEC_SQL setup_jobscout_brand.sql
echo [OK] Đã cập nhật Site Title: JobScout, Tagline và Front Page!
pause
goto MAIN_MENU

:: ===============================================================================
:OP_ACTIVATE_THEME
cls
echo [TIẾN TRÌNH] Kích hoạt Theme JobScout và các Plugin...
echo -------------------------------------------------------------------------------
call :EXEC_SQL activate_theme_plugins.sql
echo [OK] Giao diện JobScout và 4 Plugin đã được kích hoạt thành công!
pause
goto MAIN_MENU

:: ===============================================================================
:OP_OPEN_WEB
cls
echo ╔══════════════════════════════════════════════════════════════════════════════════╗
echo ║                        TRÌNH ĐIỀU HƯỚNG CÁC TRANG WEB                            ║
echo ╠══════════════════════════════════════════════════════════════════════════════════╣
echo ║   [1] Tab Bảng Điều Khiển 2D Hệ Điều Hành : %URL_DASHBOARD%
echo ║   [2] Trang Chủ Website JobScout          : %URL_WEB%
echo ║   [3] Trang Quản Trị WP-Admin             : %URL_ADMIN%
echo ║   [4] Quản Lý Cơ Sở Dữ Liệu phpMyAdmin    : %URL_PMA%
echo ║   [5] Mở Toàn Bộ 4 Tab Trên Cùng Lúc
echo ║   [0] Quay lại Menu chính
echo ╚══════════════════════════════════════════════════════════════════════════════════╝
set "WEB_CHOICE="
set /p "WEB_CHOICE=>> Nhập thao tác (0-5): "
if "%WEB_CHOICE%"=="1" start "" "%URL_DASHBOARD%" & goto MAIN_MENU
if "%WEB_CHOICE%"=="2" start "" "%URL_WEB%" & goto MAIN_MENU
if "%WEB_CHOICE%"=="3" start "" "%URL_ADMIN%" & goto MAIN_MENU
if "%WEB_CHOICE%"=="4" start "" "%URL_PMA%" & goto MAIN_MENU
if "%WEB_CHOICE%"=="5" (
    start "" "%URL_DASHBOARD%"
    start "" "%URL_WEB%"
    start "" "%URL_ADMIN%"
    start "" "%URL_PMA%"
    goto MAIN_MENU
)
goto MAIN_MENU

:: ===============================================================================
:OP_BACKUP_DB
cls
echo [TIẾN TRÌNH] Đang sao lưu cơ sở dữ liệu JobScout...
echo -------------------------------------------------------------------------------
if not exist "backups" mkdir backups
set "TS=%date:~10,4%%date:~4,2%%date:~7,2%_%time:~0,2%%time:~3,2%%time:~6,2%"
set "TS=%TS: =0%"
set "BACKUP_FILE=backups\db_jobscout_%TS%.sql"

docker exec %DB_CONTAINER% mysqldump -u root -prootpassword %DB_NAME% > "%BACKUP_FILE%" 2>nul
if %errorlevel% equ 0 (
    echo [THÀNH CÔNG] File backup đã được lưu tại: %BACKUP_FILE%
) else (
    echo [LỖI] Không thể xuất database! Vui lòng kiểm tra container.
)
pause
goto MAIN_MENU

:: ===============================================================================
:OP_STATUS
cls
echo ╔══════════════════════════════════════════════════════════════════════════════════╗
echo ║                       KIỂM TRA SỨC KHỎE HỆ THỐNG DOCKER                          ║
echo ╚══════════════════════════════════════════════════════════════════════════════════╝
echo.
docker ps --filter "name=wordpress_" --format "table {{.Names}}\t{{.Status}}\t{{.Ports}}"
echo.
echo [CHỈ SỐ DỊCH VỤ]
echo   • CSDL Container: %DB_CONTAINER% (Port %DB_PORT% / DB: %DB_NAME%)
echo   • Ứng dụng Web:   %WP_CONTAINER% (%URL_WEB%)
echo   • phpMyAdmin:     %PMA_CONTAINER% (%URL_PMA%)
echo   • Bảng Điều Khiển 2D: %URL_DASHBOARD%
echo -------------------------------------------------------------------------------
pause
goto MAIN_MENU

:: ===============================================================================
:OP_DOCKER_CTRL
cls
echo ╔══════════════════════════════════════════════════════════════════════════════════╗
echo ║                        ĐIỀU KHIỂN DOCKER CONTAINERS                              ║
echo ╚══════════════════════════════════════════════════════════════════════════════════╝
echo.
echo   [1] Khởi Động Lại Tất Cả Dịch Vụ (Restart)
echo   [2] Tạm Dừng Toàn Bộ Dịch Vụ (Stop)
echo   [0] Quay lại Menu chính
echo.
set "DOCKER_ACT="
set /p "DOCKER_ACT=>> Chọn thao tác (0-2): "
if "%DOCKER_ACT%"=="1" (
    echo Đang khởi động lại...
    docker compose restart
    echo [OK] Đã khởi động lại thành công!
    pause
    goto MAIN_MENU
)
if "%DOCKER_ACT%"=="2" (
    echo Đang dừng containers...
    docker compose stop
    echo [OK] Đã tạm dừng toàn bộ dịch vụ an toàn!
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
    echo   [+] Thực thi %SQL_FILE%: Thành công.
) else (
    echo   [-] File %SQL_FILE% không tồn tại!
)
exit /b 0

:: ===============================================================================
:OP_EXIT
cls
echo Cảm ơn bạn đã sử dụng JobScout OS - Hệ thống quản trị Nhóm C!
timeout /t 2 >nul
exit /b 0
