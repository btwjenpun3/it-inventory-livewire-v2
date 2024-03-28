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
                                                <span class="badge bg-warning text-warning-fg">Need validate</span>
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
            @if (count($data) >= 10)
                {{ $data->links() }}
            @endif
        </div>
    </div>

    {{-- Modal Show --}}

    <div class="modal modal-blur fade" id="show-modal" tabindex="-1" role="dialog" aria-hidden="true"
        wire:ignore.self>
        <div class="modal-dialog modal-full-width modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div wire:target="updateConfirm" wire:loading>
                    <div class="progress progress-sm">
                        <div class="progress-bar progress-bar-indeterminate"></div>
                    </div>
                </div>
                <div wire:target="updateConfirm" wire:loading.remove>
                    <div class="modal-body">
                        <div class="col-md-12 text-center">
                            <h2 class="bg-primary text-primary-fg py-2">PO Buyer</h2>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-4">
                                        <b>PO Buyer No.</b>
                                    </div>
                                    <div class="col-md-6 border-bottom">
                                        {{ $po_buyer_no }}
                                    </div>
                                    <div class="col-md-4 mt-3">
                                        <b>PO Buyer Date</b>
                                    </div>
                                    <div class="col-md-6 mt-3 border-bottom">
                                        {{ $po_buyer_date }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-4">
                                        <b>Buyer Code</b>
                                    </div>
                                    <div class="col-md-6 border-bottom">
                                        {{ $buyer_code }}
                                    </div>
                                    <div class="col-md-4 mt-3">
                                        <b>Buyer Name</b>
                                    </div>
                                    <div class="col-md-6 mt-3 border-bottom">
                                        {{ $buyer_name }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-4">
                                        <b>Shipping Date</b>
                                    </div>
                                    <div class="col-md-6 border-bottom">
                                        {{ $shipping_date }}
                                    </div>
                                    <div class="col-md-4 mt-3">
                                        <b>Delivery Date</b>
                                    </div>
                                    <div class="col-md-6 mt-3 border-bottom">
                                        {{ $delivery_date }}
                                    </div>
                                    <div class="col-md-4 mt-3">
                                        <b>Due Date</b>
                                    </div>
                                    <div class="col-md-6 mt-3 border-bottom">
                                        {{ $due_date }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-sm table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Article Code</th>
                                    <th>Article Name</th>
                                    <th>Color</th>
                                    <th>Size</th>
                                    <th>Quantity</th>
                                    <th>Unit</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($articles))
                                    @foreach ($articles as $article)
                                        <tr>
                                            <td class="w-7">{{ $loop->iteration }}</td>
                                            <td>
                                                {{ $article->article_code }}
                                            </td>
                                            <td>
                                                {{ $article->article_name }}
                                            </td>
                                            <td>
                                                {{ $article->color }}
                                            </td>
                                            <td>
                                                {{ $article->size }}
                                            </td>
                                            <td>
                                                {{ $article->quantity }}
                                            </td>
                                            <td>
                                                {{ $article->unit }}
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                        <div class="col-md-12 mt-3">
                            <div class="row">
                                <div class="col-md-8 d-flex justify-content-start align-self-end">
                                    <div class="text-center mx-6">
                                        <button class="btn btn-danger" data-bs-toggle="collapse"
                                            data-bs-target="#reject-collapse">
                                            Reject
                                        </button>
                                        <div class="collapse mt-3" id="reject-collapse">
                                            <div class="card card-body">
                                                <p>Are you sure want to reject this Order Production ?</p>
                                                <button class="btn btn-danger" wire:click="reject"
                                                    wire:loading.attr="disabled">
                                                    Yes
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center mx-6">
                                        <button class="btn btn-success" data-bs-toggle="collapse"
                                            data-bs-target="#approve-collapse">
                                            Approve
                                        </button>
                                        <div class="collapse mt-3" id="approve-collapse">
                                            <div class="card card-body">
                                                <p>Are you sure want to approve this Order Production ?</p>
                                                <button class="btn btn-success" wire:click="approve"
                                                    wire:loading.attr="disabled">
                                                    Yes
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label class="form-label">
                                                <b>PIC</b>
                                            </label>
                                        </div>
                                        <div class="col-md-8 border-bottom">
                                            {{ $pic_name }} - {{ $pic_title }}
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-4">
                                            <label class="form-label">
                                                <b>Currency</b>
                                            </label>
                                        </div>
                                        <div class="col-md-8 border-bottom">
                                            {{ $currency }}
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-4">
                                            <label class="form-label">
                                                <b>Discount</b>
                                            </label>
                                        </div>
                                        <div class="col-md-8 border-bottom">
                                            {{ $discount }}
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-4">
                                            <label class="form-label">
                                                <b>DP</b>
                                            </label>
                                        </div>
                                        <div class="col-md-8 border-bottom">
                                            {{ $down_payment }}
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-4">
                                            <label class="form-label">
                                                <b>Tax</b>
                                            </label>
                                        </div>
                                        <div class="col-md-8 border-bottom">
                                            {{ $tax }}%
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
            $wire.on('show-modal-close', (data) => {
                $('#show-modal').modal('hide');
            });
            $wire.on('delete-modal-close', (data) => {
                $('#delete-modal').modal('hide');
            });
        </script>
    @endscript
</div>
