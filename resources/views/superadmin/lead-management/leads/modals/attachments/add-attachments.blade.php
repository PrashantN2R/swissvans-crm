<div id="addAttachmentModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addAttachmentModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-full-width">
        <div class="modal-content">
            <div class="modal-header modal-colored-header">
                <h4 class="modal-title text-danger" id="addAttachmentModalLabel">Add Attachment</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('superadmin.leads.upload-attachments', $lead->id) }}" method="POST"
                    id="attachmentForm" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group mb-2 {{ $errors->has('attachments') ? 'has-error' : '' }}">
                        <label class="col-form-label" for="attachments">Attachments</label>
                        <input type="file" name="attachments[]" id="attachments" class="form-control bg-transparent"
                            multiple />
                        @error('attachments')
                            <span id="attachments-error" class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group mb-2">
                        <div id="attachmentPreview" class="d-flex flex-wrap gap-2"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success" form="attachmentForm">Upload</button>
            </div>
        </div>
    </div>
</div>
