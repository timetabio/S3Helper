<?php
/**
 * (c) 2016 Ruben Schmidmeister
 */
namespace Timetabio\S3Helper\Signing
{
    class Signature implements \JsonSerializable
    {
        /**
         * @var string
         */
        private $value;

        public function __construct(SigningKey $key, string $value)
        {
            $this->value = hash_hmac('sha256', $value, $key);
        }

        public function __toString(): string
        {
            return $this->value;
        }

        public function jsonSerialize(): string
        {
            return (string) $this;
        }
    }
}
