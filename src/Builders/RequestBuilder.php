<?php
/**
 * (c) 2016 Ruben Schmidmeister
 */
namespace Timetabio\S3Helper\Builders
{
    use Timetabio\S3Helper\Signing\AuthorizationHeader;
    use Timetabio\S3Helper\Signing\CanonicalRequest;
    use Timetabio\S3Helper\Signing\Credential;
    use Timetabio\S3Helper\Signing\Date;
    use Timetabio\S3Helper\Signing\RequestSignature;
    use Timetabio\S3Helper\Signing\Signature;
    use Timetabio\S3Helper\Signing\SigningKey;
    use Timetabio\S3Helper\ValueObjects\Configuration;
    use Timetabio\S3Helper\ValueObjects\Headers;
    use Timetabio\S3Helper\ValueObjects\Request;
    use Timetabio\S3Helper\ValueObjects\Uri;

    class RequestBuilder
    {
        /**
         * @var Configuration
         */
        private $configuration;

        /**
         * @var UriBuilder
         */
        private $uriBuilder;

        public function __construct(Configuration $configuration, UriBuilder $uriBuilder)
        {
            $this->configuration = $configuration;
            $this->uriBuilder = $uriBuilder;
        }

        public function buildRequest(string $method, Uri $uri, string $payload = ''): Request
        {
            $configuration = $this->configuration;

            $date = new Date;
            $payloadHash = hash('sha256', $payload);

            $headersArray = [
                'host' => $this->uriBuilder->buildBucketHost(),
                'x-amz-content-sha256' => $payloadHash,
                'x-amz-date' => $date->getLongFormatString()
            ];

            $headers = new Headers($headersArray);
            $canonicalRequest = new CanonicalRequest($method, $uri, $headers, $payloadHash);

            $stringToSign = new RequestSignature($date, $configuration->getRegion(), $canonicalRequest);
            $signingKey = new SigningKey($configuration->getAccessSecret(), $date, $configuration->getRegion());

            $signature = new Signature($signingKey, $stringToSign);
            $credential = new Credential($configuration->getAccessKey(), $date, $configuration->getRegion());

            $headersArray['authorization'] = (string) new AuthorizationHeader($credential, $headers, $signature);

            return new Request(
                $this->uriBuilder->buildBucketUrl() . $uri,
                $headersArray
            );
        }
    }
}
