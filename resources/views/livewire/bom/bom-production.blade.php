<div>

    {{-- Table --}}

    <div class="col-lg-12">
        <div class="card">
            <div class="table-responsive">
                <table class="table table-sm table-hover table-vcenter card-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>No. Order Production</th>
                            <th>Order Production Date</th>
                            <th>Marketing Name</th>
                            <th>Buyer Name</th>
                            <th class="w-1"></th>
                        </tr>
                    </thead>
                    @if (count($data) > 0)
                        <tbody>
                            @foreach ($data as $key => $d)
                                <tr wire:key="{{ $d->id }}">
                                    <td>{{ $loop->iteration }}</td>
                                    <td><b>{{ $d->order_production_no }}</b></td>
                                    <td>{{ $d->order_production_date }}</td>
                                    <td>{{ $d->pic_name }} - {{ $d->pic_title }}</td>
                                    <td>{{ $d->buyer_name }}</td>
                                    <td>
                                        <button class="btn-link" data-bs-toggle="modal" data-bs-target="#show-modal"
                                            wire:click="show({{ $d->id }})">Show</button>
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

    {{-- Show Modal --}}

    <div class="modal modal-blur fade" id="show-modal" tabindex="-1" role="dialog" aria-hidden="true"
        wire:ignore.self>
        <div class="modal-dialog modal-fullscreen modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Work Order</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div wire:target="show" wire:loading>
                    <div class="progress progress-sm">
                        <div class="progress-bar progress-bar-indeterminate"></div>
                    </div>
                </div>
                <div wire:target="show" wire:loading.remove>
                    <div class="modal-body">
                        <h3 class="bg-primary text-primary-fg ps-3">Order Production : {{ $order_production_no }}</h3>
                        <div class="row">
                            <div class="col-md-4">
                                <table class="table table-sm table-hover table-vcenter table-bordered">
                                    <tbody>
                                        <tr>
                                            <td><b>PO. Buyer</b></td>
                                            <td>
                                                {{ $po_buyer_no }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>Marketing Name</b></td>
                                            <td>
                                                {{ $pic_name }} - {{ $pic_title }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>Buyer Code</b></td>
                                            <td>
                                                {{ $buyer_code }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>Buyer Name</b></td>
                                            <td>
                                                {{ $buyer_name }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-12 mt-4">
                                <table class="table table-sm table-hover table-vcenter table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Article Code</th>
                                            <th>Article Name</th>
                                            <th>Color</th>
                                            <th>Size</th>
                                            <th>Quantity</th>
                                            <th>UoM</th>
                                            <th>Bill of Materials</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($articles as $article)
                                            <tr wire:key="{{ $article->id }}">
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $article->article_code }}</td>
                                                <td>{{ $article->article_name }}</td>
                                                <td>{{ $article->color }}</td>
                                                <td>{{ $article->size }}</td>
                                                <td>{{ $article->quantity }}</td>
                                                <td>{{ $article->unit }}</td>
                                                <td>
                                                    @if ($article->bom)
                                                        <button class="btn-link text-primary" data-bs-toggle="modal"
                                                            data-bs-target="#bom-modal-update"
                                                            wire:click="showBomDetail({{ $article->id }})">
                                                            {{ $article->bom->bom_no }}
                                                        </button>
                                                    @else
                                                        <button class="btn-link text-danger" data-bs-toggle="modal"
                                                            data-bs-target="#bom-modal"
                                                            wire:click="showBom({{ $article->id }})">
                                                            Create
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
                        <div class="col-md-3 ms-auto mx-3">
                            <div class="card card-body">
                                <p>Are you sure want to save this and forward to <b>Material Request</b> ?</p>
                                <button class="btn btn-success ms-3" wire:click="save" wire:loading.attr="disabled">
                                    Yes
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- BOM Modal --}}

    <div class="modal fade" id="bom-modal" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop="false"
        wire:ignore.self>
        <div class="modal-dialog modal-fullscreen modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Article/Style : {{ $article_no }}</h5>
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
                                        <td><label class="form-label required">BOM Code</label></td>
                                        <td>
                                            <input type="text"
                                                class="form-control form-control-sm @error('bomCode') is-invalid @enderror"
                                                wire:model="bomCode">
                                            @error('bomCode')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label class="form-label required">BOM Name</label></td>
                                        <td>
                                            <input type="text"
                                                class="form-control form-control-sm @error('bomName') is-invalid @enderror"
                                                wire:model="bomName">
                                            @error('bomName')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label class="form-label required">Description</label></td>
                                        <td>
                                            <input type="text"
                                                class="form-control form-control-sm @error('bomDescription') is-invalid @enderror"
                                                wire:model="bomDescription">
                                            @error('bomDescription')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label class="form-label required">Status</label></td>
                                        <td>
                                            <select
                                                class="form-select form-select-sm @error('bomStatus') is-invalid @enderror"
                                                wire:model="bomStatus">
                                                <option value="">-- Select --</option>
                                                <option value="Aktif">Aktif</option>
                                                <option value="Non-Aktif">Non-Aktif</option>
                                            </select>
                                            @error('bomStatus')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-4">
                            <table class="table table-sm table-hover table-vcenter table-bordered">
                                <tbody>
                                    <tr>
                                        <td>Size</td>
                                        <td>{{ $bomArticleSize }}</td>
                                    </tr>
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
                                        <th>Material Code</th>
                                        <th>Material Type</th>
                                        <th>Material Description</th>
                                        <th>Material Color</th>
                                        <th>Material Size</th>
                                        <th>Consumption</th>
                                        <th>Total Quantity</th>
                                        <th>UoM</th>
                                        <th>Location</th>
                                        <th>Group</th>
                                        <th>Level</th>
                                        <th>Procurement</th>
                                        <th>Lead Time</th>
                                        <th>Note</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($bomRows as $key => $b)
                                        <tr wire:key="{{ $key }}">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <select class="form-select form-select-sm"
                                                    wire:model="bomRows.{{ $key }}.bomIngredient"
                                                    wire:change="fillIngredientContent({{ $key }}, $event.target.value, 'false')">
                                                    <option value="">-- Select --</option>
                                                    @foreach ($materials as $m)
                                                        <option value="{{ $m->id }}">{{ $m->material_code }} -
                                                            {{ $m->description }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control form-control-sm"
                                                    wire:model="bomRows.{{ $key }}.bomMaterialType" disabled>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control form-control-sm"
                                                    wire:model="bomRows.{{ $key }}.bomMaterialDescription"
                                                    disabled>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control form-control-sm"
                                                    wire:model="bomRows.{{ $key }}.bomColor" disabled>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control form-control-sm"
                                                    wire:model="bomRows.{{ $key }}.bomSize">
                                            </td>
                                            <td>
                                                <input type="number" class="form-control form-control-sm"
                                                    wire:model="bomRows.{{ $key }}.bomConsumption"
                                                    wire:change="fillTotalQuantity({{ $key }}, $event.target.value, 'false')">
                                            </td>
                                            <td>
                                                <input type="number" class="form-control form-control-sm"
                                                    wire:model="bomRows.{{ $key }}.bomQuantity" disabled>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control form-control-sm"
                                                    class="form-select form-select-sm"
                                                    wire:model="bomRows.{{ $key }}.bomUnit" disabled>
                                            </td>
                                            <td>
                                                <select class="form-select form-select-sm"
                                                    wire:model="bomRows.{{ $key }}.bomLocation">
                                                    <option value="">-- Select --</option>
                                                    @foreach ($locations as $location)
                                                        <option value="{{ $location->id }}">
                                                            {{ $location->location_code }} -
                                                            {{ $location->location_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select class="form-select form-select-sm"
                                                    wire:model="bomRows.{{ $key }}.bomGroup">
                                                    <option value="">-- Select --</option>
                                                    @foreach ($groups as $group)
                                                        <option value="{{ $group->id }}">
                                                            {{ $group->group }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select class="form-select form-select-sm"
                                                    wire:model="bomRows.{{ $key }}.bomLevel">
                                                    <option value="">-- Select --</option>
                                                    @foreach ($levels as $level)
                                                        <option value="{{ $level->id }}">{{ $level->bom_level }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select class="form-select form-select-sm"
                                                    wire:model="bomRows.{{ $key }}.bomProcurement">
                                                    <option value="">-- Select --</option>
                                                    @foreach ($procurements as $procurement)
                                                        <option value="{{ $procurement->id }}">
                                                            {{ $procurement->procurement }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <input type="date" class="form-control form-control-sm"
                                                    wire:model="bomRows.{{ $key }}.bomLeadTime">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control form-control-sm"
                                                    wire:model="bomRows.{{ $key }}.bomNote">
                                            </td>
                                            <td>
                                                <div class="btn-list">
                                                    @if ($loop->last)
                                                        <button class="btn btn-sm btn-link"
                                                            wire:click="addRow">Add</button>
                                                    @endif
                                                    @if (!$loop->first)
                                                        <button class="btn btn-sm btn-link text-danger"
                                                            wire:click="removeRow({{ $key }})">Remove</button>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
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

    {{-- BOM Modal Update --}}

    <div class="modal fade" id="bom-modal-update" tabindex="-1" role="dialog" aria-hidden="true"
        data-bs-backdrop="false" wire:ignore.self>
        <div class="modal-dialog modal-fullscreen modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Article/Style : {{ $article_no_ }}</h5>
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
                                        <td>
                                            {{ $bomCode_ }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>BOM Name</td>
                                        <td>
                                            {{ $bomName_ }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Description</td>
                                        <td>
                                            {{ $bomDescription_ }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Status</td>
                                        <td>
                                            {{ $bomStatus_ }}
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
                    </div>
                    <h3 class="border bg-primary text-primary-fg ps-3">BOM Material Details</h3>
                    <div class="col-md-12">
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
                                    <th>Lead Time</th>
                                    <th>Note</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($bomDetails))
                                    @foreach ($bomDetails as $bd)
                                        <tr wire:key="bom-details-{{ $bd->id }}">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                {{ $bd->material_code }}
                                            </td>
                                            <td>
                                                {{ $bd->material_type }}
                                            </td>
                                            <td>
                                                {{ $bd->material_description }}
                                            </td>
                                            <td>
                                                {{ $bd->material_color }}
                                            </td>
                                            <td>
                                                {{ $bd->material_size }}
                                            </td>
                                            <td>
                                                {{ $bd->consumption }}
                                            </td>
                                            <td>
                                                {{ $bd->total_quantity }}
                                            </td>
                                            <td>
                                                {{ $bd->material_unit }}
                                            </td>
                                            <td>
                                                {{ $bd->location_name }}
                                            </td>
                                            <td>
                                                {{ $bd->level }}
                                            </td>
                                            <td>
                                                {{ $bd->procurement }}
                                            </td>
                                            <td>
                                                {{ $bd->lead_time }}
                                            </td>
                                            <td>
                                                {{ $bd->note }}
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn me-auto" data-bs-toggle="modal"
                        data-bs-target="#show-modal">Close</button>
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
            $wire.on('bom-modal-close', (data) => {
                $('#bom-modal').modal('hide');
            });
            $wire.on('delete-modal-close', (data) => {
                $('#delete-modal').modal('hide');
            });
        </script>
    @endscript
</div>
