<!-- resources/views/components/enrollment/financial.blade.php -->
<!-- resources/views/components/enrollment/financial.blade.php -->
@props(['financialData' => null])

<div class="space-y-4">
    <h3 class="text-lg font-semibold text-blue-800 dark:text-white">Financial Information</h3>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Main Financial Info -->
        <div>
            <!-- Financier Select -->
            <div class="mb-4">
                <select name="financier" id="financier" class="mt-1 block w-full p-3 rounded-md border-gray-300 shadow-sm">
                    <option value="" disabled {{ old('financier', $financialData->financier ?? '') == '' ? 'selected' : '' }}>Select Financier</option>
                    @foreach(['Parents','Relatives','Guardian','Myself','Others'] as $option)
                        <option value="{{ $option }}" {{ old('financier', $financialData->financier ?? '') == $option ? 'selected' : '' }}>
                            {{ $option }}
                        </option>
                    @endforeach
                </select>
                @error('financier')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Scholarship, Income, Company, Contact -->
            @foreach(['scholarship','income','company_name','company_address','contact_number'] as $field)
                <div class="mb-4">
                    <input type="text" name="{{ $field }}" id="{{ $field }}" 
                        class="mt-1 block w-full p-3 rounded-md border-gray-300 shadow-sm" 
                        placeholder="{{ ucwords(str_replace('_',' ',$field)) }}"
                        value="{{ old($field, $financialData->$field ?? '') }}">
                    @error($field)
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            @endforeach
        </div>

        <!-- Relative Info -->
        <div>
            <div class="flex justify-between items-center w-full">
                <h3 class="text-lg font-semibold text-blue-800 dark:text-white mb-5">Relative Information</h3>
                <button type="button" id="add-relative" class="mt-2 text-white flex justify-between items-center bg-blue-700 p-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Add
                </button>
            </div>

            <div id="relative-info-container">
                @php
                    $relativeNames = explode(', ', old('relative_names', $financialData->relative_names ?? ''));
                    $relationships = explode(', ', old('relationships', $financialData->relationships ?? ''));
                    $positionCourses = explode(', ', old('position_courses', $financialData->position_courses ?? ''));
                    $relativeContactNumbers = explode(', ', old('relative_contact_numbers', $financialData->relative_contact_numbers ?? ''));
                    $maxRows = max(count($relativeNames), count($relationships), count($positionCourses), count($relativeContactNumbers));
                @endphp

                <div id="relative-entries">
                    @for ($i = 0; $i < $maxRows; $i++)
                        <div class="relative-entry flex flex-col border-b hover:bg-gray-300 bg-gray-200">
                            <!-- Accordion Button -->
                            <div class="relative-entry-header px-4 py-3 flex justify-between items-center cursor-pointer">
                                <span class="text-lg font-medium text-gray-700">Relative</span>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 5.25 7.5 7.5 7.5-7.5m-15 6 7.5 7.5 7.5-7.5" />
                                </svg>
                            </div>

                            <!-- Accordion Content -->
                            <div class="relative-entry-details px-4 py-3 hidden" id="relative-entry-details-{{ $i }}">
                                @foreach([
                                    ['name'=>'relative_names','value'=>$relativeNames[$i] ?? '','placeholder'=>'Name'],
                                    ['name'=>'relationships','value'=>$relationships[$i] ?? '','placeholder'=>'Relationship'],
                                    ['name'=>'position_courses','value'=>$positionCourses[$i] ?? '','placeholder'=>'Position/Course'],
                                    ['name'=>'relative_contact_numbers','value'=>$relativeContactNumbers[$i] ?? '','placeholder'=>'Contact Number'],
                                ] as $input)
                                    <div class="px-4 py-2">
                                        <input type="text" name="{{ $input['name'] }}[{{ $i }}]" 
                                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 ease-in-out"
                                            placeholder="{{ $input['placeholder'] }}" value="{{ $input['value'] }}">
                                    </div>
                                @endforeach
                            </div>

                            <!-- Remove Button -->
                            <div class="px-4 py-2 text-center flex justify-end">
                                <button type="button" class="remove-relative text-red-600 hover:text-red-800 font-semibold rounded-md transition duration-200 ease-in-out transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50 flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @endfor
                </div>
            </div>

            @error('relative_names') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            @error('relationships') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            @error('position_courses') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            @error('relative_contact_numbers') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>
    </div>
</div>





<script>
    document.addEventListener('DOMContentLoaded', function() {
        const addRelativeButton = document.getElementById('add-relative');
        const container = document.getElementById('relative-entries');

        // Function to handle both adding a new relative and toggling the accordion visibility
        function addRelative() {
            const firstEntry = document.querySelector('.relative-entry');
            if (!firstEntry) return; // Safety check
            const newEntry = firstEntry.cloneNode(true);
            const entryCount = container.querySelectorAll('.relative-entry').length;

            // Update each input in the cloned row with the new index
            newEntry.querySelectorAll('input').forEach((input) => {
                input.value = ''; // Clear the value
                const name = input.getAttribute('name');
                const updatedName = name.replace(/\[\d+\]/, `[${entryCount}]`);
                input.setAttribute('name', updatedName);
            });

            // Attach remove functionality
            const removeButton = newEntry.querySelector('.remove-relative');
            removeButton.addEventListener('click', function() {
                if (container.querySelectorAll('.relative-entry').length > 1) {
                    newEntry.remove();
                } else {
                    newEntry.querySelectorAll('input').forEach(input => input.value = '');
                }
            });

            // Add accordion functionality for new entry
            const accordionHeader = newEntry.querySelector('.relative-entry-header');
            const accordionDetails = newEntry.querySelector('.relative-entry-details');
            const accordionIcon = accordionHeader.querySelector('svg');

            accordionHeader.addEventListener('click', function() {
                accordionDetails.classList.toggle('hidden');
                accordionIcon.classList.toggle('rotate-90');
            });

            container.appendChild(newEntry);
        }

        addRelativeButton.addEventListener('click', addRelative);

        // Attach remove event for initial rows
        container.querySelectorAll('.remove-relative').forEach(button => {
            button.addEventListener('click', function() {
                const currentRows = container.querySelectorAll('.relative-entry');
                if (currentRows.length > 1) {
                    button.closest('.relative-entry').remove();
                } else {
                    button.closest('.relative-entry').querySelectorAll('input').forEach(input =>
                        input.value = '');
                }
            });
        });

        // Attach initial accordion functionality
        document.querySelectorAll('.relative-entry-header').forEach((header, index) => {
            const details = document.getElementById(`relative-entry-details-${index}`);
            const icon = header.querySelector('svg');

            header.addEventListener('click', function() {
                details.classList.toggle('hidden');
                icon.classList.toggle('rotate-90');
            });
        });
    });
</script>
</div>