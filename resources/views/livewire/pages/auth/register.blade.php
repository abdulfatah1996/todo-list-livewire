<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    public bool $showTerms = false;

    public function showModalTerms(): void
    {
        $this->showTerms = true;
    }

    public function close(): void
    {
        $this->showTerms = false;
    }

    // Validation rules for the registration form
    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
            'terms' => ['accepted'],
        ];
    }

    // Validation messages for the registration form
    protected function messages(): array
    {
        return [
            'name.required' => 'الاسم مطلوب.',
            'email.required' => 'البريد الإلكتروني مطلوب.',
            'email.email' => 'البريد الإلكتروني يجب أن يكون عنوان بريد إلكتروني صالح.',
            'email.unique' => 'هذا البريد الإلكتروني مسجل بالفعل.',
            'password.required' => 'كلمة المرور مطلوبة.',
            'password.confirmed' => 'كلمة المرور وتأكيد كلمة المرور لا يتطابقان.',
            'terms.accepted' => 'يجب الموافقة على الشروط والأحكام.',
        ];
    }

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered(($user = User::create($validated))));

        Auth::login($user);
        redirect()->route('dashboard')->with('success', 'تم إنشاء حسابك بنجاح!');
    }
}; ?>

<div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-lg border border-purple-800 border-1">
    <!-- العنوان مع رسالة ترحيب -->
    <div class="text-purple-800">
        <h2 class="text-2xl font-bold mb-0 text-center">
            <i class="fa-solid fa-check-double me-1"></i>
            مرحبًا بك في مهامي!
        </h2>
        <p class="text-purple-500 text-center mb-6">
            قم بإنشاء حساب جديد للبدء في إدارة مهامك اليومية بسهولة ويسر.
        </p>
    </div>

    <!-- نموذج التسجيل -->
    <form wire:submit="register" class="space-y-6">
        <!-- حقل الاسم -->
        <div class="form-group">
            <!-- عنوان الحقل -->
            <label for="name" class="block text-sm font-medium text-purple-700 mb-1">
                الاسم الكامل
            </label>
            <!-- حقل الإدخال -->
            <input type="text" id="name" wire:model.live="name"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm size-8 focus:border-purple-500 focus:ring-purple-500"
                placeholder="أدخل اسمك">
            @error('name')
                <span class="text-red-600 font-medium text-sm animate-shake flex items-center gap-1">
                    <i class="fa-solid fa-circle-info"></i>
                    {{ $message }}
                </span>
            @enderror
        </div>
        <!-- حقل البريد الإلكتروني -->
        <div class="form-group">
            <!-- عنوان الحقل -->
            <label for="email" class="block text-sm font-medium text-purple-700 mb-1">
                البريد الإلكتروني
            </label>
            <!-- حقل الإدخال -->
            <input type="email" id="email" wire:model.live="email"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm size-8 focus:border-purple-500 focus:ring-purple-500"
                placeholder="أدخل بريدك الإلكتروني">
            @error('email')
                <span class="text-red-600 font-medium text-sm animate-shake flex items-center gap-1">
                    <i class="fa-solid fa-circle-info"></i>
                    {{ $message }}
                </span>
            @enderror
        </div>
        <!-- حقل كلمة المرور -->
        <div class="form-group">
            <!-- عنوان الحقل -->
            <label for="password" class="block text-sm font-medium text-purple-700 mb-1">
                كلمة المرور
            </label>
            <!-- حقل الإدخال -->
            <input type="password" id="password" wire:model.live="password"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm size-8 focus:border-purple-500 focus:ring-purple-500"
                placeholder="أدخل كلمة المرور">
            @error('password')
                <span class="text-red-600 font-medium text-sm animate-shake flex items-center gap-1">
                    <i class="fa-solid fa-circle-info"></i>
                    {{ $message }}
                </span>
            @enderror
        </div>
        <!-- حقل تأكيد كلمة المرور -->
        <div class="form-group">
            <!-- عنوان الحقل -->
            <label for="password_confirmation" class="block text-sm font-medium text-purple-700 mb-1">
                تأكيد كلمة المرور
            </label>
            <!-- حقل الإدخال -->
            <input type="password" id="password_confirmation" wire:model.live="password_confirmation"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm size-8 focus:border-purple-500 focus:ring-purple-500"
                placeholder="أعد إدخال كلمة المرور">
            @error('password_confirmation')
                <span class="text-red-600 font-medium text-sm animate-shake flex items-center gap-1">
                    <i class="fa-solid fa-circle-info"></i>
                    {{ $message }}
                </span>
            @enderror
        </div>

        <!-- رسالة الموافقة على الشروط مع مودل فيه الشروط-->
        <div class="form-group">
            <div class="flex items-center">
                <input type="checkbox" id="terms" wire:model.live="terms"
                    class="h-4 w-4 me-1 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                <label for="terms" class="ml-2 text-sm text-purple-700">
                    أوافق على
                    <button type="button" wire:click="showModalTerms"
                        class="text-purple-600 hover:text-purple-800 focus:outline-none focus:ring-2 focus:ring-purple-500">
                        الشروط والأحكام
                    </button>
                </label>
            </div>
            <!-- رسالة الخطأ في حالة عدم الموافقة -->
            @error('terms')
                <span class="text-red-600 font-medium text-sm animate-shake flex items-center gap-1">
                    <i class="fa-solid fa-circle-info"></i>
                    {{ $message }}
                </span>
            @enderror
            <!-- مودل الشروط والأحكام -->
            <!-- استدعاء كمبوننت المودال -->
            <x-modals.terms :show="$showTerms" />

        </div>
        <!-- زر التسجيل -->
        <div class="form-group">
            <button type="submit" wire:loading.attr="disabled" wire:target="register"
                class="w-full bg-purple-600 text-white font-semibold py-2 px-4 rounded-md shadow hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition duration-200 flex items-center justify-center gap-2">

                {{-- Spinner أثناء التحميل --}}
                <svg wire:loading wire:target="register" class="animate-spin w-4 h-4 text-white" fill="none"
                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                        stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                </svg>

                {{-- النص الرئيسي مع إخفائه أثناء التحميل --}}
                <span wire:loading.remove wire:target="register">
                    <i class="fa-solid fa-user-plus me-1"></i> إنشاء حساب
                </span>
            </button>
        </div>
        <!-- رابط تسجيل الدخول للمستخدمين الجدد -->
        <div class="text-center text-sm text-purple-600">
            <p>
                لديك حساب بالفعل؟
                <a href="{{ route('login') }}" class="text-purple-800 hover:underline">
                    تسجيل الدخول
                </a>
            </p>
        </div>
    </form>
</div>
