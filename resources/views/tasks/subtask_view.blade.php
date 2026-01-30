@extends('layouts.master')

@section('content')
<div class="max-w-[1100px] mx-auto px-8 py-10">
    
    <!-- 1. العودة للمهمة الأم -->
    <a href="{{ route('tasks.show', $task->parent_id) }}" class="inline-flex items-center text-[10px] font-black text-cyan-600 uppercase mb-6 hover:underline group">
        <svg class="w-3 h-3 mr-2 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M15 19l-7-7 7-7"/></svg>
        Back to Main Mission: {{ $task->parent?->title }}
    </a>

    <!-- 2. كرت إنجاز العمل (Header) -->
    <div class="bg-slate-900 rounded-[3rem] p-10 shadow-2xl text-white mb-10 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-cyan-500/10 rounded-full -mr-32 -mt-32 blur-3xl"></div>
        <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div>
                <span class="px-3 py-1 bg-cyan-500 text-[10px] font-black uppercase rounded-full tracking-widest">Execution Portal</span>
                <h1 class="text-4xl font-800 tracking-tight mt-4 leading-tight">{{ $task->title }}</h1>
                <p class="text-slate-400 mt-2 font-medium">Assigned to: <span class="text-white">{{ $task->assignees->first()?->name }}</span></p>
            </div>

            @if($isSubTaskOwner)
                <button onclick="updateSubStatus({{ $task->id }}, '{{ $task->status == 'done' ? 'todo' : 'done' }}')" 
                        class="px-10 py-4 rounded-2xl text-xs font-black uppercase tracking-widest transition-all {{ $task->status == 'done' ? 'bg-emerald-500 text-white' : 'bg-white text-slate-900 hover:bg-cyan-500 hover:text-white shadow-xl' }}">
                    {{ $task->status == 'done' ? '✓ Mission Completed' : 'Mark as Delivered' }}
                </button>
            @else
                <div class="px-10 py-4 rounded-2xl border border-white/10 text-[10px] font-black uppercase {{ $task->status == 'done' ? 'text-emerald-400 bg-emerald-500/10' : 'text-amber-400 bg-amber-500/10' }}">
                    Status: {{ $task->status == 'done' ? 'Completed' : 'In Progress' }}
                </div>
            @endif
        </div>
    </div>

    <!-- فورم الإرسال الموحد (يغلف المحتوى بالكامل لضمان إرسال النص والملف معاً) -->
    <form action="{{ route('tasks.notes.store', $task->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
            
            <!-- 3. الجهة اليسرى: الملاحظات والنقاش -->
            <div class="lg:col-span-7 space-y-8">
                <h3 class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-2">Progress Updates</h3>
                <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm p-8">
                    <div class="max-h-[400px] overflow-y-auto pr-4 space-y-6 custom-scroll mb-8" id="subtask-notes">
                        @forelse($task->notes as $note)
                            <div class="flex gap-4">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($note->user->name) }}&background=f1f5f9&color=64748b&bold=true" class="w-8 h-8 rounded-xl shrink-0">
                                <div class="flex-1 bg-slate-50 p-4 rounded-2xl border border-slate-100">
                                    <span class="text-[10px] font-black text-slate-700 uppercase">{{ $note->user->name }}</span>
                                    <p class="text-sm text-slate-600 mt-1">{{ $note->content }}</p>
                                </div>
                            </div>
                        @empty
                            <p class="text-center py-10 text-xs text-slate-300 italic uppercase">No messages yet.</p>
                        @endforelse
                    </div>

                    <!-- منطقة الكتابة (أزلنا الـ Required) -->
                    <textarea name="content" rows="4" class="w-full bg-slate-50 border-none rounded-2xl p-5 text-xs font-medium outline-none focus:ring-4 focus:ring-cyan-500/5 transition-all" placeholder="Tell the lead what you've done..."></textarea>
                    
                    <button type="submit" class="w-full bg-slate-900 text-white py-4 rounded-2xl text-[11px] font-black uppercase tracking-widest hover:bg-cyan-600 transition-all shadow-lg mt-4">
                        Submit Work / Update
                    </button>
                </div>
            </div>

            <!-- 4. الجهة اليمنى: الملفات المرفوعة والمختارة -->
            <div class="lg:col-span-5 space-y-8">
                <h3 class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-2">Evidence & Deliverables</h3>
                
                <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm p-8 space-y-6">
                    <div class="flex items-center justify-between">
                        <span class="text-[10px] font-bold text-slate-300 uppercase italic">Shared Files</span>
                        @if($isSubTaskOwner)
                            <!-- الزر الذي يفتح اختيار الملفات -->
                            <button type="button" onclick="document.getElementById('subtask-file-input').click()" class="text-cyan-600 text-[10px] font-black uppercase hover:underline">+ Upload File</button>
                        @endif
                    </div>

                    <!-- حقل الملف المخفي -->
                    <input type="file" name="file" id="subtask-file-input" class="hidden" onchange="updateFileNameDisplay()">

                    <!-- منطقة عرض الملف المختار (تظهر هنا قبل الرفع) -->
                    <div id="file-preview-zone" class="hidden">
                        <div class="p-4 bg-cyan-50 border border-dashed border-cyan-200 rounded-2xl flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <div class="w-2 h-2 rounded-full bg-cyan-500 animate-pulse"></div>
                                <span id="file-name-display" class="text-[10px] font-bold text-cyan-700 uppercase truncate max-w-[150px]"></span>
                            </div>
                            <button type="button" onclick="clearFileSelection()" class="text-rose-500 hover:text-rose-700">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"/></svg>
                            </button>
                        </div>
                    </div>

                    <!-- قائمة الملفات المرفوعة فعلياً -->
                    <div class="space-y-3 pt-4 border-t border-slate-50">
                        @forelse($task->attachments as $file)
                            <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank" class="flex items-center gap-4 p-4 bg-slate-50 rounded-2xl hover:bg-cyan-50 transition-all border border-transparent hover:border-cyan-100 group">
                                <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-[10px] font-black text-cyan-600 border border-slate-100 uppercase">{{ $file->file_type }}</div>
                                <div class="flex-1 truncate">
                                    <p class="text-[11px] font-bold text-slate-700 truncate">{{ $file->file_name }}</p>
                                    <span class="text-[9px] text-slate-400 uppercase font-medium">Download</span>
                                </div>
                            </a>
                        @empty
                            <div class="py-12 border-2 border-dashed border-slate-50 rounded-[2.5rem] text-center opacity-30">
                                <p class="text-[9px] font-bold uppercase tracking-widest">No evidence shared</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    // إظهار اسم الملف في جهة اليمين فور اختياره
    function updateFileNameDisplay() {
        const input = document.getElementById('subtask-file-input');
        const previewZone = document.getElementById('file-preview-zone');
        const display = document.getElementById('file-name-display');
        if (input.files.length > 0) {
            display.innerText = input.files[0].name;
            previewZone.classList.remove('hidden');
        }
    }

    function clearFileSelection() {
        const input = document.getElementById('subtask-file-input');
        const previewZone = document.getElementById('file-preview-zone');
        input.value = '';
        previewZone.classList.add('hidden');
    }

    function updateSubStatus(id, status) {
        fetch(`/tasks/update-status`, {
            method: "POST",
            headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": "{{ csrf_token() }}", "X-Requested-With": "XMLHttpRequest" },
            body: JSON.stringify({ id: id, status: status })
        }).then(res => res.json()).then(data => {
            if(data.success) location.reload();
            else alert(data.error);
        });
    }

    const notesContainer = document.getElementById('subtask-notes');
    if(notesContainer) notesContainer.scrollTop = notesContainer.scrollHeight;
</script>

<style>
    .custom-scroll::-webkit-scrollbar { width: 4px; }
    .custom-scroll::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
</style>
@endsection