<?php
/**
 * (c) 2016 Ruben Schmidmeister
 */
namespace Timetabio\S3Helper\Signing
{
    use Timetabio\S3Helper\ValueObjects\Headers;

    class AuthorizationHeader
    {
        /**
         * @var Credential
         */
        private $credential;

        /**
         * @var Headers
         */
        private $headers;

        /**
         * @var Signature
         */
        private $signature;

        public function __construct(Credential $credential, Headers $headers, Signature $signature)
        {
            $this->credential = $credential;
            $this->headers = $headers;
            $this->signature = $signature;
        }

        public function __toString(): string
        {
            return 'AWS4-HMAC-SHA256 ' . implode(',', [
                'Credential=' . $this->credential,
                'SignedHeaders=' . $this->headers->getNamesString(),
                'Signature=' . $this->signature
            ]);
        }
    }
}
