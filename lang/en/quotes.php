<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Quotes',
    ],

    'statuses' => [
        'draft'    => 'Draft',
        'sent'     => 'Sent',
        'accepted' => 'Accepted',
        'rejected' => 'Rejected',
        'expired'  => 'Expired',
    ],

    'sections' => [
        'details'    => 'Quote Details',
        'line_items' => 'Line Items',
        'notes'      => 'Notes',
    ],

    'fields' => [
        'quote_number'             => 'Quote Number',
        'quote_number_placeholder' => 'Auto-generated on save',
        'status'                   => 'Status',
        'opportunity'              => 'Opportunity',
        'company'                  => 'Company',
        'contact'                  => 'Contact',
        'valid_until'              => 'Valid Until',
        'notes'                    => 'Notes',
        'product'                  => 'Product',
        'description'              => 'Description',
        'quantity'                 => 'Qty',
        'unit_price'               => 'Unit Price',
        'discount_pct'             => 'Discount',
        'tax_pct'                  => 'Tax',
        'line_total'               => 'Total',
        'subtotal'                 => 'Subtotal',
        'total_tax'                => 'Tax Total',
        'grand_total'              => 'Grand Total',
    ],

    'actions' => [
        'add_line_item' => 'Add line item',
        'download_pdf'  => 'Download PDF',
        'send_quote'    => 'Send Quote',
    ],

    'email' => [
        'default_subject' => 'Quote :number from :team',
        'default_body'    => '<p>Please find attached quote <strong>:number</strong> from <strong>:team</strong>.</p><p>If you have any questions, please don\'t hesitate to get in touch.</p><p>Kind regards,<br>:team</p>',
    ],

    'filters' => [
        'status' => 'Status',
    ],
];
