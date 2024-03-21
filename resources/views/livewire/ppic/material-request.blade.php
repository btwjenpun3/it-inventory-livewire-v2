<div>

    {{-- Table --}}

    <div class="col-lg-12">
        <div class="card">
            <div class="table-responsive">
                <table class="table table-hover table-vcenter card-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>No. BOM</th>
                            <th>BOM Name</th>
                            <th>BOM Description</th>
                            <th>BOM Date</th>
                            <th>Status</th>
                            <th class="w-1"></th>
                        </tr>
                    </thead>
                    @if (count($data) > 0)
                        <tbody>
                            @foreach ($data as $d)
                                <tr wire:key="{{ $d->id }}">
                                    <td>{{ $loop->iteration }}</td>
                                    <td><b>{{ $d->bom_no }}</b></td>
                                    <td>{{ $d->bom_name }}</td>
                                    <td>{{ $d->description }}</td>
                                    <td>{{ $d->bom_date }}</td>
                                    <td>
                                        @foreach ($d->details as $dd)
                                            @if (isset($dd->status))
                                                <span class="badge bg-green">Yes</span>
                                                @php
                                                    break;
                                                @endphp
                                            @else
                                                <span class="badge bg-yellow">No</span>
                                                @php
                                                    break;
                                                @endphp
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        <div class="btn-list flex-nowrap">
                                            <button class="btn-link" data-bs-toggle="modal" data-bs-target="#show-modal"
                                                wire:click="show({{ $d->id }})">
                                                Show
                                            </button>
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
                    <h3 class="border bg-primary text-primary-fg ps-3">BOM Info</h3>
                    <div class="row">
                        <div class="col-md-4">
                            <table class="table table-sm table-hover table-vcenter table-bordered">
                                <tbody>
                                    <tr>
                                        <td>BOM Code</td>
                                        <td>{{ $bomCode }}</td>
                                    </tr>
                                    <tr>
                                        <td>BOM Name</td>
                                        <td>{{ $bomName }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Description</td>
                                        <td>{{ $bomDescription }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Status</td>
                                        <td>{{ $bomStatus }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Material Type</td>
                                        <td>{{ $bomMaterialType }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-4">
                            <table class="table table-sm table-hover table-vcenter table-bordered">
                                <tbody>
                                    <tr>
                                        <td>Quantity</td>
                                        <td>{{ $bomArticleQuantity }} {{ $bomArticleUnit }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <h3 class="border bg-primary text-primary-fg ps-3">BOM Material Details</h3>
                        <div class="col-md-12">
                            <table class="table table-sm table-hover table-vcenter table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th></th>
                                        <th>Material</th>
                                        <th>Material Description</th>
                                        <th>Consumption</th>
                                        <th>Total Quantity</th>
                                        <th>UoM</th>
                                        <th>Note</th>
                                        <th>Stock</th>
                                        <th>Required Quantity</th>
                                        <th>Quantity to Order</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($details))
                                        @foreach ($details->details as $d)
                                            <tr wire:key="details-{{ $d->id }}">
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $d->material_type }}</td>
                                                <td>{{ $d->material->material_code }}</td>
                                                <td>{{ $d->material->description }}</td>
                                                <td>{{ $d->consumption }}</td>
                                                <td>{{ $d->total_quantity }} </td>
                                                <td>{{ $d->unit->satuan }}</td>
                                                <td>{{ $d->note }}</td>
                                                <td>{{ $stock }}</td>
                                                <td>
                                                    @if ($stock - $d->total_quantity >= 0)
                                                        <span class="text-success">
                                                            0
                                                        </span>
                                                    @else
                                                        <span class="text-danger">
                                                            {{ $stock - $d->total_quantity }}
                                                        </span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @switch($d->status)
                                                        @case(1)
                                                            {{ $d->quantity_request }}
                                                        @break

                                                        @default
                                                            <input type="text" class="form-control form-control-sm"
                                                                wire:model="quantityToStock.{{ $d->id }}">
                                                    @endswitch
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
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
            $wire.on('error', (data) => {
                toastr.error(data);
            });
        </script>
    @endscript
</div>
