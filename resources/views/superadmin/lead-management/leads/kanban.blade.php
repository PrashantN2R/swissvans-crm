@extends('layouts.superadmin')

@section('title', 'Leads | Superadmin')

@section('head')
    <link rel="stylesheet" href="https://unpkg.com/jkanban@1.3.1/dist/jkanban.min.css" />
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background: #f9fafb;
        }

        .kanban-scroll {
            overflow-x: auto;
            /* enable horizontal scroll */
            overflow-y: hidden;
            white-space: nowrap;
            /* prevent columns wrapping */
            padding-bottom: 0.5rem;
        }

        /* Make inner kanban row a single unbroken line of boards */
        .kanban-scroll #kanban {
            display: inline-flex;
            /* lay columns horizontally */
            min-width: max-content;
            /* keep min width to prevent wrapping */
        }

        /* Aesthetics */
        .kanban-board {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
        }

        .kanban-title-board {
            font-weight: bold;
            font-size: 1.1rem;
            padding: 10px;
        }

        .kanban-item {
            background: #f3f4f6;
            border-radius: 6px;
            padding: 5px;
        }

        .lead-title fs-6 {
            font-weight: 600;
        }

        .lead-meta {
            font-size: 0.8rem;
            color: #6b7280;
        }

        .kanban-board .kanban-drag {
            min-height: 200px;
            padding: 6px;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                         <a href="{{ route('superadmin.leads.index') }}" class="btn btn-sm btn-dark" style="width: 86.06px;"><i
                                class="bi bi-view-list me-1"></i>List</a>
                        <a href="{{ route('superadmin.leads.create') }}" class="btn btn-sm btn-primary">
                            <i class="bi bi-plus-circle me-1"></i>Add Lead
                        </a>
                    </div>
                    <h4 class="page-title">Leads</h4>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item">Lead Management</li>
                        <li class="breadcrumb-item active">Kanban View</li>
                    </ol>
                </div>
            </div>

            <div class="col-12">
                <!-- H-scroll wrapper -->
                <div class="kanban-scroll">
                    <div id="kanban"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://unpkg.com/jkanban@1.3.1/dist/jkanban.min.js"></script>
    <script>
        // Prepare items per column from server, safely JSON-encoded
        const boards = [{
                id: "New",
                title: "New",
                class: "status-new",
                item: @json(
                    $new_leads->map(function ($lead) {
                        return [
                            'id' => "lead-{$lead->id}",
                            'title' =>
                                "<div class='lead-title fs-6 text-body fw-semibold'>" .
                                e($lead->name ?? 'Untitled') .
                                '</div>' .
                                "<div class='lead-meta' style='font-size:0.7rem;'>" .
                                e($lead->email ?? '') .
                                '</div>' .
                                "<div class='lead-meta' style='font-size:0.7rem;'>" .
                                e($lead->phone ?? '') .
                                '</div>' .
                                "<div class='lead-meta d-flex justify-content-between' style='font-size:0.7rem;'><span class='text-dark'>" .
                                e($lead->event_type ?? '') .
                                '</span><span class="text-dark">' .
                                e($lead->event_date ?? '') .
                                '</span></div>',
                        ];
                    }))
            },
            {
                id: "Contacted",
                title: "Contacted",
                class: "status-contacted",
                item: @json(
                    $contacted_leads->map(function ($lead) {
                        return [
                            'id' => "lead-{$lead->id}",
                            'title' =>
                                "<div class='lead-title fs-6 text-body fw-semibold'>" .
                                e($lead->name ?? 'Untitled') .
                                '</div>' .
                                "<div class='lead-meta' style='font-size:0.7rem;'>" .
                                e($lead->email ?? '') .
                                '</div>' .
                                "<div class='lead-meta' style='font-size:0.7rem;'>" .
                                e($lead->phone ?? '') .
                                '</div>' .
                                "<div class='lead-meta d-flex justify-content-between' style='font-size:0.7rem;'><span class='text-dark'>" .
                                e($lead->event_type ?? '') .
                                '</span><span class="text-dark">' .
                                e($lead->event_date ?? '') .
                                '</span></div>',
                        ];
                    }))
            },
            {
                id: "Quoted",
                title: "Quoted",
                class: "status-quoted",
                item: @json(
                    $quoted_leads->map(function ($lead) {
                        return [
                            'id' => "lead-{$lead->id}",
                            'title' =>
                                "<div class='lead-title fs-6 text-body fw-semibold'>" .
                                e($lead->name ?? 'Untitled') .
                                '</div>' .
                                "<div class='lead-meta' style='font-size:0.7rem;'>" .
                                e($lead->email ?? '') .
                                '</div>' .
                                "<div class='lead-meta' style='font-size:0.7rem;'>" .
                                e($lead->phone ?? '') .
                                '</div>' .
                                "<div class='lead-meta d-flex justify-content-between' style='font-size:0.7rem;'><span class='text-dark'>" .
                                e($lead->event_type ?? '') .
                                '</span><span class="text-dark">' .
                                e($lead->event_date ?? '') .
                                '</span></div>',
                        ];
                    }))
            },
            {
                id: "Negotiation",
                title: "Negotiation",
                class: "status-negotiation",
                item: @json(
                    $negotiation_leads->map(function ($lead) {
                        return [
                            'id' => "lead-{$lead->id}",
                            'title' =>
                                "<div class='lead-title fs-6 text-body fw-semibold'>" .
                                e($lead->name ?? 'Untitled') .
                                '</div>' .
                                "<div class='lead-meta' style='font-size:0.7rem;'>" .
                                e($lead->email ?? '') .
                                '</div>' .
                                "<div class='lead-meta' style='font-size:0.7rem;'>" .
                                e($lead->phone ?? '') .
                                '</div>' .
                                "<div class='lead-meta d-flex justify-content-between' style='font-size:0.7rem;'><span class='text-dark'>" .
                                e($lead->event_type ?? '') .
                                '</span><span class="text-dark">' .
                                e($lead->event_date ?? '') .
                                '</span></div>',
                        ];
                    }))
            },
            {
                id: "Won",
                title: "Won",
                class: "status-won",
                item: @json(
                    $won_leads->map(function ($lead) {
                        return [
                            'id' => "lead-{$lead->id}",
                            'title' =>
                                "<div class='lead-title fs-6 text-body fw-semibold'>" .
                                e($lead->name ?? 'Untitled') .
                                '</div>' .
                                "<div class='lead-meta' style='font-size:0.7rem;'>" .
                                e($lead->email ?? '') .
                                '</div>' .
                                "<div class='lead-meta' style='font-size:0.7rem;'>" .
                                e($lead->phone ?? '') .
                                '</div>' .
                                "<div class='lead-meta d-flex justify-content-between' style='font-size:0.7rem;'><span class='text-dark'>" .
                                e($lead->event_type ?? '') .
                                '</span><span class="text-dark">' .
                                e($lead->event_date ?? '') .
                                '</span></div>',
                        ];
                    }))
            },
            {
                id: "Lost",
                title: "Lost",
                class: "status-lost",
                item: @json(
                    $lost_leads->map(function ($lead) {
                        return [
                            'id' => "lead-{$lead->id}",
                            'title' =>
                                "<div class='lead-title fs-6 text-body fw-semibold'>" .
                                e($lead->name ?? 'Untitled') .
                                '</div>' .
                                "<div class='lead-meta' style='font-size:0.7rem;'>" .
                                e($lead->email ?? '') .
                                '</div>' .
                                "<div class='lead-meta' style='font-size:0.7rem;'>" .
                                e($lead->phone ?? '') .
                                '</div>' .
                                "<div class='lead-meta d-flex justify-content-between' style='font-size:0.7rem;'><span class='text-dark'>" .
                                e($lead->event_type ?? '') .
                                '</span><span class="text-dark">' .
                                e($lead->event_date ?? '') .
                                '</span></div>',
                        ];
                    }))
            }
        ];

        new jKanban({
            element: '#kanban',
            gutter: '6px',
            widthBoard: `${1212 / 6 - 6}px`,
            boards: boards,
            dragItems: true,
            dragBoards: true,
            dropEl: function(el, target, source, sibling) {
                // jKanban sets data-eid to the item's id
                const leadId = (el.getAttribute('data-eid') || '').replace('lead-', '');
                const newStatus = target?.parentElement?.getAttribute('data-id');

                if (!leadId || !newStatus) return;

                $.ajax({
                    url: '{{ route("superadmin.leads.kanban.update-status") }}',
                    method: 'POST',
                    // Form-encoded is fine for Laravel; no need for JSON unless you prefer it
                    data: {
                        lead_id: leadId,
                        status: newStatus,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json'
                }).fail(function(xhr) {
                    // Optional: revert UI or show toast
                    alert('Failed to update status. Please try again.');
                    // TODO: move the card back if you track the previous column
                });
            }
        });
    </script>
@endpush
