<div id="assignModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="assignModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('superadmin.leads.assign') }}" id="assignForm">
            @csrf
            <input type="hidden" name="lead_id" id="lead_id">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-primary">
                    <h4 class="modal-title" id="assignModalLabel">Assign Lead</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="assigned_to" class="form-label">Select Assignee</label>
                        <select name="assigned_to" id="assigned_to" class="form-select" required>
                            <option value="">Select Assignee</option>
                            @foreach ($assignees as $assignee)
                                <option value="{{ $assignee->id }}">{{ $assignee->firstname }} {{ $assignee->lastname }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" form="assignForm">Assign</button>
                </div>
            </div>
        </form>
    </div>
</div>
