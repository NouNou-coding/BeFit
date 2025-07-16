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

:: Get source directory path
:getSource
set /p "source_path=Enter the SOURCE directory path (where files are located): "
if "%source_path%"=="" (
    echo ERROR: Source path cannot be empty!
    goto getSource
)

:: Verify source path exists
if not exist "%source_path%\" (
    echo ERROR: Source path does not exist!
    echo Please check the path and try again.
    goto getSource
)

:: Get destination directory path
:getDest
set /p "dest_path=Enter the DESTINATION directory path (where output will be saved): "
if "%dest_path%"=="" (
    echo ERROR: Destination path cannot be empty!
    goto getDest
)

:: Verify destination path exists
if not exist "%dest_path%\" (
    echo.
    echo WARNING: Destination path does not exist!
    set /p "create_dir=Do you want to create this directory? (Y/N): "
    if /i "!create_dir!"=="Y" (
        mkdir "%dest_path%"
        if errorlevel 1 (
            echo ERROR: Failed to create directory!
            goto getDest
        )
    ) else (
        goto getDest
    )
)

:: Get output filename
:getFilename
set /p "output_filename=Enter the OUTPUT filename (without extension): "
if "%output_filename%"=="" (
    echo ERROR: Filename cannot be empty!
    goto getFilename
)

:: Set full output path
set "output_file=%dest_path%\%output_filename%.txt"

:: Check if output file exists and prompt to overwrite
if exist "%output_file%" (
    echo.
    set /p "overwrite=Output file already exists. Overwrite? (Y/N): "
    if /i not "!overwrite!"=="Y" (
        goto getFilename
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

:: Initialize counter
set file_count=0

:: Process each file in the directory and subdirectories
for /r "%source_path%" %%f in (*) do (
    set /a file_count+=1
    echo [!file_count!] Processing: %%f
    echo. >> "%output_file%"
    echo [FILE: %%f] >> "%output_file%"
    echo ======================================= >> "%output_file%"
    type "%%f" >> "%output_file%" 2>nul
    echo. >> "%output_file%"
    echo ======================================= >> "%output_file%"
    echo. >> "%output_file%"
)

:: Completion message
echo.
echo **********************************************
echo PROCESSING COMPLETE!
echo.
echo Processed %file_count% files
echo Output saved to: %output_file%
echo **********************************************
echo.
pause