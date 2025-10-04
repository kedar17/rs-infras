<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Proposal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .editor-toolbar {
            background-color: #f8f9fa;
            border: 1px solid #ced4da;
            border-radius: 4px 4px 0 0;
            padding: 5px;
        }
        .editor-toolbar button {
            background: none;
            border: none;
            padding: 5px 8px;
            cursor: pointer;
            border-radius: 3px;
        }
        .editor-toolbar button:hover {
            background-color: #e9ecef;
        }
        .rich-editor {
            min-height: 150px;
            border: 1px solid #ced4da;
            border-radius: 0 0 4px 4px;
            padding: 10px;
        }
        .section-title {
            border-bottom: 2px solid #0d6efd;
            padding-bottom: 8px;
            margin-top: 25px;
            margin-bottom: 15px;
        }
        .proposal-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            border-radius: 8px;
        }
        .header-bar {
            background: linear-gradient(90deg, #0d6efd, #0dcaf0);
            color: white;
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 25px;
        }
        .btn-primary {
            background: linear-gradient(to right, #0d6efd, #0dcaf0);
            border: none;
        }
        .btn-primary:hover {
            background: linear-gradient(to right, #0b5ed7, #0ba9c5);
        }
        .error-message {
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container my-5">
        <div class="proposal-container">
            <div class="header-bar">
                <h1 class="h3 mb-0"><i class="fas fa-file-alt me-2"></i><b>Create Proposal</b></h1>
            </div>

            <form method="POST" action="{{ route('add-proposal') }}">
                @csrf
                <!-- Date & Reference -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Date</label>
                            <input type="date" name="date" class="form-control" value="{{ old('date') }}" required>
                            @error('date')<p class="text-danger error-message">{{ $message }}</p>@enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Reference</label>
                            <input type="text" name="reference" class="form-control" value="{{ old('reference') }}" maxlength="255" required>
                            @error('reference')<p class="text-danger error-message">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>

                <!-- Client Details -->
                <h4 class="section-title">Client Details</h4>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Client Name</label>
                        <input type="text" name="client_name" class="form-control" value="{{ old('client_name') }}" maxlength="255" required>
                        @error('client_name')<p class="text-danger error-message">{{ $message }}</p>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Client Mobile</label>
                        <input type="tel" name="client_mobile" class="form-control" value="{{ old('client_mobile') }}" maxlength="10" onkeyup="this.value=this.value.replace(/[^0-9]/g,'');" required>
                        @error('client_mobile')<p class="text-danger error-message">{{ $message }}</p>@enderror
                    </div>
                </div>
                <div class="mb-4">
                    <label class="form-label">Client Address</label>
                    <textarea name="client_address" class="form-control" rows="3" required>{{ old('client_address') }}</textarea>
                    @error('client_address')<p class="text-danger error-message">{{ $message }}</p>@enderror
                </div>

                <!-- Proposal Content -->
                <h4 class="section-title">Proposal Content</h4>
                <div class="mb-3">
                    <label class="form-label">Subject</label>
                    <input type="text" name="subject" class="form-control" value="{{ old('subject') }}" maxlength="255" required>
                    @error('subject')<p class="text-danger error-message">{{ $message }}</p>@enderror
                </div>

                <div class="mb-4">
                    <label class="form-label">Body</label>
                    <div class="editor-container">
                        <div class="editor-toolbar">
                            <button type="button" data-command="bold" title="Bold"><i class="fas fa-bold"></i></button>
                            <button type="button" data-command="italic" title="Italic"><i class="fas fa-italic"></i></button>
                            <button type="button" data-command="underline" title="Underline"><i class="fas fa-underline"></i></button>
                            <div class="btn-group">
                                <button type="button" data-command="insertUnorderedList" title="Bullet List"><i class="fas fa-list-ul"></i></button>
                                <button type="button" data-command="insertOrderedList" title="Numbered List"><i class="fas fa-list-ol"></i></button>
                            </div>
                            <button type="button" data-command="justifyLeft" title="Align Left"><i class="fas fa-align-left"></i></button>
                            <button type="button" data-command="justifyCenter" title="Center"><i class="fas fa-align-center"></i></button>
                            <button type="button" data-command="justifyRight" title="Align Right"><i class="fas fa-align-right"></i></button>
                        </div>
                        <div class="rich-editor" contenteditable="true" id="body-intro-editor">{!! old('body_intro', '') !!}</div>
                        <textarea name="body_intro" class="d-none" id="body-intro-textarea" required>{{ old('body_intro') }}</textarea>
                    </div>
                    @error('body_intro')<p class="text-danger error-message">{{ $message }}</p>@enderror
                </div>

                <!-- Line Items -->
                <h4 class="section-title">Line Items</h4>
                <table class="table table-bordered mb-3" id="items-table">
                    <thead class="table-light">
                        <tr>
                            <th>Item</th>
                            <th>Make</th>
                            <th>Quantity</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $items = old('items', [['description' => '', 'qty' => '', 'unit_price' => '']]);
                            if (count($items) === 0) {
                                $items = [['description' => '', 'qty' => '', 'unit_price' => '']];
                            }
                        @endphp
                        @foreach($items as $i => $item)
                        <tr>
                            <td>
                                <input type="text" name="items[{{ $i }}][description]" value="{{ $item['description'] ?? '' }}" class="form-control form-control-sm" required>
                                @error("items.$i.description")<p class="text-danger error-message">{{ $message }}</p>@enderror
                            </td>
                            <td>
                                <input type="text"  name="items[{{ $i }}][make]" value="{{ $item['make'] ?? '' }}" class="form-control form-control-sm"  required>
                                @error("items.$i.unit_price")<p class="text-danger error-message">{{ $message }}</p>@enderror
                            </td>
                            <td>
                                <input type="text" name="items[{{ $i }}][qty]" value="{{ $item['qty'] ?? '' }}" class="form-control form-control-sm"  required>
                                @error("items.$i.qty")<p class="text-danger error-message">{{ $message }}</p>@enderror
                            </td>
                            
                            <td class="text-center">
                                <button type="button" class="btn btn-sm btn-danger remove-row">×</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <button type="button" id="add-item" class="btn btn-sm btn-primary mb-4">
                    <i class="fas fa-plus me-1"></i> Add Item
                </button>

                <!-- Pricing Information -->
                <h4 class="section-title">Pricing Information</h4>
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Total Price (₹)</label>
                            <input type="number" step="0.01" name="price_total" class="form-control" value="{{ old('price_total') }}" min="0" required>
                            @error('price_total')<p class="text-danger error-message">{{ $message }}</p>@enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">GST (%)</label>
                            <input type="number" name="price_gst_percent" class="form-control" value="{{ old('price_gst_percent', 18) }}" min="0" max="100" required>
                            @error('price_gst_percent')<p class="text-danger error-message">{{ $message }}</p>@enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Price in Words</label>
                            <input type="text" name="price_in_words" class="form-control" value="{{ old('price_in_words') }}" maxlength="255" required>
                            @error('price_in_words')<p class="text-danger error-message">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>

                <!-- Additional Sections -->
                <h4 class="section-title">Scope of Work</h4>
                <div class="mb-4">
                    <div class="editor-container">
                        <div class="editor-toolbar">
                            <button type="button" data-command="bold" title="Bold"><i class="fas fa-bold"></i></button>
                            <button type="button" data-command="italic" title="Italic"><i class="fas fa-italic"></i></button>
                            <button type="button" data-command="underline" title="Underline"><i class="fas fa-underline"></i></button>
                            <div class="btn-group">
                                <button type="button" data-command="insertUnorderedList" title="Bullet List"><i class="fas fa-list-ul"></i></button>
                                <button type="button" data-command="insertOrderedList" title="Numbered List"><i class="fas fa-list-ol"></i></button>
                            </div>
                        </div>
                        <div class="rich-editor" contenteditable="true" id="scope-editor">{!! old('scope_of_work', '') !!}</div>
                        <textarea name="scope_of_work" class="d-none" id="scope-textarea" required>{{ old('scope_of_work') }}</textarea>
                    </div>
                    @error('scope_of_work')<p class="text-danger error-message">{{ $message }}</p>@enderror
                </div>

                <h4 class="section-title">Warranty</h4>
                <div class="mb-4">
                    <div class="editor-container">
                        <div class="editor-toolbar">
                            <button type="button" data-command="bold" title="Bold"><i class="fas fa-bold"></i></button>
                            <button type="button" data-command="italic" title="Italic"><i class="fas fa-italic"></i></button>
                            <button type="button" data-command="underline" title="Underline"><i class="fas fa-underline"></i></button>
                            <div class="btn-group">
                                <button type="button" data-command="insertUnorderedList" title="Bullet List"><i class="fas fa-list-ul"></i></button>
                                <button type="button" data-command="insertOrderedList" title="Numbered List"><i class="fas fa-list-ol"></i></button>
                            </div>
                        </div>
                        <div class="rich-editor" contenteditable="true" id="warranty-editor">{!! old('warranty', '') !!}</div>
                        <textarea name="warranty" class="d-none" id="warranty-textarea" required>{{ old('warranty') }}</textarea>
                    </div>
                    @error('warranty')<p class="text-danger error-message">{{ $message }}</p>@enderror
                </div>

                <h4 class="section-title">Payment Schedule</h4>
                <div class="mb-4">
                    <div class="editor-container">
                        <div class="editor-toolbar">
                            <button type="button" data-command="bold" title="Bold"><i class="fas fa-bold"></i></button>
                            <button type="button" data-command="italic" title="Italic"><i class="fas fa-italic"></i></button>
                            <button type="button" data-command="underline" title="Underline"><i class="fas fa-underline"></i></button>
                            <div class="btn-group">
                                <button type="button" data-command="insertUnorderedList" title="Bullet List"><i class="fas fa-list-ul"></i></button>
                                <button type="button" data-command="insertOrderedList" title="Numbered List"><i class="fas fa-list-ol"></i></button>
                            </div>
                        </div>
                        <div class="rich-editor" contenteditable="true" id="payment-editor">{!! old('payment_schedule', '') !!}</div>
                        <textarea name="payment_schedule" class="d-none" id="payment-textarea" required>{{ old('payment_schedule') }}</textarea>
                    </div>
                    @error('payment_schedule')<p class="text-danger error-message">{{ $message }}</p>@enderror
                </div>

                <h4 class="section-title">Notes</h4>
                <div class="mb-4">
                    <div class="editor-container">
                        <div class="editor-toolbar">
                            <button type="button" data-command="bold" title="Bold"><i class="fas fa-bold"></i></button>
                            <button type="button" data-command="italic" title="Italic"><i class="fas fa-italic"></i></button>
                            <button type="button" data-command="underline" title="Underline"><i class="fas fa-underline"></i></button>
                            <div class="btn-group">
                                <button type="button" data-command="insertUnorderedList" title="Bullet List"><i class="fas fa-list-ul"></i></button>
                                <button type="button" data-command="insertOrderedList" title="Numbered List"><i class="fas fa-list-ol"></i></button>
                            </div>
                        </div>
                        <div class="rich-editor" contenteditable="true" id="notes-editor">{!! old('notes', '') !!}</div>
                        <textarea name="notes" class="d-none" id="notes-textarea">{{ old('notes') }}</textarea>
                    </div>
                    @error('notes')<p class="text-danger error-message">{{ $message }}</p>@enderror
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Signatory Name</label>
                            <input type="text" name="signatory_name" class="form-control" value="{{ old('signatory_name') }}" maxlength="255" required>
                            @error('signatory_name')<p class="text-danger error-message">{{ $message }}</p>@enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Signatory Role</label>
                            <input type="text" name="signatory_role" class="form-control" value="{{ old('signatory_role') }}" maxlength="255" required>
                            @error('signatory_role')<p class="text-danger error-message">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="d-flex justify-content-end mt-5">
                    <button type="button" class="btn btn-secondary me-3">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Save Proposal
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize rich text editor functionality
            function initEditor(editorEl, textareaEl) {
                const toolbar = editorEl.previousElementSibling;
                
                // Add event listeners to toolbar buttons
                toolbar.querySelectorAll('button').forEach(button => {
                    button.addEventListener('click', function() {
                        const command = this.dataset.command;
                        document.execCommand(command, false, null);
                        editorEl.focus();
                        updateTextarea(editorEl, textareaEl);
                    });
                });
                
                // Update textarea on editor input
                editorEl.addEventListener('input', function() {
                    updateTextarea(editorEl, textareaEl);
                });
                
                // Initialize content
                updateTextarea(editorEl, textareaEl);
            }
            
            function updateTextarea(editorEl, textareaEl) {
                textareaEl.value = editorEl.innerHTML;
            }
            
            // Initialize all editors
            initEditor(document.getElementById('body-intro-editor'), document.getElementById('body-intro-textarea'));
            initEditor(document.getElementById('scope-editor'), document.getElementById('scope-textarea'));
            initEditor(document.getElementById('warranty-editor'), document.getElementById('warranty-textarea'));
            initEditor(document.getElementById('payment-editor'), document.getElementById('payment-textarea'));
            initEditor(document.getElementById('notes-editor'), document.getElementById('notes-textarea'));
            
            // Add line item functionality
            document.getElementById('add-item').addEventListener('click', function() {
                const table = document.querySelector('#items-table tbody');
                const rowCount = table.children.length;
                const newRow = document.createElement('tr');
                
                newRow.innerHTML = `
                    <td>
                        <input type="text" name="items[${rowCount}][description]" class="form-control form-control-sm" required>
                    </td>
                    <td>
                        <input type="text" name="items[${rowCount}][qty]" class="form-control form-control-sm" min="1" value="1" required>
                    </td>
                    <td>
                        <input type="text" step="0.01" name="items[${rowCount}][make]" class="form-control form-control-sm" min="0" required>
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-sm btn-danger remove-row">×</button>
                    </td>
                `;
                
                table.appendChild(newRow);
            });
            
            // Remove row functionality
            document.addEventListener('click', function(e) {
                if (e.target.matches('.remove-row')) {
                    const row = e.target.closest('tr');
                    if (document.querySelectorAll('#items-table tbody tr').length > 1) {
                        row.remove();
                    }
                }
            });
            
            // Update all textareas before form submission
            document.querySelector('form').addEventListener('submit', function() {
                updateTextarea(document.getElementById('body-intro-editor'), document.getElementById('body-intro-textarea'));
                updateTextarea(document.getElementById('scope-editor'), document.getElementById('scope-textarea'));
                updateTextarea(document.getElementById('warranty-editor'), document.getElementById('warranty-textarea'));
                updateTextarea(document.getElementById('payment-editor'), document.getElementById('payment-textarea'));
                updateTextarea(document.getElementById('notes-editor'), document.getElementById('notes-textarea'));
            });
        });
    </script>
</body>
</html>