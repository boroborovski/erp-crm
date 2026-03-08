<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Invoices',
    ],

    'statuses' => [
        'draft'   => 'Draft',
        'issued'  => 'Issued',
        'partial' => 'Partial',
        'paid'    => 'Paid',
        'overdue' => 'Overdue',
        'void'    => 'Void',
    ],

    'payment_methods' => [
        'bank'  => 'Bank Transfer',
        'card'  => 'Card',
        'cash'  => 'Cash',
        'other' => 'Other',
    ],

    'sections' => [
        'details'    => 'Invoice Details',
        'line_items' => 'Line Items',
        'payments'   => 'Payments',
        'notes'      => 'Notes',
    ],

    'fields' => [
        'invoice_number'             => 'Invoice Number',
        'invoice_number_placeholder' => 'Auto-generated on save',
        'status'                     => 'Status',
        'quote'                      => 'Quote',
        'company'                    => 'Company',
        'contact'                    => 'Contact',
        'issue_date'                 => 'Issue Date',
        'due_date'                   => 'Due Date',
        'notes'                      => 'Notes',
        'product'                    => 'Product',
        'description'                => 'Description',
        'quantity'                   => 'Qty',
        'unit_price'                 => 'Unit Price',
        'discount_pct'               => 'Discount',
        'tax_pct'                    => 'Tax',
        'line_total'                 => 'Total',
        'subtotal'                   => 'Subtotal',
        'total_tax'                  => 'Tax Total',
        'grand_total'                => 'Grand Total',
        'amount_paid'                => 'Amount Paid',
        'amount_outstanding'         => 'Outstanding',
        'amount'                     => 'Amount',
        'paid_at'                    => 'Paid At',
        'method'                     => 'Method',
        'reference'                  => 'Reference',
    ],

    'actions' => [
        'add_line_item'       => 'Add line item',
        'download_pdf'        => 'Download PDF',
        'send_invoice'        => 'Send Invoice',
        'record_payment'      => 'Record Payment',
        'void_invoice'        => 'Void Invoice',
        'void_confirm'        => 'Are you sure you want to void this invoice?',
        'convert_to_invoice'  => 'Convert to Invoice',
    ],

    'email' => [
        'default_subject' => 'Invoice :number from :team',
        'default_body'    => '<p>Please find attached invoice <strong>:number</strong> from <strong>:team</strong>.</p><p>If you have any questions, please don\'t hesitate to get in touch.</p><p>Kind regards,<br>:team</p>',
    ],

    'filters' => [
        'status' => 'Status',
    ],

    'widgets' => [
        'heading'              => 'Invoice Overview (This Month)',
        'total_invoiced'       => 'Total Invoiced',
        'total_paid'           => 'Total Paid',
        'outstanding_balance'  => 'Outstanding Balance',
    ],
];
