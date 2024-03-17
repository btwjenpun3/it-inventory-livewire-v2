<div>

    {{-- Collapse --}}

    <div id="create-collapse" class="accordion-collapse collapse mb-3" wire:ignore.self>
        <div class="accordion-body pt-0">
            <div class="card card-body">
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label required">Purchase Name</label>
                        <input type="text" class="form-control @error('purchase_name') is-invalid @enderror"
                            wire:model="purchase_name">
                        @error('purchase_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label required">Purchase Code</label>
                        <input type="text" class="form-control @error('purchase_code') is-invalid @enderror"
                            wire:model="purchase_code">
                        @error('purchase_code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-12 ms-auto">
                        <button type="submit" wire:loading.attr="disabled" class="btn btn-success mt-3"
                            wire:click="save">Tambah</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Table --}}

    <div class="col-lg-12">
        <div class="card">
            <div class="table-responsive">
                <table class="table table-hover table-vcenter card-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Purchase Name</th>
                            <th>Purchase Code</th>
                            <th class="w-1"></th>
                        </tr>
                    </thead>
                    @if (count($data) > 0)
                        <tbody>
                            @foreach ($data as $index => $d)
                                <tr wire:key="{{ $d->id }}">
                                    <td>{{ $data->firstItem() + $index }}</td>
                                    <td>{{ $d->purchase_name }}</td>
                                    <td>{{ $d->purchase_code }}</td>
                                    <td>
                                        <div class="btn-list flex-nowrap">
                                            <button class="btn-link" data-bs-toggle="modal"
                                                data-bs-target="#update-modal"
                                                wire:click="updateConfirm({{ $d->id }})">
                                                Edit
                                            </button>
                                            <button class="btn-link text-danger" data-bs-toggle="modal"
                                                data-bs-target="#delete-modal"
                                                wire:click="deleteConfirm({{ $d->id }})">
                                                Delete
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
        </div>
    </div>

    {{-- Modal Update --}}

    <div class="modal modal-blur fade" id="update-modal" tabindex="-1" role="dialog" aria-hidden="true"
        wire:ignore.self>
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Master Purchase Order</h5>
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
                            <div class="col-md-6">
                                <label class="form-label required">Purchase Name</label>
                                <input type="text" class="form-control @error('purchase_name_') is-invalid @enderror"
                                    wire:model="purchase_name_">
                                @error('purchase_name_')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label required">Purchase Code</label>
                                <input type="text" class="form-control @error('purchase_code_') is-invalid @enderror"
                                    wire:model="purchase_code_">
                                @error('purchase_code_')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-link link-secondary" data-bs-dismiss="modal">
                            Cancel
                        </button>
                        <button class="btn btn-primary ms-auto" wire:click="update" wire:loading.attr="disabled">
                            Update
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Delete --}}

    <div class="modal modal-blur fade" id="delete-modal" tabindex="-1" role="dialog" aria-hidden="true"
        wire:ignore.self>
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-status bg-danger"></div>
                <div class="modal-body text-center py-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-danger icon-lg" width="24"
                        height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path
                            d="M10.24 3.957l-8.422 14.06a1.989 1.989 0 0 0 1.7 2.983h16.845a1.989 1.989 0 0 0 1.7 -2.983l-8.423 -14.06a1.989 1.989 0 0 0 -3.4 0z" />
                        <path d="M12 9v4" />
                        <path d="M12 17h.01" />
                    </svg>
                    <h3>Apa kamu yakin?</h3>
                    <div class="text-muted">
                        Data tidak dapat di kembalikan setelah terhapus!
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="w-100">
                        <div class="row">
                            <div class="col">
                                <button class="btn w-100" data-bs-dismiss="modal">
                                    Tutup
                                </button>
                            </div>
                            <div class="col">
                                <button class="btn btn-danger w-100" wire:click="delete"
                                    wire:loading.attr="disabled">
                                    Hapus
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @script
        <script>
            $wire.on('success', (data) => {
                toastr.success(data)
            });
            $wire.on('error', (data) => {
                toastr.error(data)
            });
            $wire.on('delete-modal-close', () => {
                $('#delete-modal').modal('hide');
            });
            $wire.on('update-modal-close', () => {
                $('#update-modal').modal('hide');
            });
        </script>
    @endscript

</div>
