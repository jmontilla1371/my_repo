<?php

require __DIR__ . '/../vendor/autoload.php';

// Alias global Cezpdf a nuestro adapter para minimizar cambios legacy
class_alias(Legacy\EzPdf\CezpdfAdapter::class, 'Cezpdf');
