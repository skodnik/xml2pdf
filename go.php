<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

$xmls = [
    '77-05-0010004-30629-202110170314.xml',
    '77-05-0010004-30629-202110170327.xml',
];

$arrays = [];

foreach ($xmls as $key => $fileName) {
    $xml = simplexml_load_string(
        mb_convert_encoding(file_get_contents(__DIR__ . '/data/' . $fileName), 'UTF-8', 'UTF-8'),
        "SimpleXMLElement",
        LIBXML_NOCDATA
    );
    $json = json_encode($xml);

    $arrays[] = json_decode($json, true);
}

$result = [];

foreach ($arrays as $key => $array) {
    $array['ReestrExtract' . $key] = $array['ReestrExtract'];
    unset($array['ReestrExtract']);

    $result = array_merge($result, $array);
}

$structure = [
    [
        'tag' => 'Result',
        'elements' => [
            [
                'tag' => 'item',
                'attributes' => [
                    'DispathNumber' => '1',
                    'Date' => '2',
                ],
            ],
        ],
    ],
];

$newXml = (new \bupy7\xml\constructor\XmlConstructor())
    ->fromArray($structure)
    ->toOutput();

$pdf = new TCPDF(
    PDF_PAGE_ORIENTATION,
    PDF_UNIT,
    PDF_PAGE_FORMAT,
    true,
    'UTF-8',
    false,
);
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
$pdf->AddPage();
$pdf->Write(0, $newXml);
$pdf->Output(__DIR__ . '/data/result.pdf', 'F');