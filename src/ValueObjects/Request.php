<?php
namespace Timetabio\S3Helper\ValueObjects
{
    class Request
    {
        /**
         * @var string
         */
        private $url;

        /**
         * @var array
         */
        private $headers;

        public function __construct(string $url, array $headers)
        {
            $this->url = $url;
            $this->headers = $headers;
        }

        public function getUrl(): string
        {
            return $this->url;
        }

        public function getHeaders(): array
        {
            return $this->headers;
        }
    }
}
