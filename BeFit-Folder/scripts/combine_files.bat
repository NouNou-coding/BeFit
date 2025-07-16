@echo off
setlocal enabledelayedexpansion

:: Title and introduction
title File Combiner Script
echo **********************************************
echo       FILE CONTENT COMBINER TOOL
echo **********************************************
echo.
echo This script will:
echo 1. Combine all files from a source directory
echo 2. Create a single text file with each file's path and content
echo 3. Save the output to your specified location
echo.
echo **********************************************
echo.

:: Function to validate and normalize paths
:normalizePath
set "temp_path=%~1"
:: Convert to absolute path
for %%A in ("%temp_path%") do set "temp_path=%%~fA"
exit /b

:: Get source directory path
:getSource
set "source_path="
set /p "source_path=Enter the SOURCE directory path (where files are located): "
if "%source_path%"=="" (
    echo ERROR: Source path cannot be empty!
    goto getSource
)

:: Normalize the source path
call :normalizePath "%source_path%"
set "source_path=%temp_path%"

:: Verify source path exists
if not exist "%source_path%\" (
    echo ERROR: Source path does not exist: %source_path%
    echo Please check the path and try again.
    goto getSource
)

:: Get destination directory path
:getDest
set "dest_path="
set /p "dest_path=Enter the DESTINATION directory path (where output will be saved): "
if "%dest_path%"=="" (
    echo ERROR: Destination path cannot be empty!
    goto getDest
)

:: Normalize the destination path
call :normalizePath "%dest_path%"
set "dest_path=%temp_path%"

:: Verify/Create destination path
if not exist "%dest_path%\" (
    echo.
    echo Creating destination directory structure...
    mkdir "%dest_path%"
    if errorlevel 1 (
        echo ERROR: Failed to create destination directory: %dest_path%
        echo Please check the path and try again.
        goto getDest
    )
    echo Successfully created destination directory.
)

:: Get output filename
:getFilename
set "output_filename="
set /p "output_filename=Enter the OUTPUT filename (without extension): "
if "%output_filename%"=="" (
    echo ERROR: Filename cannot be empty!
    goto getFilename
)

:: Clean filename (remove invalid characters)
set "output_filename=%output_filename:"=%"
set "output_filename=%output_filename:/=%"
set "output_filename=%output_filename:\=%"
set "output_filename=%output_filename::=%"
set "output_filename=%output_filename:?=%"
set "output_filename=%output_filename:*=%"
set "output_filename=%output_filename:<=%"
set "output_filename=%output_filename:>=%"
set "output_filename=%output_filename:|=%"

:: Set full output path
set "output_file=%dest_path%\%output_filename%.txt"

:: Check if output file exists and prompt to overwrite
if exist "%output_file%" (
    echo.
    :overwritePrompt
    set "overwrite="
    set /p "overwrite=Output file already exists. Overwrite? (Y/N): "
    if /i "%overwrite%"=="Y" (
        echo Overwriting existing file...
    ) else if /i "%overwrite%"=="N" (
        goto getFilename
    ) else (
        echo Please enter Y or N
        goto overwritePrompt
    )
)

:: Begin processing
echo.
echo **********************************************
echo Processing files from: %source_path%
echo Saving output to: %output_file%
echo **********************************************
echo.

:: Remove existing output file if it exists
if exist "%output_file%" del "%output_file%"

:: Initialize counters
set file_count=0
set success_count=0
set error_count=0

:: Process each file in the directory and subdirectories
for /r "%source_path%" %%f in (*) do (
    set /a file_count+=1
    echo [!file_count!] Processing: %%f
    
    echo. >> "%output_file%"
    echo [FILE: %%f] >> "%output_file%"
    echo ======================================= >> "%output_file%"
    
    type "%%f" >> "%output_file%" 2>nul
    if errorlevel 1 (
        echo [ERROR READING FILE] >> "%output_file%"
        set /a error_count+=1
    ) else (
        set /a success_count+=1
    )
    
    echo. >> "%output_file%"
    echo ======================================= >> "%output_file%"
    echo. >> "%output_file%"
)

:: Completion message
echo.
echo **********************************************
echo PROCESSING COMPLETE!
echo.
echo Total files found:    %file_count%
echo Successfully read:    %success_count%
echo Failed to read:       %error_count%
echo.
echo Output saved to: %output_file%
echo **********************************************
echo.

:: Open the destination folder
start "" "%dest_path%"

pause