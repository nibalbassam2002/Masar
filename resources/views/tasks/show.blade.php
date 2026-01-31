@extends('layouts.master')

@section('content')
    <div class="max-w-[1400px] mx-auto px-8 py-6">

        <div class="mb-6">
            <a href="{{ route('tasks.index') }}" class="group flex items-center gap-3 text-slate-400 hover:text-cyan-600 transition-all">
                <div class="w-9 h-9 bg-white border border-slate-100 rounded-xl flex items-center justify-center shadow-sm group-hover:border-cyan-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M15 19l-7-7 7-7" /></svg>
                </div>
                <span class="text-[10px] font-black uppercase tracking-widest">Back to Missions Control</span>
            </a>
        </div>

        @php
            $user = auth()->user();
            $mySubTasks = $task->subtasks()->whereHas('assignees', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })->get();
        @endphp

        <header class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 pb-6 border-b border-slate-100 gap-4">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <span class="px-2 py-0.5 bg-cyan-50 text-cyan-600 rounded text-[9px] font-black uppercase tracking-widest border border-cyan-100">{{ $task->category }}</span>
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $task->project->name }}</span>
                </div>
                <h1 class="heading-font text-3xl font-800 text-slate-900 tracking-tight">{{ $task->title }}</h1>
            </div>

            <div class="flex items-center gap-3">
                <div class="px-4 py-2 bg-white border border-slate-200 rounded-xl flex items-center gap-3 shadow-sm">
                    <div class="w-2 h-2 rounded-full {{ $task->status == 'done' ? 'bg-emerald-500' : 'bg-cyan-500 animate-pulse' }}"></div>
                    <span class="text-[10px] font-black uppercase tracking-widest text-slate-600">{{ str_replace('_', ' ', $task->status) }}</span>
                </div>
                @if ($isWorkspaceOwner)
                    <a href="{{ route('tasks.edit', $task->id) }}" class="btn-primary !py-2.5 text-[11px]">Edit Mission</a>
                @endif
            </div>
        </header>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            
            <div class="lg:col-span-8 space-y-12">
                <div class="space-y-4">
                    <h3 class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 ml-1">Context</h3>
                    <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm text-sm text-slate-600 leading-relaxed">
                        {!! nl2br(e($task->description ?? 'No detailed description provided.')) !!}
                    </div>
                </div>

                <section class="space-y-6">
                    <h3 class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 ml-1">Team Collaboration</h3>
                    <div class="max-h-[400px] overflow-y-auto pr-4 space-y-4 custom-scroll" id="notes-container">
                        @forelse($task->notes as $note)
                            <div class="flex gap-4 p-5 {{ $note->user_id === auth()->id() ? 'bg-cyan-50/30 border-cyan-100' : 'bg-white border-slate-100' }} border rounded-3xl shadow-sm">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($note->user->name) }}&background=f1f5f9&color=64748b&bold=true" class="w-8 h-8 rounded-lg shrink-0">
                                <div class="flex-1">
                                    <div class="flex justify-between items-center mb-1">
                                        <p class="text-[11px] font-black text-slate-700 uppercase">{{ $note->user->name }}</p>
                                        <span class="text-[9px] font-bold text-slate-300 uppercase">{{ $note->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="text-sm text-slate-600 leading-relaxed">{{ $note->content }}</p>
                                </div>
                            </div>
                        @empty
                            <p class="text-center py-10 text-xs text-slate-300 italic uppercase">No logs yet.</p>
                        @endforelse
                    </div>

                    <form action="{{ route('tasks.notes.store', $task->id) }}" method="POST" class="bg-slate-50 p-6 rounded-[2rem] border border-slate-100 shadow-sm">
                        @csrf
                        <textarea name="content" rows="3" required class="w-full bg-white border-none rounded-2xl p-4 text-xs font-medium outline-none focus:ring-4 focus:ring-cyan-500/5 transition-all mb-4" placeholder="Post a progress log..."></textarea>
                        <div class="flex justify-end">
                            <button type="submit" class="bg-slate-900 text-white px-10 py-3.5 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-cyan-600 transition-all shadow-lg">Post Log</button>
                        </div>
                    </form>
                </section>
            </div>

            <aside class="lg:col-span-4 space-y-6">

                <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm space-y-6">
                    <div class="flex items-center justify-between">
                        <h4 class="text-[10px] font-black uppercase tracking-widest text-slate-400">Lead Console</h4>
                        <span class="text-[10px] font-bold text-cyan-600 bg-cyan-50 px-2 py-0.5 rounded">{{ $task->subtasks->count() }} Steps</span>
                    </div>

                    <form action="{{ route('tasks.subtasks.store', $task->id) }}" method="POST" class="space-y-3 pb-6 border-b border-slate-50">
                        @csrf
                        <input type="text" name="title" required placeholder="Delegate a new step..." class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-xs font-medium outline-none focus:ring-1 focus:ring-cyan-500 transition-all">
                        <div class="flex gap-2">
                            <select name="assignee_id" required class="flex-1 bg-slate-50 border-none rounded-xl px-3 py-3 text-[10px] font-black uppercase text-slate-500 outline-none">
                                <option value="" disabled selected>Assign Member...</option>
                                @foreach ($teamMembers as $member)
                                    <option value="{{ $member->id }}">{{ $member->name }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="bg-cyan-500 text-white p-3 rounded-xl hover:bg-cyan-600 shadow-lg shadow-cyan-100 transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M12 4v16m8-8H4" /></svg>
                            </button>
                        </div>
                    </form>

                    <div class="space-y-3 pt-4">
                        @foreach ($task->subtasks as $sub)
                            <div class="group flex items-center justify-between p-4 bg-slate-50 rounded-2xl border border-transparent hover:border-cyan-100 transition-all shadow-sm">
                                <div class="flex items-center gap-3">
                                    <div class="w-3.5 h-3.5 rounded-full border-2 {{ $sub->status == 'done' ? 'bg-emerald-500 border-emerald-500' : 'bg-white border-slate-300' }}"></div>
                                    <div class="flex flex-col">
                                        <span class="text-xs font-bold text-slate-700 leading-tight">{{ $sub->title }}</span>
                                        <span class="text-[9px] font-black text-slate-400 uppercase mt-0.5">{{ $sub->assignees->first()?->name ?? 'Unassigned' }}</span>
                                    </div>
                                </div>
                                <a href="{{ route('tasks.show', $sub->id) }}" class="w-8 h-8 bg-white rounded-lg flex items-center justify-center text-slate-300 hover:text-cyan-600 shadow-sm border border-slate-100 transition-all" title="Monitor Progress">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>

                @if ($mySubTasks->count() > 0)
                    <div class="bg-slate-900 p-8 rounded-[2.5rem] shadow-xl space-y-6">
                        <h4 class="text-[10px] font-black uppercase tracking-widest text-cyan-400">My Contribution</h4>
                        <div class="space-y-4">
                            @foreach ($mySubTasks as $sub)
                                <div class="flex items-center justify-between p-4 bg-white/5 rounded-2xl border border-white/10 hover:border-cyan-500/30 transition-all group">
                                    <a href="{{ route('tasks.show', $sub->id) }}" class="flex-1 text-xs font-bold text-white leading-snug hover:text-cyan-400">
                                        {{ $sub->title }}
                                        <span class="block text-[8px] text-slate-500 uppercase mt-1 italic">Open Evidence Link</span>
                                    </a>
                                    <button onclick="updateStatus({{ $sub->id }}, '{{ $sub->status == 'done' ? 'todo' : 'done' }}')"
                                        class="p-2 ml-3 rounded-xl {{ $sub->status == 'done' ? 'bg-emerald-500 text-white' : 'bg-white/10 text-slate-400 group-hover:text-white' }} transition-all shrink-0">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M5 13l4 4L19 7"/></svg>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- 3. المرفقات والأدلة (تفعيل زر الرفع) -->
                <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm space-y-6">
                    <form action="{{ route('tasks.notes.store', $task->id) }}" method="POST" enctype="multipart/form-data" id="evidence-upload-form">
                        @csrf
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="text-[10px] font-black uppercase tracking-widest text-slate-400">Evidence</h4>
                            <input type="file" name="file" id="evidence-file-input" class="hidden" onchange="document.getElementById('evidence-upload-form').submit()">
                            <button type="button" onclick="document.getElementById('evidence-file-input').click()" class="text-cyan-600 text-[10px] font-black uppercase tracking-widest hover:underline hover:text-cyan-700 transition-colors">
                                + Upload File
                            </button>
                        </div>
                    </form>
                    <div class="space-y-2">
                        @forelse($task->attachments as $file)
                            <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank" class="flex items-center gap-3 p-3 bg-slate-50 rounded-xl hover:bg-cyan-50">
                                <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center text-[8px] font-black text-cyan-600 border border-slate-100 uppercase">{{ $file->file_type }}</div>
                                <span class="text-[10px] font-bold text-slate-500 truncate flex-1">{{ $file->file_name }}</span>
                            </a>
                        @empty
                            <p class="text-[9px] font-bold text-slate-300 uppercase text-center py-4 italic">No documents shared</p>
                        @endforelse
                    </div>
                </div>
            </aside>
        </div>
    </div>

    <script>
        const container = document.getElementById('notes-container');
        if (container) container.scrollTop = container.scrollHeight;

        function updateStatus(id, status) {
            fetch(`/tasks/update-status`, {
                method: "POST",
                headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": "{{ csrf_token() }}", "X-Requested-With": "XMLHttpRequest" },
                body: JSON.stringify({ id: id, status: status })
            }).then(() => location.reload());
        }
    </script>
@endsection