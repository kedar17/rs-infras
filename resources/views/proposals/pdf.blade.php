<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <style>
    @page {
      size: A4;
      margin: 0;
    }
    
    body {
      font-family: Arial, sans-serif;
      font-size: 13px;
      line-height: 1.5;
      margin: 0;
      padding: 0;
      color: #333;
      width: 100%;
      box-sizing: border-box;
      background: white;
    }
    
    .page {
      width: 210mm;
      min-height: 297mm;
      margin: 0 auto;
      padding: 100px 25px 80px 25px;
      box-sizing: border-box;
      position: relative;
      background: white;
      page-break-after: always;
    }
    
    /* Fixed header */
    .header {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      height: 90px;
      background: white;
      text-align: center;
      padding: 10px 20px;
      border-bottom: 2px solid #2c5aa0;
      z-index: 100;
    }
    
    .header h1 {
      margin: 4px 0;
      font-size: 18px;
      color: #2c5aa0;
    }
    
    .header div {
      font-size: 12px;
    }
    
    /* Fixed footer */
    .footer {
      position: fixed;
      bottom: 0;
      left: 0;
      right: 0;
      height: 70px;
      background: white;
      text-align: center;
      padding: 8px 20px;
      border-top: 1px solid #eee;
      font-size: 11px;
      color: #666;
      z-index: 100;
    }
    
    /* Content area with constrained width */
    .content {
      width: 100%;
      max-width: 680px;
      margin: 0 auto;
      overflow-wrap: break-word;
    }
    
    /* Date and reference */
    .date-ref {
      text-align: right;
      margin-top: 2rem;
      font-size: 13px;
    }
    
    /* Meta information */
    .meta {
      margin: 15px 0;
      line-height: 1.6;
    }
    
    /* Horizontal rule */
    .divider {
      border-top: 1px solid #ddd;
      margin: 20px 0;
    }
    
    /* Tables */
    table {
      width: 100%;
      border-collapse: collapse;
      margin: 15px 0;
      page-break-inside: avoid;
      font-size: 12px;
    }
    
    th, td {
      border: 1px solid #444;
      padding: 8px;
      text-align: left;
    }
    
    .bom-table th {
      background-color: #f2f2f2;
      font-weight: bold;
    }
    
    /* Content sections */
    .content-section {
      margin-bottom: 20px;
      page-break-inside: avoid;
    }
    
    .content-section h3 {
      color: #2c5aa0;
      border-bottom: 1px solid #ddd;
      padding-bottom: 5px;
      margin-bottom: 10px;
      font-size: 15px;
    }
    
    /* HTML content styling */
    .html-content ul, .html-content ol {
      margin-top: 8px;
      margin-bottom: 15px;
      padding-left: 25px;
    }
    
    .html-content li {
      margin-bottom: 8px;
      line-height: 1.5;
    }
    
    .html-content b, .html-content strong {
      font-weight: bold;
    }
    
    .html-content i, .html-content em {
      font-style: italic;
    }
    
    .html-content u {
      text-decoration: underline;
    }
    
    /* Lists */
    ul, ol {
      margin-top: 8px;
      margin-bottom: 15px;
      padding-left: 25px;
    }
    
    li {
      margin-bottom: 8px;
      line-height: 1.5;
    }
    
    /* Signature area */
    .signature {
      margin-top: 40px;
      padding-top: 20px;
      border-top: 1px solid #ddd;
    }
    
    /* Print styles */
    @media print {
      body {
        background: white;
        margin: 0;
        padding: 0;
      }
      
      .page {
        width: 210mm;
        height: 297mm;
        margin: 0;
        padding: 100px 15mm 80px 15mm;
        box-shadow: none;
      }
      
      .header, .footer {
        position: fixed;
      }
      
      .header {
        top: 0;
        height: 80px;
      }
      
      .footer {
        bottom: 0;
        height: 60px;
        font-size: 10pt;
      }
      
      .content {
        max-width: 160mm;
      }
      
      table {
        font-size: 11pt;
      }
      
      .html-content ul, .html-content ol {
        padding-left: 20px;
      }
    }
  </style>
</head>
<body>
  <!-- Fixed Header -->
  <div class="header">
    <h1>AAYANSH POWER PRIVATE LIMITED</h1>
    <div>G.F, H.No.2, LANE No.-8, S.K PURAM, ARYA SAMAJ ROAD, DANAPUR, PATNA (BIHAR) -801503</div>
  </div>

  <!-- Fixed Footer -->
  <div class="footer">
    <div><strong>AAYANSH POWER PRIVATE LIMITED</strong></div>
    <div>CONTACT No. 9835200147,8750646546 | Email: pankaj.kumar2312@gmail.com | infoaayansh.solarpower@gmail.com</div>
    <div>BANK ACCOUNT: ICICI BANK A/C No. 333905000348, IFSC-ICIC0003339 | GSTIN: 10AACCA6895C1ZM</div>
  </div>

  <!-- Page 1 Content -->
  <div class="page">
    <div class="content">
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
      
      <!-- If there's space on the first page, include BOM -->
      <div class="content-section">
        <h3>BOM Item Wise Details:</h3>
        <table class="bom-table">
          <thead>
            <tr>
              <th width="8%">S.No.</th>
              <th width="52%">Description</th>
              <th width="20%">Quantity</th>
              <th width="20%">Unit Price (₹)</th>
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
            
            @if($hasCustomItems)
              @foreach($items as $item)
                <tr>
                  <td>{{ $counter }}</td>
                  <td>{{ $item['description'] ?? '' }}</td>
                  <td>{{ $item['qty'] ?? '' }}</td>
                  <td>{{ isset($item['unit_price']) ? '₹' . number_format($item['unit_price'], 2) : '' }}</td>
                </tr>
                @php $counter++; @endphp
              @endforeach
            @else
              <!-- Fallback content -->
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
    </div>
  </div>

  <!-- Page 2 Content -->
  <div class="page">
    <div class="content">
      <!-- If BOM was already shown on Page 1, don't show again -->
      @if(/* Logic to determine if BOM was already displayed */ false)
      @else
      <div class="content-section">
        <h3>BOM Item Wise Details:</h3>
        <table class="bom-table">
          <thead>
            <tr>
              <th width="8%">S.No.</th>
              <th width="52%">Description</th>
              <th width="20%">Quantity</th>
              <th width="20%">Unit Price (₹)</th>
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
                  <td>{{ $item['qty'] ?? '' }}</td>
                  <td>{{ isset($item['unit_price']) ? '₹' . number_format($item['unit_price'], 2) : '' }}</td>
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
      @endif

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