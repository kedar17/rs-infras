<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Fixed Header/Footer + Table Content (Inline CSS)</title>
</head>

<body style="margin:0; font-family:Arial, sans-serif; font-size:12pt; -webkit-print-color-adjust:exact; print-color-adjust:exact;">

    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;">
        <tr>
            <td align="center">

                <!-- Main Container -->
                <table border="0" cellpadding="0" cellspacing="0" width="800" style="border:1px solid #ddd; border-collapse:collapse;">

                    <!-- Letterhead -->
                    <tr>
                        <td>
                            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-bottom:4px solid #0ea5e9; border-collapse:collapse;">
                                <tr>
                                    <!-- Logo -->
                                    <!-- <td width="25%" style="padding:10px;" align="left">
                                       <img src="https://logovectorseek.com/wp-content/uploads/2020/02/demos-logo-vector.png" alt="Company Logo" style="display:block; max-width:120px;"> 
                                    </td> -->

                                    <!-- Company Name -->
                                    <td width="50%" style="padding:10px; text-align:left;">
                                        <div style="font-size:20px; font-weight:bold; color:#0ea5e9;">RS INFRAS </div>
                                        <div style="font-size:12px; color:#666;">Reference: <strong>{{ $proposal->reference }}</div>
                                    </td>

                                    <!-- Contact Info -->
                                    <td width="25%" style="padding:10px; text-align:right; font-size:12px; color:#555;">
                                        <div> +91 94825 19301</div>
                                        <div> rsinfras@gmail.com</div>
                                        <div> www.rsinfras.com</div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Spacer -->
                    <tr>
                        <td style="height:20px;"></td>
                    </tr>

                    <!-- Document Title -->
                    <tr>
                        <td style="padding:0 20px; font-size:16px;">

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
                            </div>



                            <div class="content-section">
                                <p><strong>Validity of offer:</strong> 7 days from the date of offer.</p>
                                <p><strong>Timeline:</strong> For Installation 20 days. Net Metering: Within 10 Days after Installation.</p>
                            </div>

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






                        </td>
                    </tr>

                    <!-- Spacer -->
                    <tr>
                        <td style="height:20px;"></td>
                    </tr>

                    <!-- Table Content -->
                    <tr>
                        <td style="padding:0 20px;">
                            <table style="width:100%; border-collapse:collapse; table-layout:fixed;">
                                <thead>
                                    <tr>
                                        <th style="width:20%; border:1px solid #ddd; padding:8px; text-align:left; background:#f7f7f7;">Item
                                        </th>
                                        <th style="width:50%; border:1px solid #ddd; padding:8px; text-align:left; background:#f7f7f7;">
                                            Description</th>
                                        <th style="width:30%; border:1px solid #ddd; padding:8px; text-align:left; background:#f7f7f7;">
                                            Notes</th>
                                        <th style="width:30%; border:1px solid #ddd; padding:8px; text-align:left; background:#f7f7f7;">
                                            Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    // Handle both string and array formats for items
                                    if (is_string($proposal->items)) {
                                    $items = json_decode($proposal->items, true) ?? [];
                                    } else {
                                    $items = is_array($proposal->items) ? $proposal->items : [];
                                    }
                                    $counter = 1;
                                    $hasCustomItems = is_array($items) && count($items) > 0;
                                    @endphp

                                    @foreach($items as $item)
                                    <tr>
                                        <td style="border:1px solid #ddd; padding:8px;">{{ $counter }}</td>
                                        <td style="border:1px solid #ddd; padding:8px;">{{ $item['description'] ?? '' }}</td>
                                        <td style="border:1px solid #ddd; padding:8px;">{{ $item['make'] ?? '' }}</td>
                                        <td style="border:1px solid #ddd; padding:8px;">{{ $item['qty'] ?? '' }}</td>
                                    </tr>
                                    @php $counter++; @endphp
                                    @endforeach
                                    <!-- 50 sample rows -->
                                </tbody>
                            </table>
                        </td>
                    </tr>

                    <!-- Spacer -->
                    <tr>
                        <td style="height:30px;"></td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td bgcolor="#f9fafb" style="padding:12px; font-size:16px;  color:#666; border-top:1px solid #ddd;">
                            <p style="margin: 0;">For, RS INFRAS</p>
                            <p style="margin: 0;"><strong>{{ $proposal->signatory_name }}</strong></p>
                            <p style="margin: 0;">{{ $proposal->signatory_role }}</p>
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>
</body>

</html>