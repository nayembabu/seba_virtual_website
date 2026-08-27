# Create a directory for PHP
$phpPath = "C:\php"
New-Item -ItemType Directory -Force -Path $phpPath

# Download PHP
$url = "https://windows.php.net/downloads/releases/php-8.2.12-nts-Win32-vs16-x64.zip"
$output = "$phpPath\php.zip"
Invoke-WebRequest -Uri $url -OutFile $output

# Extract PHP
Expand-Archive -Path $output -DestinationPath $phpPath -Force
Remove-Item $output

# Add PHP to PATH
$phpExePath = "$phpPath\php-8.2.12-nts-Win32-vs16-x64"
$currentPath = [Environment]::GetEnvironmentVariable("Path", "Machine")
if ($currentPath -notlike "*$phpExePath*") {
    [Environment]::SetEnvironmentVariable("Path", "$currentPath;$phpExePath", "Machine")
}

Write-Host "PHP has been installed. Please restart your terminal and run 'php -v' to verify the installation."
