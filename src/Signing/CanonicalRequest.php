<?php
namespace Timetabio\S3Helper\Signing
{
    use Timetabio\S3Helper\ValueObjects\Headers;
    use Timetabio\S3Helper\ValueObjects\Uri;

    class CanonicalRequest
    {
        /**
         * @var string
         */
        private $method;

        /**
         * @var Uri
         */
        private $uri;

        /**
         * @var Headers
         */
        private $headers;

        /**
         * @var string
         */
        private $payloadHash;

        public function __construct(string $method, Uri $uri, Headers $headers, string $payloadHash)
        {
            $this->method = $method;
            $this->uri = $uri;
            $this->headers = $headers;
            $this->payloadHash = $payloadHash;
        }

        public function __toString(): string
        {
            return implode("\n", [
                $this->method,
                $this->uri->getPath(),
                $this->uri->getQueryString(),
                $this->headers,
                $this->headers->getNamesString(),
                $this->payloadHash
            ]);
        }
    }
}
