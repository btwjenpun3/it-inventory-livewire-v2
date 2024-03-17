<div>
    {{-- Table --}}

    <div class="col-lg-12">
        <div class="card">
            <div class="table-responsive">
                <table class="table table-hover table-vcenter card-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>No. PO Buyer</th>
                            <th>PO Buyer Date</th>
                            <th>Due Date</th>
                            <th>Status</th>
                            <th class="w-1"></th>
                        </tr>
                    </thead>
                    @if (count($data) > 0)
                        <tbody>
                            @foreach ($data as $index => $d)
                                <tr wire:key="{{ $d->id }}">
                                    <td>{{ $data->firstItem() + $index }}</td>
                                    <td><b>{{ $d->po_buyer_no }}</b></td>
                                    <td>{{ $d->po_buyer_date }}</td>
                                    <td>{{ $d->due_date }}</td>
                                    <td>
                                        @switch($d->validate)
                                            @case('Waiting')
                                                <span class="badge bg-warning text-warning-fg">Waiting</span>
                                            @break

                                            @default
                                        @endswitch
                                    </td>
                                    <td>
                                        <div class="btn-list flex-nowrap">
                                            @switch($d->validate)
                                                @case('Waiting')
                                                    <button class="btn-link" data-bs-toggle="modal" data-bs-target="#show-modal"
                                                        wire:click="show({{ $d->id }})">
                                                        Show
                                                    </button>
                                                @break

                                                @default
                                            @endswitch
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    @else
                        <tbody>
                            <tr>
                                <td><i>Belum ada Data</i></td>
                            </tr>
                        </tbody>
                    @endif
                </table>
            </div>
        </div>
    </div>

    {{-- Modal Create --}}

    <div class="modal modal-blur fade" id="create-modal" tabindex="-1" role="dialog" aria-hidden="true"
        wire:ignore.self>
        <div class="modal-dialog modal-full-width modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-blue text-blue-fg">
                    <h5 class="modal-title">Add New</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div wire:target="updateConfirm" wire:loading>
                    <div class="progress progress-sm">
                        <div class="progress-bar progress-bar-indeterminate"></div>
                    </div>
                </div>
                <div wire:target="updateConfirm" wire:loading.remove>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="form-label required mt-3">No. PO
                                            Buyer</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text"
                                            class="form-control border-top-0 border-start-0 border-end-0 @error('po_buyer_no') is-invalid @enderror"
                                            wire:model="po_buyer_no">
                                        @error('po_buyer_no')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-4">
                                        <label class="form-label required mt-3">
                                            PO. Date
                                        </label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="date"
                                            class="form-control border-top-0 border-start-0 border-end-0 @error('po_buyer_date') is-invalid @enderror"
                                            wire:model="po_buyer_date">
                                        @error('po_buyer_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="form-label required mt-3">
                                            Buyer Code
                                        </label>
                                    </div>
                                    <div class="col-md-6">
                                        @if (count($buyers) > 0)
                                            <select
                                                class="form-select border-top-0 border-start-0 border-end-0 @error('buyer_code') is-invalid @enderror"
                                                wire:model="buyer_code"
                                                wire:change="fillBuyerName($event.target.value)">
                                                <option value="">-- Select --</option>
                                                @foreach ($buyers as $buyer)
                                                    <option value="{{ $buyer->id }}">{{ $buyer->code_buyer }} -
                                                        {{ $buyer->buyer_name }}</option>
                                                @endforeach
                                            </select>
                                        @else
                                            <p class="mt-3">
                                                Not found. Please create from <a
                                                    href="{{ route('master.buyer') }}">Master
                                                    Buyer</a>.
                                            </p class="mt-3">
                                        @endif
                                        @error('buyer_code')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-4">
                                        <label class="form-label required mt-3">
                                            Buyer Name
                                        </label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text"
                                            class="form-control border-top-0 border-start-0 border-end-0 @error('buyer_name') is-invalid @enderror"
                                            wire:model="buyer_name" disabled>
                                        @error('buyer_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="form-label required mt-3">
                                            Shipping Date
                                        </label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="date"
                                            class="form-control border-top-0 border-start-0 border-end-0 @error('shipping_date') is-invalid @enderror"
                                            wire:model="shipping_date">
                                        @error('shipping_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label required mt-3">
                                            Deliver Date
                                        </label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="date"
                                            class="form-control border-top-0 border-start-0 border-end-0 @error('delivery_date') is-invalid @enderror"
                                            wire:model="delivery_date">
                                        @error('delivery_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label required mt-3">
                                            Due Date
                                        </label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="date"
                                            class="form-control border-top-0 border-start-0 border-end-0 @error('due_date') is-invalid @enderror"
                                            wire:model="due_date">
                                        @error('due_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 mt-3">
                            <table class="table table-hover table-vcenter card-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Article / Style</th>
                                        <th>Quantity</th>
                                        <th>UoM</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($rows as $key => $row)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                @if (count($articles) > 0)
                                                    <select
                                                        class="form-control @error('rows.{{ $key }}.article') is-invalid @enderror"
                                                        wire:model="rows.{{ $key }}.article">
                                                        <option value="">-- Select --</option>
                                                        @foreach ($articles as $a)
                                                            <option value="{{ $a->id }}">
                                                                {{ $a->article_code }} -
                                                                {{ $a->article_name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('rows.{{ $key }}.article')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                @else
                                                    <p class="mt-3">
                                                        Not found. Please create from <a
                                                            href="{{ route('master.article') }}">Master
                                                            Article</a>.
                                                    </p>
                                                @endif
                                            </td>
                                            <td>
                                                <input type="number"
                                                    class="form-control @error('rows.{{ $key }}.quantity') is-invalid @enderror"
                                                    wire:model="rows.{{ $key }}.quantity">
                                                @error('rows.{{ $key }}.quantity')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </td>
                                            <td>
                                                @if (count($units) > 0)
                                                    <select
                                                        class="form-select @error('rows.{{ $key }}.unit') is-invalid @enderror"
                                                        wire:model="rows.{{ $key }}.unit">
                                                        <option value="">-- Select --</option>
                                                        @foreach ($units as $unit)
                                                            <option value="{{ $unit->id }}">
                                                                {{ $unit->satuan }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('rows.{{ $key }}.unit')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                @else
                                                    <p class="mt-3">
                                                        Not found. Please create from <a
                                                            href="{{ route('master.satuan') }}">Master
                                                            Unit</a>.
                                                    </p>
                                                @endif
                                            </td>
                                            <td class="text-end">
                                                @if ($loop->last)
                                                    <button wire:click="addRow" class="btn btn-success"
                                                        wire:loading.attr="disabled">
                                                        Add new
                                                    </button>
                                                @endif
                                                @if ($loop->first)
                                                @else
                                                    <button wire:click="removeRow({{ $key }})"
                                                        class="btn btn-warning" wire:loading.attr="disabled">
                                                        Remove
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="col-md-12 mt-4">
                            <div class="row">
                                <div class="col-md-8">

                                </div>
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label class="form-label required mt-3">
                                                PIC
                                            </label>
                                        </div>
                                        <div class="col-md-8">
                                            @if (count($pics) > 0)
                                                <select
                                                    class="form-select border-top-0 border-start-0 border-end-0 @error('pic') is-invalid @enderror"
                                                    wire:model="pic">
                                                    <option value="">-- Select --</option>
                                                    @foreach ($pics as $pic)
                                                        <option value="{{ $pic->id }}">{{ $pic->name }} -
                                                            {{ $pic->title }}</option>
                                                    @endforeach
                                                </select>
                                            @else
                                                <p class="mt-3">
                                                    Not found. Please create from <a
                                                        href="{{ route('master.pic') }}">Master
                                                        PIC</a>.
                                                </p>
                                            @endif
                                            @error('pic')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label class="form-label required mt-3">
                                                Currency
                                            </label>
                                        </div>
                                        <div class="col-md-8">
                                            @if (count($currencies) > 0)
                                                <select
                                                    class="form-select border-top-0 border-start-0 border-end-0 @error('currency') is-invalid @enderror"
                                                    wire:model="currency">
                                                    <option value="">-- Select --</option>
                                                    @foreach ($currencies as $currency)
                                                        <option value="{{ $currency->id }}">
                                                            {{ $currency->currency_code }} -
                                                            {{ $currency->currency_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            @else
                                                <p class="mt-3">
                                                    Not found. Please create from <a
                                                        href="{{ route('master.currency') }}">Master
                                                        Currency</a>.
                                                </p>
                                            @endif
                                            @error('currency')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label class="form-label required mt-3">
                                                Discount
                                            </label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text"
                                                class="form-control border-top-0 border-start-0 border-end-0 @error('discount') is-invalid @enderror"
                                                wire:model="discount">
                                            @error('discount')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label class="form-label required mt-3">
                                                DP
                                            </label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text"
                                                class="form-control border-top-0 border-start-0 border-end-0 @error('down_payment') is-invalid @enderror"
                                                wire:model="down_payment">
                                            @error('down_payment')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label class="form-label required mt-3">
                                                Tax
                                            </label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text"
                                                class="form-control border-top-0 border-start-0 border-end-0 @error('tax') is-invalid @enderror"
                                                wire:model="tax">
                                            @error('tax')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-link link-secondary" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <div class="ms-auto">
                        <button class="btn btn-primary" data-bs-toggle="collapse" href="#save-collapse">
                            Save
                        </button>
                    </div>
                </div>
                <div class="collapse" id="save-collapse">
                    <div class="d-flex justify-content-end mx-3 mb-3">
                        <p>Are you sure want to save this and forward to <b>Approval Department</b> ?</p>
                        <button class="btn btn-success ms-3" wire:click="save" wire:loading.attr="disabled">
                            Yes
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Show --}}

    <div class="modal modal-blur fade" id="show-modal" tabindex="-1" role="dialog" aria-hidden="true"
        wire:ignore.self>
        <div class="modal-dialog modal-full-width modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header @if ($validate_ === 'Waiting') bg-yellow text-yellow-fg @endif">
                    <h5 class="modal-title">{{ $po_buyer_no_ }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div wire:target="updateConfirm" wire:loading>
                    <div class="progress progress-sm">
                        <div class="progress-bar progress-bar-indeterminate"></div>
                    </div>
                </div>
                <div wire:target="updateConfirm" wire:loading.remove>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="form-label">
                                            <b>No. PO Buyer</b>
                                        </label>
                                    </div>
                                    <div class="col-md-6 border-bottom">
                                        {{ $po_buyer_no_ }}
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-4">
                                        <label class="form-label">
                                            <b>PO. Date</b>
                                        </label>
                                    </div>
                                    <div class="col-md-6 border-bottom">
                                        {{ $po_buyer_date_ }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="form-label">
                                            <b>Buyer Code</b>
                                        </label>
                                    </div>
                                    <div class="col-md-6  border-bottom">
                                        {{ $buyer_code_ }}
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-4">
                                        <label class="form-label">
                                            <b>Buyer Name</b>
                                        </label>
                                    </div>
                                    <div class="col-md-6  border-bottom">
                                        {{ $buyer_name_ }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="form-label">
                                            <b>Shipping Date</b>
                                        </label>
                                    </div>
                                    <div class="col-md-6  border-bottom">
                                        {{ $shipping_date_ }}
                                    </div>
                                    <div class="col-md-4 mt-3">
                                        <label class="form-label">
                                            <b>Deliver Date</b>
                                        </label>
                                    </div>
                                    <div class="col-md-6 mt-3 border-bottom">
                                        {{ $delivery_date_ }}
                                    </div>
                                    <div class="col-md-4 mt-3">
                                        <label class="form-label">
                                            <b>Due Date</b>
                                        </label>
                                    </div>
                                    <div class="col-md-6 mt-3 border-bottom">
                                        {{ $due_date_ }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 mt-4">
                            <table class="table table-sm table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Article / Style</th>
                                        <th>Quantity</th>
                                        <th>Unit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($articles_))
                                        @foreach ($articles_ as $article)
                                            <tr>
                                                <td> {{ $loop->iteration }} </td>
                                                <td>
                                                    {{ $article->article->article_name }}
                                                </td>
                                                <td>
                                                    {{ $article->quantity }}
                                                </td>
                                                <td>
                                                    {{ $article->unit->satuan }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>

                        <div class="col-md-12 mt-4">
                            <div class="row">
                                <div class="col-md-8">

                                </div>
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label class="form-label">
                                                <b>PIC</b>
                                            </label>
                                        </div>
                                        <div class="col-md-8 border-bottom">
                                            {{ $pic_ }}
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-4">
                                            <label class="form-label">
                                                <b>Currency</b>
                                            </label>
                                        </div>
                                        <div class="col-md-8 border-bottom">
                                            {{ $currency_ }}
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-4">
                                            <label class="form-label">
                                                <b>Discount</b>
                                            </label>
                                        </div>
                                        <div class="col-md-8 border-bottom">
                                            {{ $discount_ }}
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-4">
                                            <label class="form-label">
                                                <b>DP</b>
                                            </label>
                                        </div>
                                        <div class="col-md-8 border-bottom">
                                            {{ $down_payment_ }}
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-4">
                                            <label class="form-label">
                                                <b>Tax</b>
                                            </label>
                                        </div>
                                        <div class="col-md-8 border-bottom">
                                            {{ $tax_ }}%
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-link link-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    @script
        <script>
            $wire.on('success', (data) => {
                toastr.success(data);
            });
            $wire.on('error', (data) => {
                toastr.error(data);
            });
            $wire.on('create-modal-close', (data) => {
                $('#create-modal').modal('hide');
            });
            $wire.on('delete-modal-close', (data) => {
                $('#delete-modal').modal('hide');
            });
        </script>
    @endscript
</div>
