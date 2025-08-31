<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title>Fixed Header/Footer + Table Content (Inline CSS)</title>



</head>

<body
  style="margin:0; font-family:Arial, sans-serif; font-size:12pt; -webkit-print-color-adjust:exact; print-color-adjust:exact;">

  <!-- Fixed header (will appear at top of every printed page) -->
  <div
    style="position:fixed; top:0; left:0; right:0; height:72px; box-sizing:border-box; padding:12px 5mm; border-bottom:1px solid #ccc; background:#fff; display:flex; align-items:center; justify-content:space-between; z-index:9999;">
    <div style="font-weight:700; font-size:14pt;">AAYANSH POWER PRIVATE LIMITED</div>
    <div style="">
      <div style="font-weight:400; font-size:14pt;">G.F, H.No.2, LANE No.-8, S.K PURAM, ARYA SAMAJ ROAD, DANAPUR, PATNA (BIHAR) -801503</div>

    </div>
  </div>

  <!-- Fixed footer (will appear at bottom of every printed page) -->
  <div
    style="position:fixed; bottom:0; left:0; right:0; height:48px; box-sizing:border-box; padding:8px 5mm; border-top:1px solid #ccc; background:#fff; display:flex; align-items:center; justify-content:center; color:#444; z-index:9999;">
    <!-- Note: Automatic per-page numbers require @page CSS (limited support). -->
    <!-- <div style="font-size:10pt;">My Company — Address • Phone • Email</div> -->

    <div><strong>AAYANSH POWER PRIVATE LIMITED</strong></div>
    <div>CONTACT No. 9835200147,8750646546 | Email: pankaj.kumar2312@gmail.com | infoaayansh.solarpower@gmail.com</div>
    <div>BANK ACCOUNT: ICICI BANK A/C No. 333905000348, IFSC-ICIC0003339 | GSTIN: 10AACCA6895C1ZM</div>

  </div>

  <!-- Content area. Padding top & bottom reserve space so content doesn't go under header/footer -->
  <div style="padding:92px 5mm 64px; box-sizing:border-box;">
    <!-- Table-based content (inline CSS) -->
    <div class="date-ref">
      <div>Reference: <strong>{{ $proposal->reference }}</strong></div>
    </div>
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
    <table style="width:100%; border-collapse:collapse; table-layout:fixed;">
      <thead>
        <tr>
          <th style="width:20%; border:1px solid #ddd; padding:8px; text-align:left; background:#f7f7f7;">Item
          </th>
          <th style="width:50%; border:1px solid #ddd; padding:8px; text-align:left; background:#f7f7f7;">
            Description</th>
          <th style="width:30%; border:1px solid #ddd; padding:8px; text-align:left; background:#f7f7f7;">
            Notes</th>
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
          <td style="border:1px solid #ddd; padding:8px;">{{ $item['qty'] ?? '' }}</td>
          <td style="border:1px solid #ddd; padding:8px;">{{ isset($item['unit_price']) ? '₹' . number_format($item['unit_price'], 2) : '' }}</td>
        </tr>
        @php $counter++; @endphp
        @endforeach
        <!-- 50 sample rows -->
      </tbody>
    </table>

    <div class="content-section">
        <h3>PRICE SCHEDULE</h3>
        <p>The Total Project Cost including Supply of material along with installation & commissioning is</p>
        <p>Rs {{ number_format($proposal->price_total, 2) }}/- (Including GST @{{ $proposal->price_gst_percent }}%).</p>
        <p>(In Words: {{ $proposal->price_in_words }}.)</p>
      </div>

      @if(!empty($proposal->scope_of_work))
      <div class="content-section html-content">
        <h3>Scope of Work:</h3>
        {!! $proposal->scope_of_work !!}
      </div>
      @endif
    </div>
  </div>

  <!-- Page 3 Content -->
  <div class="page">
    <div class="content">
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

      <div class="signature">
        <p>For, AAYANSH POWER PRIVATE LIMITED</p>
        <p><strong>{{ $proposal->signatory_name }}</strong></p>
        <p>{{ $proposal->signatory_role }}</p>
      </div>
    </div>
  </div>

</body>

</html>