@extends('layouts.master')

@section('content')
    <div class="h-screen flex flex-col bg-[#fcfcfd] overflow-hidden">

        <style>
            @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Plus+Jakarta+Sans:wght@700;800&display=swap');

            body {
                font-family: 'Inter', sans-serif;
            }

            .heading-font {
                font-family: 'Plus Jakarta Sans', sans-serif;
            }

            .board-canvas {
                display: flex;
                flex-direction: row;
                gap: 1.25rem;
                padding: 1.5rem;
                height: calc(100vh - 120px);
                overflow-x: auto;
                align-items: stretch;
            }

            .column-node {
                width: 310px;
                min-width: 310px;
                background-color: #f1f5f9;
                border-radius: 20px;
                display: flex;
                flex-direction: column;
                border: 1px solid #e2e8f0;
                max-height: 100%;
            }

            .task-container {
                flex: 1;
                overflow-y: auto;
                padding: 0 0.75rem 1rem 0.75rem;
                min-height: 100px;
            }

            .task-card {
                background: white;
                border-radius: 14px;
                border: 1px solid #e2e8f0;
                padding: 1rem;
                margin-bottom: 0.75rem;
                transition: all 0.2s ease;
                position: relative;
            }

            .task-card[data-draggable="true"] {
                cursor: grab;
            }

            .task-card[data-draggable="true"]:hover {
                border-color: #06b6d4;
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            }

            .task-card[data-draggable="false"] {
                opacity: 0.75;
                cursor: not-allowed;
                background-color: #f8fafc;
            }

            .lock-icon {
                @apply absolute top-2 right-3 text-slate-300;
            }

            .custom-scroll::-webkit-scrollbar {
                width: 4px;
                height: 6px;
            }

            .custom-scroll::-webkit-scrollbar-thumb {
                background: #cbd5e1;
                border-radius: 10px;
            }
        </style>

        <header class="bg-white border-b border-slate-200 px-8 py-5 shrink-0 flex items-center justify-between">
            <div>
                <h1 class="heading-font text-xl font-800 text-slate-900 tracking-tight capitalize">{{ $project->name }}</h1>

                @php
                    $totalMissions = $project->tasks()->whereNull('parent_id')->count();
                    $completedMissions = $project->tasks()->whereNull('parent_id')->where('status', 'done')->count();
                    $percent = $totalMissions > 0 ? round(($completedMissions / $totalMissions) * 100) : 0;
                @endphp

                <div class="mt-2 flex items-center gap-3">
                    <div class="w-32 bg-slate-100 h-1.5 rounded-full overflow-hidden">
                        <div class="bg-cyan-500 h-full transition-all duration-1000" style="width: {{ $percent }}%">
                        </div>
                    </div>
                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">{{ $percent }}%
                        Complete</span>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <div class="flex items-center bg-slate-50 px-3 py-1.5 rounded-xl border border-slate-100">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mr-4">Team</span>
                    <div class="flex -space-x-2">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($project->workspace->owner->name) }}&background=0f172a&color=fff&bold=true"
                            class="w-8 h-8 rounded-lg border-2 border-white shadow-sm"
                            title="Owner: {{ $project->workspace->owner->name }}">
                        @foreach ($project->users as $u)
                            @if ($u->id !== $project->workspace->owner_id)
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($u->name) }}&background=06b6d4&color=fff&bold=true"
                                    class="w-8 h-8 rounded-lg border-2 border-white shadow-sm" title="{{ $u->name }}">
                            @endif
                        @endforeach
                        @if ($isLeader)
                            <button onclick="toggleModal('inviteModal', true)"
                                class="w-8 h-8 rounded-lg border-2 border-dashed border-slate-200 bg-white flex items-center justify-center text-slate-400 hover:text-cyan-600 transition-all ml-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    stroke-width="2.5">
                                    <path d="M12 4v16m8-8H4" />
                                </svg>
                            </button>
                        @endif
                    </div>
                </div>

                @if ($isLeader)
                    <div class="flex items-center gap-2">

                        <a href="{{ route('tasks.create', $project->id) }}"
                            class="btn-primary !px-5 !py-2.5 text-[11px] shadow-cyan-100">New Task</a>
                    </div>
                @endif
                @if (auth()->user()->isSuperAdmin())
                    <a href="{{ route('projects.analytics', $project->id) }}"
                        class="w-10 h-10 bg-slate-50 text-slate-400 rounded-xl flex items-center justify-center hover:text-cyan-600 transition-all"
                        title="Quick Analytics">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"
                                stroke-width="2.5" />
                        </svg>
                    </a>
                @endif
            </div>
        </header>

        <div class="flex-1 overflow-hidden">
            <div class="board-canvas custom-scroll">
                @foreach ($columns as $column)
                    <div class="column-node shrink-0">
                        <div class="p-4 flex justify-between items-center">
                            <div class="flex items-center gap-2">
                                <div class="w-1.5 h-1.5 rounded-full {{ $column['color'] }}"></div>
                                <h4 class="text-[11px] font-bold text-slate-700 uppercase tracking-widest">
                                    {{ $column['name'] }}</h4>
                                <span
                                    class="text-[10px] font-black text-slate-300 ml-1">{{ $project->tasks()->where('status', $column['id'])->whereNull('parent_id')->count() }}</span>
                            </div>
                        </div>

                        <div class="task-container custom-scroll" data-status="{{ $column['id'] }}">
                            @forelse($project->tasks()->where('status', $column['id'])->whereNull('parent_id')->oldest()->get() as $task)
                                @php
                                    $isActuallyAssignedToMe =
                                        $task->assignees->contains(auth()->id()) || $task->assignee_id === auth()->id();
                                @endphp

                                <div class="task-card group" data-id="{{ $task->id }}"
                                    data-draggable="{{ $isActuallyAssignedToMe ? 'true' : 'false' }}">

                                    <div
                                        class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-all z-20">
                                        <button onclick="openQuickView({{ $task->id }})"
                                            class="w-7 h-7 bg-white shadow-md border border-slate-100 rounded-lg flex items-center justify-center text-slate-400 hover:text-cyan-500">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24" stroke-width="2.5">
                                                <path
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </button>
                                    </div>

                                    @if (!$isActuallyAssignedToMe)
                                        <div class="lock-icon" title="Only assigned members can move this"><svg
                                                class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                stroke-width="3">
                                                <path
                                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                            </svg></div>
                                    @endif

                                    <div class="mb-3"><span
                                            class="px-1.5 py-0.5 bg-slate-50 border border-slate-100 text-slate-400 rounded text-[8px] font-bold uppercase tracking-wider">{{ $task->category }}</span>
                                    </div>
                                    <h5
                                        class="text-[13px] font-semibold text-slate-800 leading-snug group-hover:text-cyan-600 transition-colors mb-4 line-clamp-2">
                                        <a href="{{ route('tasks.show', $task->id) }}">{{ $task->title }}</a>
                                    </h5>

                                    <div class="flex items-center justify-between pt-3 border-t border-slate-50">
                                        <div class="flex -space-x-2">
                                            @forelse($task->assignees as $assignee)
                                                <img src="https://ui-avatars.com/api/?name={{ urlencode($assignee->name) }}&background=f1f5f9&color=64748b&bold=true"
                                                    class="w-6 h-6 rounded-md ring-2 ring-white shadow-sm"
                                                    title="{{ $assignee->name }}">
                                            @empty
                                                @if ($task->assignee_id)
                                                    @php $u = \App\Models\User::find($task->assignee_id); @endphp
                                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($u->name) }}&background=f1f5f9&color=64748b&bold=true"
                                                        class="w-6 h-6 rounded-md ring-2 ring-white shadow-sm">
                                                @else
                                                    <span
                                                        class="text-[8px] text-slate-300 font-bold italic uppercase">Unassigned</span>
                                                @endif
                                            @endforelse
                                        </div>
                                        <span
                                            class="text-[9px] font-black text-slate-300 uppercase">{{ $task->created_at->format('d M') }}</span>
                                    </div>
                                </div>
                            @empty
                                <div
                                    class="py-8 border-2 border-dashed border-slate-200 rounded-2xl flex items-center justify-center opacity-20">
                                    <p class="text-[9px] font-bold uppercase text-slate-400">Empty</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div id="quickViewModal" class="hidden fixed inset-0 z-[300] items-center justify-center p-6">
        <div class="absolute inset-0 bg-slate-950/20 backdrop-blur-sm" onclick="closeQuickView()"></div>
        <div class="relative bg-white rounded-[2.5rem] shadow-2xl w-full max-w-lg border border-slate-100 transform transition-all scale-95 opacity-0 overflow-hidden"
            id="quickViewContainer">
            <button onclick="closeQuickView()"
                class="absolute top-6 right-6 z-[50] text-slate-400 hover:text-rose-500 transition-all transform hover:rotate-90">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            <div class="p-8 border-b border-slate-50 bg-white sticky top-0 z-10">
                <h4 id="qv-title" class="text-xl font-bold text-slate-900 leading-tight">Task Notes</h4>
                <p id="qv-target" class="text-[10px] font-black text-cyan-500 uppercase tracking-widest mt-1"></p>
            </div>
            <div class="p-8 py-4 space-y-4 max-h-[300px] overflow-y-auto custom-scroll bg-slate-50/30" id="qv-notes-list">
            </div>
            <div class="p-8 bg-white border-t border-slate-100">
                <div class="flex flex-col gap-3">
                    <div class="relative group">
                        <textarea id="quick-note-content" rows="2"
                            class="w-full bg-slate-50 border border-slate-100 rounded-2xl p-4 pr-12 text-xs font-medium outline-none focus:ring-4 focus:ring-cyan-500/5 focus:bg-white transition-all"
                            placeholder="Write a note..."></textarea>
                        <button onclick="document.getElementById('quick-file-input').click()"
                            class="absolute right-4 top-4 text-slate-400 hover:text-cyan-600 transition-colors"><svg
                                class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.414a4 4 0 00-5.656-5.656l-6.415 6.415a6 6 0 108.486 8.486L20.5 13" />
                            </svg></button>
                        <input type="file" id="quick-file-input" class="hidden" onchange="updateFileStatus()">
                    </div>
                    <div class="flex justify-between items-center px-1">
                        <span id="file-status" class="text-[9px] font-bold text-slate-400 uppercase italic">No file
                            selected</span>
                        <button onclick="saveQuickNote(event)"
                            class="bg-slate-900 text-white px-8 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-cyan-600 transition-all shadow-lg">Send
                            Message</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="inviteModal" class="hidden fixed inset-0 z-[500] items-center justify-center p-6">
        <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm" onclick="toggleModal('inviteModal', false)"></div>
        <div class="relative bg-white rounded-[2rem] shadow-2xl w-full max-w-md p-8 overflow-hidden">
            <h3 class="heading-font text-xl font-800 text-slate-900 mb-6 text-center italic">Invite Collaborator</h3>
            <form action="{{ route('projects.invite', $project->id) }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="text-[10px] font-black text-slate-400 uppercase ml-1">Email Address</label>
                    <input type="email" name="email" required
                        class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 text-sm outline-none focus:border-cyan-500"
                        placeholder="colleague@example.com">
                </div>
                <div>
                    <label class="text-[10px] font-black text-slate-400 uppercase ml-1">Assign to Group / Dept</label>
                    <select name="job_title" required
                        class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 text-sm outline-none focus:border-cyan-500">
                        <option value="" disabled selected>Select a group...</option>

                        @foreach ($project->workspace->taskCategories->unique('name') as $group)
                            <option value="{{ $group->name }}">{{ $group->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit"
                    class="w-full bg-cyan-500 text-white font-bold py-4 rounded-xl shadow-lg hover:bg-cyan-600 transition-all">Send
                    Invitation</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script>
        let currentTaskId = null;

        document.querySelectorAll('.task-container').forEach(el => {
            new Sortable(el, {
                group: 'tasks',
                animation: 150,
                draggable: ".task-card[data-draggable='true']",
                ghostClass: 'opacity-50',
                onEnd: function(evt) {
                    const taskId = evt.item.getAttribute('data-id');
                    const newStatus = evt.to.getAttribute('data-status');
                    fetch(`/tasks/update-status`, {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": "{{ csrf_token() }}"
                            },
                            body: JSON.stringify({
                                id: taskId,
                                status: newStatus
                            })
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (!data.success) {
                                alert(data.error);
                                location.reload();
                            }
                        });
                }
            });
        });

        function toggleModal(modalId, show) {
            const modal = document.getElementById(modalId);
            if (show) modal.classList.replace('hidden', 'flex');
            else modal.classList.replace('flex', 'hidden');
        }

        function openQuickView(taskId) {
            currentTaskId = taskId;
            const notesList = document.getElementById('qv-notes-list');
            notesList.innerHTML =
                '<p class="text-center py-10 text-[10px] font-bold text-slate-400 animate-pulse">Syncing...</p>';
            fetch(`/tasks/${taskId}/quick-view`)
                .then(res => res.json())
                .then(data => {
                    document.getElementById('qv-title').innerText = data.title;
                    let filesHtml = '';
                    if (data.attachments && data.attachments.length > 0) {
                        filesHtml = '<div class="flex gap-2 mb-6 overflow-x-auto pb-2 custom-scroll">';
                        data.attachments.forEach(file => {
                            filesHtml +=
                                `<a href="${file.url}" target="_blank" class="shrink-0 w-20 h-20 bg-slate-50 rounded-xl border border-slate-100 flex flex-col items-center justify-center p-2 hover:border-cyan-500 group"><div class="text-[10px] font-black text-cyan-600 mb-1">${file.type.toUpperCase()}</div><span class="text-[8px] font-bold text-slate-400 truncate w-full text-center px-1">${file.name}</span></a>`;
                        });
                        filesHtml += '</div>';
                    }
                    let notesHtml = '';
                    data.notes.forEach(n => {
                        const bgClass = n.is_mine ? 'bg-cyan-50 border-cyan-100 ml-8' :
                            'bg-white border-slate-100 mr-8';
                        const deleteBtn = n.can_delete ?
                            `<button onclick="deleteNote(${n.id})" class="text-slate-300 hover:text-rose-500 transition-colors"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-width="2.5"/></svg></button>` :
                            '';
                        notesHtml +=
                            `<div class="p-4 rounded-2xl border shadow-sm ${bgClass} relative group/note"><div class="flex justify-between items-start mb-1"><p class="text-[13px] text-slate-700 leading-relaxed">${n.content}</p>${deleteBtn}</div><div class="flex justify-between items-center mt-2 border-t border-black/5 pt-2"><span class="text-[9px] font-black uppercase text-cyan-600">${n.is_mine ? 'You' : n.user_name}</span><span class="text-[9px] text-slate-300 font-bold uppercase">${n.time}</span></div></div>`;
                    });
                    notesList.innerHTML = filesHtml + (notesHtml ||
                        '<p class="text-center text-xs text-slate-300 italic uppercase">No logs yet</p>');
                    const modal = document.getElementById('quickViewModal');
                    modal.classList.replace('hidden', 'flex');
                    setTimeout(() => {
                        document.getElementById('quickViewContainer').classList.replace('scale-95',
                            'scale-100');
                        document.getElementById('quickViewContainer').classList.replace('opacity-0',
                            'opacity-100');
                    }, 10);
                });
        }

        function closeQuickView() {
            const container = document.getElementById('quickViewContainer');
            container.classList.replace('scale-100', 'scale-95');
            container.classList.replace('opacity-100', 'opacity-0');
            setTimeout(() => {
                document.getElementById('quickViewModal').classList.replace('flex', 'hidden');
            }, 200);
        }

        function saveQuickNote(event) {
            const input = document.getElementById('quick-note-content');
            const fileInput = document.getElementById('quick-file-input');
            const btn = event.target;
            if (!input.value.trim() && !fileInput.files[0]) return;
            btn.disabled = true;
            btn.innerText = 'Sending...';
            let formData = new FormData();
            formData.append('content', input.value);
            if (fileInput.files[0]) formData.append('file', fileInput.files[0]);
            fetch(`/tasks/${currentTaskId}/notes`, {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Accept": "application/json"
                    },
                    body: formData
                })
                .then(res => res.json()).then(data => {
                    if (data.success) {
                        input.value = '';
                        fileInput.value = '';
                        document.getElementById('file-status').innerText = 'No file selected';
                        openQuickView(currentTaskId);
                    }
                })
                .finally(() => {
                    btn.disabled = false;
                    btn.innerText = 'Send Message';
                });
        }

        function updateFileStatus() {
            const fileInput = document.getElementById('quick-file-input');
            const status = document.getElementById('file-status');
            if (fileInput.files.length > 0) {
                status.innerText = 'File: ' + fileInput.files[0].name;
                status.classList.replace('text-slate-400', 'text-cyan-600');
            }
        }
        // دالة حذف الملاحظة
function deleteNote(noteId) {
    if (!confirm('Are you sure you want to delete this message?')) return;

    fetch(`/notes/${noteId}`, {
        method: "DELETE",
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
            "Accept": "application/json"
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            // تحديث القائمة فوراً لإخفاء الملاحظة المحذوفة
            openQuickView(currentTaskId);
        } else {
            alert(data.error || "You don't have permission to delete this.");
        }
    })
    .catch(err => {
        console.error('Delete error:', err);
        alert("Connection error.");
    });
}
    </script>
@endsection
