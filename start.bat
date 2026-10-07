@echo off
setlocal
chcp 65001 >nul
title JOBSCOUT OS - DIEU KHIEN 2D NHOM C

:: ===============================================================================
:: KHOI DONG UNG DUNG TERMINAL 2D CO TAB TUONG TAC (AN NUT LA CHAY NGAY)
:: ===============================================================================
if exist "%~dp0menu.ps1" (
    powershell.exe -NoProfile -ExecutionPolicy Bypass -File "%~dp0menu.ps1"
    exit /b %errorlevel%
)

echo [LOI] Khong tim thay menu.ps1!
pause
exit /b 1
