<?php
/**
 * (c) 2016 Ruben Schmidmeister
 */
namespace Timetabio\S3Helper\ValueObjects
{
    class Uri
    {
        /**
         * @var string
         */
        private $path;

        /**
         * @var array
         */
        private $query;

        public function __construct(string $path, array $query = [])
        {
            $this->path = $path;
            $this->query = $query;
        }

        public function getPath(): string
        {
            return $this->path;
        }

        public function getQuery(): array
        {
            return $this->query;
        }

        public function getQueryString(): string
        {
            return http_build_query($this->query);
        }

        public function __toString(): string
        {
            $query = '';

            if (!empty($this->query)) {
                $query = '?' . $this->getQueryString();
            }

            return $this->path . $query;
        }
    }
}
