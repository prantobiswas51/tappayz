<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class VccService
{
    protected string $baseUrl;
    protected string $userSerial;
    protected string $secretKey;

    public function __construct()
    {
        $this->baseUrl    = 'http://api.vcc.center';
        $this->userSerial = '0852811946422621';
        $this->secretKey  = 'Okfc-yMDRgKig4E2V75pxw==';
    }

    protected function sign(array $params): string
    {
        // Remove empty values
        $filtered = array_filter($params, fn($v) => $v !== null && $v !== '');
        // Sort by key
        ksort($filtered);
        // Build query string
        $stringA = urldecode(http_build_query($filtered));
        // Replace + with %20
        $stringA = str_replace('+', '%20', $stringA);
        // Append secret key
        $stringSignTemp = $stringA . "&key=" . $this->secretKey;
        // MD5 -> uppercase
        return strtoupper(md5($stringSignTemp));
    }
}
