$ErrorActionPreference = "Stop"

# Configuration
$phpVersion = "8.3"
$phpPath = "C:\laragon\bin\php\php-8.3.16-Win32-vs16-x64"
$extPath = "$phpPath\ext"
$tempPath = "C:\laragon\www\oopjhjh-09-29-25\temp_imagick"

# Create temp directory
New-Item -ItemType Directory -Force -Path $tempPath | Out-Null
Set-Location $tempPath

Write-Host "1. Downloading ImageMagick..."
$imageMagickUrl = "https://download.imagemagick.org/ImageMagick/download/binaries/ImageMagick-7.1.1-29-Q16-HDRI-x64-dll.exe"
$imageMagickInstaller = "$tempPath\ImageMagick-installer.exe"
Invoke-WebRequest -Uri $imageMagickUrl -OutFile $imageMagickInstaller

Write-Host "2. Installing ImageMagick..."
Start-Process -FilePath $imageMagickInstaller -ArgumentList "/SILENT /MERGETASKS=install_devel" -Wait

Write-Host "3. Downloading PHP Imagick extension..."
$imagickUrl = "https://windows.php.net/downloads/pecl/releases/imagick/3.7.0/php_imagick-3.7.0-$phpVersion-ts-vs16-x64.zip"
$imagickZip = "$tempPath\imagick.zip"
Invoke-WebRequest -Uri $imagickUrl -OutFile $imagickZip

Write-Host "4. Extracting Imagick extension..."
Expand-Archive -Path $imagickZip -DestinationPath "$tempPath\imagick" -Force

Write-Host "5. Installing Imagick extension..."
Copy-Item "$tempPath\imagick\php_imagick.dll" -Destination $extPath -Force

Write-Host "6. Copying ImageMagick DLLs..."
$imageMagickPath = "${env:ProgramFiles}\ImageMagick-7.1.1-Q16-HDRI"
Get-ChildItem "$imageMagickPath\CORE_RL_*.dll" | Copy-Item -Destination $phpPath -Force

Write-Host "7. Updating php.ini..."
$phpIni = "$phpPath\php.ini"
if (!(Select-String -Path $phpIni -Pattern "^extension=imagick" -Quiet)) {
    Add-Content -Path $phpIni -Value "`nextension=imagick"
}

Write-Host "8. Cleaning up..."
Remove-Item -Path $tempPath -Recurse -Force

Write-Host "`nInstallation complete! Please restart Laragon."
Write-Host "You can verify the installation by running 'php -m | Select-String imagick'"