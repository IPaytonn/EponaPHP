@echo off
TITLE EponaPHP - Console View (BETA v0.1)
cd /d %~dp0
if exist bin\php\php.exe (
	if exist bin\mintty.exe (
		start "" bin\mintty.exe -o Columns=88 -o Rows=32 -o AllowBlinking=0 -o FontQuality=3 -o CursorType=0 -o CursorBlinks=1 -h error -t "EponaPHP Beta v0.1" -i bin/EponaPHP.ico -w max bin\php\php.exe -d enable_dl=On EponaPHP.php --enable-ansi %*
	) else (
		bin\php\php.exe -d enable_dl=On EponaPHP.php %*
	)
) else (
	if exist bin\mintty.exe (
		start "" bin\mintty.exe -o Columns=88 -o Rows=32 -o AllowBlinking=0 -o FontQuality=3 -o CursorType=0 -o CursorBlinks=1 -h error -t "EponaPHP Beta v0.1" -i bin/EponaPHP.ico -w max php -d enable_dl=On EponaPHP.php --enable-ansi %*
	) else (
		php -d enable_dl=On EponaPHP.php %*
	)
)

