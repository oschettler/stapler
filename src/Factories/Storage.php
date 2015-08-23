<?php namespace Codesleeve\Stapler\Factories;

use Codesleeve\Stapler\StorableInterface as Storable;
use Codesleeve\Stapler\Storage\Filesystem;
use Codesleeve\Stapler\Storage\S3;
use Codesleeve\Stapler\Storage\Github;
use Codesleeve\Stapler\Stapler;

class Storage
{
    /**
     * Build a storage instance.
     *
     * @param  Storable $storable
     * @return \Codesleeve\Stapler\Storage\StorageableInterface
     */
    public static function create(Storable $storable)
    {
        switch ($storable->storage) {
            case 'filesystem':
                return new Filesystem($storable);
                break;

            case 's3':
                $s3Client = Stapler::getS3ClientInstance($storable);
                return new S3($storable, $s3Client);
                break;

            case 'github':
                return new Github($storable);
                break;

            default:
                return new Filesystem($storable);
                break;
        }
    }
}