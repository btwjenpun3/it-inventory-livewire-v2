<div>

    {{-- Table --}}

    <div class="col-lg-12">
        <div class="card">
            <div class="table-responsive">
                <table class="table table-hover table-vcenter card-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>No. PO. Buyer</th>
                            <th>No. Order Production</th>
                            <th>Order Production Date</th>
                            <th class="w-1"></th>
                        </tr>
                    </thead>
                    @if (count($data) > 0)
                        <tbody>
                            @foreach ($data as $d)
                                <tr wire:key="data-{{ $d->id }}">
                                    <td>{{ $loop->iteration }}</td>
                                    <td><b>{{ $d->po_buyer_no }}</b></td>
                                    <td>{{ $d->order_production_no }}</td>
                                    <td>{{ $d->order_production_date }}</td>
                                    <td>
                                        <button class="btn-link" data-bs-toggle="modal" data-bs-target="#show-modal"
                                            wire:click="show({{ $d->id }})">
                                            Show
                                        </button>
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
            @if (count($data) >= 10)
                {{ $data->links() }}
            @endif
        </div>
    </div>

    {{-- BOM Modal --}}

    <div class="modal fade" id="show-modal" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop="false"
        wire:ignore.self>
        <div class="modal-dialog modal-fullscreen modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Material Request</h5>
                    <button type="button" class="btn-close" data-bs-toggle="modal" data-bs-target="#show-modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div>
                        <h3 class="border bg-primary text-primary-fg ps-3">Order Production</h3>
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-sm table-hover table-vcenter table-bordered">
                                    <tbody>
                                        <tr>
                                            <td><b>No. Order Production</b></td>
                                            <td>{{ $orderProductionNo }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-sm table-hover table-vcenter table-bordered">
                                    <tbody>
                                        <tr>
                                            <td><b>Order Production Date</b></td>
                                            <td>{{ $orderProductionDate }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <h3 class="border bg-primary text-primary-fg ps-3">Bom Details</h3>
                    @foreach ($bomNo as $no)
                        <div class="card mt-4">
                            <div class="card-body">
                                <h4 class="card-title">
                                    Bom No. {{ $no->bom_no }}
                                </h4>
                                <div class="col-md-4">
                                    <table class="table table-sm table-hover table-vcenter table-bordered">
                                        <tbody>
                                            <tr>
                                                <td><b>Bom Name</b></td>
                                                <td>{{ $no->bom_name }}</td>
                                            </tr>
                                            <tr>
                                                <td><b>Bom Description</b></td>
                                                <td>{{ $no->description }}</td>
                                            </tr>
                                            <tr>
                                                <td><b>Bom Date</b></td>
                                                <td>{{ $no->bom_date }}</td>
                                            </tr>
                                            <tr>
                                                <td><b>Quantity</b></td>
                                                <td>{{ $no->article->quantity }} {{ $no->article->unit }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div>
                                    <table class="table table-sm table-hover table-vcenter table-bordered">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Material Code</th>
                                                <th>Material Type</th>
                                                <th>Material Description</th>
                                                <th>Material Color</th>
                                                <th>Material Size</th>
                                                <th>Consumption</th>
                                                <th>Total Quantity</th>
                                                <th>UoM</th>
                                                <th>Location</th>
                                                <th>Level</th>
                                                <th>Procurement</th>
                                                <th>Note</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($no->details as $key => $detail)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $detail->material_code }}</td>
                                                    <td>{{ $detail->material_type }}</td>
                                                    <td>{{ $detail->material_description }}</td>
                                                    <td>{{ $detail->material_color }}</td>
                                                    <td>{{ $detail->material_size }}</td>
                                                    <td>{{ $detail->consumption }}</td>
                                                    <td>{{ $detail->total_quantity }}</td>
                                                    <td>{{ $detail->material_unit }}</td>
                                                    <td>{{ $detail->location }}</td>
                                                    <td>{{ $detail->level }}</td>
                                                    <td>{{ $detail->procurement }}</td>
                                                    <td>{{ $detail->note }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <h3 class="border bg-primary text-primary-fg ps-3">Total</h3>
                    <table class="table table-sm table-hover table-vcenter table-bordered">
                        <thead>
                            <tr>
                                <th>Material Code</th>
                                <th>Material Description</th>
                                <th>Total Quantity</th>
                                <th>Stock</th>
                                <th>UoM</th>
                                <th>Required Quantity</th>
                                <th>Quantity to Request</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($totalMaterial) > 0)
                                @foreach ($totalMaterial as $key => $group)
                                    <tr>
                                        <td>{{ $key }}</td>
                                        <td>{{ $group['material_description'] }}</td>
                                        <td>{{ $group['total_quantity'] }}</td>
                                        <td>{{ $group['stock'] }}</td>
                                        <td>{{ $group['unit'] }}</td>
                                        <td>
                                            @if ($group['stock'] - $group['total_quantity'] < 0)
                                                <span class="text-danger">
                                                    {{ $group['stock'] - $group['total_quantity'] }}
                                                </span>
                                            @else
                                                <span class="text-success">
                                                    0
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <input type="text" class="form-control form-control-sm"
                                                wire:model="totalMaterial.{{ $key }}.material_requested">
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn me-auto" data-bs-toggle="modal"
                        data-bs-target="#show-modal">Close</button>
                    <button type="button" class="btn btn-primary" wire:click="save"
                        wire:loading.attr="disabled">Save</button>
                </div>
            </div>
        </div>
    </div>

    @script
        <script>
            $wire.on('success', (data) => {
                toastr.success(data);
            });
            $wire.on('show-modal-close', (data) => {
                $('#show-modal').modal('hide');
            });
            $wire.on('error', (data) => {
                toastr.error(data);
            });
        </script>
    @endscript
</div>
