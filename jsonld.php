<?php
$organization = [
    '@type'    => 'LocalBusiness',
    '@id'      => SITE_URL . '/#business',
    'name'     => SITE_NAME . ' ' . SITE_OWNER,
    'url'      => SITE_URL . '/',
    'image'    => SITE_URL . '/img/og-image.jpg',
    'email'    => 'info@astrologieratgeber.ch',
    'telephone' => '+41444420223',
    'priceRange' => 'CHF ' . HOURLY_RATE . '.– pro Stunde',
    'address'  => [
        '@type'           => 'PostalAddress',
        'streetAddress'   => 'Ackerstrasse 56',
        'postalCode'      => '8610',
        'addressLocality' => 'Uster',
        'addressRegion'   => 'Zürich',
        'addressCountry'  => 'CH',
    ],
    'founder' => [
        '@type'      => 'Person',
        '@id'        => SITE_URL . '/#stefanhaas',
        'name'       => SITE_OWNER,
        'jobTitle'   => 'Astrologe',
        'url'        => SITE_URL . '/uebermich',
    ],
    'areaServed' => ['@type' => 'Country', 'name' => 'Schweiz'],
    'knowsLanguage' => 'de-CH',
];

function service_schema(array $svc, string $slug): array
{
    $node = [
        '@type'       => 'Service',
        '@id'         => SITE_URL . '/' . $slug . '#service',
        'name'        => $svc['name'],
        'description' => $svc['description'],
        'url'         => SITE_URL . '/' . $slug,
        'serviceType' => 'Astrologische Beratung',
        'provider'    => ['@id' => SITE_URL . '/#business'],
        'areaServed'  => ['@type' => 'Country', 'name' => 'Schweiz'],
    ];

    $offers = [];
    foreach ($svc['variants'] as $variant) {
        $offers[] = [
            '@type'        => 'Offer',
            'name'         => $variant['name'],
            'availability' => 'https://schema.org/InStock',
            'url'          => SITE_URL . '/' . $slug . '#form',
            'priceSpecification' => [
                '@type'         => 'UnitPriceSpecification',
                'price'         => (string) HOURLY_RATE,
                'priceCurrency' => 'CHF',
                'unitCode'      => 'HUR',
                'referenceQuantity' => [
                    '@type'    => 'QuantitativeValue',
                    'value'    => 1,
                    'unitCode' => 'HUR',
                ],
            ],
            'eligibleDuration' => [
                '@type'    => 'QuantitativeValue',
                'value'    => $variant['hours'],
                'unitCode' => 'HUR',
            ],
        ];
    }
    if ($offers) {
        $node['offers'] = $offers;
    }

    return $node;
}

$graph = [$organization];

switch ($page_jsonld ?? null) {
    case 'home':
        $graph[] = [
            '@type'    => 'WebSite',
            '@id'      => SITE_URL . '/#website',
            'url'      => SITE_URL . '/',
            'name'     => SITE_NAME,
            'inLanguage' => 'de-CH',
            'publisher'  => ['@id' => SITE_URL . '/#business'],
        ];
        foreach (services() as $slug => $svc_item) {
            $graph[] = service_schema($svc_item, $slug);
        }
        break;

    case 'service':
        $graph[] = service_schema($svc, $svc['slug']);
        $graph[] = [
            '@type' => 'BreadcrumbList',
            'itemListElement' => [
                ['@type' => 'ListItem', 'position' => 1, 'name' => 'Startseite', 'item' => SITE_URL . '/'],
                ['@type' => 'ListItem', 'position' => 2, 'name' => $svc['name'], 'item' => SITE_URL . '/' . $svc['slug']],
            ],
        ];
        break;

    case 'about':
        $graph[] = [
            '@type'       => 'AboutPage',
            'url'         => SITE_URL . '/uebermich',
            'mainEntity'  => ['@id' => SITE_URL . '/#stefanhaas'],
        ];
        break;

    case 'offers':
        foreach (services() as $slug => $svc_item) {
            $graph[] = service_schema($svc_item, $slug);
        }
        break;
}

$jsonld = ['@context' => 'https://schema.org', '@graph' => $graph];
?>
<script type="application/ld+json">
<?= json_encode($jsonld, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) ?>

</script>
