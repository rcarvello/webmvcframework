<?php
/**
 * PHP File Watcher to trigger browser reload via BrowserSync
 */

$watchPaths = ['/'];
$extensions = ['php', 'css', 'js'];
$lastModTimes = [];

function getFiles($paths, $extensions)
{
    $files = [];
    foreach ($paths as $path) {
        $iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path));
        foreach ($iterator as $file) {
            if ($file->isFile()) {
                $ext = strtolower($file->getExtension());
                if (in_array($ext, $extensions)) {
                    $files[$file->getPathname()] = $file->getMTime();
                }
            }
        }
    }
    return $files;
}

echo "\033[36m[Watcher] Avviato: monitoraggio modifiche in corso...\033[0m\n";

while (true) {
    clearstatcache();
    $currentFiles = getFiles($watchPaths, $extensions);

    foreach ($currentFiles as $file => $mtime) {
        if (!isset($lastModTimes[$file]) || $lastModTimes[$file] < $mtime) {
            echo "\033[33m[Modifica] $file\033[0m\n";
            $lastModTimes[$file] = $mtime;

            // Trigger reload (browser-sync must be running)
            exec("npx browser-sync reload");
        }
    }

    sleep(1);
}
