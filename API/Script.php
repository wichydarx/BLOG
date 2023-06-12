<?php


function updateComposerJson()
{

    $currentDir = dirname(__FILE__);


    $subdirectories = array_filter(scandir($currentDir), function ($item) use ($currentDir) {
        return is_dir($currentDir . '/' . $item) && $item !== 'vendor' && $item !== '.' && $item !== '..' && $item !== 'Public';
    });

    $composerFile = $currentDir . '/composer.json';
    $composerData = json_decode(file_get_contents($composerFile), true);

    $autoload = $composerData['autoload'] ?? [];
    $psr4 = $autoload['psr-4'] ?? [];

    $removedDirectories = [];
    $addedDirectory = null;

    foreach (array_keys($psr4) as $key) {
        $directory = trim($key, '\\');
        if (!in_array($directory, $subdirectories)) {
            unset($psr4[$key]);
            $removedDirectories[] = $directory;
        }
    }

    foreach ($subdirectories as $subdirectory) {

        if (isset($psr4[$subdirectory . '\\']) || $subdirectory === '.\\' || $subdirectory === '..\\') {
            continue;
        }

        if (!is_dir($currentDir . '/' . $subdirectory)) {
            unset($psr4[$subdirectory . '\\']);
            continue;
        }

        $addedDirectory = $subdirectory;

        $psr4[$subdirectory . '\\'] = $subdirectory . '/';
    }

    $autoload['psr-4'] = $psr4;
    $composerData['autoload'] = $autoload;

    file_put_contents($composerFile, json_encode($composerData, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    chmod($composerFile, 0664);

    chmod($currentDir, 0775);

    if (!empty($removedDirectories)) {
        echo "The following directories were removed from PSR-4 autoload:" . PHP_EOL;
        foreach ($removedDirectories as $directory) {
            echo $directory . PHP_EOL;
        }
        echo PHP_EOL;
    }

    if (!empty($addedDirectory)) {
        echo "The directory '$addedDirectory' was added to PSR-4 autoload." . PHP_EOL;
    } else {
        if (empty($removedDirectories)) {
            echo "No changes were made." . PHP_EOL;
        }
    }
}

updateComposerJson();
