@ECHO OFF
setlocal DISABLEDELAYEDEXPANSION
SET BIN_TARGET=%~dp0/../infection/infection/bin/infection
php "%BIN_TARGET%" %*
