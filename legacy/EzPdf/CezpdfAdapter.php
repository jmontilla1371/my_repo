<?php

namespace Legacy\EzPdf;

use Mpdf\Mpdf;

class CezpdfAdapter
{
    private Mpdf $mpdf;
    private string $buffer = '';

    public function __construct(string $paper = 'A4', array $options = [])
    {
        $config = [
            'format' => $paper,
            'margin_left' => $options['margin_left'] ?? 15,
            'margin_right' => $options['margin_right'] ?? 15,
            'margin_top' => $options['margin_top'] ?? 16,
            'margin_bottom' => $options['margin_bottom'] ?? 16,
        ];
        $this->mpdf = new Mpdf($config);
    }

    public function ezText(string $text, int $size = 12): void
    {
        $this->buffer .= '<p style="font-size:'.(int)$size.'px">'.htmlspecialchars($text)."</p>\n";
    }

    /**
     * $data: array<array<string,mixed>>
     * $cols: array<string,string> // header => key
     */
    public function ezTable(array $data, array $cols, string $title = '', array $options = []): void
    {
        $border = (int)($options['border'] ?? 1);
        $cellpadding = (int)($options['cellPadding'] ?? 4);
        $this->buffer .= '<h3>'.htmlspecialchars($title)."</h3>";
        $this->buffer .= '<table border="'.$border.'" cellpadding="'.$cellpadding.'" cellspacing="0" width="100%">';
        $this->buffer .= '<thead><tr>';
        foreach ($cols as $header => $_key) {
            $this->buffer .= '<th style="text-align:left">'.htmlspecialchars($header).'</th>';
        }
        $this->buffer .= '</tr></thead><tbody>';
        foreach ($data as $row) {
            $this->buffer .= '<tr>';
            foreach ($cols as $_header => $key) {
                $val = $row[$key] ?? '';
                $this->buffer .= '<td>'.htmlspecialchars((string)$val).'</td>';
            }
            $this->buffer .= '</tr>';
        }
        $this->buffer .= '</tbody></table>';
    }

    public function ezStream(string $filename = 'reporte.pdf'): void
    {
        $this->mpdf->WriteHTML($this->buffer);
        $this->mpdf->Output($filename, \Mpdf\Output\Destination::INLINE);
    }
}
