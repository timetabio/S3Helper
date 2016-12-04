<?php
/**
 * (c) 2016 Ruben Schmidmeister
 */
namespace Timetabio\S3Helper\ValueObjects
{
    class Configuration
    {
        /**
         * @var string
         */
        private $accessKey;

        /**
         * @var string
         */
        private $accessSecret;

        /**
         * @var string
         */
        private $region;

        /**
         * @var string
         */
        private $bucket;

        public function __construct(string $accessKey, string $accessSecret, string $region, string $bucket)
        {
            $this->accessKey = $accessKey;
            $this->accessSecret = $accessSecret;
            $this->region = $region;
            $this->bucket = $bucket;
        }

        public function getAccessKey(): string
        {
            return $this->accessKey;
        }

        public function getAccessSecret(): string
        {
            return $this->accessSecret;
        }

        public function getRegion(): string
        {
            return $this->region;
        }

        public function getBucket(): string
        {
            return $this->bucket;
        }
    }
}
