<?php
namespace Timetabio\S3Helper\Signing
{
    class RequestScope
    {
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

        public function __construct(Date $date, string $region, string $service = 's3')
        {
            $this->date = $date;
            $this->region = $region;
            $this->service = $service;
        }

        public function __toString(): string
        {
            return $this->date->getShortFormatString() . '/' . $this->region . '/' . $this->service . '/aws4_request';
        }
    }
}
