@php
    $tables = \App\Models\User\Table::query()->where('status', 1)->where('user_id', $user->id)->get();
@endphp
<div class="modal fade" id="callWaiterModal" tabindex="-1" aria-labelledby="callWaiterModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="callWaiterModalLabel">
                    {{ $keywords['Call Waiter'] ?? __('Call Waiter') }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="callWaiterForm" action="{{ route('user.front.call.waiter', getParam()) }}" method="GET">
                    <select class="form-control" name="table" required>
                        <option value="" disabled selected>
                            {{ $keywords['Select a Table'] ?? __('Select a Table') }}
                        </option>
                        @foreach ($tables as $table)
                            <option value="{{ $table->table_no }}">
                                {{ $keywords['Table'] ?? __('Table') }} - {{ $table->table_no }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>

            <div class="modal-footer">
                <button type="submit" form="callWaiterForm" class="btn thm-btn">
                    {{ $keywords['Call Waiter'] ?? __('Call Waiter') }}
                </button>
            </div>
        </div>
    </div>
</div>
