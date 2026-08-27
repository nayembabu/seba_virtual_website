@echo off
where ngrok >nul 2>nul
if %ERRORLEVEL% NEQ 0 (
    echo ngrok is not found in PATH
    echo Please install ngrok and add it to your system PATH
    echo Visit https://ngrok.com/download for installation
    pause
    exit /b 1
)

echo Starting ngrok...
ngrok http 80
