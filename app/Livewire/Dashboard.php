<?php

namespace App\Livewire;

use App\Models\Todo;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Illuminate\Support\Facades\Auth; // تأكد من استيراد Auth
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Attributes\On;

#[Layout('layouts.app')]
#[Title('لوحة التحكم')]
class Dashboard extends Component
{
    public $content = ''; // متغير لتخزين محتوى المهمة
    public $lastPosition = 0;

    //function addTodo
    public function addTodo()
    {
        $this->lastPosition = $this->query()->max('position') ?? 0;

        $this->validate([
            'content' => 'required|string|max:255', // تحقق من صحة المحتوى
        ]);
        $this->query()->create([
            'content' => $this->content,
            'completed' => false, // تعيين المهمة كغير مكتملة
            'position' => $this->lastPosition + 1, // تعيين الموضع الافتراضي
            'priority' => 'medium', // تعيين الأولوية الافتراضية
            'due_date' => null, // تعيين تاريخ الاستحقاق كـ null
        ]); // حفظ المهمة في قاعدة البيانات
        $this->content = ''; // إعادة تعيين محتوى المهمة
        $this->dispatch('toast', message: 'تم إضافة المهمة بنجاح', type: 'success'); // إرسال رسالة نجاح
    }
    #[Computed()]
    public function todos()
    {
        return $this->query()->orderBy('position')->get();
    }
    #[On('updateOrder')]
    public function updateOrder(array $ids)
    {
        foreach ($ids as $index => $id) {
            Todo::where('id', $id)->update(['position' => $index]);
        }
    }

    // function to toggle the completion status of a todo
    public function toggleComplete($id)
    {
        $this->lastPosition = $this->query()->max('position') ?? 0;
        $todo = $this->query()->find($id);
        if ($todo) {
            $todo->completed = !$todo->completed;
            //change the position to the last position
            $todo->position = $this->lastPosition + 1;
            $todo->save();
            $this->dispatch('toast', message: 'تم تحديث حالة المهمة بنجاح', type: 'info');
        }
    }

    public function deleteTodo($id)
    {
        $todo = $this->query()->find($id);

        if ($todo) {
            $todo->delete();
            $this->dispatch('toast', message: 'تم حذف المهمة بنجاح', type: 'warning');
        }
    }

    // query function to get the user
    public function query()
    {
        return Auth::user()->todos();
    }
    public function render()
    {
        return view('livewire.dashboard');
    }
}
