@ECHO OFF
setlocal DISABLEDELAYEDEXPANSION
SET BIN_TARGET=%~dp0/vendor/snapwp/snap-core/bin/snap
php "%BIN_TARGET%" %*
