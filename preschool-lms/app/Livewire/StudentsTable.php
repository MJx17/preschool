<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

class StudentsTable extends Component
{
    use WithPagination;

    public $performanceFilter = 'All';
    public $statusFilter = 'All';

    protected $paginationTheme = 'bootstrap'; // Optional, use 'tailwind' if Tailwind CSS

    public function updatingPerformanceFilter()
    {
        $this->resetPage(); // Reset to page 1 when filter changes
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function render()
    {
        $students = collect([
            ['name' => 'John Smith', 'grade' => 'Grade 1', 'performance' => 'Excellent'],
            ['name' => 'Emily Lee', 'grade' => 'Grade 2', 'performance' => 'Good'],
            ['name' => 'Michael Brown', 'grade' => 'Grade 3', 'performance' => 'Average'],
            // ... rest of your $students array
        ]);

        $detailedStudents = collect([
            ['id' => 1, 'name' => 'John Smith', 'email' => 'john.smith@example.com', 'status' => 'Active'],
            ['id' => 2, 'name' => 'Emily Lee', 'email' => 'emily.lee@example.com', 'status' => 'Active'],
            ['id' => 3, 'name' => 'Michael Brown', 'email' => 'michael.brown@example.com', 'status' => 'Inactive'],
            // ... rest of your $detailedStudents array
        ]);

        // Apply filters
        if ($this->performanceFilter !== 'All') {
            $students = $students->where('performance', $this->performanceFilter);
        }

        if ($this->statusFilter !== 'All') {
            $detailedStudents = $detailedStudents->where('status', $this->statusFilter);
        }

        $currentPage = request()->query('page', 1);

        return view('livewire.students-table', [
            'students' => $students->forPage($currentPage, 10),
            'detailedStudents' => $detailedStudents->forPage($currentPage, 5),
            'totalStudents' => $students->count(),
            'totalDetailedStudents' => $detailedStudents->count(),
        ]);
    }
}
