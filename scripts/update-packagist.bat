@echo off
REM Script to manually trigger Packagist update on Windows
REM Usage: scripts\update-packagist.bat

REM Check if credentials are provided
if "%PACKAGIST_USERNAME%"=="" (
    echo Error: PACKAGIST_USERNAME environment variable is not set
    echo Usage: set PACKAGIST_USERNAME=your_username
    echo         set PACKAGIST_API_TOKEN=your_token
    echo         scripts\update-packagist.bat
    exit /b 1
)

if "%PACKAGIST_API_TOKEN%"=="" (
    echo Error: PACKAGIST_API_TOKEN environment variable is not set
    echo Usage: set PACKAGIST_USERNAME=your_username
    echo         set PACKAGIST_API_TOKEN=your_token
    echo         scripts\update-packagist.bat
    exit /b 1
)

REM Update Packagist package
echo Triggering Packagist update...
curl -X POST "https://packagist.org/api/update-package?username=%PACKAGIST_USERNAME%&apiToken=%PACKAGIST_API_TOKEN%"

if %ERRORLEVEL% EQU 0 (
    echo Packagist update triggered successfully!
) else (
    echo Failed to trigger Packagist update
    exit /b 1
)

