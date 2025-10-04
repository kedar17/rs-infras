<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Proposal PDF</title>
    <style>
        @page {
            margin: 150px 25px 120px 25px;
        }
        body {
            font-family: DejaVu Sans, sans-serif;
            margin: 0;
            padding: 0;
        }
        header {
            position: fixed;
            top: -120px;
            left: 0;
            right: 0;
            height: 160px;
        }
        footer {
            position: fixed;
            bottom: -100px;
            left: 0;
            right: 0;
            height: 100px;
        }
        .header-table {
            width: 100%;
            border-bottom: 4px solid #0ea5e9;
            background: #fff;
        }
        .footer-table {
            width: 100%;
            border-top: 1px solid #ddd;
            font-size: 16px;
            color: #666;
            background: none;
            padding: 0;
        }
        .content {
            margin: 20px 0;
            padding: 0;
        }
        .content-section {
            margin-bottom: 15px;
        }
        .meta {
            margin-bottom: 15px;
            font-size: 15px;
        }
        .html-content {
            font-size: 15px;
        }
        h3 {
            color: #0ea5e9;
            margin-bottom: 8px;
        }
        table, th, td {
            page-break-inside: avoid !important;
        }
        .bom-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        .bom-table th, 
        .bom-table td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        .bom-table th {
            background-color: #f8f9fa;
        }
    </style>

</head>
<body>
    <header>
        <table class="header-table" cellpadding="0" cellspacing="0">
            <tr>
                <!-- <td width="25%" style="padding:10px;" align="left">
                    <img src="https://logovectorseek.com/wp-content/uploads/2020/02/demos-logo-vector.png" 
                         alt="Company Logo" 
                         style="display:block; max-width:120px;">
                </td> -->
                <td width="50%" style="padding:10px; text-align:left;">
                    <div style="font-size:20px; font-weight:bold; color:#0ea5e9;">
                        RS INFRAS
                    </div>
                    <div style="font-size:12px; color:#666;">
                        Reference: <strong>{{ $proposal->reference }}</strong>
                    </div>
                </td>
                <td width="25%" style="padding:10px; text-align:right; font-size:12px; color:#555;">
                   
                    <div> +91 94825 19301</div>
                    <div> rsinfras@gmail.com</div>
                    <div> www.rsinfras.com</div>
                </td>
            </tr>
        </table>
    </header>

    <footer>
        <table class="footer-table">
            <tr>
                <td style="padding: 10px;">
                    <p style="margin: 0;">For, RS INFRAS </p>
                    <p style="margin: 0;"><strong>{{ $proposal->signatory_name }}</strong></p>
                    <p style="margin: 0;">{{ $proposal->signatory_role }}</p>
                </td>
                <td style="text-align:right; padding: 10px; font-size:12px;">
                 
                </td>
            </tr>
        </table>
    </footer>

    <div class="content">
        <div class="meta">
            <div>To,</div>
            <div><strong>{{ $proposal->client_name }}</strong></div>
            <div>{{ $proposal->client_address }}</div>
            <div>Mobile: {{ $proposal->client_mobile }}</div>
        </div>

        <div class="content-section">
            <div><strong>Subject: {{ $proposal->subject }}</strong></div>
        </div>

        <div class="content-section html-content">
            {!! $proposal->body_intro !!}
        </div>

        <div class="content-section">
            <h3>BOM Item Wise Details:</h3>
            <table class="bom-table">
                <thead>
                    <tr>
                        <th width="8%">S.No.</th>
                        <th width="52%">Item</th>
                        <th width="20%">Make</th>
                        <th width="20%">Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        if (is_string($proposal->items)) {
                            $items = json_decode($proposal->items, true) ?? [];
                        } else {
                            $items = is_array($proposal->items) ? $proposal->items : [];
                        }
                        $counter = 1;
                        $hasCustomItems = is_array($items) && count($items) > 0;
                    @endphp
                    
                    @if($hasCustomItems)
                        @foreach($items as $item)
                            <tr>
                                <td>{{ $counter }}</td>
                                <td>{{ $item['description'] ?? '' }}</td>
                                <td>{{ $item['make'] ?? '' }}</td>
                                <td>{{ $item['qty'] ?? '' }}</td>
                            </tr>
                            @php $counter++; @endphp
                        @endforeach
                    @else
                        <tr>
                            <td>1</td>
                            <td>Solar On-Grid Inverter - 3KW-1Phase</td>
                            <td>1 No.</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Solar Modules Mono PERC 560Wp</td>
                            <td>6 Nos.</td>
                            <td></td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <div class="content-section">
            <h3>PRICE SCHEDULE</h3>
            <p>The Total Project Cost including Supply of material along with installation & commissioning is</p>
            <p>Rs {{ number_format($proposal->price_total, 2) }}/- (Including GST @ {{ $proposal->price_gst_percent }} %).</p>
            <p>(In Words: {{ $proposal->price_in_words }}.)</p>
        </div>

        @if(!empty($proposal->scope_of_work))
        <div class="content-section html-content">
            <h3>Scope of Work:</h3>
            {!! $proposal->scope_of_work !!}
        </div>
        @endif

      
        @if(!empty($proposal->warranty))
        <div class="content-section html-content">
            <h3>Warranty:</h3>
            {!! $proposal->warranty !!}
        </div>
        @endif

        @if(!empty($proposal->payment_schedule))
        <div class="content-section html-content">
            <h3>Payment Schedule</h3>
            {!! $proposal->payment_schedule !!}
        </div>
        @endif

        @if(!empty($proposal->notes))
        <div class="content-section html-content">
            <h3>Note:</h3>
            {!! $proposal->notes !!}
        </div>
        @endif
    </div>
    <script type="text/php">
        if ( isset($pdf) ) {
            $x = 512;
            $y = 800;
            $text = "Page {PAGE_NUM} of {PAGE_COUNT}";
            $font = $fontMetrics->get_font("DejaVu Sans", "normal");
            $size = 10;
            $color = array(0,0,0);
            $word_space = 0.0;  
            $char_space = 0.0;  
            $angle = 0.0;   
            $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
        }
    </script>
</body>
</html>