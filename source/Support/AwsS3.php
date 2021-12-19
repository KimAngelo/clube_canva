<?php

namespace Source\Support;

use Aws\S3\S3Client;
use League\Flysystem\AwsS3V3\AwsS3V3Adapter;
use League\Flysystem\Filesystem;
use League\Flysystem\FilesystemException;
use League\Flysystem\StorageAttributes;
use League\Flysystem\UnableToCheckFileExistence;
use League\Flysystem\UnableToDeleteFile;
use League\Flysystem\UnableToWriteFile;

class AwsS3
{
    private $filesystem;
    private $adapter;

    public function __construct()
    {
        $client = new S3Client([
            'credentials' => [
                'key' => env('AWS_S3_KEY'),
                'secret' => env('AWS_S3_SECRET'),
            ],
            'region' => env('AWS_S3_REGION'),
            'version' => env('AWS_S3_VERSION'),
        ]);
        $this->adapter = new AwsS3V3Adapter(
            $client, env('AWS_S3_BUCKET'),
            env('AWS_S3_PREFIX')
        );
        $this->filesystem = new Filesystem($this->adapter);
    }

    public function adapter()
    {
        return $this->adapter;
    }

    public function write($path, $content): bool
    {
        try {
            $this->filesystem->write($path, $content, ['visibility' => 'public']);
            return true;
        } catch (FilesystemException | UnableToWriteFile $exception) {
            return false;
        }
    }

    public function delete($path): bool
    {
        try {
            $this->filesystem->delete($path);
            return true;
        } catch (FilesystemException | UnableToDeleteFile $exception) {
            return false;
        }
    }

    public function listContent($path)
    {
        /** @var string[] $allPaths */
        $allPaths = $this->filesystem->listContents($path, true)
            ->filter(fn (StorageAttributes $attributes) => $attributes->isFile())
            ->map(fn (StorageAttributes $attributes) => $attributes->path())
            ->toArray();
    }

    public function fileExists($path)
    {
        try {
            if ($this->filesystem->fileExists($path)) {
                return true;
            }
            return false;
        } catch (FilesystemException | UnableToCheckFileExistence $exception) {
            return false;
        }
    }


}