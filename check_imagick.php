<?php
if (extension_loaded('imagick')) {
    echo "Imagick is installed!";
    echo "\nVersion: " . Imagick::getVersion()['versionString'];
} else {
    echo "Imagick is NOT installed!";
}
?>