<?php
/**
 * (c) 2016 Ruben Schmidmeister
 */
namespace Timetabio\S3Helper\ValueObjects
{
    class FileUpload
    {
        /**
         * @var string
         */
        private $filename;

        /**
         * @var string
         */
        private $mimeType;

        public function __construct(string $filename, string $mimeType)
        {
            $this->filename = $filename;
            $this->mimeType = $mimeType;
        }

        public function getFilename(): string
        {
            return $this->filename;
        }

        public function getMimeType(): string
        {
            return $this->mimeType;
        }
    }
}
