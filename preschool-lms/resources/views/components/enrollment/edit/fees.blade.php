<div class="space-y-4">
    <h3 class="text-lg font-semibold text-blue-800 dark:text-white">Tuition & Fees</h3>
    <div class="grid grid-cols-1 gap-4">

        <input type="number" name="tuition_fee" placeholder="Tuition Fee"
            class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500 @error('tuition_fee') border-red-500 @enderror"
            value="{{ old('tuition_fee', $fee->tuition_fee ?? '') }}" required>
        @error('tuition_fee')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror

        <input type="number" name="lab_fee" placeholder="Lab Fee"
            class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500 @error('lab_fee') border-red-500 @enderror"
            value="{{ old('lab_fee', $fee->lab_fee ?? '') }}">
        @error('lab_fee')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror

        <input type="number" name="miscellaneous_fee" placeholder="Miscellaneous Fee"
            class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500 @error('miscellaneous_fee') border-red-500 @enderror"
            value="{{ old('miscellaneous_fee', $fee->miscellaneous_fee ?? '') }}">
        @error('miscellaneous_fee')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror

        <input type="number" name="other_fee" placeholder="Other Fee"
            class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500 @error('other_fee') border-red-500 @enderror"
            value="{{ old('other_fee', $fee->other_fee ?? '') }}">
        @error('other_fee')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror

        <input type="number" name="discount" placeholder="Discount"
            class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500 @error('discount') border-red-500 @enderror"
            value="{{ old('discount', $fee->discount ?? '') }}">
        @error('discount')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror

        <input type="number" name="initial_payment" placeholder="Initial Payment"
            class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500 @error('initial_payment') border-red-500 @enderror"
            value="{{ old('initial_payment', $fee->initial_payment ?? '') }}">
        @error('initial_payment')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror

    </div>
</div>
