@echo off
setlocal enabledelayedexpansion

:: Ask user for the folder path
set /p "folder=Enter the full path of the folder you want to scan: "

:: Check if folder exists
if not exist "%folder%" (
    echo Folder not found!
    pause
    exit /b
)

:: Output file
set "output=all_files_output.txt"
echo Creating %output%...

:: Clear previous content
> "%output%" echo === Combined File Output ===

:: Loop through all files in the folder and subfolders
for /r "%folder%" %%f in (*) do (
    echo Processing: %%f
    >> "%output%" echo.
    >> "%output%" echo ===============================
    >> "%output%" echo FILE PATH: %%f
    >> "%output%" echo ===============================
    >> "%output%" type "%%f"
    >> "%output%" echo.
)

echo Done! All content written to %output%
pause
