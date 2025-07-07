 <div class="py-12">
     <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
         <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
             <div class="p-6 text-gray-900">
                 <div class="flex items-center justify-between border-b border-purple-300 pb-4 mb-6" dir="rtl">
                     <!-- الجهة اليمنى: العنوان والوصف -->
                     <div class="text-right">
                         <h1 class="text-xl font-bold text-purple-800">
                             <i class="fa-solid fa-list ms-2"></i>
                             مهامي اليومية
                         </h1>
                         <p class="text-gray-600 mt-1">
                             مرحبًا بك في لوحة التحكم الخاصة بك! هنا يمكنك إدارة مهامك اليومية بسهولة ويسر.
                         </p>
                     </div>

                     <!-- الجهة اليسرى: القائمة المنسدلة -->
                     <div class="relative inline-block text-left" x-data="{ open: false }">
                         <button @click="open = !open" type="button"
                             class="inline-flex items-center px-4 py-2 text-sm font-medium text-purple-800 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-purple-500">
                             {{ auth()->user()->name }}
                             <i class="fa-solid fa-user ms-2"></i>
                             <svg class="ms-1 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                 <path fill-rule="evenodd"
                                     d="M5.23 7.21a.75.75 0 011.06.02L10 10.939l3.71-3.71a.75.75 0 111.06 1.06l-4.25 4.25a.75.75 0 01-1.06 0l-4.25-4.25a.75.75 0 01.02-1.06z"
                                     clip-rule="evenodd" />
                             </svg>
                         </button>

                         <div x-show="open" @click.away="open = false"
                             class="absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50 text-right">
                             <div class="py-2 px-4">
                                 <p class="text-sm font-semibold text-purple-800">{{ auth()->user()->name }}</p>
                                 <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
                             </div>
                             <div class="border-t border-gray-200"></div>
                             <form method="POST" action="{{ route('logout') }}">
                                 @csrf
                                 <button type="submit"
                                     class="w-full text-right px-4 py-2 text-sm text-red-600 hover:bg-red-50 hover:text-red-700">
                                     <i class="fa-solid fa-right-from-bracket ms-2"></i>
                                     تسجيل الخروج
                                 </button>
                             </form>
                         </div>
                     </div>
                 </div>
                 <div class="flex flex-col gap-5 max-w-xl mx-auto">
                     <!-- Add todo -->
                     <form wire:submit.prevent="addTodo" class="mb-4">
                         <div class="flex gap-2">
                             <input type="text" wire:model="content"
                                 class="mt-1 block w-full border-gray-300 rounded-md shadow-sm size-8 focus:border-purple-500 focus:ring-purple-500"
                                 placeholder="أدخل مهمة جديدة..." />
                         </div>
                         @error('content')
                             <span class="text-red-600 font-medium text-sm animate-shake flex items-center gap-1">
                                 <i class="fa-solid fa-circle-info"></i>
                                 {{ $message }}
                             </span>
                         @enderror
                     </form>

                     <!-- Todo list -->
                     <!-- قائمة المهام القابلة للترتيب -->
                     <div class="grid gap-3 min-w-[24rem]" x-data x-sort
                         x-on:end="let ids = Array.from($el.querySelectorAll('[x-sort\\:item]')).map(el => el.dataset.id); $wire.updateOrder(ids)">

                         @forelse ($this->todos as $todo)
                             <div class="group flex items-center justify-between bg-white border border-purple-100 shadow-sm rounded-xl px-4 py-2 transition hover:shadow-md cursor-default"
                                 x-sort:item data-id="{{ $todo->id }}">

                                 <!-- مقبض السحب - يظهر عند hover فقط -->
                                 <div class="opacity-0 group-hover:opacity-100 text-gray-400 hover:text-purple-500 cursor-move me-3 transition duration-200"
                                     x-sort:handle title="اسحب لتحريك المهمة">
                                     <i class="fa-solid fa-grip-lines"></i>
                                 </div>

                                 <!-- نص المهمة -->
                                 <div
                                     class="flex-1 text-sm font-medium truncate {{ $todo->completed ? 'line-through text-gray-400' : 'text-purple-700' }}">
                                     {{ $todo->content }}
                                 </div>

                                 <!-- زر لجعل المهمة مكتملة-->
                                 <button wire:click="toggleComplete({{ $todo->id }})"
                                     class="opacity-0 group-hover:opacity-100 text-green-200 hover:text-green-700 transition-all duration-200 p-1 rounded-full"
                                     title="{{ $todo->completed ? 'إلغاء إكمال المهمة' : 'إكمال المهمة' }}">
                                     <i class="{{ $todo->completed ? 'fa-solid fa-circle-check' : 'fa-regular fa-circle' }} text-base"
                                         style="font-size: 1.2rem"></i>
                                 </button>
                                 <!-- زر الحذف - يظهر عند hover فقط -->
                                 <button wire:click="deleteTodo({{ $todo->id }})"
                                     class="opacity-0 group-hover:opacity-100 text-red-200 hover:text-red-700 transition-all duration-200 p-1 rounded-full"
                                     title="حذف المهمة">
                                     <i class="fa-solid fa-circle-minus text-base" style="font-size: 1.2rem"></i>
                                 </button>
                             </div>
                         @empty
                             <div class="text-center text-gray-500 col-span-full">
                                 لا توجد مهام.
                             </div>
                         @endforelse
                     </div>

                 </div>
             </div>
         </div>
     </div>
 </div>
