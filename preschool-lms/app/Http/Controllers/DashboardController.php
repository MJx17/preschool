<?php

namespace App\Http\Controllers;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Line chart (attendance trend)
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May'];

        $attendanceDatasets = [
            [
                'label' => 'Pending',
                'data' => [3, 4, 2, 5, 3],
                'borderColor' => '#facc15',
                'backgroundColor' => 'rgba(250, 204, 21, 0.3)',
            ],
            [
                'label' => 'Reviewed',
                'data' => [7, 6, 8, 5, 7],
                'borderColor' => '#22c55e',
                'backgroundColor' => 'rgba(34, 197, 94, 0.3)',
            ],
            [
                'label' => 'Approved',
                'data' => [4, 5, 3, 4, 6],
                'borderColor' => '#3b82f6',
                'backgroundColor' => 'rgba(59, 130, 246, 0.3)',
            ]
        ];

        // Gender distribution (Pie)
        $genderLabels = ['Male', 'Female'];
        $genderDatasets = [
            [
                'label' => 'Gender',
                'data' => [180, 150],
                'backgroundColor' => ['#3b82f6', '#ef4444'], // blue = male, red = female
            ]
        ];

        // Grade level distribution (Doughnut)
        $gradeLabels = ['Nursery', 'Preschool', 'Grade 1', 'Grade 2', 'Grade 3'];
        $gradeDatasets = [
            [
                'label' => 'Students',
                'data' => [40, 60, 80, 70, 50],
                'backgroundColor' => [
                    '#f87171', // red
                    '#fbbf24', // yellow
                    '#34d399', // green
                    '#60a5fa', // blue
                    '#a78bfa'  // purple
                ],
            ]
        ];

        $students = [
            ['name' => 'John Smith', 'grade' => 'Grade 1', 'performance' => 'Excellent'],
            ['name' => 'Emily Lee', 'grade' => 'Grade 2', 'performance' => 'Good'],
            ['name' => 'Michael Brown', 'grade' => 'Grade 3', 'performance' => 'Average'],
            ['name' => 'Sarah Johnson', 'grade' => 'Grade 1', 'performance' => 'Good'],
            ['name' => 'David Davis', 'grade' => 'Grade 2', 'performance' => 'Excellent'],
            ['name' => 'Laura Wilson', 'grade' => 'Grade 3', 'performance' => 'Good'],
            ['name' => 'James Martinez', 'grade' => 'Grade 1', 'performance' => 'Average'],
            ['name' => 'Anna Clark', 'grade' => 'Grade 2', 'performance' => 'Excellent'],
            ['name' => 'Robert Lewis', 'grade' => 'Grade 3', 'performance' => 'Good'],
            ['name' => 'Olivia Walker', 'grade' => 'Grade 1', 'performance' => 'Excellent'],
            ['name' => 'William Hall', 'grade' => 'Grade 2', 'performance' => 'Average'],
            ['name' => 'Sophia Allen', 'grade' => 'Grade 3', 'performance' => 'Good'],
        ];
    
        // Get the selected filter from query string
        $filter = $request->get('performance', 'All');
    
        $collection = collect($students);
    
        // Filter students if a specific performance is selected
        if ($filter !== 'All') {
            $collection = $collection->where('performance', $filter);
        }
    
        $perPage = 10;
        $currentPage = $request->get('page', 1);
    
        $paginatedStudents = new LengthAwarePaginator(
            $collection->forPage($currentPage, $perPage),
            $collection->count(),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );
    
        

        $studentsData= [
            [
                'id' => 1,
                'name' => 'John Smith',
                'email' => 'john.smith@example.com',
                'phone' => '+1 555-1234',
                'dob' => '2012-05-14',
                'grade' => 'Grade 1',
                'enrollment_date' => '2023-06-01',
                'status' => 'Active',
                'guardian' => 'Mary Smith',
            ],
            [
                'id' => 2,
                'name' => 'Emily Lee',
                'email' => 'emily.lee@example.com',
                'phone' => '+1 555-5678',
                'dob' => '2011-11-22',
                'grade' => 'Grade 2',
                'enrollment_date' => '2022-08-15',
                'status' => 'Active',
                'guardian' => 'Peter Lee',
            ],
            [
                'id' => 3,
                'name' => 'Michael Brown',
                'email' => 'michael.brown@example.com',
                'phone' => '+1 555-8765',
                'dob' => '2010-03-09',
                'grade' => 'Grade 3',
                'enrollment_date' => '2021-09-10',
                'status' => 'Inactive',
                'guardian' => 'Linda Brown',
            ],
            [
                'id' => 4,
                'name' => 'Sarah Johnson',
                'email' => 'sarah.johnson@example.com',
                'phone' => '+1 555-4321',
                'dob' => '2012-07-30',
                'grade' => 'Grade 1',
                'enrollment_date' => '2023-01-12',
                'status' => 'Active',
                'guardian' => 'James Johnson',
            ],
            [
                'id' => 5,
                'name' => 'David Davis',
                'email' => 'david.davis@example.com',
                'phone' => '+1 555-3456',
                'dob' => '2011-09-18',
                'grade' => 'Grade 2',
                'enrollment_date' => '2022-03-20',
                'status' => 'Active',
                'guardian' => 'Laura Davis',
            ],
            [
                'id' => 6,
                'name' => 'Laura Wilson',
                'email' => 'laura.wilson@example.com',
                'phone' => '+1 555-6543',
                'dob' => '2010-12-05',
                'grade' => 'Grade 3',
                'enrollment_date' => '2021-07-15',
                'status' => 'Inactive',
                'guardian' => 'Mark Wilson',
            ],
            [
                'id' => 7,
                'name' => 'James Martinez',
                'email' => 'james.martinez@example.com',
                'phone' => '+1 555-7890',
                'dob' => '2012-02-11',
                'grade' => 'Grade 1',
                'enrollment_date' => '2023-02-20',
                'status' => 'Active',
                'guardian' => 'Patricia Martinez',
            ],
            [
                'id' => 8,
                'name' => 'Anna Clark',
                'email' => 'anna.clark@example.com',
                'phone' => '+1 555-9876',
                'dob' => '2011-06-07',
                'grade' => 'Grade 2',
                'enrollment_date' => '2022-05-05',
                'status' => 'Active',
                'guardian' => 'Steven Clark',
            ],
            [
                'id' => 9,
                'name' => 'Robert Lewis',
                'email' => 'robert.lewis@example.com',
                'phone' => '+1 555-2109',
                'dob' => '2010-10-12',
                'grade' => 'Grade 3',
                'enrollment_date' => '2021-10-01',
                'status' => 'Inactive',
                'guardian' => 'Michelle Lewis',
            ],
            [
                'id' => 10,
                'name' => 'Olivia Walker',
                'email' => 'olivia.walker@example.com',
                'phone' => '+1 555-3457',
                'dob' => '2012-08-23',
                'grade' => 'Grade 1',
                'enrollment_date' => '2023-03-18',
                'status' => 'Active',
                'guardian' => 'Richard Walker',
            ],
            [
                'id' => 11,
                'name' => 'William Hall',
                'email' => 'william.hall@example.com',
                'phone' => '+1 555-4322',
                'dob' => '2011-04-16',
                'grade' => 'Grade 2',
                'enrollment_date' => '2022-09-12',
                'status' => 'Active',
                'guardian' => 'Jennifer Hall',
            ],
            [
                'id' => 12,
                'name' => 'Sophia Allen',
                'email' => 'sophia.allen@example.com',
                'phone' => '+1 555-6789',
                'dob' => '2010-11-30',
                'grade' => 'Grade 3',
                'enrollment_date' => '2021-11-15',
                'status' => 'Inactive',
                'guardian' => 'Kevin Allen',
            ],
        ];

        $filteredData = $request->get('status', 'All');

        $collection = collect($studentsData);
    
        if ($filteredData !== 'All') {
            $collection = $collection->where('status', $filteredData);
        }
    
        $perPage = 5;
        $currentPage = $request->get('page', 1);
    
        $paginatedStudentsData = new LengthAwarePaginator(
            $collection->forPage($currentPage, $perPage),
            $collection->count(),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );
        
        

        return view('dashboard', compact(
            'months',
            'attendanceDatasets',
            'genderLabels',
            'genderDatasets',
            'gradeLabels',
            'gradeDatasets',
            'paginatedStudents',
            'paginatedStudentsData',
            'filter',
            'filteredData'
        ));
    }
}
