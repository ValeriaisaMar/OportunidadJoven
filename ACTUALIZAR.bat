@echo off
chcp 65001 >nul
title OportunidadJoven - Actualizar ofertas
cd /d "%~dp0"

echo.
echo ===============================================
echo   OportunidadJoven: cargar ofertas reales
echo ===============================================
echo.

if not exist "artisan" (
    echo [ERROR] Este archivo debe estar en la carpeta del proyecto,
    echo         la misma donde esta el archivo "artisan".
    echo         Revisa que no hayas descomprimido una carpeta dentro de otra.
    goto fin
)

if not exist ".env" (
    echo [ERROR] No encuentro el archivo .env en esta carpeta.
    echo         Copia el .env de tu proyecto anterior aqui y vuelve a intentarlo.
    goto fin
)

set "PHP=php"
if exist "C:\xampp\php\php.exe" set "PHP=C:\xampp\php\php.exe"

"%PHP%" -v >nul 2>&1
if errorlevel 1 (
    echo [ERROR] No encuentro PHP. Si usas XAMPP, revisa que este en C:\xampp
    goto fin
)

echo [1/3] Actualizando las tablas de la base de datos...
"%PHP%" artisan migrate --force
if errorlevel 1 (
    echo.
    echo [ERROR] No se pudo conectar o actualizar la base de datos.
    echo         Revisa que MySQL este encendido en el panel de XAMPP.
    goto fin
)

echo.
echo [2/3] Borrando ofertas de ejemplo y cargando ofertas reales...
"%PHP%" artisan ofertas:cargar
if errorlevel 1 goto fin

echo.
echo [3/3] Limpiando la cache y activando la carpeta de CVs...
"%PHP%" artisan optimize:clear
if not exist "public\storage" "%PHP%" artisan storage:link

echo.
echo ===============================================
echo   Listo. Abre la pagina y recarga con Ctrl + F5
echo ===============================================

:fin
echo.
pause
