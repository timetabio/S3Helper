<?php
namespace Timetabio\S3Helper\Signing
{
    class RequestSignature
    {
        /**
         * @var Date
         */
        private $date;

        /**
         * @var string
         */
        private $regionName;

        /**
         * @var CanonicalRequest
         */
        private $canonicalRequest;

        public function __construct(Date $date, string $regionName, CanonicalRequest $canonicalRequest)
        {
            $this->date = $date;
            $this->regionName = $regionName;
            $this->canonicalRequest = $canonicalRequest;
        }

        public function __toString(): string
        {
            $scope = new RequestScope($this->date, $this->regionName);

            return implode("\n", [
                'AWS4-HMAC-SHA256',
                $this->date->getLongFormatString(),
                $scope,
                hash('sha256', $this->canonicalRequest)
            ]);
        }
    }
}
