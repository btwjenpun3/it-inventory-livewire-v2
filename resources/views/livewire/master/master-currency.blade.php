<div>

    {{-- Collapse --}}

    <div id="create-collapse" class="accordion-collapse collapse mb-3" wire:ignore.self>
        <div class="accordion-body pt-0">
            <div class="card card-body">
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label required">Currency Code</label>
                        <input type="text" class="form-control @error('currency_code') is-invalid @enderror"
                            wire:model="currency_code">
                        @error('currency_code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label required">Currency Name</label>
                        <input type="text" class="form-control @error('currency_name') is-invalid @enderror"
                            wire:model="currency_name">
                        @error('currency_name')
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
                            <th>Currency Code</th>
                            <th>Currency Name</th>
                            <th class="w-1"></th>
                        </tr>
                    </thead>
                    @if (count($data) > 0)
                        <tbody>
                            @foreach ($data as $index => $d)
                                <tr wire:key="{{ $d->id }}">
                                    <td>{{ $data->firstItem() + $index }}</td>
                                    <td>{{ $d->currency_code }}</td>
                                    <td>{{ $d->currency_name }}</td>
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
            @if (count($data) >= 10)
                <div class="mt-3 ms-3 me-3">
                    {{ $data->links() }}
                </div>
            @endif
        </div>
    </div>

    {{-- Modal Update --}}

    <div class="modal modal-blur fade" id="update-modal" tabindex="-1" role="dialog" aria-hidden="true"
        wire:ignore.self>
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Master Currency</h5>
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
                                <label class="form-label required">Currency Code</label>
                                <input type="text" class="form-control @error('currency_code_') is-invalid @enderror"
                                    wire:model="currency_code_">
                                @error('currency_code_')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label required">Currency Name</label>
                                <input type="text" class="form-control @error('currency_name_') is-invalid @enderror"
                                    wire:model="currency_name_">
                                @error('currency_name_')
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

    {{-- Modal Import --}}

    <div class="modal modal-blur fade" id="import-modal" tabindex="-1" role="dialog" aria-hidden="true"
        wire:ignore.self>
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-status bg-info"></div>
                <div class="modal-body text-center py-4">
                    <h3>Are you sure?</h3>
                    <div class="text-muted">
                        This action will Import <code>All 160 Countries</code> currency all over the world!
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="w-100">
                        <div class="row">
                            <div class="col">
                                <button class="btn w-100" data-bs-dismiss="modal">
                                    Close
                                </button>
                            </div>
                            <div class="col">
                                <button class="btn btn-info w-100" wire:click="import" wire:loading.attr="disabled">
                                    Import
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
            $wire.on('import-modal-close', () => {
                $('#import-modal').modal('hide');
            });
        </script>
    @endscript

</div>
