<!-- resources/views/components/enrollment/fees.blade.php -->
<div class="space-y-4">
    <h3 class="text-lg font-semibold text-blue-800 dark:text-white">Tuition & Fees</h3>
    <div class="grid grid-cols-1 gap-4">
        <input type="number" name="tuition_fee" placeholder="Tuition Fee"
            class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500"
            value="{{ $oldData['tuition_fee'] ?? '' }}" required>
        <input type="number" name="lab_fee" placeholder="Lab Fee"
            class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500"
            value="{{ $oldData['lab_fee'] ?? '' }}">
        <input type="number" name="miscellaneous_fee" placeholder="Miscellaneous Fee"
            class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500"
            value="{{ $oldData['miscellaneous_fee'] ?? '' }}">
        <input type="number" name="other_fee" placeholder="Other Fee"
            class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500"
            value="{{ $oldData['other_fee'] ?? '' }}">
        <input type="number" name="discount" placeholder="Discount"
            class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500"
            value="{{ $oldData['discount'] ?? '' }}">
        <input type="number" name="initial_payment" placeholder="Initial Payment"
            class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500"
            value="{{ $oldData['initial_payment'] ?? '' }}">
    </div>
</div>
