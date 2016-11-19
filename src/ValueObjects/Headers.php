<?php
namespace Timetabio\S3Helper\ValueObjects
{
    class Headers
    {
        /**
         * @var array
         */
        private $headers;

        public function __construct(array $headers)
        {
            ksort($headers);

            $this->headers = $headers;
        }

        public function getHeaders(): array
        {
            return $this->headers;
        }

        public function getNamesString(): string
        {
            return implode(';', array_keys($this->headers));
        }

        public function __toString(): string
        {
            $headers = '';

            foreach ($this->headers as $name => $value) {
                $headers .= strtolower($name) . ':' . $value . "\n";
            }

            return $headers;
        }
    }
}
