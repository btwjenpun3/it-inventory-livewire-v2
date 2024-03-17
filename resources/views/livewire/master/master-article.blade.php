<div>

    {{-- Collapse --}}

    <div id="create-collapse" class="accordion-collapse collapse mb-3" wire:ignore.self>
        <div class="accordion-body pt-0">
            <div class="card card-body">
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label required">Article Code</label>
                        <input type="text" class="form-control @error('articleCode') is-invalid @enderror"
                            wire:model="articleCode">
                        @error('articleCode')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label required">Article Name</label>
                        <input type="text" class="form-control @error('articleName') is-invalid @enderror"
                            wire:model="articleName">
                        @error('articleName')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mt-3">
                        <label class="form-label required">Description</label>
                        <input type="text" class="form-control @error('description') is-invalid @enderror"
                            wire:model="description">
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mt-3">
                        <label class="form-label required">Buyer</label>
                        @if (count($buyers) > 0)
                            <select class="form-select @error('buyerCode') is-invalid @enderror" wire:model="buyerCode">
                                <option value="">-- Select --</option>
                                @foreach ($buyers as $b)
                                    <option value="{{ $b->id }}">{{ $b->code_buyer }} - {{ $b->buyer_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('buyerCode')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        @else
                            <p class="mt-3">
                                Not found. Please create from <a href="{{ route('master.buyer') }}">Master
                                    Buyer</a>.
                            </p>
                        @endif
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
                            <th>Article Code</th>
                            <th>Article Code</th>
                            <th>Description</th>
                            <th>Buyer</th>
                            <th class="w-1"></th>
                        </tr>
                    </thead>
                    @if (count($data) > 0)
                        <tbody>
                            @foreach ($data as $d)
                                <tr wire:key="{{ $d->id }}">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $d->article_code }}</td>
                                    <td>{{ $d->article_name }}</td>
                                    <td>{{ $d->description }}</td>
                                    <td>{{ $d->buyer->buyer_name }}</td>
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
                    <h5 class="modal-title">Edit Data Article</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div wire:target="updateConfirm" wire:loading>
                    <div class="progress progress-sm">
                        <div class="progress-bar progress-bar-indeterminate"></div>
                    </div>
                </div>
                <div wire:target="updateConfirm" wire:loading.remove>
                    <div class="modal-body">
                        <div class="card card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label required">Article Code</label>
                                    <input type="text"
                                        class="form-control @error('articleCode_') is-invalid @enderror"
                                        wire:model="articleCode_">
                                    @error('articleCode_')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label required">Article Name</label>
                                    <input type="text"
                                        class="form-control @error('articleName_') is-invalid @enderror"
                                        wire:model="articleName_">
                                    @error('articleName_')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label class="form-label required">Description</label>
                                    <input type="text"
                                        class="form-control @error('description_') is-invalid @enderror"
                                        wire:model="description_">
                                    @error('description_')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label class="form-label">Buyer</label>
                                    <select class="form-control @error('buyerCode_') is-invalid @enderror"
                                        wire:model="buyerCode_">
                                        <option value="">-- Select --</option>
                                        @foreach ($buyers as $b)
                                            <option value="{{ $b->id }}">{{ $b->code_buyer }} -
                                                {{ $b->buyer_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('buyerCode_')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
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
