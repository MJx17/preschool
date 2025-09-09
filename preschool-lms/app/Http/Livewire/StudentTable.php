<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

class StudentTable extends Component
{
    use WithPagination;

    public $status = 'All';

    public function updatingStatus()
    {
        $this->resetPage();
    }

    public function render()
    {
        $students = collect([
            ['name' => 'John', 'status' => 'Active'],
            ['name' => 'Mary', 'status' => 'Inactive'],
        ]);

        if ($this->status !== 'All') {
            $students = $students->where('status', $this->status);
        }

        return view('livewire.student-table', ['students' => $students]);
    }
}
