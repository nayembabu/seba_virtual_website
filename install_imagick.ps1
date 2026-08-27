# Download ImageMagick
$imagemagickUrl = "https://download.imagemagick.org/ImageMagick/download/binaries/ImageMagick-7.1.1-29-Q16-HDRI-x64-dll.exe"
$imagemagickInstaller = "ImageMagick-installer.exe"
Invoke-WebRequest -Uri $imagemagickUrl -OutFile $imagemagickInstaller

# Install ImageMagick silently with development headers
Start-Process -FilePath ".\$imagemagickInstaller" -ArgumentList "/SILENT /COMPONENTS=development" -Wait

# Download PHP Imagick extension
$imagickUrl = "https://windows.php.net/downloads/pecl/releases/imagick/3.7.0/php_imagick-3.7.0-8.3-ts-vs16-x64.zip"
$imagickZip = "imagick.zip"
Invoke-WebRequest -Uri $imagickUrl -OutFile $imagickZip

# Extract the extension
Expand-Archive -Path $imagickZip -DestinationPath "imagick" -Force

# Copy the DLL to PHP ext directory
$phpExtDir = "C:/laragon/bin/php/php-8.3.16-Win32-vs16-x64/ext"
Copy-Item "imagick/php_imagick.dll" -Destination $phpExtDir -Force

# Copy ImageMagick DLLs to PHP directory
$imageMagickPath = "C:\Program Files\ImageMagick-7.1.1-Q16-HDRI"
$phpDir = "C:/laragon/bin/php/php-8.3.16-Win32-vs16-x64"
Get-ChildItem "$imageMagickPath\*.dll" | Copy-Item -Destination $phpDir -Force

Write-Host "Installation complete. Please restart Laragon."