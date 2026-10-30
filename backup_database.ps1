$ErrorActionPreference = 'Stop'
try {
    $backupDirectory = Join-Path $PSScriptRoot 'backups'
    New-Item -ItemType Directory -Path $backupDirectory -Force | Out-Null
    Set-Content -LiteralPath (Join-Path $backupDirectory '.htaccess') -Value 'Require all denied' -Encoding Ascii
    $backupName = 'wordpress-before-reload-' + (Get-Date -Format 'yyyyMMdd-HHmmss-fff') + '.sql'
    $containerBackupFile = '/tmp/' + $backupName
    $backupFile = Join-Path $backupDirectory $backupName
    & docker exec wordpress_db mysqldump -u root -prootpassword --single-transaction --routines --triggers --no-tablespaces "--result-file=$containerBackupFile" wordpress
    if ($LASTEXITCODE -ne 0) { throw 'mysqldump failed; the database will not be reloaded.' }
    & docker cp "wordpress_db:${containerBackupFile}" $backupFile
    if ($LASTEXITCODE -ne 0 -or !(Test-Path -LiteralPath $backupFile)) { throw 'Could not copy the database backup.' }
    $tail = Get-Content -LiteralPath $backupFile -Tail 3 | Out-String
    if ((Get-Item -LiteralPath $backupFile).Length -eq 0 -or $tail -notmatch '-- Dump completed on ') { throw 'Database backup is incomplete.' }
    Write-Output "Backup saved: $backupFile"
} catch {
    Write-Output "Backup failed: $($_.Exception.Message)"
    exit 1
}
