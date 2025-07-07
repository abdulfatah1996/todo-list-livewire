<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {
    public string $email = '';
    public string $password = '';
    public bool $remember = false;

    public array $rules = [
        'email' => 'required|email',
        'password' => 'required|min:8',
        'remember' => 'boolean',
    ];

    public array $messages = [
        'email.required' => 'البريد الإلكتروني مطلوب.',
        'email.email' => 'يرجى إدخال بريد إلكتروني صالح.',
        'password.required' => 'كلمة المرور مطلوبة.',
        'password.min' => 'كلمة المرور يجب أن تكون 8 أحرف على الأقل.',
    ];

    public function login()
    {
        $this->validate();

        if (!Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            $this->addError('email', 'بيانات تسجيل الدخول غير صحيحة.');
            return;
        }

        Session::regenerate();

        return redirect()->route('dashboard')->with('success', 'تم تسجيل الدخول بنجاح!');
    }
}; ?>

<div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-lg border border-purple-800">
    <!-- العنوان -->
    <div class="text-purple-800 text-center mb-6">
        <h2 class="text-2xl font-bold mb-0">
            <i class="fa-solid fa-lock me-1"></i>
            تسجيل الدخول إلى مهامي
        </h2>
        <p class="text-purple-500">
            أدخل بياناتك للبدء في إدارة مهامك بسهولة ويسر.
        </p>
    </div>

    <!-- نموذج تسجيل الدخول -->
    <form wire:submit.prevent="login" class="space-y-6">

        <!-- البريد الإلكتروني -->
        <div class="form-group">
            <label for="email" class="block text-sm font-medium text-purple-700 mb-1">
                البريد الإلكتروني
            </label>
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

        <!-- كلمة المرور -->
        <div class="form-group">
            <label for="password" class="block text-sm font-medium text-purple-700 mb-1">
                كلمة المرور
            </label>
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

        <!-- تذكرني -->
        <div class="form-group flex items-center">
            <input type="checkbox" id="remember" wire:model.live="remember"
                class="h-4 w-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500 me-1">
            <label for="remember" class="ml-2 text-sm text-purple-700">
                تذكرني
            </label>
        </div>
        <!-- زر تسجيل الدخول -->
        <div class="text-center">
            <button type="submit"
                class="w-full px-4 py-2 bg-purple-800 hover:bg-purple-900 text-white font-semibold rounded-md transition-colors duration-200">
                تسجيل الدخول
            </button>
        </div>
        <!-- رابط التسجيل للمستخدمين الجدد -->
        <div class="text-center text-sm text-purple-600">
            <p>
                ليس لديك حساب؟
                <a href="{{ route('register') }}" class="text-purple-800 hover:underline">
                    إنشاء حساب جديد
                </a>
            </p>
        </div>
    </form>
</div>
