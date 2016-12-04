<?php
/**
 * (c) 2016 Ruben Schmidmeister
 */
namespace Timetabio\S3Helper\Signing
{
    class Date
    {
        /**
         * @var int
         */
        private $value;

        public function __construct(int $value = null)
        {
            if ($value === null) {
                $this->value = time();
            } else {
                $this->value = $value;
            }
        }

        public function getShortFormatString(): string
        {
            return gmdate('Ymd', $this->value);
        }

        public function getLongFormatString(): string
        {
            return gmdate('Ymd\THis\Z', $this->value);
        }

        public function getIsoString(): string
        {
            return gmdate('Y-m-d\TH:i:s\Z', $this->value);
        }
    }
}
