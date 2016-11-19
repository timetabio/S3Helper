<?php
namespace Timetabio\S3Helper\Builders
{
    use Timetabio\S3Helper\Signing\Credential;
    use Timetabio\S3Helper\Signing\Date;
    use Timetabio\S3Helper\Signing\Signature;
    use Timetabio\S3Helper\Signing\SigningKey;
    use Timetabio\S3Helper\ValueObjects\Configuration;
    use Timetabio\S3Helper\ValueObjects\FileUpload;

    class UploadBuilder
    {
        /**
         * @var Configuration
         */
        private $configuration;

        public function __construct(Configuration $configuration)
        {
            $this->configuration = $configuration;
        }

        public function buildUploadParams(
            FileUpload $file,
            int $maxUploadSize,
            int $expires,
            string $acl = 'public-read'
        ): array
        {
            $configuration = $this->configuration;

            $date = new Date;
            $expiration = new Date(time() + $expires);

            $credential = new Credential($configuration->getAccessKey(), $date, $configuration->getRegion());
            $signingKey = new SigningKey($configuration->getAccessSecret(), $date, $configuration->getRegion());

            $policy = $this->buildPolicy($date, $expiration, $file, $credential, $maxUploadSize);
            $encodedPolicy = base64_encode(json_encode($policy));

            $signedPolicy = new Signature($signingKey, $encodedPolicy);

            return [
                'key' => $file->getFilename(),
                'acl' => $acl,
                'success_action_status' => '201',
                'Content-Type' => $file->getMimeType(),
                'policy' => $encodedPolicy,
                'x-amz-algorithm' => 'AWS4-HMAC-SHA256',
                'x-amz-credential' => $credential,
                'x-amz-date' => $date->getLongFormatString(),
                'x-amz-signature' => $signedPolicy
            ];
        }

        private function buildPolicy(
            Date $date,
            Date $expiration,
            FileUpload $file,
            Credential $credential,
            int $maxUploadSize
        ): array
        {
            return [
                'expiration' => $expiration->getIsoString(),
                'conditions' => [
                    ['bucket' => $this->configuration->getBucket()],
                    ['key' => $file->getFilename()],
                    ['acl' => 'public-read'],
                    ['success_action_status' => '201'],
                    ['Content-Type' => $file->getMimeType()],
                    ['content-length-range', 0, $maxUploadSize],
                    ['x-amz-algorithm' => 'AWS4-HMAC-SHA256'],
                    ['x-amz-credential' => $credential],
                    ['x-amz-date' => $date->getLongFormatString()]
                ]
            ];
        }
    }
}
