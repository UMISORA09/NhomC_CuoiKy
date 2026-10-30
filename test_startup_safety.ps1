$ErrorActionPreference = 'Stop'
$taskTokens = $null
$taskErrors = $null
$ast = [System.Management.Automation.Language.Parser]::ParseFile((Join-Path $PSScriptRoot 'menu.ps1'), [ref]$taskTokens, [ref]$taskErrors)
if ($taskErrors) { throw 'menu.ps1 has syntax errors.' }
$startup = $ast.Find({ param($node) $node -is [System.Management.Automation.Language.FunctionDefinitionAst] -and $node.Name -eq 'Start-JobScoutAll' }, $true)
$body = $startup.Body.Extent.Text
$end = $body.IndexOf('    Open-FloatingWindow')
if ($end -lt 0) { throw 'Cannot find the end of the startup data steps.' }
$body = $body.Substring(1, $end - 1)
$script:dockerCalls = [System.Collections.Generic.List[string]]::new()
function docker {
    $script:dockerCalls.Add(($args -join ' '))
    $global:LASTEXITCODE = 0
}
function Clear-Host {}
function Write-Host {}
function Start-Sleep { throw 'Unexpected wait in the successful startup check.' }
function Invoke-SqlFile { throw 'Existing database must never be imported during normal startup.' }
& ([scriptblock]::Create($body))
if (!($script:dockerCalls | Where-Object { $_ -match 'php setup_widgets.php' })) { throw 'Normal startup did not apply the widget migration.' }
if ($script:dockerCalls | Where-Object { $_ -match 'source /tmp|mysqldump' }) { throw 'Normal startup tried to reload an existing database.' }
Write-Output 'PASS: normal startup retains existing data and updates widgets.'

$sqlFunction = $ast.Find({ param($node) $node -is [System.Management.Automation.Language.FunctionDefinitionAst] -and $node.Name -eq 'Invoke-SqlFile' }, $true)
Invoke-Expression $sqlFunction.Extent.Text
function powershell.exe { $global:LASTEXITCODE = 1 }
$before = $script:dockerCalls.Count
$blocked = $false
try { Invoke-SqlFile 'import_job_design_data.sql' } catch { $blocked = $true }
if (!$blocked -or $script:dockerCalls.Count -ne $before) { throw 'Backup failure did not stop the SQL import.' }
Write-Output 'PASS: failed backup blocks SQL import without running Docker data commands.'
