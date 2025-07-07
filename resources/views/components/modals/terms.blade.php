@props(['show' => false])

{{-- استدعاء الكمبوننت --}}
@if ($show)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white w-full max-w-md p-6 rounded shadow-lg border border-gray-300 relative">

            <!-- زر الإغلاق -->
            <button wire:click="$set('showTerms', false)"
                class="absolute top-2 left-2 text-gray-500 hover:text-red-600 text-xl">
                &times;
            </button>

            <!-- العنوان -->
            <h2 class="text-lg font-bold mb-4 text-[#581845]">الشروط والأحكام</h2>

            <!-- المحتوى -->
            <div class="text-sm text-gray-700 space-y-2 max-h-[50vh] overflow-y-auto leading-relaxed">
                <p>باستخدامك لهذا التطبيق، فإنك توافق على الالتزام بالشروط والأحكام التالية. يرجى قراءتها بعناية قبل
                    المتابعة.</p>

                <p><strong>1. الخصوصية:</strong> نحن نحترم خصوصيتك ونتعهد بعدم مشاركة بياناتك الشخصية مع أي طرف ثالث دون
                    موافقتك المسبقة، إلا في حال طلب قانوني.</p>

                <p><strong>2. الأمان:</strong> أنت مسؤول عن الحفاظ على سرية بيانات الدخول إلى حسابك. في حال الشك بأي
                    نشاط غير معتاد، نرجو منك تغيير كلمة المرور فورًا.</p>

                <p><strong>3. الاستخدام المقبول:</strong> يُمنع استخدام التطبيق لأي أنشطة غير قانونية أو ضارة أو مسيئة،
                    ويحق لنا إيقاف الحسابات المخالفة دون إشعار مسبق.</p>

                <p><strong>4. التعديلات:</strong> نحتفظ بحق تعديل هذه الشروط في أي وقت. سيتم إشعار المستخدمين بأي
                    تغييرات جوهرية عبر البريد الإلكتروني أو داخل التطبيق.</p>

                <p><strong>5. الدعم الفني:</strong> نحن نوفر دعمًا فنيًا محدودًا لحل المشكلات التقنية خلال أيام العمل
                    الرسمية.</p>

                <p>باستمرارك في استخدام التطبيق، فإنك تقر بقراءة هذه الشروط وفهمها والموافقة عليها بالكامل.</p>
            </div>


            <!-- زر الموافقة -->
            <div class="mt-4 text-end">
                <button wire:click="$set('showTerms', false)"
                    class="px-4 py-1.5 bg-[#581845] hover:bg-[#6e1d57] text-white text-sm rounded">
                    موافق
                </button>
            </div>

        </div>
    </div>
@endif
