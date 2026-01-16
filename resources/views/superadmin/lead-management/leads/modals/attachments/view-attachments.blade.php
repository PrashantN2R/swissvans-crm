<div id="attachmentsModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="attachmentsModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-full-width">
        <div class="modal-content">
            <div class="modal-header modal-colored-header bg-danger">
                <h4 class="modal-title text-white" id="attachmentsModalLabel">View Attachments</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body">
                @if(count($lead->attachments) > 0)
                <table id="basic-datatable" class="table table-sm align-middle table-row-dashed fs-6 gy-5 dataTable">
                    <thead>
                        <tr>
                            <th class="th-primary" width="20%">Filename</th>
                            <th class="th-primary" width="20%">Size</th>
                            <th class="th-primary" width="20%">Uploaded By</th>
                            <th class="th-primary" width="20%">Uploaded On</th>
                            <th class="th-primary text-end" width="20%"></th>
                        </tr>
                    </thead>
                    <tbody class="fw-semibold text-gray-600">
                        @foreach ($lead->attachments as $row)
                            <tr>
                                <td><a href="{{ $row->path }}" download="{{ $row->attachment }}" class="text-body fw-semibold">{{ $row->attachment }}</a></td>
                                <td>
    @if ($row->size >= 1024 * 1024)
        {{ number_format($row->size / (1024 * 1024), 2) }} MB
    @else
        {{ number_format($row->size / 1024, 2) }} KB
    @endif
</td>
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
                                <td class="text-end"><a href="{{ $row->path }}" download="{{ $row->attachment }}" class="btn btn-xs btn-primary">Download</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="text-center py-5">
                    <h4 class="text-muted">No Attachments Uploaded</h4>
                </div>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
