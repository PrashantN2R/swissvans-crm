<div id="notesModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="notesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-full-width">
        <div class="modal-content">
            <div class="modal-header modal-colored-header bg-dark">
                <h4 class="modal-title text-white" id="notesModalLabel">View Notes</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body">
                @if(count($lead->notes) > 0)
                <table id="basic-datatable" class="table table-sm align-middle table-row-dashed fs-6 gy-5 dataTable">
                    <thead>
                        <tr>
                            <th class="th-primary" width="60%">Note</th>
                            <th class="th-primary" width="20%">Updated By</th>
                            <th class="th-primary" width="20%">Updated On</th>
                        </tr>
                    </thead>
                    <tbody class="fw-semibold text-gray-600">
                        @foreach ($lead->notes as $row)
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
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
