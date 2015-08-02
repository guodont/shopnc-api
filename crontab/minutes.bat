	@echo off
mshta vbscript:createobject("wscript.shell").run("""iexplore"" http://v3.33hao.com/crontab/cj_index.php?act=minutes",0)(window.close) 
echo 1
taskkill /f /im iexplore.exe 