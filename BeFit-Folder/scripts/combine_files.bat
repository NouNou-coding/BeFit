:: ========================================================
:: BATCH FILE CONTENT COMBINER
:: 
:: This script:
:: 1. Prompts user for a target folder path
:: 2. Validates the folder exists
:: 3. Creates/overwrites an output file (all_files_output.txt)
:: 4. Recursively scans all files in the folder and subfolders
:: 5. Writes each file's path and content to the output
::    with clear separation markers between files
:: 6. Provides progress feedback in console
::
:: Usage: Double-click or run from command prompt
:: Output: Creates all_files_output.txt in script's directory
:: ========================================================


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
