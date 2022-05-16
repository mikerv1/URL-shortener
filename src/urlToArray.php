<?php

declare(strict_types=1);

namespace App;

function urlToArray($dividedUrl): array
{
    return [
        'getScheme' => $dividedUrl->getScheme(), // 'https'
        'getHost' => $dividedUrl->getHost(), // 'spatie.be'
        'getPath' => $dividedUrl->getPath(), // '/opensource'
        'getOne' => $dividedUrl->getQueryParameter('one'),
        'getTwo' => $dividedUrl->getQueryParameter('two'),
        'utmContent' => $dividedUrl->getQueryParameter('utm_content'),
        'utmMedium' => $dividedUrl->getQueryParameter('utm_medium'),
        'utmSource' => $dividedUrl->getQueryParameter('utm_source'),
        'utmCampaing' => $dividedUrl->getQueryParameter('utm_campaign'),
        'utmTerm' => $dividedUrl->getQueryParameter('utm_term')
    ];
}
