<?php
/**
 * (c) 2016 Ruben Schmidmeister
 */
namespace Timetabio\S3Helper\Signing
{
    class SigningKey
    {
        /**
         * @var string
         */
        private $value;

        public function __construct(string $secret, Date $date, string $region, string $service = 's3')
        {
            $dateKey = hash_hmac('sha256', $date->getShortFormatString(), 'AWS4' . $secret, true);
            $regionKey = hash_hmac('sha256', $region, $dateKey, true);
            $serviceKey = hash_hmac('sha256', $service, $regionKey, true);

            $this->value = hash_hmac('sha256', 'aws4_request', $serviceKey, true);
        }

        public function __toString(): string
        {
            return $this->value;
        }
    }
}
