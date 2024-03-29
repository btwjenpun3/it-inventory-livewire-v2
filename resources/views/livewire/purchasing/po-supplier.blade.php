<div>
    {{-- Table --}}

    <div class="col-lg-12">
        <div class="card">
            <div class="table-responsive">
                <table class="table table-hover table-vcenter card-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>No. PO Supplier</th>
                            <th>No. OP Production</th>
                            <th>PO Supplier Date</th>
                            <th>Supplier Code</th>
                            <th>Supplier Name</th>
                            <th>Grouping</th>
                            <th>Status</th>
                            <th class="w-1"></th>
                        </tr>
                    </thead>
                    @if (count($data) > 0)
                        <tbody>
                            @foreach ($data as $d)
                                <tr wire:key="data-{{ $d->id }}">
                                    <td>{{ $loop->iteration }}</td>
                                    <td><b>{{ $d->po_no }}</b></td>
                                    <td>{{ $d->op->order_production_no }}</td>
                                    <td>{{ $d->po_date }}</td>
                                    <td>
                                        @if (isset($d->supplier_code))
                                            {{ $d->supplier_code }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if (isset($d->supplier_name))
                                            {{ $d->supplier_name }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>{{ $d->grouping }}</td>
                                    <td>
                                        @switch($d->status)
                                            @case(null)
                                                <span class="badge bg-secondary">not complete</span>
                                            @break

                                            @case('Completed')
                                                <span class="badge bg-success">completed</span>
                                            @break

                                            @default
                                        @endswitch
                                    </td>
                                    <td>
                                        @switch($d->status)
                                            @case(null)
                                                <button class="btn-link" data-bs-toggle="modal"
                                                    data-bs-target="#show-create-modal"
                                                    wire:click="showCreatePoSupplier({{ $d->id }})">
                                                    Create
                                                </button>
                                            @break

                                            @case('Completed')
                                                <button class="btn-link" data-bs-toggle="modal" data-bs-target="#show-modal"
                                                    wire:click="showPoSupplier({{ $d->id }})">
                                                    Show
                                                </button>
                                            @break

                                            @default
                                        @endswitch

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
            <div class="ms-3 mt-3 me-3">
                {{ $data->links() }}
            </div>
        </div>
    </div>

    {{-- Create PO Supplier Modal --}}

    <div class="modal modal-blur fade" id="create-modal" tabindex="-1" role="dialog" aria-hidden="true"
        wire:ignore.self>
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create PO Supplier</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label required">Select OP</label>
                            <select class="form-select @error('opNo') is-invalid @enderror" wire:model="opNo">
                                <option value="">-- Select --</option>
                                @foreach ($opNoLists as $o)
                                    <option value="{{ $o->id }}">{{ $o->order_production_no }}</option>
                                @endforeach
                            </select>
                            @error('opNo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label required">No. PO Supplier</label>
                            <input type="text" class="form-control @error('poSupplierNo') is-invalid @enderror"
                                wire:model="poSupplierNo">
                            @error('poSupplierNo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label required">PO Supplier Date</label>
                            <input type="date" class="form-control @error('poSupplierDate') is-invalid @enderror"
                                wire:model="poSupplierDate">
                            @error('poSupplierDate')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-12 mt-3">
                            <label class="form-label required">Grouping</label>
                            <select class="form-select @error('poSupplierGrouping') is-invalid @enderror"
                                wire:model="poSupplierGrouping">
                                <option value="">-- Select --</option>
                                <option value="Production">Production</option>
                                <option value="Sampling">Sampling</option>
                                <option value="Non-Allocate">Non-Allocate</option>
                                <option value="Finish Good">Finish Good</option>
                            </select>
                            @error('poSupplierGrouping')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" wire:click="savePoSupplier"
                        wire:loading.attr="disabled">Save</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Show Create PO Supplier Modal --}}

    <div class="modal fade" id="show-create-modal" tabindex="-1" role="dialog" aria-hidden="true"
        data-bs-backdrop="false" wire:ignore.self>
        <div class="modal-dialog modal-fullscreen modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">PO Supplier - {{ $showPoSupplierNo }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h3 class="border bg-primary text-primary-fg ps-3">PO Supplier Details</h3>
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-sm table-hover table-vcenter table-bordered">
                                <tbody>
                                    <tr>
                                        <td>No. OP Production</td>
                                        <td><b>{{ $showPoSupplierOp }}</b></td>
                                    </tr>
                                    <tr>
                                        <td>No. PO Supplier</td>
                                        <td><b>{{ $showPoSupplierNo }}</b></td>
                                    </tr>
                                    <tr>
                                        <td>PO Supplier Date</td>
                                        <td><b>{{ $showPoSupplierDate }}</b></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <h3 class="border bg-primary text-primary-fg ps-3">Material Required</h3>
                    <table class="table table-sm table-hover table-vcenter table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Material Code</th>
                                <th>Material Description</th>
                                <th>Subtotal</th>
                                <th>Stock</th>
                                <th>Required Material to Purchase</th>
                                <th>Requested</th>
                                <th>Purchased</th>
                                <th>UoM</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($materialRequiredLists))
                                @foreach ($materialRequiredLists as $mrl)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $mrl->material_code }}</td>
                                        <td>{{ $mrl->material_name }}</td>
                                        <td>{{ $mrl->subtotal }}</td>
                                        <td>{{ $mrl->stock }}</td>
                                        <td>
                                            @if ($mrl->required > 0)
                                                <label class="text-success">0</label>
                                            @else
                                                <label class="text-danger">{{ $mrl->required }}</label>
                                            @endif
                                        </td>
                                        <td>{{ $mrl->material_requested }}</td>
                                        <td>
                                            @if ($mrl->material_purchased >= $mrl->material_requested)
                                                <label class="text-success">{{ $mrl->material_purchased }}</label>
                                            @else
                                                <label class="text-secondary">{{ $mrl->material_purchased }}</label>
                                            @endif
                                        </td>
                                        <td>{{ $mrl->material_unit }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                    <h3 class="border bg-primary text-primary-fg ps-3">Supplier Details</h3>
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-sm table-hover table-vcenter table-bordered">
                                <tbody>
                                    <tr>
                                        <td>
                                            <label class="form-label required">
                                                Supplier Code
                                            </label>
                                        </td>
                                        <td>
                                            <select
                                                class="form-control form-control-sm @error('supplierCode') is-invalid @enderror"
                                                wire:model="supplierCode" wire:change="fillSupplierContent">
                                                <option value="">-- Select --</option>
                                                @foreach ($suppliers as $supplier)
                                                    <option value="{{ $supplier->supplier_code }}">
                                                        {{ $supplier->supplier_code }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('supplierCode')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label class="form-label">
                                                Supplier Name
                                            </label>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control form-control-sm"
                                                wire:model="supplierName" disabled>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label class="form-label">
                                                State
                                            </label>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control form-control-sm"
                                                wire:model="supplierState" disabled>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label class="form-label">
                                                Address
                                            </label>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control form-control-sm"
                                                wire:model="supplierAddress" disabled>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label class="form-label">
                                                Email
                                            </label>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control form-control-sm"
                                                wire:model="supplierEmail" disabled>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label class="form-label">
                                                Phone
                                            </label>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control form-control-sm"
                                                wire:model="supplierPhone" disabled>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-sm table-hover table-vcenter table-bordered">
                                <tbody>
                                    <tr>
                                        <td>
                                            <label class="form-label required">
                                                Grouping
                                            </label>
                                        </td>
                                        <td>
                                            <select
                                                class="form-select form-select-sm @error('supplierGrouping') is-invalid @enderror"
                                                wire:model="supplierGrouping">
                                                <option value="">-- Select --</option>
                                                <option value="Production">Production</option>
                                                <option value="Sampling">Sampling</option>
                                                <option value="Non-Allocate">Non-Allocate</option>
                                                <option value="Finish Good">Finish Good</option>
                                            </select>
                                            @error('supplierGrouping')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label class="form-label required">
                                                Payment Term
                                            </label>
                                        </td>
                                        <td>
                                            <select
                                                class="form-select form-select-sm @error('supplierPaymentTerm') is-invalid @enderror"
                                                wire:model="supplierPaymentTerm">
                                                <option value="">-- Select --</option>
                                                <option value="Work">Work</option>
                                                <option value="CIF">CIF</option>
                                                <option value="FOB">FOB</option>
                                            </select>
                                            @error('supplierPaymentTerm')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label class="form-label required">
                                                Shipment Term
                                            </label>
                                        </td>
                                        <td>
                                            <input type="text"
                                                class="form-control form-control-sm @error('supplierShipmentTerm') is-invalid @enderror"
                                                wire:model="supplierShipmentTerm">
                                            @error('supplierShipmentTerm')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label class="form-label required">
                                                Currency
                                            </label>
                                        </td>
                                        <td>
                                            <select
                                                class="form-select form-select-sm @error('supplierCurrency') is-invalid @enderror"
                                                wire:model="supplierCurrency">
                                                <option value="">-- Select --</option>
                                                @foreach ($currencies as $currency)
                                                    <option value="{{ $currency->currency_code }}">
                                                        {{ $currency->currency_code }}</option>
                                                @endforeach
                                            </select>
                                            @error('supplierCurrency')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label class="form-label required">
                                                ETA
                                            </label>
                                        </td>
                                        <td>
                                            <input type="date"
                                                class="form-control form-control-sm @error('supplierEta') is-invalid @enderror"
                                                wire:model="supplierEta">
                                            @error('supplierEta')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label class="form-label required">
                                                PIC
                                            </label>
                                        </td>
                                        <td>
                                            <input type="text"
                                                class="form-control form-control-sm @error('supplierPic') is-invalid @enderror"
                                                wire:model="supplierPic">
                                            @error('supplierPic')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <h3 class="border bg-primary text-primary-fg ps-3">Material Details</h3>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-sm table-hover table-vcenter table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Material Code</th>
                                        <th>Material Description</th>
                                        <th>Stock</th>
                                        <th>Purchase Quantity</th>
                                        <th>UoM</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($materialDetails as $key => $m)
                                        <tr wire:key="data-material-{{ $key }}">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <select class="form-select form-select-sm {!! $errors->has('materialDetails.' . $key . '.materialCode') ? 'is-invalid' : '' !!}"
                                                    wire:model="materialDetails.{{ $key }}.materialCode"
                                                    wire:change="fillMaterialDescriptionAndUom({{ $key }})">
                                                    <option value="">-- Select --</option>
                                                    @foreach ($materialRequiredLists as $mr)
                                                        <option value="{{ $mr->material_code }}">
                                                            {{ $mr->material_code }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control form-control-sm"
                                                    wire:model="materialDetails.{{ $key }}.materialDescription"
                                                    disabled>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control form-control-sm"
                                                    wire:model="materialDetails.{{ $key }}.materialStock"
                                                    disabled>
                                            </td>
                                            <td>
                                                <input type="number"
                                                    class="form-control form-control-sm {!! $errors->has('materialDetails.' . $key . '.materialQuantityPurchase') ? 'is-invalid' : '' !!}"
                                                    wire:model="materialDetails.{{ $key }}.materialQuantityPurchase">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control form-control-sm"
                                                    wire:model="materialDetails.{{ $key }}.materialUom"
                                                    disabled>
                                            </td>
                                            <td>
                                                @if ($loop->last)
                                                    <button class="btn-link" wire:click="addMaterialRow">
                                                        Add
                                                    </button>
                                                @endif
                                                @if ($loop->count > 1)
                                                    <button class="btn-link text-danger"
                                                        wire:click="removeMaterialRow({{ $key }})">
                                                        Remove
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" wire:click="savePoSupplierDetails"
                        wire:loading.attr="disabled">Save</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Show PO Supplier Modal --}}

    <div class="modal fade" id="show-modal" tabindex="-1" role="dialog" aria-hidden="true"
        data-bs-backdrop="false" wire:ignore.self>
        <div class="modal-dialog modal-fullscreen modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">PO Supplier - {{ $showPoSupplierNo_ }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h3 class="border bg-primary text-primary-fg ps-3">PO Supplier Details</h3>
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-sm table-hover table-vcenter table-bordered">
                                <tbody>
                                    <tr>
                                        <td>No. OP Production</td>
                                        <td><b>{{ $showPoSupplierOp_ }}</b></td>
                                    </tr>
                                    <tr>
                                        <td>No. PO Supplier</td>
                                        <td><b>{{ $showPoSupplierNo_ }}</b></td>
                                    </tr>
                                    <tr>
                                        <td>PO Supplier Date</td>
                                        <td><b>{{ $showPoSupplierDate_ }}</b></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <h3 class="border bg-primary text-primary-fg ps-3">Material Required</h3>
                    <table class="table table-sm table-hover table-vcenter table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Material Code</th>
                                <th>Material Description</th>
                                <th>Subtotal</th>
                                <th>Stock</th>
                                <th>Required Material to Purchase</th>
                                <th>Requested</th>
                                <th>Purchased</th>
                                <th>UoM</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($materialRequiredLists_))
                                @foreach ($materialRequiredLists_ as $mrl_)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $mrl_->material_code }}</td>
                                        <td>{{ $mrl_->material_name }}</td>
                                        <td>{{ $mrl_->subtotal }}</td>
                                        <td>{{ $mrl_->stock }}</td>
                                        <td>
                                            @if ($mrl_->required > 0)
                                                <label class="text-success">0</label>
                                            @else
                                                <label class="text-danger">{{ $mrl_->required }}</label>
                                            @endif
                                        </td>
                                        <td>{{ $mrl_->material_requested }}</td>
                                        <td>
                                            @if ($mrl_->material_purchased >= $mrl_->material_requested)
                                                <label class="text-success">{{ $mrl_->material_purchased }}</label>
                                            @else
                                                <label class="text-secondary">{{ $mrl_->material_purchased }}</label>
                                            @endif
                                        </td>
                                        <td>{{ $mrl_->material_unit }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                    <h3 class="border bg-primary text-primary-fg ps-3">Supplier Details</h3>
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-sm table-hover table-vcenter table-bordered">
                                <tbody>
                                    <tr>
                                        <td>
                                            <label class="form-label">
                                                Supplier Code
                                            </label>
                                        </td>
                                        <td><b>{{ $supplierCode_ }}</b></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label class="form-label">
                                                Supplier Name
                                            </label>
                                        </td>
                                        <td><b>{{ $supplierName_ }}</b></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label class="form-label">
                                                State
                                            </label>
                                        </td>
                                        <td><b>{{ $supplierState_ }}</b></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label class="form-label">
                                                Address
                                            </label>
                                        </td>
                                        <td><b>{{ $supplierAddress_ }}</b></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label class="form-label">
                                                Email
                                            </label>
                                        </td>
                                        <td><b>{{ $supplierEmail_ }}</b></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label class="form-label">
                                                Phone
                                            </label>
                                        </td>
                                        <td><b>{{ $supplierPhone_ }}</b></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-sm table-hover table-vcenter table-bordered">
                                <tbody>
                                    <tr>
                                        <td>
                                            <label class="form-label">
                                                Grouping
                                            </label>
                                        </td>
                                        <td><b>{{ $supplierGrouping_ }}</b></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label class="form-label">
                                                Payment Term
                                            </label>
                                        </td>
                                        <td><b>{{ $supplierPaymentTerm_ }}</b></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label class="form-label">
                                                Shipment Term
                                            </label>
                                        </td>
                                        <td><b>{{ $supplierShipmentTerm_ }}</b></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label class="form-label">
                                                Currency
                                            </label>
                                        </td>
                                        <td><b>{{ $supplierCurrency_ }}</b></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label class="form-label">
                                                ETA
                                            </label>
                                        </td>
                                        <td><b>{{ $supplierEta_ }}</b></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label class="form-label">
                                                PIC
                                            </label>
                                        </td>
                                        <td><b>{{ $supplierPic_ }}</b></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <h3 class="border bg-primary text-primary-fg ps-3">Material Details</h3>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-sm table-hover table-vcenter table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Material Code</th>
                                        <th>Material Description</th>
                                        <th>Stock</th>
                                        <th>Purchase Quantity</th>
                                        <th>UoM</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($materialDetails_))
                                        @foreach ($materialDetails_ as $md)
                                            <tr wire:key="data-material-show-{{ $md->id }}">
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $md->material_code }}</td>
                                                <td>{{ $md->material_description }}</td>
                                                <td>{{ $md->stock }}</td>
                                                <td>{{ $md->purchase_quantity }}</td>
                                                <td>{{ $md->material_unit }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
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
        </script>
    @endscript

</div>
