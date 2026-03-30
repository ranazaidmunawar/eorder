 <div class="modal fade" id="callWaiterModal" tabindex="-1" role="dialog" aria-labelledby="callWaiterModalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">
                        {{ $keywords['Call Waiter'] ?? __('Call Waiter') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @php
                        $tables = Table::query()
                            ->where('status', 1)
                            ->where('user_id', $user->id)
                            ->get();
                    @endphp
                    <form id="callWaiterForm" action="{{ route('user.front.call.waiter', getParam()) }}"
                        method="GET">
                        <select class="form-control" name="table" required>
                            <option value="" disabled selected>
                                {{ $keywords['Select a Table'] ?? __('Select a Table') }}
                            </option>
                            @foreach ($tables as $table)
                                <option value="{{ $table->table_no }}">{{ $keywords['Table'] ?? __('Table') }} -
                                    {{ $table->table_no }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" form="callWaiterForm" class="btn base-btn text-white">
                        {{ $keywords['Call Waiter'] ?? __('Call Waiter') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
