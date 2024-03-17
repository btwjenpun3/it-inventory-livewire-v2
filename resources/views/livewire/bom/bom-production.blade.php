<div>

    {{-- Table --}}

    <div class="col-lg-12">
        <div class="card">
            <div class="table-responsive">
                <table class="table table-sm table-hover table-vcenter card-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>No. Bill of Materials</th>
                            <th>No. Order Production</th>
                            <th>Order Production Date</th>
                            <th>MD Name</th>
                            <th>Buyer Name</th>
                            <th class="w-1"></th>
                        </tr>
                    </thead>
                    @if (count($data) > 0)
                        <tbody>
                            @foreach ($data as $key => $d)
                                <tr wire:key="{{ $d->id }}">
                                    <td></td>
                                    <td><b>-</b></td>
                                    <td>{{ $d->order_production_no }}</td>
                                    <td>{{ $d->order_production_date }}</td>
                                    <td>{{ $d->pic->name }}</td>
                                    <td>{{ $d->buyer->buyer_name }}</td>
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
                    <h5 class="modal-title">Bill of Materials</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div wire:target="show" wire:loading>
                    <div class="progress progress-sm">
                        <div class="progress-bar progress-bar-indeterminate"></div>
                    </div>
                </div>
                <div wire:target="show" wire:loading.remove>
                    <div class="modal-body">
                        <h2 class="bg-primary text-primary-fg ps-3">Order Production : {{ $order_production_no }}</h2>
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
                                            <td><b>MD. Name</b></td>
                                            <td>
                                                {{ $pic_name }}
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
                                            <th>Article / Style</th>
                                            <th>Quantity</th>
                                            <th>Unit</th>
                                            <th>Bill of Materials</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($articles as $article)
                                            <tr wire:key="{{ $article->id }}">
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $article->article }}</td>
                                                <td>{{ $article->quantity }}</td>
                                                <td>{{ $article->unit->satuan }}</td>
                                                <td>
                                                    @if ($article->bom)
                                                        <button class="btn-link text-success" data-bs-toggle="modal"
                                                            data-bs-target="#bom-modal-update"
                                                            wire:click="showBomDetail({{ $article->id }})">
                                                            {{ $article->bom->bom_no }}
                                                        </button>
                                                    @else
                                                        <button class="btn-link" data-bs-toggle="modal"
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
                <div class="collapse ms-auto m-3" id="save-collapse">
                    Are you sure want to save this and forward to <b>Approval Department</b> ?
                    <button class="btn btn-success ms-3" wire:click="save" wire:loading.attr="disabled">
                        Yes
                    </button>
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
                    <div class="col-md-4">
                        <table class="table table-sm table-hover table-vcenter table-bordered">
                            <tbody>
                                <tr>
                                    <td>BOM Code</td>
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
                                    <td>BOM Name</td>
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
                                    <td>Description</td>
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
                                    <td>Status</td>
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
                                <tr>
                                    <td>Material Type</td>
                                    <td>
                                        <select
                                            class="form-select form-select-sm @error('bomStatus') is-invalid @enderror"
                                            wire:model="bomMaterialType">
                                            <option value="">-- Select --</option>
                                            @foreach ($materialTypes as $m)
                                                <option value="{{ $m->id }}">{{ $m->material_type }}</option>
                                            @endforeach
                                        </select>
                                        @error('bomStatus')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </td>
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
                                    <th class="danger">Ga tau namanya</th>
                                    <th>Material</th>
                                    <th>Quantity</th>
                                    <th>U/M</th>
                                    <th>Level</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bomRows as $key => $b)
                                    <tr wire:key="{{ $key }}">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <select class="form-select form-select-sm"
                                                wire:model="bomRows.{{ $key }}.bomMaterial">
                                                <option value="">-- Select --</option>
                                                <option value="Raw Material">Raw Material</option>
                                                <option value="Auxiliary Material">Auxiliary Material</option>
                                                <option value="Accessories">Accessories</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control form-control-sm"
                                                wire:model="bomRows.{{ $key }}.bomIngredient">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control form-control-sm"
                                                wire:model="bomRows.{{ $key }}.bomQuantity">
                                        </td>
                                        <td>
                                            <select class="form-select form-select-sm"
                                                wire:model="bomRows.{{ $key }}.bomUnit">
                                                <option value="">-- Select --</option>
                                                @foreach ($units as $u)
                                                    <option value="{{ $u->id }}">{{ $u->satuan }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select class="form-select form-select-sm"
                                                wire:model="bomRows.{{ $key }}.bomLevel">
                                                <option value="">-- Select --</option>
                                                <option value="1">Level 1</option>
                                                <option value="2">Level 2</option>
                                                <option value="3">Level 3</option>
                                                <option value="4">Level 4</option>
                                                <option value="5">Level 5</option>
                                            </select>
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
                <div class="modal-footer">
                    <button type="button" class="btn me-auto" data-bs-toggle="modal"
                        data-bs-target="#show-modal">Close</button>
                    <button type="button" class="btn btn-primary" wire:click="save">Save</button>
                </div>
            </div>
        </div>
    </div>

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
                                <tr>
                                    <td>Material Type</td>
                                    <td>
                                        {{ $bomMaterialType_ }}
                                    </td>
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
                                    <th class="danger">Ga tau namanya</th>
                                    <th>Material</th>
                                    <th>Quantity</th>
                                    <th>U/M</th>
                                    <th>Level</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($bomDetails))
                                    @foreach ($bomDetails as $b)
                                        <tr wire:key="{{ $b->id }}">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $b->material }}</td>
                                            <td>{{ $b->ingredient }}</td>
                                            <td>{{ $b->quantity }}</td>
                                            <td>{{ $b->unit }}</td>
                                            <td>{{ $b->level }}</td>
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
                    <button type="button" class="btn btn-primary" wire:click="save">Save</button>
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
