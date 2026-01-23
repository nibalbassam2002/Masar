@extends('layouts.master')

@section('breadcrumbs')
    <a href="{{ route('projects.index') }}" class="hover:text-primary-500 transition-colors">Projects</a>
    <span class="opacity-30">/</span>
    <span class="text-slate-900 font-semibold">{{ $project->name }}</span>
@endsection

@section('content')
    <div class="h-full flex flex-col overflow-hidden bg-[#fcfcfd]">

        <style>
            /* نظام التمرير والتحكم في الأعمدة */
            .board-canvas {
                display: flex;
                flex-direction: row;
                gap: 1.25rem;
                padding: 1.5rem;
                height: calc(100vh - 160px);
                overflow-x: auto;
                align-items: stretch;
            }

            .column-node {
                width: 300px;
                min-width: 300px;
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
            }

            /* كرت المهمة: يدعم منطق الصلاحيات بصرياً */
            .task-card {
                background: white;
                border-radius: 12px;
                border: 1px solid #e2e8f0;
                padding: 1rem;
                margin-bottom: 0.75rem;
                transition: all 0.2s ease;
                position: relative;
            }

            .task-card[data-draggable="true"]:hover {
                border-color: #06b6d4;
                transform: translateY(-2px);
                shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            }

            .task-card[data-draggable="false"] {
                opacity: 0.6;
                cursor: not-allowed;
                background-color: #fafafa;
            }

            .sortable-ghost {
                opacity: 0.1;
                background: #cbd5e1;
                border: 2px dashed #06b6d4;
            }
        </style>

        <!-- 1. Global Project Header -->
        <header class="bg-white px-8 py-4 border-b border-slate-100 flex items-center justify-between shrink-0">
            <div class="flex flex-col gap-2">
                <div class="flex items-center gap-4">
                    <h1 class="heading-font text-2xl font-800 text-slate-900 tracking-tight capitalize">{{ $project->name }}
                    </h1>
                    <!-- Progress Indicator: شريط الإنجاز الذكي -->
                    <div class="flex items-center gap-3 bg-slate-50 border border-slate-100 px-3 py-1 rounded-full">
                        <span class="text-[10px] font-black text-primary-600">{{ $project->progress }}%</span>
                        <div class="w-16 h-1 bg-slate-200 rounded-full overflow-hidden">
                            <div class="bg-primary-500 h-full transition-all duration-1000"
                                style="width: {{ $project->progress }}%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <!-- Project Team Hub -->
                <div class="flex items-center bg-white p-1.5 pl-4 rounded-2xl border border-slate-100 shadow-sm">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mr-4">Team</span>
                    <div class="flex -space-x-2 mr-2">
                        @forelse($project->users as $user)
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=06b6d4&color=fff&bold=true"
                                class="w-8 h-8 rounded-lg border-2 border-white shadow-sm" title="{{ $user->name }}">
                        @empty
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=cbd5e1&color=fff&bold=true"
                                class="w-8 h-8 rounded-lg border-2 border-white shadow-sm" title="Project Owner">
                        @endforelse
                        <button onclick="toggleModal('inviteModal', true)"
                            class="w-8 h-8 rounded-lg border-2 border-dashed border-slate-200 bg-white flex items-center justify-center text-slate-400 hover:text-primary-500 hover:border-primary-500 transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                stroke-width="2.5">
                                <path d="M12 4v16m8-8H4" />
                            </svg>
                        </button>
                    </div>
                </div>

                <a href="{{ route('tasks.create', $project->id) }}" class="btn-primary">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        stroke-width="3">
                        <path d="M12 4v16m8-8H4" />
                    </svg>
                    New Task
                </a>
            </div>
        </header>

        <!-- 2. Kanban Engine -->
        <div class="board-canvas custom-scroll">
            @foreach ($columns as $column)
                <div class="column-node shrink-0">
                    <!-- Column Meta -->
                    <div class="p-4 flex justify-between items-center shrink-0">
                        <div class="flex items-center gap-2.5">
                            <div class="w-1.5 h-1.5 rounded-full {{ $column['color'] }}"></div>
                            <h4 class="text-[11px] font-bold text-slate-700 uppercase tracking-widest">
                                {{ $column['name'] }}</h4>
                            <span class="task-count text-[10px] font-black text-slate-300 ml-1">
                                {{ $project->tasks()->where('status', $column['id'])->count() }}
                            </span>
                        </div>
                        <button class="text-slate-300 hover:text-primary-500 transition-colors"><svg class="w-3.5 h-3.5"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                                <path d="M12 4v16m8-8H4" />
                            </svg></button>
                    </div>

                    <!-- Dynamic Task List Area -->
                    <div class="task-container custom-scroll" data-status="{{ $column['id'] }}">
                        @forelse($project->tasks()->where('status', $column['id'])->oldest()->get() as $task)
                            <div class="task-card group" data-id="{{ $task->id }}"
                                data-draggable="{{ $task->assignee_id === auth()->id() ? 'true' : 'false' }}">

                                <!-- Security Lock Indicator for Non-Owners -->
                                @if ($task->assignee_id !== auth()->id())
                                    <div class="absolute top-2 right-2 text-slate-300">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                            stroke-width="2.5">
                                            <path
                                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                        </svg>
                                    </div>
                                @endif

                                <div class="flex justify-between items-start mb-3">
                                    <span
                                        class="px-1.5 py-0.5 bg-slate-50 text-slate-400 rounded text-[8px] font-bold uppercase tracking-wider border border-slate-100">{{ $task->category }}</span>
                                    <div
                                        class="w-1 h-1 rounded-full {{ $task->priority == 'urgent' ? 'bg-red-500' : 'bg-slate-300' }}">
                                    </div>
                                </div>

                                <h5
                                    class="text-[13px] font-semibold text-slate-800 leading-snug group-hover:text-primary-500 transition-colors mb-4 line-clamp-2">
                                    {{ $task->title }}
                                </h5>

                                <div class="flex items-center justify-between pt-3 border-t border-slate-50">
                                    <div class="flex items-center gap-1.5">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($task->assignee->name) }}&background=f1f5f9&color=64748b&bold=true"
                                            class="w-5 h-5 rounded-md">
                                        <span
                                            class="text-[9px] font-bold text-slate-400">{{ explode(' ', $task->assignee->name)[0] }}</span>
                                    </div>
                                    <span
                                        class="text-[9px] font-black text-slate-300 uppercase">{{ $task->created_at->format('d M') }}</span>
                                </div>
                            </div>
                        @empty
                            <div
                                class="py-10 border-2 border-dashed border-slate-200 rounded-2xl flex flex-col items-center justify-center opacity-20">
                                <p class="text-[9px] font-bold uppercase tracking-widest text-slate-400 italic">Empty List
                                </p>
                            </div>
                        @endforelse
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Modal: Invite Team Member -->
    <div id="inviteModal" class="hidden fixed inset-0 z-[250] items-center justify-center p-6">
        <div class="absolute inset-0 bg-slate-950/40 backdrop-blur-sm transition-opacity"
            onclick="toggleModal('inviteModal', false)"></div>
        <div
            class="relative bg-white rounded-[2rem] shadow-2xl w-full max-w-sm p-10 border border-slate-100 transform transition-all scale-95 opacity-0 duration-300">
            <div class="text-center mb-8">
                <h3 class="heading-font text-xl font-bold text-slate-900">Add Contributor</h3>
                <p class="text-xs text-slate-400 mt-1 uppercase tracking-widest">Team Expansion</p>
            </div>
            <form action="{{ route('projects.invite', $project->id) }}" method="POST" class="space-y-4">
                @csrf
                <input type="email" name="email" required placeholder="Enter colleague's email" class="input-field">
                <button type="submit" class="w-full btn-primary !py-4 justify-center">Send Invitation</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script>
        document.querySelectorAll('.task-container').forEach(column => {
            new Sortable(column, {
                group: 'tasks',
                animation: 200,
                ghostClass: 'sortable-ghost',
                // منع سحب المهام التي لا تخص المستخدم
                filter: '[data-draggable="false"]',

                onEnd: function(evt) {
                    // منع التحديث إذا لم يكن هناك تغيير في العمود أو إذا كان المستخدم غير مخول
                    if (evt.from === evt.to) return;

                    let isDraggable = evt.item.getAttribute('data-draggable');
                    if (isDraggable === 'false') return;

                    // تحديث العدادات الرقمية لحظياً
                    let fromCount = evt.from.closest('.column-node').querySelector('.task-count');
                    fromCount.innerText = Math.max(0, parseInt(fromCount.innerText) - 1);
                    let toCount = evt.to.closest('.column-node').querySelector('.task-count');
                    toCount.innerText = parseInt(toCount.innerText) + 1;

                    // إرسال البيانات للخادم
                    fetch("{{ route('tasks.updateStatus') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            id: evt.item.getAttribute('data-id'),
                            status: evt.to.getAttribute('data-status')
                        })
                    }).then(res => res.json()).then(data => {
                        if (data.success) {
                            // تحديث شريط التقدم في الصفحة بدون ريفريش (اختياري)
                            window.location.reload();
                        }
                    });
                }
            });
        });
    </script>
@endsection
