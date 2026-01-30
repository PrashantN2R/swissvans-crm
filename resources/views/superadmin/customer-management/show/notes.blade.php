<div class="tab-pane" id="notes">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('superadmin.customers.save-note', $user->id) }}" method="POST"
                        id="addNoteForm">
                        @csrf
                        @method('PUT')
                        <div class="form-group {{ $errors->has('note') ? 'has-error' : '' }}">
                            <label class="col-form-label" for="note">Customer Internal Notes <span
                                    class="text-danger">*</span></label>
                            <textarea class="form-control" id="note" name="note" placeholder="Enter note" rows="5" required>{{ old('note') }}</textarea>
                            @error('note')
                                <span id="note-error" class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group d-grid mt-2">
                            <button type="submit" class="btn btn-sm btn-primary" form="addNoteForm"><i
                                    class="bi bi-floppy me-1"></i>Save
                                Note</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if (count($user->notes) > 0)
                        <table id="basic-datatable"
                            class="table table-sm align-middle table-row-dashed fs-6 gy-5 dataTable">
                            <thead>
                                <tr>
                                    <th class="th-primary" width="60%">Note</th>
                                    <th class="th-primary" width="20%">Updated By</th>
                                    <th class="th-primary" width="20%">Updated On</th>
                                </tr>
                            </thead>
                            <tbody class="fw-semibold text-gray-600">
                                @foreach ($user->notes as $row)
                                    <tr>
                                        <td>{{ $row->note }}</td>
                                        <td>
                                            <span class="text-dark">
                                                <i class="uil-user me-1"></i>
                                                {{ $row->creator->firstname }} {{ $row->creator->lastname }}
                                            </span>
                                            <br>
                                            <span class="text-muted">
                                                <i class="uil-anchor me-1"></i>
                                                {{ $row->creator->roles->first()->name }}
                                            </span>
                                        </td>

                                        <td><i class="uil-calender me-1"></i>
                                            {{ \Carbon\Carbon::parse($row->created_at)->format('M d Y') }}<br>
                                            <i class="uil-clock me-1"></i>
                                            {{ \Carbon\Carbon::parse($row->created_at)->format('h:i A') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="text-center py-5">
                            <h4 class="text-muted">No Notes Added</h4>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
