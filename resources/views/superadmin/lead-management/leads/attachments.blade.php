<div id="attachedPreview" class="d-flex flex-wrap gap-2">
    @foreach ($lead->attachments as $key => $attachment)
        @switch($attachment->extension)
            @case('csv')
                <div class="card shadow-sm" style="width: 180px; position: relative;" id="file-card-{{ $key }}">
                    <div class="overlay d-flex justify-content-between p-2">
                        <a href="{{ $attachment->path }}" download class="btn btn-xs btn-icon btn-success download-file"
                            data-index="{{ $key }}" title="Download" style="border-radius: 50%;">
                            <i class="bi bi-download fs-4"></i>
                        </a>
                        <a href="javascript:void(0)" onclick="confirmAttachmentDelete({{ $attachment->id }})"
                            class="btn btn-xs btn-icon btn-danger" data-index="{{ $key }}" style="border-radius: 50%;">
                            <i class="bi bi-x fs-4"></i>
                        </a>

                    </div>
                    <div class="card-body text-center p-2 d-flex flex-column align-items-center justify-content-center"
                        style="height: 150px;">
                        <div class="mb-2" id="file-preview-{{ $key }}"><i
                                class="bi bi-file-earmark-excel-fill text-success fs-1"></i>
                        </div>
                        <div class="text-truncate w-100" title="{{ $attachment->attachment }}" style="font-size: 0.85rem;">
                            {{ $attachment->attachment }}</div>
                    </div>
                </div>
            @break

            @case('png')
                <div class="card shadow-sm" style="width: 180px; position: relative;" id="file-card-{{ $key }}">
                    <div class="overlay d-flex justify-content-between p-2">
                        <a href="{{ $attachment->path }}" download class="btn btn-xs btn-icon btn-success download-file"
                            data-index="{{ $key }}" title="Download" style="border-radius: 50%;">
                            <i class="bi bi-download fs-4"></i>
                        </a>
                        <a href="javascript:void(0)" onclick="confirmAttachmentDelete({{ $attachment->id }})"
                            class="btn btn-xs btn-icon btn-danger" data-index="{{ $key }}"
                            style="border-radius: 50%;">
                            <i class="bi bi-x fs-4"></i>
                        </a>

                    </div>
                    <div class="card-body text-center p-2 d-flex flex-column align-items-center justify-content-center"
                        style="height: 150px;">
                        <div class="mb-2" id="file-preview-{{ $key }}"><img src="{{ $attachment->path }}"
                                class="img-fluid rounded" style="max-height: 80px;"></div>
                        <div class="text-truncate w-100" title="{{ $attachment->attachment }}" style="font-size: 0.85rem;">
                            {{ $attachment->attachment }}</div>
                    </div>
                </div>
            @break

            @case('jpeg')
                <div class="card shadow-sm" style="width: 180px; position: relative;" id="file-card-{{ $key }}">
                    <div class="overlay d-flex justify-content-between p-2">
                        <a href="{{ $attachment->path }}" download class="btn btn-xs btn-icon btn-success download-file"
                            data-index="{{ $key }}" title="Download" style="border-radius: 50%;">
                            <i class="bi bi-download fs-4"></i>
                        </a>
                        <a href="javascript:void(0)" onclick="confirmAttachmentDelete({{ $attachment->id }})"
                            class="btn btn-xs btn-icon btn-danger" data-index="{{ $key }}"
                            style="border-radius: 50%;">
                            <i class="bi bi-x fs-4"></i>
                        </a>

                    </div>
                    <div class="card-body text-center p-2 d-flex flex-column align-items-center justify-content-center"
                        style="height: 150px;">
                        <div class="mb-2" id="file-preview-{{ $key }}"><img src="{{ $attachment->path }}"
                                class="img-fluid rounded" style="max-height: 80px;"></div>
                        <div class="text-truncate w-100" title="{{ $attachment->attachment }}" style="font-size: 0.85rem;">
                            {{ $attachment->attachment }}</div>
                    </div>
                </div>
            @break

            @case('jpg')
                <div class="card shadow-sm" style="width: 180px; position: relative;" id="file-card-{{ $key }}">
                    <div class="overlay d-flex justify-content-between p-2">
                        <a href="{{ $attachment->path }}" download class="btn btn-xs btn-icon btn-success download-file"
                            data-index="{{ $key }}" title="Download" style="border-radius: 50%;">
                            <i class="bi bi-download fs-4"></i>
                        </a>
                        <a href="javascript:void(0)" onclick="confirmAttachmentDelete({{ $attachment->id }})"
                            class="btn btn-xs btn-icon btn-danger" data-index="{{ $key }}"
                            style="border-radius: 50%;">
                            <i class="bi bi-x fs-4"></i>
                        </a>

                    </div>
                    <div class="card-body text-center p-2 d-flex flex-column align-items-center justify-content-center"
                        style="height: 150px;">
                        <div class="mb-2" id="file-preview-{{ $key }}"><img src="{{ $attachment->path }}"
                                class="img-fluid rounded" style="max-height: 80px;"></div>
                        <div class="text-truncate w-100" title="{{ $attachment->attachment }}" style="font-size: 0.85rem;">
                            {{ $attachment->attachment }}</div>
                    </div>
                </div>
            @break

            @case('webp')
                <div class="card shadow-sm" style="width: 180px; position: relative;" id="file-card-{{ $key }}">
                    <div class="overlay d-flex justify-content-between p-2">
                        <a href="{{ $attachment->path }}" download class="btn btn-xs btn-icon btn-success download-file"
                            data-index="{{ $key }}" title="Download" style="border-radius: 50%;">
                            <i class="bi bi-download fs-4"></i>
                        </a>
                        <a href="javascript:void(0)" onclick="confirmAttachmentDelete({{ $attachment->id }})"
                            class="btn btn-xs btn-icon btn-danger" data-index="{{ $key }}"
                            style="border-radius: 50%;">
                            <i class="bi bi-x fs-4"></i>
                        </a>

                    </div>
                    <div class="card-body text-center p-2 d-flex flex-column align-items-center justify-content-center"
                        style="height: 150px;">
                        <div class="mb-2" id="file-preview-{{ $key }}"><img src="{{ $attachment->path }}"
                                class="img-fluid rounded" style="max-height: 80px;"></div>
                        <div class="text-truncate w-100" title="{{ $attachment->attachment }}" style="font-size: 0.85rem;">
                            {{ $attachment->attachment }}</div>
                    </div>
                </div>
            @break

            @case('gif')
                <div class="card shadow-sm" style="width: 180px; position: relative;" id="file-card-{{ $key }}">
                    <div class="overlay d-flex justify-content-between p-2">
                        <a href="{{ $attachment->path }}" download class="btn btn-xs btn-icon btn-success download-file"
                            data-index="{{ $key }}" title="Download" style="border-radius: 50%;">
                            <i class="bi bi-download fs-4"></i>
                        </a>
                        <a href="javascript:void(0)" onclick="confirmAttachmentDelete({{ $attachment->id }})"
                            class="btn btn-xs btn-icon btn-danger" data-index="{{ $key }}"
                            style="border-radius: 50%;">
                            <i class="bi bi-x fs-4"></i>
                        </a>

                    </div>
                    <div class="card-body text-center p-2 d-flex flex-column align-items-center justify-content-center"
                        style="height: 150px;">
                        <div class="mb-2" id="file-preview-{{ $key }}"><img src="{{ $attachment->path }}"
                                class="img-fluid rounded" style="max-height: 80px;"></div>
                        <div class="text-truncate w-100" title="{{ $attachment->attachment }}" style="font-size: 0.85rem;">
                            {{ $attachment->attachment }}</div>
                    </div>
                </div>
            @break

            @case('xlsx')
                <div class="card shadow-sm" style="width: 180px; position: relative;" id="file-card-{{ $key }}">
                    <div class="overlay d-flex justify-content-between p-2">
                        <a href="{{ $attachment->path }}" download class="btn btn-xs btn-icon btn-success download-file"
                            data-index="{{ $key }}" title="Download" style="border-radius: 50%;">
                            <i class="bi bi-download fs-4"></i>
                        </a>
                        <a href="javascript:void(0)" onclick="confirmAttachmentDelete({{ $attachment->id }})"
                            class="btn btn-xs btn-icon btn-danger" data-index="{{ $key }}"
                            style="border-radius: 50%;">
                            <i class="bi bi-x fs-4"></i>
                        </a>

                    </div>
                    <div class="card-body text-center p-2 d-flex flex-column align-items-center justify-content-center"
                        style="height: 150px;">
                        <div class="mb-2" id="file-preview-{{ $key }}"><i
                                class="bi bi-file-earmark-excel-fill text-success fs-1"></i>
                        </div>
                        <div class="text-truncate w-100" title="{{ $attachment->attachment }}" style="font-size: 0.85rem;">
                            {{ $attachment->attachment }}</div>
                    </div>
                </div>
            @break

            @case('txt')
                <div class="card shadow-sm" style="width: 180px; position: relative;" id="file-card-{{ $key }}">
                    <div class="overlay d-flex justify-content-between p-2">
                        <a href="{{ $attachment->path }}" download class="btn btn-xs btn-icon btn-success download-file"
                            data-index="{{ $key }}" title="Download" style="border-radius: 50%;">
                            <i class="bi bi-download fs-4"></i>
                        </a>
                        <a href="javascript:void(0)" onclick="confirmAttachmentDelete({{ $attachment->id }})"
                            class="btn btn-xs btn-icon btn-danger" data-index="{{ $key }}"
                            style="border-radius: 50%;">
                            <i class="bi bi-x fs-4"></i>
                        </a>

                    </div>
                    <div class="card-body text-center p-2 d-flex flex-column align-items-center justify-content-center"
                        style="height: 150px;">
                        <div class="mb-2" id="file-preview-{{ $key }}"><i
                                class="bi bi-file-earmark-text-fill text-muted fs-1"></i>
                        </div>
                        <div class="text-truncate w-100" title="{{ $attachment->attachment }}" style="font-size: 0.85rem;">
                            {{ $attachment->attachment }}</div>
                    </div>
                </div>
            @break

            @case('pptx')
                <div class="card shadow-sm" style="width: 180px; position: relative;" id="file-card-{{ $key }}">
                    <div class="overlay d-flex justify-content-between p-2">
                        <a href="{{ $attachment->path }}" download class="btn btn-xs btn-icon btn-success download-file"
                            data-index="{{ $key }}" title="Download" style="border-radius: 50%;">
                            <i class="bi bi-download fs-4"></i>
                        </a>
                        <a href="javascript:void(0)" onclick="confirmAttachmentDelete({{ $attachment->id }})"
                            class="btn btn-xs btn-icon btn-danger" data-index="{{ $key }}"
                            style="border-radius: 50%;">
                            <i class="bi bi-x fs-4"></i>
                        </a>

                    </div>
                    <div class="card-body text-center p-2 d-flex flex-column align-items-center justify-content-center"
                        style="height: 150px;">
                        <div class="mb-2" id="file-preview-{{ $key }}"><i
                                class="bi bi-file-earmark-slides-fill text-warning fs-1"></i>
                        </div>
                        <div class="text-truncate w-100" title="{{ $attachment->attachment }}" style="font-size: 0.85rem;">
                            {{ $attachment->attachment }}</div>
                    </div>
                </div>
            @break

            @case('ppt')
                <div class="card shadow-sm" style="width: 180px; position: relative;" id="file-card-{{ $key }}">
                    <div class="overlay d-flex justify-content-between p-2">
                        <a href="{{ $attachment->path }}" download class="btn btn-xs btn-icon btn-success download-file"
                            data-index="{{ $key }}" title="Download" style="border-radius: 50%;">
                            <i class="bi bi-download fs-4"></i>
                        </a>
                        <a href="javascript:void(0)" onclick="confirmAttachmentDelete({{ $attachment->id }})"
                            class="btn btn-xs btn-icon btn-danger" data-index="{{ $key }}"
                            style="border-radius: 50%;">
                            <i class="bi bi-x fs-4"></i>
                        </a>

                    </div>
                    <div class="card-body text-center p-2 d-flex flex-column align-items-center justify-content-center"
                        style="height: 150px;">
                        <div class="mb-2" id="file-preview-{{ $key }}"><i
                                class="bi bi-file-earmark-slides-fill text-warning fs-1"></i>
                        </div>
                        <div class="text-truncate w-100" title="{{ $attachment->attachment }}" style="font-size: 0.85rem;">
                            {{ $attachment->attachment }}</div>
                    </div>
                </div>
            @break

            @case('pdf')
                <div class="card shadow-sm" style="width: 180px; position: relative;" id="file-card-{{ $key }}">
                    <div class="overlay d-flex justify-content-between p-2">
                        <a href="{{ $attachment->path }}" download class="btn btn-xs btn-icon btn-success download-file"
                            data-index="{{ $key }}" title="Download" style="border-radius: 50%;">
                            <i class="bi bi-download fs-4"></i>
                        </a>
                        <a href="javascript:void(0)" onclick="confirmAttachmentDelete({{ $attachment->id }})"
                            class="btn btn-xs btn-icon btn-danger" data-index="{{ $key }}"
                            style="border-radius: 50%;">
                            <i class="bi bi-x fs-4"></i>
                        </a>

                    </div>
                    <div class="card-body text-center p-2 d-flex flex-column align-items-center justify-content-center"
                        style="height: 150px;">
                        <div class="mb-2" id="file-preview-{{ $key }}"><i
                                class="bi bi-file-earmark-pdf-fill text-danger fs-1"></i>
                        </div>
                        <div class="text-truncate w-100" title="{{ $attachment->attachment }}" style="font-size: 0.85rem;">
                            {{ $attachment->attachment }}</div>
                    </div>
                </div>
            @break

            @case('mp4')
                <div class="card shadow-sm" style="width: 180px; position: relative;" id="file-card-{{ $key }}">
                    <div class="overlay d-flex justify-content-between p-2">
                        <a href="{{ $attachment->path }}" download class="btn btn-xs btn-icon btn-success download-file"
                            data-index="{{ $key }}" title="Download" style="border-radius: 50%;">
                            <i class="bi bi-download fs-4"></i>
                        </a>
                        <a href="javascript:void(0)" onclick="confirmAttachmentDelete({{ $attachment->id }})"
                            class="btn btn-xs btn-icon btn-danger" data-index="{{ $key }}"
                            style="border-radius: 50%;">
                            <i class="bi bi-x fs-4"></i>
                        </a>

                    </div>
                    <div class="card-body text-center p-2 d-flex flex-column align-items-center justify-content-center"
                        style="height: 150px;">
                        <div class="mb-2" id="file-preview-{{ $key }}">
                            <video src="{{ $attachment->path }}" controls=""
                                style="max-height: 80px; width: 100%; border-radius: 6px;">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                        <div class="text-truncate w-100" title="{{ $attachment->attachment }}" style="font-size: 0.85rem;">
                            {{ $attachment->attachment }}</div>
                    </div>
                </div>
            @break

            @case('webm')
                <div class="card shadow-sm" style="width: 180px; position: relative;" id="file-card-{{ $key }}">
                    <div class="overlay d-flex justify-content-between p-2">
                        <a href="{{ $attachment->path }}" download class="btn btn-xs btn-icon btn-success download-file"
                            data-index="{{ $key }}" title="Download" style="border-radius: 50%;">
                            <i class="bi bi-download fs-4"></i>
                        </a>
                        <a href="javascript:void(0)" onclick="confirmAttachmentDelete({{ $attachment->id }})"
                            class="btn btn-xs btn-icon btn-danger" data-index="{{ $key }}"
                            style="border-radius: 50%;">
                            <i class="bi bi-x fs-4"></i>
                        </a>

                    </div>
                    <div class="card-body text-center p-2 d-flex flex-column align-items-center justify-content-center"
                        style="height: 150px;">
                        <div class="mb-2" id="file-preview-{{ $key }}">
                            <video src="{{ $attachment->path }}" controls=""
                                style="max-height: 80px; width: 100%; border-radius: 6px;">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                        <div class="text-truncate w-100" title="{{ $attachment->attachment }}" style="font-size: 0.85rem;">
                            {{ $attachment->attachment }}</div>
                    </div>
                </div>
            @break

            @case('ogg')
                <div class="card shadow-sm" style="width: 180px; position: relative;" id="file-card-{{ $key }}">
                    <div class="overlay d-flex justify-content-between p-2">
                        <a href="{{ $attachment->path }}" download class="btn btn-xs btn-icon btn-success download-file"
                            data-index="{{ $key }}" title="Download" style="border-radius: 50%;">
                            <i class="bi bi-download fs-4"></i>
                        </a>
                        <a href="javascript:void(0)" onclick="confirmAttachmentDelete({{ $attachment->id }})"
                            class="btn btn-xs btn-icon btn-danger" data-index="{{ $key }}"
                            style="border-radius: 50%;">
                            <i class="bi bi-x fs-4"></i>
                        </a>

                    </div>
                    <div class="card-body text-center p-2 d-flex flex-column align-items-center justify-content-center"
                        style="height: 150px;">
                        <div class="mb-2" id="file-preview-{{ $key }}">
                            <video src="{{ $attachment->path }}" controls=""
                                style="max-height: 80px; width: 100%; border-radius: 6px;">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                        <div class="text-truncate w-100" title="{{ $attachment->attachment }}" style="font-size: 0.85rem;">
                            {{ $attachment->attachment }}</div>
                    </div>
                </div>
            @break

            @case('xls')
                <div class="card shadow-sm" style="width: 180px; position: relative;" id="file-card-{{ $key }}">
                    <div class="overlay d-flex justify-content-between p-2">
                        <a href="{{ $attachment->path }}" download class="btn btn-xs btn-icon btn-success download-file"
                            data-index="{{ $key }}" title="Download" style="border-radius: 50%;">
                            <i class="bi bi-download fs-4"></i>
                        </a>
                        <a href="javascript:void(0)" onclick="confirmAttachmentDelete({{ $attachment->id }})"
                            class="btn btn-xs btn-icon btn-danger" data-index="{{ $key }}"
                            style="border-radius: 50%;">
                            <i class="bi bi-x fs-4"></i>
                        </a>

                    </div>
                    <div class="card-body text-center p-2 d-flex flex-column align-items-center justify-content-center"
                        style="height: 150px;">
                        <div class="mb-2" id="file-preview-{{ $key }}"><i
                                class="bi bi-file-earmark-excel-fill text-success fs-1"></i>
                        </div>
                        <div class="text-truncate w-100" title="{{ $attachment->attachment }}" style="font-size: 0.85rem;">
                            {{ $attachment->attachment }}</div>
                    </div>
                </div>
            @break

            @default
                <div class="card shadow-sm" style="width: 180px; position: relative;" id="file-card-{{ $key }}">
                    <div class="overlay d-flex justify-content-between p-2">
                        <a href="{{ $attachment->path }}" download class="btn btn-xs btn-icon btn-success download-file"
                            data-index="{{ $key }}" title="Download" style="border-radius: 50%;">
                            <i class="bi bi-download fs-4"></i>
                        </a>
                        <a href="javascript:void(0)" onclick="confirmAttachmentDelete({{ $attachment->id }})"
                            class="btn btn-xs btn-icon btn-danger" data-index="{{ $key }}"
                            style="border-radius: 50%;">
                            <i class="bi bi-x fs-4"></i>
                        </a>

                    </div>
                    <div class="card-body text-center p-2 d-flex flex-column align-items-center justify-content-center"
                        style="height: 150px;">
                        <div class="mb-2" id="file-preview-{{ $key }}"><i
                                class="bi bi-file-earmark-fill text-secondary fs-1"></i>
                        </div>
                        <div class="text-truncate w-100" title="{{ $attachment->attachment }}" style="font-size: 0.85rem;">
                            {{ $attachment->attachment }}</div>
                    </div>
                </div>
        @endswitch
    @endforeach
</div>
