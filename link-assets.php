#!/usr/bin/env php
<?php

// base directory where symlinks will be created
$baseAssetsPath = './public/assets';

// mapping of symlinks to target directories
// if symlink part contains directories they will be created
// fill it with your own configuration
$pathsMapping = array(
    'symlink-name' => './abcd/module/resources/public',
    'symlink-path/link-name' => './some-target-path/you-want-to-link-to',
    'hmm' => './vendor/something/something'
);

define('DS', DIRECTORY_SEPARATOR);

// not sure if its necessary but clear cache
// as it can influence is_dir results
clearstatcache();

$realAssetsPath = realpath($baseAssetsPath);

if (!is_string($realAssetsPath) || !is_dir($realAssetsPath))
{
    $message = sprintf('Base assets path is not a directory ' . PHP_EOL . 'source path: %s' . PHP_EOL . 'real path: %s', $baseAssetsPath, $realAssetsPath);
    throw new \Exception($message);
}

foreach ($pathsMapping as $symlinkPath => $targetPath)
{
    $symlinkSource = $realAssetsPath . DS . $symlinkPath;
    $symlinkParentPath = dirname($symlinkSource);

    if (!is_dir($symlinkParentPath))
    {
        $result = mkdir($symlinkParentPath, 0777, true);

        if (!$result)
        {
            $message = sprintf('Creation of link parent path failed: ' . PHP_EOL . 'path to be created: %s' . PHP_EOL . 'occured on link: %s', $symlinkParentPath, $symlinkPath);
            throw new \Exception($message);
        }

        echo sprintf('Created symlink parent path: ' . PHP_EOL . '%s', $symlinkParentPath) . PHP_EOL;
    }

    if (is_link($symlinkSource))
    {
        echo sprintf('Target symlink already exists: ' . PHP_EOL . 'link: %s' . PHP_EOL . 'configured target: %s' . PHP_EOL . 'currently links to: %s', $symlinkSource, $targetPath, readlink($symlinkSource)) . PHP_EOL;
        echo sprintf('Skipping item...') . PHP_EOL;
        echo '---------------------------------' . PHP_EOL;
        continue;
    }

    $realTargetPath = realpath($targetPath);

    if (!is_string($realTargetPath) || !is_dir($realTargetPath))
    {
        $message = sprintf('Symlink target path is not directory or does not exists: ' . PHP_EOL . '%s', $realTargetPath);
        throw new \Exception($message);
    }

    $result = symlink($realTargetPath, $symlinkSource);

    if (!$result)
    {
        $message = sprintf('Creation of symlink failed: ' . PHP_EOL . 'from: %s' . PHP_EOL . 'to: %s', $symlinkSource, $realTargetPath);
        throw new \Exception($message);
    }

    echo sprintf('Succesfully created symlink: ' . PHP_EOL . 'from: %s' . PHP_EOL . 'to: %s', $symlinkSource, $realTargetPath) . PHP_EOL;
    echo '---------------------------------' . PHP_EOL;
}
