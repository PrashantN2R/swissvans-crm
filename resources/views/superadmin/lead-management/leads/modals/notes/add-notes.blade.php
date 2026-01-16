<div id="addNoteModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addNoteModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-colored-header">
                <h4 class="modal-title text-dark" id="addNoteModalLabel">Add Note</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('superadmin.leads.save-note', $lead->id) }}" method="POST" id="addNoteForm">
                    @csrf
                    @method('PUT')
                    <div class="form-group {{ $errors->has('note') ? 'has-error' : '' }}">
                        <label class="col-form-label" for="note">Note <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="note" name="note" placeholder="Enter note" rows="5" required>{{ old('note') }}</textarea>
                        @error('note')
                            <span id="note-error" class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success" form="addNoteForm">Save</button>
            </div>
        </div>
    </div>
</div>
