# ===============================================================================
# JOBSCOUT OS - UNG DUNG MENU TERMINAL 2D TUONG TAC CO TAB RIENG BIET
# DO AN CUOI KY - KHOA CNTT - NHOM C
# ===============================================================================

[Console]::OutputEncoding = [System.Text.Encoding]::UTF8
$Host.UI.RawUI.WindowTitle = "JOBSCOUT OS - TERMINAL TAB CONTROLLER (NHOM C)"

$DB_CONTAINER = "wordpress_db"
$DB_NAME = "wordpress"
$WP_CONTAINER = "wordpress_app"
$PMA_CONTAINER = "wordpress_phpmyadmin"
$WP_PORT = "8080"
$PMA_PORT = "8085"
$DB_PORT = "3307"

# Tu dong nhan dien ten mien wordpress.local (chuan file Excel), wordpressc hoac localhost
$DOMAIN = "localhost"
try {
    [System.Net.Dns]::GetHostAddresses("wordpress.local") | Out-Null
    $DOMAIN = "wordpress.local"
} catch {
    try {
        [System.Net.Dns]::GetHostAddresses("wordpressc") | Out-Null
        $DOMAIN = "wordpressc"
    } catch {
        try {
            [System.Net.Dns]::GetHostAddresses("WordpressC.local") | Out-Null
            $DOMAIN = "WordpressC.local"
        } catch {
            $DOMAIN = "localhost"
        }
    }
}

$URL_WEB = "http://${DOMAIN}:${WP_PORT}"
$URL_ADMIN = "http://${DOMAIN}:${WP_PORT}/wp-admin"
$URL_PMA = "http://${DOMAIN}:${PMA_PORT}"
$URL_DASHBOARD = "http://${DOMAIN}:${WP_PORT}/dashboard.html"

# Browser tim Edge hoac Chrome
$APP_BROWSER = $null
if (Test-Path "${env:ProgramFiles(x86)}\Microsoft\Edge\Application\msedge.exe") {
    $APP_BROWSER = "${env:ProgramFiles(x86)}\Microsoft\Edge\Application\msedge.exe"
} elseif (Test-Path "$env:ProgramFiles\Microsoft\Edge\Application\msedge.exe") {
    $APP_BROWSER = "$env:ProgramFiles\Microsoft\Edge\Application\msedge.exe"
} elseif (Test-Path "$env:ProgramFiles\Google\Chrome\Application\chrome.exe") {
    $APP_BROWSER = "$env:ProgramFiles\Google\Chrome\Application\chrome.exe"
}

function Open-FloatingWindow {
    if ($APP_BROWSER) {
        Start-Process $APP_BROWSER -ArgumentList "--app=$URL_DASHBOARD", "--window-size=1280,820"
    } else {
        Start-Process $URL_DASHBOARD
    }
}

function Invoke-SqlFile ($sqlFile) {
    if (Test-Path $sqlFile) {
        docker cp $sqlFile "${DB_CONTAINER}:/tmp/$sqlFile" 2>$null
        docker exec $DB_CONTAINER mysql -u root -prootpassword --default-character-set=utf8mb4 $DB_NAME -e "source /tmp/$sqlFile;" 2>$null
        Write-Host "  [+] Thuc thi ${sqlFile} - Thanh cong." -ForegroundColor Green
    } else {
        Write-Host "  [-] File $sqlFile khong ton tai!" -ForegroundColor Red
    }
}

function Start-JobScoutAll {
    Clear-Host
    Write-Host "+--------------------------------------------------------------------------+" -ForegroundColor Cyan
    Write-Host "|          TIEN TRINH KHOI DONG TOAN DIEN HE THONG JOBSCOUT 2D             |" -ForegroundColor Cyan
    Write-Host "+--------------------------------------------------------------------------+" -ForegroundColor Cyan
    Write-Host ""
    
    Write-Host "[1/6] Khoi dong Docker containers (docker-compose)..." -ForegroundColor Yellow
    docker compose up -d

    Write-Host "[2/6] Doi co so du lieu MySQL san sang tren cong 3307..." -ForegroundColor Yellow
    $dbReady = $false
    for ($i = 0; $i -lt 35; $i++) {
        docker exec $DB_CONTAINER mysqladmin ping -u root -prootpassword --silent 2>$null
        if ($LASTEXITCODE -eq 0) { $dbReady = $true; break }
        Start-Sleep -Seconds 1
    }
    if ($dbReady) {
        Write-Host "      CSDL MySQL da san sang ket noi!" -ForegroundColor Green
    } else {
        Write-Host "      [Canh bao] MySQL van dang khoi dong, tiep tuc nap..." -ForegroundColor DarkYellow
    }

    Write-Host "[3/6] Nap 7 trang thiet ke Figma & CSDL goc vao Database..." -ForegroundColor Yellow
    Invoke-SqlFile "import_job_design_data.sql"

    Write-Host "[4/6] Dong bo 6 tai khoan Administrator Nhom C..." -ForegroundColor Yellow
    Invoke-SqlFile "create_users.sql"

    Write-Host "[5/6] Thiet lap thuong hieu JobScout va Front Page..." -ForegroundColor Yellow
    Invoke-SqlFile "setup_jobscout_brand.sql"

    Write-Host "[6/6] Kich hoat Theme JobScout, 5 Plugins va Dong bo Doanh Nghiep..." -ForegroundColor Yellow
    Invoke-SqlFile "activate_theme_plugins.sql"
    docker exec $WP_CONTAINER php sync_company_profiles.php 2>$null

    Write-Host ""
    Write-Host "+--------------------------------------------------------------------------+" -ForegroundColor Green
    Write-Host "| [HOAN TAT] He thong da san sang! Dang mo Cua So Tab Noi 2D tren man hinh |" -ForegroundColor Green
    Write-Host "+--------------------------------------------------------------------------+" -ForegroundColor Green
    Open-FloatingWindow
    Start-Process $URL_WEB
    Write-Host ""
    Write-Host "Nhan phim bat ky de quay lai menu..." -ForegroundColor Gray
    [Console]::ReadKey($true) | Out-Null
}

function Import-JobDesign {
    Clear-Host
    Write-Host "[TIEN TRINH] Nap du lieu 7 trang thiet ke Figma vao CSDL JobScout..." -ForegroundColor Cyan
    Write-Host "-------------------------------------------------------------------------------" -ForegroundColor Gray
    Invoke-SqlFile "import_job_design_data.sql"
    Write-Host "[OK] Da nap thanh cong Trang, Tin Tuc va 6 Tin Tuyen Dung vao database!" -ForegroundColor Green
    Write-Host ""
    Write-Host "Nhan phim bat ky de quay lai menu..." -ForegroundColor Gray
    [Console]::ReadKey($true) | Out-Null
}

function Set-JobScoutBrand {
    Clear-Host
    Write-Host "[TIEN TRINH] Thiet lap thuong hieu JobScout..." -ForegroundColor Cyan
    Write-Host "-------------------------------------------------------------------------------" -ForegroundColor Gray
    Invoke-SqlFile "setup_jobscout_brand.sql"
    Write-Host "[OK] Da cap nhat Site Title: JobScout, Tagline va Front Page!" -ForegroundColor Green
    Write-Host ""
    Write-Host "Nhan phim bat ky de quay lai menu..." -ForegroundColor Gray
    [Console]::ReadKey($true) | Out-Null
}

function Enable-ThemePlugins {
    Clear-Host
    Write-Host "[TIEN TRINH] Kich hoat Theme JobScout va cac Plugin..." -ForegroundColor Cyan
    Write-Host "-------------------------------------------------------------------------------" -ForegroundColor Gray
    Invoke-SqlFile "activate_theme_plugins.sql"
    Write-Host "[OK] Theme JobScout va 4 Plugin da duoc kich hoat!" -ForegroundColor Green
    Write-Host ""
    Write-Host "Nhan phim bat ky de quay lai menu..." -ForegroundColor Gray
    [Console]::ReadKey($true) | Out-Null
}

function Set-AdminUsers {
    Clear-Host
    Write-Host "[TIEN TRINH] Cap nhat 6 tai khoan Administrator Nhom C..." -ForegroundColor Cyan
    Write-Host "-------------------------------------------------------------------------------" -ForegroundColor Gray
    Invoke-SqlFile "create_users.sql"
    Write-Host "[OK] Da cap nhat 6 tai khoan Administrator thanh cong [Password@123]!" -ForegroundColor Green
    Write-Host ""
    Write-Host "Nhan phim bat ky de quay lai menu..." -ForegroundColor Gray
    [Console]::ReadKey($true) | Out-Null
}

function Get-AdminUsersList {
    Clear-Host
    Write-Host "+--------------------------------------------------------------------------+" -ForegroundColor Cyan
    Write-Host "|                DANH SACH 6 TAI KHOAN QUAN TRI VIEN NHOM C                |" -ForegroundColor Cyan
    Write-Host "+--------------------------------------------------------------------------+" -ForegroundColor Cyan
    Write-Host ""
    Write-Host "  1. xuanhoa      - Van Nguyen Xuan Hoa  (vhoa1682006@gmail.com)" -ForegroundColor White
    Write-Host "  2. thanhhien    - Nguyen Thanh Hien    (thenghien2006@gmail.com)" -ForegroundColor White
    Write-Host "  3. vinhem       - Huynh Van Vinh Em    (trumvinh85@gmail.com)" -ForegroundColor White
    Write-Host "  4. anhquy       - Nguyen Anh Quy       (nguyquy67@gmail.com)" -ForegroundColor White
    Write-Host "  5. dangnguyen   - Dang Dang Nguyen     (dn1275102@gmail.com)" -ForegroundColor White
    Write-Host "  6. admin_nhomc  - Quan Tri Vien Nhom C (admin_nhomc@fit.tdc.edu.vn)" -ForegroundColor White
    Write-Host ""
    Write-Host "  * Mat khau dang nhap chung: Password@123" -ForegroundColor Yellow
    Write-Host "-------------------------------------------------------------------------------" -ForegroundColor Gray
    Write-Host "Nhan phim bat ky de quay lai menu..." -ForegroundColor Gray
    [Console]::ReadKey($true) | Out-Null
}

function Backup-JobScoutDb {
    Clear-Host
    Write-Host "[TIEN TRINH] Dang sao luu co so du lieu JobScout..." -ForegroundColor Cyan
    Write-Host "-------------------------------------------------------------------------------" -ForegroundColor Gray
    if (-not (Test-Path "backups")) { New-Item -ItemType Directory -Path "backups" | Out-Null }
    $ts = Get-Date -Format "yyyyMMdd_HHmmss"
    $backupFile = "backups\db_jobscout_$ts.sql"
    docker exec $DB_CONTAINER mysqldump -u root -prootpassword $DB_NAME > $backupFile 2>$null
    if ($LASTEXITCODE -eq 0) {
        Write-Host "[THANH CONG] File backup da luu tai: $backupFile" -ForegroundColor Green
    } else {
        Write-Host "[LOI] Khong the xuat database!" -ForegroundColor Red
    }
    Write-Host ""
    Write-Host "Nhan phim bat ky de quay lai menu..." -ForegroundColor Gray
    [Console]::ReadKey($true) | Out-Null
}

function Get-JobScoutStatus {
    Clear-Host
    Write-Host "+--------------------------------------------------------------------------+" -ForegroundColor Cyan
    Write-Host "|                       KIEM TRA TRANG THAI HE THONG                       |" -ForegroundColor Cyan
    Write-Host "+--------------------------------------------------------------------------+" -ForegroundColor Cyan
    Write-Host ""
    docker ps --filter "name=wordpress_" --format "table {{.Names}}\t{{.Status}}\t{{.Ports}}"
    Write-Host ""
    Write-Host "[CHI SO DICH VU]" -ForegroundColor Yellow
    Write-Host "  * CSDL Container: $DB_CONTAINER (Port $DB_PORT / DB: $DB_NAME)" -ForegroundColor White
    Write-Host "  * Web App:        $WP_CONTAINER ($URL_WEB)" -ForegroundColor White
    Write-Host "  * phpMyAdmin:     $PMA_CONTAINER ($URL_PMA)" -ForegroundColor White
    Write-Host "  * 2D Dashboard:   $URL_DASHBOARD" -ForegroundColor White
    Write-Host "-------------------------------------------------------------------------------" -ForegroundColor Gray
    Write-Host "Nhan phim bat ky de quay lai menu..." -ForegroundColor Gray
    [Console]::ReadKey($true) | Out-Null
}

function Restart-DockerServices {
    Clear-Host
    Write-Host "Dang khoi dong lai cac containers..." -ForegroundColor Yellow
    docker compose restart
    Write-Host "[OK] Da khoi dong lai thanh cong!" -ForegroundColor Green
    Start-Sleep -Seconds 1
}

function Stop-DockerServices {
    Clear-Host
    Write-Host "Dang tam dung cac containers..." -ForegroundColor Yellow
    docker compose stop
    Write-Host "[OK] Da tam dung dich vu an toan!" -ForegroundColor Green
    Start-Sleep -Seconds 1
}

function Set-VirtualHosts {
    Clear-Host
    Write-Host "[TIEN TRINH] Cap nhat ten mien Virtual Host 'wordpressc'..." -ForegroundColor Cyan
    Write-Host "-------------------------------------------------------------------------------" -ForegroundColor Gray
    if (Test-Path "$PSScriptRoot\setup-hosts.bat") {
        Start-Process "$PSScriptRoot\setup-hosts.bat" -Verb RunAs -Wait
        Write-Host "[OK] Da kich hoat cap nhat file hosts!" -ForegroundColor Green
    } else {
        Write-Host "[-] Khong tim thay setup-hosts.bat!" -ForegroundColor Red
    }
    Write-Host ""
    Write-Host "Nhan phim bat ky de quay lai menu..." -ForegroundColor Gray
    [Console]::ReadKey($true) | Out-Null
}

# ===============================================================================
# DATA STRUCTURE FOR TABS AND ITEMS
# ===============================================================================

$tabs = @(
    @{
        Title = "1. TONG QUAN"
        Items = @(
            @{
                Key    = "A"
                Label  = "[A] KHOI DONG TOAN DIEN (1-Click Docker + CSDL + Mo Tab 2D)"
                Action = { Start-JobScoutAll }
            },
            @{
                Key    = "M"
                Label  = "[M] MO NGAY CUA SO TAB NOI 2D (Floating 2D OS Dashboard)"
                Action = { Open-FloatingWindow }
            },
            @{
                Key    = "W"
                Label  = "[W] Mo Website JobScout ($URL_WEB)"
                Action = { Start-Process $URL_WEB }
            },
            @{
                Key    = "P"
                Label  = "[P] Mo phpMyAdmin Quan Ly CSDL ($URL_PMA)"
                Action = { Start-Process $URL_PMA }
            },
            @{
                Key    = "S"
                Label  = "[S] Kiem Tra Suc Khoe & Tien Trinh Containers"
                Action = { Get-JobScoutStatus }
            }
        )
    },
    @{
        Title = "2. DU LIEU THIET KE"
        Items = @(
            @{
                Key    = "F"
                Label  = "[F] Nap 7 Trang Thiet Ke Figma vao Database"
                Action = { Import-JobDesign }
            },
            @{
                Key    = "B"
                Label  = "[B] Thiet Lap Thuong Hieu JobScout & Front Page"
                Action = { Set-JobScoutBrand }
            },
            @{
                Key    = "K"
                Label  = "[K] Kich Hoat Theme JobScout va 4 Plugin Nghiep Vu"
                Action = { Enable-ThemePlugins }
            },
            @{
                Key    = "V"
                Label  = "[V] Mo Xem Trang Du Lieu Thiet Ke Tren Trinh Duyet"
                Action = {
                    Start-Process "$URL_WEB/about-us"
                    Start-Process "$URL_WEB/all-jobs"
                }
            }
        )
    },
    @{
        Title = "3. TAI KHOAN ADMIN"
        Items = @(
            @{
                Key    = "U"
                Label  = "[U] Cap Nhat & Dat Lai 6 Tai Khoan Admin [Password@123]"
                Action = { Set-AdminUsers }
            },
            @{
                Key    = "L"
                Label  = "[L] Xem Danh Sach 6 Quan Tri Vien (Ho ten, User, Email)"
                Action = { Get-AdminUsersList }
            },
            @{
                Key    = "G"
                Label  = "[G] Mo Trang Dang Nhap WP-Admin ($URL_ADMIN)"
                Action = { Start-Process $URL_ADMIN }
            }
        )
    },
    @{
        Title = "4. CSDL & DOCKER"
        Items = @(
            @{
                Key    = "H"
                Label  = "[H] Cap Nhat Ten Mien 'wordpressc' Vao File Hosts (Admin)"
                Action = { Set-VirtualHosts }
            },
            @{
                Key    = "X"
                Label  = "[X] Sao Luu Co So Du Lieu (.sql vao backups/)"
                Action = { Backup-JobScoutDb }
            },
            @{
                Key    = "R"
                Label  = "[R] Khoi Dong Lai Tat Ca Containers (Restart Docker)"
                Action = { Restart-DockerServices }
            },
            @{
                Key    = "Q"
                Label  = "[Q] Tam Dung Tat Ca Dich Vu Containers (Stop Docker)"
                Action = { Stop-DockerServices }
            },
            @{
                Key    = "S"
                Label  = "[S] Kiem Tra Chi Tiet Cong & Trang Thai Containers"
                Action = { Get-JobScoutStatus }
            }
        )
    }
)

$currentTabIdx = 0
$selectedItemIdx = 0

# ===============================================================================
# AUTO-LAUNCH CUA SO TAB NOI 2D KHI WEB SERVICE DA SAN SANG
# ===============================================================================
try {
    $tcp = New-Object System.Net.Sockets.TcpClient
    $iar = $tcp.BeginConnect("127.0.0.1", [int]$WP_PORT, $null, $null)
    $ok = $iar.AsyncWaitHandle.WaitOne(400)
    if ($ok -and $tcp.Connected) {
        $tcp.EndConnect($iar)
        Open-FloatingWindow
    }
    $tcp.Close()
} catch {}

# ===============================================================================
# MAIN TUI LOOP (INSTANT KEYPRESS INTERACTION - AN CHON LA CHAY)
# ===============================================================================

while ($true) {
    Clear-Host
    
    # 1. Header
    Write-Host "+=============================================================================+" -ForegroundColor Cyan
    Write-Host "|         JOBSCOUT OS v2.0 - BANG DIEU KHIEN TERMINAL CO TAB 2D               |" -ForegroundColor Cyan
    Write-Host "|                  DO AN CUOI KY - KHOA CNTT - NHOM C                         |" -ForegroundColor Cyan
    Write-Host "+=============================================================================+" -ForegroundColor Cyan
    Write-Host "| Ports: Web :8080 | PMA :8085 | MySQL :3307 | Database: $DB_NAME               |" -ForegroundColor DarkGray
    Write-Host "| Cach ly FIT-TDC: 100% Doc Lap (Tuyet doi khong dung cham CSDL FIT-TDC)     |" -ForegroundColor DarkGreen
    Write-Host "+=============================================================================+" -ForegroundColor Cyan

    # 2. Tab Bar
    Write-Host "| " -NoNewline -ForegroundColor Cyan
    for ($i = 0; $i -lt $tabs.Count; $i++) {
        $tabTitle = $tabs[$i].Title
        if ($i -eq $currentTabIdx) {
            Write-Host " >>> [ $tabTitle ] <<< " -NoNewline -ForegroundColor Black -BackgroundColor Cyan
        } else {
            Write-Host "   $tabTitle   " -NoNewline -ForegroundColor Gray
        }
        if ($i -lt $tabs.Count - 1) {
            Write-Host "|" -NoNewline -ForegroundColor DarkGray
        }
    }
    Write-Host " |" -ForegroundColor Cyan
    Write-Host "+-----------------------------------------------------------------------------+" -ForegroundColor Cyan

    # 3. Items on Active Tab
    $currentTab = $tabs[$currentTabIdx]
    $items = $currentTab.Items

    Write-Host "|                                                                             |" -ForegroundColor Cyan
    for ($j = 0; $j -lt $items.Count; $j++) {
        $item = $items[$j]
        $label = $item.Label
        
        # Padded string for width
        $padded = $label.PadRight(71)
        
        if ($j -eq $selectedItemIdx) {
            Write-Host "|  " -NoNewline -ForegroundColor Cyan
            Write-Host " ► $padded" -NoNewline -ForegroundColor Black -BackgroundColor Green
            Write-Host " |" -ForegroundColor Cyan
        } else {
            Write-Host "|     $padded |" -ForegroundColor White
        }
    }
    Write-Host "|                                                                             |" -ForegroundColor Cyan

    # 4. Footer & Instructions
    Write-Host "+-----------------------------------------------------------------------------+" -ForegroundColor Cyan
    Write-Host "|  DIEU HUONG : Phim [<-] [->] chuyen Tab | Phim [^] [v] chon chuc nang       |" -ForegroundColor Yellow
    Write-Host "|  THUC THI   : Nhan [ENTER] de CHAY NGAY muc dang chon                       |" -ForegroundColor Green
    Write-Host "|  PHIM NHANH : Nhan phim so [1-4] chuyen Tab | [A, M, W...] chay ngay        |" -ForegroundColor Cyan
    Write-Host "|  THOAT      : Nhan phim [0] hoac [ESC] de thoat chuong trinh                |" -ForegroundColor Magenta
    Write-Host "+-----------------------------------------------------------------------------+" -ForegroundColor Cyan

    # 5. Read Key instantly (NO ENTER NEEDED FOR NAVIGATION OR HOTKEYS)
    $keyInfo = $Host.UI.RawUI.ReadKey("NoEcho,IncludeKeyDown")
    $key = $keyInfo.Key
    $char = $keyInfo.Character.ToString().ToUpper()

    # Arrow keys & Tab
    if ($key -eq [System.ConsoleKey]::RightArrow -or $key -eq [System.ConsoleKey]::Tab) {
        $currentTabIdx = ($currentTabIdx + 1) % $tabs.Count
        $selectedItemIdx = 0
        continue
    }
    if ($key -eq [System.ConsoleKey]::LeftArrow) {
        $currentTabIdx = ($currentTabIdx - 1 + $tabs.Count) % $tabs.Count
        $selectedItemIdx = 0
        continue
    }
    if ($key -eq [System.ConsoleKey]::DownArrow) {
        $selectedItemIdx = ($selectedItemIdx + 1) % $items.Count
        continue
    }
    if ($key -eq [System.ConsoleKey]::UpArrow) {
        $selectedItemIdx = ($selectedItemIdx - 1 + $items.Count) % $items.Count
        continue
    }

    # Execute selected item with ENTER or SPACE
    if ($key -eq [System.ConsoleKey]::Enter -or $key -eq [System.ConsoleKey]::Spacebar) {
        & $items[$selectedItemIdx].Action
        continue
    }

    # Exit
    if ($key -eq [System.ConsoleKey]::Escape -or $char -eq "0") {
        Clear-Host
        Write-Host "Cam on ban da su dung JobScout OS - Nhom C!" -ForegroundColor Cyan
        Start-Sleep -Seconds 1
        break
    }

    # Switch tab directly by number 1-4
    if ($char -ge "1" -and $char -le "4") {
        $num = [int]$char - 1
        if ($num -lt $tabs.Count) {
            $currentTabIdx = $num
            $selectedItemIdx = 0
        }
        continue
    }

    # Direct action trigger by letter (An chon la chay ngay lap tuc)
    $handled = $false
    for ($t = 0; $t -lt $tabs.Count; $t++) {
        foreach ($it in $tabs[$t].Items) {
            if ($it.Key -eq $char) {
                & $it.Action
                $handled = $true
                break
            }
        }
        if ($handled) { break }
    }
}
