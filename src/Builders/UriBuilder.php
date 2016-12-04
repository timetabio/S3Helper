<?php
/**
 * (c) 2016 Ruben Schmidmeister
 */
namespace Timetabio\S3Helper\Builders
{
    class UriBuilder
    {
        /**
         * @var string
         */
        private $bucketName;

        public function __construct(string $bucketName)
        {
            $this->bucketName = $bucketName;
        }

        public function buildBucketHost(): string
        {
            return $this->bucketName . '.s3.amazonaws.com';
        }

        public function buildBucketUrl(): string
        {
            return 'https://' . $this->buildBucketHost();
        }

        public function buildObjectUrl(string $objectName): string
        {
            return $this->buildBucketUrl() . '/' . $objectName;
        }
    }
}
