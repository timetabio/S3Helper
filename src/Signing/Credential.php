<?php
namespace Timetabio\S3Helper\Signing
{
    class Credential implements \JsonSerializable
    {
        /**
         * @var string
         */
        private $accessKey;

        /**
         * @var Date
         */
        private $date;

        /**
         * @var string
         */
        private $region;

        /**
         * @var string
         */
        private $service;

        public function __construct(string $accessKey, Date $date, string $region, string $service = 's3')
        {
            $this->accessKey = $accessKey;
            $this->date = $date;
            $this->region = $region;
            $this->service = $service;
        }

        public function __toString(): string
        {
            return $this->accessKey . '/' . $this->date->getShortFormatString() . '/' . $this->region . '/' . $this->service . '/aws4_request';
        }

        public function jsonSerialize(): string
        {
            return (string) $this;
        }
    }
}
