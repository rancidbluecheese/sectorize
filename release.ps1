param(
    [Parameter(Mandatory=$true)][string]$Version,
    [switch]$ForcePush,
    [string]$ZipName = ""
)

if ([string]::IsNullOrWhiteSpace($ZipName)) {
    $ZipName = "sectorize-$Version.zip"
}

# Safety: ensure clean tree
$status = git status --porcelain
if ($status) {
    Write-Error "Working tree is not clean. Commit or stash changes before releasing."
    exit 1
}

# Tag creation / move
$tag = "v$Version"
if (git rev-parse --verify $tag 2>$null) {
    if ($ForcePush) {
        Write-Host "Tag $tag exists locally; moving it to HEAD (force)" -ForegroundColor Yellow
        git tag -f -a $tag HEAD -m "Version $Version - WordPress.org compliance fixes"
    } else {
        Write-Host "Tag $tag already exists locally; leaving it in place" -ForegroundColor Cyan
    }
} else {
    Write-Host "Creating annotated tag $tag at HEAD" -ForegroundColor Green
    git tag -a $tag -m "Version $Version - WordPress.org compliance fixes"
}

# Push tag to origin
if ($ForcePush) {
    Write-Host "Force-pushing tag $tag to origin" -ForegroundColor Yellow
    git push origin $tag --force
} else {
    Write-Host "Pushing tag $tag to origin" -ForegroundColor Green
    git push origin $tag
}

# Build zip from the tag (ensures deterministic content)
if (Test-Path .\$ZipName) { Remove-Item .\$ZipName -Force }
Write-Host "Building ZIP from tag ${tag}: ${ZipName}" -ForegroundColor Green
git archive --format=zip --prefix=sectorize/ -o $ZipName $tag

# Sanity-check the top-level folder
$dest = Join-Path $env:TEMP "sectorize-check"
if (Test-Path $dest) { Remove-Item $dest -Recurse -Force }
Expand-Archive -Path .\$ZipName -DestinationPath $dest -Force

Write-Host "`nTop-level entries in the built ZIP:" -ForegroundColor Cyan
Get-ChildItem $dest | ForEach-Object { Write-Host " - $($_.Name)" }

# Validate top-level is exactly 'sectorize'
$entries = Get-ChildItem $dest | Select-Object -ExpandProperty Name
if ($entries.Count -ne 1 -or $entries[0] -ne "sectorize") {
    Write-Error "ZIP top-level is not 'sectorize'. Aborting. Inspect $ZipName in $dest"
    exit 2
}

# Print final path for upload
$absPath = (Resolve-Path .\$ZipName).Path
Write-Host "`nBuilt ZIP ready for upload:" -ForegroundColor Green
Write-Host $absPath -ForegroundColor White

Write-Host "`nReminders:" -ForegroundColor Cyan
Write-Host " - Upload the printed ZIP as the release asset for tag $tag on GitHub." -ForegroundColor White
Write-Host " - Ignore the auto-generated 'Source code (zip/tar.gz)' links." -ForegroundColor White

exit 0
