<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: DejaVu Sans, sans-serif; font-size: 13px; color: #1f2937; background: #fff; }
        .page { padding: 40px; }

        .header { display: flex; justify-content: space-between; margin-bottom: 32px; }
        .header h1 { font-size: 28px; font-weight: 700; color: #111827; }
        .header .meta { text-align: right; color: #6b7280; font-size: 12px; }
        .header .meta .number { font-size: 18px; font-weight: 600; color: #111827; margin-bottom: 4px; }

        .badge { display: inline-block; padding: 2px 10px; border-radius: 9999px; font-size: 11px; font-weight: 600; }
        .badge-draft    { background: #f3f4f6; color: #374151; }
        .badge-sent     { background: #dbeafe; color: #1e40af; }
        .badge-accepted { background: #d1fae5; color: #065f46; }
        .badge-rejected { background: #fee2e2; color: #991b1b; }
        .badge-expired  { background: #fef3c7; color: #92400e; }

        .parties { display: flex; gap: 24px; margin-bottom: 32px; }
        .party { flex: 1; }
        .party-label { font-size: 11px; font-weight: 600; text-transform: uppercase; color: #9ca3af; margin-bottom: 6px; letter-spacing: 0.05em; }
        .party-name { font-size: 15px; font-weight: 600; color: #111827; }
        .party-sub { font-size: 12px; color: #6b7280; margin-top: 2px; }

        .meta-row { display: flex; gap: 24px; margin-bottom: 32px; }
        .meta-item { }
        .meta-item .label { font-size: 11px; font-weight: 600; text-transform: uppercase; color: #9ca3af; margin-bottom: 4px; letter-spacing: 0.05em; }
        .meta-item .value { font-size: 13px; color: #374151; }

        table { width: 100%; border-collapse: collapse; margin-bottom: 24px; }
        thead th { background: #f9fafb; border-bottom: 2px solid #e5e7eb; padding: 10px 12px; text-align: left; font-size: 11px; font-weight: 600; text-transform: uppercase; color: #6b7280; letter-spacing: 0.05em; }
        thead th.right { text-align: right; }
        tbody td { padding: 10px 12px; border-bottom: 1px solid #f3f4f6; vertical-align: top; }
        tbody td.right { text-align: right; }
        tbody tr:last-child td { border-bottom: none; }

        .totals { margin-left: auto; width: 280px; }
        .totals table { margin-bottom: 0; }
        .totals td { padding: 6px 12px; border: none; font-size: 13px; }
        .totals td.right { text-align: right; }
        .totals .grand { font-weight: 700; font-size: 15px; border-top: 2px solid #e5e7eb; }

        .notes { margin-top: 32px; padding: 16px; background: #f9fafb; border-radius: 6px; }
        .notes .label { font-size: 11px; font-weight: 600; text-transform: uppercase; color: #9ca3af; margin-bottom: 6px; letter-spacing: 0.05em; }
        .notes p { font-size: 13px; color: #374151; line-height: 1.6; }

        .footer { margin-top: 48px; text-align: center; font-size: 11px; color: #9ca3af; border-top: 1px solid #f3f4f6; padding-top: 16px; }
    </style>
</head>
<body>
<div class="page">

    <div class="header">
        <div>
            <h1>{{ $quote->team->name }}</h1>
        </div>
        <div class="meta">
            <div class="number">{{ $quote->quote_number }}</div>
            <span class="badge badge-{{ $quote->status->value }}">{{ $quote->status->getLabel() }}</span>
        </div>
    </div>

    <div class="parties">
        @if($quote->company)
        <div class="party">
            <div class="party-label">Bill To</div>
            <div class="party-name">{{ $quote->company->name }}</div>
            @if($quote->contact)
            <div class="party-sub">{{ $quote->contact->name }}</div>
            @endif
        </div>
        @elseif($quote->contact)
        <div class="party">
            <div class="party-label">Bill To</div>
            <div class="party-name">{{ $quote->contact->name }}</div>
        </div>
        @endif

        @if($quote->opportunity)
        <div class="party">
            <div class="party-label">Opportunity</div>
            <div class="party-name">{{ $quote->opportunity->name }}</div>
        </div>
        @endif
    </div>

    <div class="meta-row">
        <div class="meta-item">
            <div class="label">Issue Date</div>
            <div class="value">{{ $quote->created_at->format('d M Y') }}</div>
        </div>
        @if($quote->valid_until)
        <div class="meta-item">
            <div class="label">Valid Until</div>
            <div class="value">{{ $quote->valid_until->format('d M Y') }}</div>
        </div>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th style="width:40%">Description</th>
                <th class="right" style="width:10%">Qty</th>
                <th class="right" style="width:15%">Unit Price</th>
                <th class="right" style="width:10%">Discount</th>
                <th class="right" style="width:10%">Tax</th>
                <th class="right" style="width:15%">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($quote->lineItems as $item)
            <tr>
                <td>{{ $item->description }}</td>
                <td class="right">{{ number_format((float) $item->quantity, 2) }}</td>
                <td class="right">{{ number_format((float) $item->unit_price, 2) }}</td>
                <td class="right">{{ number_format((float) $item->discount_pct, 2) }}%</td>
                <td class="right">{{ number_format((float) $item->tax_pct, 2) }}%</td>
                <td class="right">{{ number_format($item->total, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="totals">
        <table>
            <tr>
                <td>Subtotal</td>
                <td class="right">{{ number_format($quote->subtotal, 2) }}</td>
            </tr>
            <tr>
                <td>Tax</td>
                <td class="right">{{ number_format($quote->total_tax, 2) }}</td>
            </tr>
            <tr class="grand">
                <td>Total</td>
                <td class="right">{{ number_format($quote->grand_total, 2) }}</td>
            </tr>
        </table>
    </div>

    @if($quote->notes)
    <div class="notes">
        <div class="label">Notes</div>
        <p>{{ $quote->notes }}</p>
    </div>
    @endif

    <div class="footer">
        Generated by {{ $quote->team->name }} &mdash; {{ now()->format('d M Y') }}
    </div>

</div>
</body>
</html>
