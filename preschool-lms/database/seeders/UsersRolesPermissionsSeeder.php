<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\Teacher;
use App\Models\Student;

class UsersRolesPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = ['admin', 'student', 'teacher'];

        // Permissions for admin
        $permissionsAdmin = [
            'students.index',
            'students.create',
            'students.store',
            'students.edit',
            'students.update',
            'students.destroy',
            'enrollments.index',
            'enrollments.create',
            'enrollments.store',
            'enrollments.edit',
            'enrollments.update',
            'enrollments.destroy',
            'profile.edit',
            'profile.update',
        ];

        // Permissions for students
        $permissionsStudent = [
            'enrollments.index',
            'enrollments.store',
            'profile.edit',
            'profile.update',
        ];

        // Permissions for Teachers
        $permissionsTeacher = [
            'students.index',
            'enrollments.index',
            'enrollments.create',
            'enrollments.edit',
            'enrollments.update',
            'profile.edit',
            'profile.update',
        ];




        // Create roles
        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName]);
        }

        // Create permissions for admin, students, and teachers
        foreach (array_merge($permissionsAdmin, $permissionsStudent, $permissionsTeacher) as $permissionName) {
            Permission::firstOrCreate(['name' => $permissionName]);
        }

        // Assign permissions to roles
        $roleAdmin = Role::where('name', 'admin')->first();
        $roleAdmin->syncPermissions(Permission::whereIn('name', $permissionsAdmin)->get());

        $roleStudent = Role::where('name', 'student')->first();
        $roleStudent->syncPermissions(Permission::whereIn('name', $permissionsStudent)->get());

        $roleTeacher = Role::where('name', 'teacher')->first();
        $roleTeacher->syncPermissions(Permission::whereIn('name', $permissionsTeacher)->get());

        // Create admin user
        $adminUser = User::factory()->create([
            'name' => 'Admin User',
            'username' => 'admin',
            'email' => 'admin@school.com',
            'password' => bcrypt('adminpassword'),
            'status' => 'active', // Admin status is active
        ]);
        $adminUser->assignRole('admin');


        // Create Teacher users
        $Teacher1 = User::factory()->create([
            'name' => 'Dr. Michael Brown',
            'username' => 'michaelbrown',
            'email' => 'michaelbrown@Teacher.com',
            'password' => bcrypt('Teacherpassword'),
            'status' => 'active', // Teachers have active status
        ]);
        $Teacher1->assignRole('teacher'); // Assign 'Teacher' role

        // Create the associated Teacher record for Dr. Michael Brown
        $Teacher1->teacher()->create([
            'user_id' => $Teacher1->id,
            'surname' => 'Brown',
            'first_name' => 'Michael',
            'middle_name' => 'J',
            'sex' => 'Male',
            'contact_number' => '123-456-7890',
            'email' => 'michaelbrown@Teacher.com',
            'designation' => 'Teacher of Computer Science',
        ]);

        // Creating the second Teacher
        $Teacher2 = User::factory()->create([
            'name' => 'Dr. Sarah Lee',
            'username' => 'sarahlee',
            'email' => 'sarahlee@Teacher.com',
            'password' => bcrypt('Teacherpassword'),
            'status' => 'active', // Teachers have active status
        ]);
        $Teacher2->assignRole('teacher'); // Assign 'Teacher' role

        // Create the associated Teacher record for Dr. Sarah Lee
        $Teacher2->teacher()->create([
            'user_id' => $Teacher2->id,
            'surname' => 'Lee',
            'first_name' => 'Sarah',
            'middle_name' => 'M',
            'sex' => 'Female',
            'contact_number' => '098-765-4321',
            'email' => 'sarahlee@Teacher.com',
            'designation' => 'Associate Teacher of Mathematics',
        ]);


        // Creating the third Teacher
        $Teacher3 = User::factory()->create([
            'name' => 'Dr. John Carter',
            'username' => 'johncarter',
            'email' => 'johncarter@Teacher.com',
            'password' => bcrypt('Teacherpassword'),
            'status' => 'active',
        ]);
        $Teacher3->assignRole('teacher');

        $Teacher3->teacher()->create([
            'user_id' => $Teacher3->id,
            'surname' => 'Carter',
            'first_name' => 'John',
            'middle_name' => 'D',
            'sex' => 'Male',
            'contact_number' => '0912-345-6789',
            'email' => 'johncarter@Teacher.com',
            'designation' => 'Teacher of Finance',
        ]);

        // Creating the fourth Teacher
        $Teacher4 = User::factory()->create([
            'name' => 'Dr. Emily Watson',
            'username' => 'emilywatson',
            'email' => 'emilywatson@Teacher.com',
            'password' => bcrypt('Teacherpassword'),
            'status' => 'active',
        ]);
        $Teacher4->assignRole('teacher');

        $Teacher4->teacher()->create([
            'user_id' => $Teacher4->id,
            'surname' => 'Watson',
            'first_name' => 'Emily',
            'middle_name' => 'R',
            'sex' => 'Female',
            'contact_number' => '0933-456-7890',
            'email' => 'emilywatson@Teacher.com',
            'designation' => 'Senior Lecturer in Banking',
        ]);

        // Creating the fifth Teacher
        $Teacher5 = User::factory()->create([
            'name' => 'Juan Luna',
            'username' => 'juanluna',
            'email' => 'juanluna@Teacher.com',
            'password' => bcrypt('Teacherpassword'),
            'status' => 'active',
        ]);
        $Teacher5->assignRole('teacher');

        $Teacher5->teacher()->create([
            'user_id' => $Teacher5->id,
            'surname' => 'Luna',
            'first_name' => 'Juan',
            'middle_name' => '',
            'sex' => 'Male',
            'contact_number' => '0923-456-7890',
            'email' => 'juanluna@Teacher.com',
            'designation' => 'Teacher of Fine Arts',
        ]);


        // Creating the sixth Teacher
        $Teacher6 = User::factory()->create([
            'name' => 'Dr. Anna Martinez',
            'username' => 'annamartinez',
            'email' => 'annamartinez@Teacher.com',
            'password' => bcrypt('Teacherpassword'),
            'status' => 'active',
        ]);
        $Teacher6->assignRole('teacher');

        $Teacher6->teacher()->create([
            'user_id' => $Teacher6->id,
            'surname' => 'Martinez',
            'first_name' => 'Anna',
            'middle_name' => 'K',
            'sex' => 'Female',
            'contact_number' => '0955-678-9012',
            'email' => 'annamartinez@Teacher.com',
            'designation' => 'Assistant Teacher of Economics',
        ]);

        // Creating the seventh Teacher
        $Teacher7 = User::factory()->create([
            'name' => 'Dr. David Wilson',
            'username' => 'davidwilson',
            'email' => 'davidwilson@Teacher.com',
            'password' => bcrypt('Teacherpassword'),
            'status' => 'active',
        ]);
        $Teacher7->assignRole('teacher');

        $Teacher7->teacher()->create([
            'user_id' => $Teacher7->id,
            'surname' => 'Wilson',
            'first_name' => 'David',
            'middle_name' => 'L',
            'sex' => 'Male',
            'contact_number' => '0966-789-0123',
            'email' => 'davidwilson@Teacher.com',
            'designation' => 'Teacher of Accounting',
        ]);


        // Creating the eighth Teacher - Efren Reyes (Billiards)
        $Teacher8 = User::factory()->create([
            'name' => 'Efren Reyes',
            'username' => 'efrenreyes',
            'email' => 'efrenreyes@Teacher.com',
            'password' => bcrypt('Teacherpassword'),
            'status' => 'active',
        ]);

        $Teacher8->assignRole('teacher');

        $Teacher8->teacher()->create([
            'user_id' => $Teacher8->id,
            'surname' => 'Reyes',
            'first_name' => 'Efren',
            'middle_name' => 'M',
            'sex' => 'Male',
            'contact_number' => '0966-789-0123',
            'email' => 'efrenreyes@Teacher.com',
            'designation' => 'Teacher of Billiards & Strategic Sports',
        ]);

        // Creating the ninth Teacher - Paeng Nepomuceno (Bowling)
        $Teacher9 = User::factory()->create([
            'name' => 'Paeng Nepomuceno',
            'username' => 'paengnepomuceno',
            'email' => 'paengnepomuceno@Teacher.com',
            'password' => bcrypt('Teacherpassword'),
            'status' => 'active',
        ]);

        $Teacher9->assignRole('teacher');

        $Teacher9->teacher()->create([
            'user_id' => $Teacher9->id,
            'surname' => 'Nepomuceno',
            'first_name' => 'Paeng',
            'middle_name' => 'C',
            'sex' => 'Male',
            'contact_number' => '0977-654-3210',
            'email' => 'paengnepomuceno@Teacher.com',
            'designation' => 'Teacher of Bowling & Precision Sports',
        ]);

        // Add more courses as needed...

        $student1 = User::factory()->create([
            'name' => 'John Doe',
            'username' => 'johndoe',
            'email' => 'johndoe@student.com',
            'password' => bcrypt('studentpassword'),
            'status' => 'pending', // Default status for students
        ]);
        $student1->assignRole('student');

        // Create student specific details
        Student::create([
            'user_id' => $student1->id,
            'surname' => 'Doe',
            'first_name' => 'John',
            'middle_name' => null,
            'sex' => 'Male',
            'dob' => '2000-01-01',
            'age' => 23,
            'place_of_birth' => 'City Name',
            'home_address' => 'Home Address',
            'mobile_number' => '1234567890',
            'email_address' => 'johndoe@student.com',
            'fathers_name' => 'Father Doe',
            'fathers_educational_attainment' => 'Bachelor\'s Degree',
            'fathers_address' => 'Father\'s Address',
            'fathers_contact_number' => '0987654321',
            'fathers_occupation' => 'Engineer',
            'fathers_employer' => 'Company Name',
            'fathers_employer_address' => 'Employer Address',
            'mothers_name' => 'Mother Doe',
            'mothers_educational_attainment' => 'Bachelor\'s Degree',
            'mothers_address' => 'Mother\'s Address',
            'mothers_contact_number' => '0987654321',
            'mothers_occupation' => 'Teacher',
            'mothers_employer' => 'School Name',
            'mothers_employer_address' => 'Employer Address',
            'guardians_name' => 'Guardian Doe',
            'guardians_educational_attainment' => 'Master\'s Degree',
            'guardians_address' => 'Guardian\'s Address',
            'guardians_contact_number' => '0987654321',
            'guardians_occupation' => 'Doctor',
            'guardians_employer' => 'Hospital Name',
            'guardians_employer_address' => 'Employer Address',
            'living_situation' => 'with_family',
            'living_address' => 'Living Address',
            'living_contact_number' => '0987654321',
            'image' => 'path/to/image.jpg',
            'status' => 'not_enrolled',
        ]);

        $student3 = User::factory()->create([
            'name' => 'Sherlock Homes',
            'username' => 'sherlock',
            'email' => 'sherlockhomes@student.com',
            'password' => bcrypt('studentpassword'),
            'status' => 'pending',
        ]);
        $student3->assignRole('student');

        Student::create([
            'user_id' => $student3->id,
            'surname' => 'Homes',
            'first_name' => 'Sherlock',
            'middle_name' => 'A',
            'sex' => 'Male',
            'dob' => '2000-05-15',
            'age' => 23,
            'place_of_birth' => 'City Name',
            'home_address' => 'Home Address',
            'mobile_number' => '0987123456',
            'email_address' => 'sherlockhomes@student.com',
            'fathers_name' => 'Father Doe',
            'fathers_educational_attainment' => 'Master\'s Degree',
            'fathers_address' => 'Father\'s Address',
            'fathers_contact_number' => '0912345678',
            'fathers_occupation' => 'Engineer',
            'fathers_employer' => 'Tech Company',
            'fathers_employer_address' => 'Employer Address',
            'mothers_name' => 'Mother Doe',
            'mothers_educational_attainment' => 'Bachelor\'s Degree',
            'mothers_address' => 'Mother\'s Address',
            'mothers_contact_number' => '0923456789',
            'mothers_occupation' => 'Teacher',
            'mothers_employer' => 'High School',
            'mothers_employer_address' => 'Employer Address',
            'guardians_name' => 'Guardian Doe',
            'guardians_educational_attainment' => 'PhD',
            'guardians_address' => 'Guardian\'s Address',
            'guardians_contact_number' => '0934567890',
            'guardians_occupation' => 'Scientist',
            'guardians_employer' => 'Research Institute',
            'guardians_employer_address' => 'Employer Address',
            'living_situation' => 'with_family',
            'living_address' => 'Living Address',
            'living_contact_number' => '0945678901',
            'image' => 'path/to/image.jpg',
            'status' => 'not_enrolled',
        ]);

        // Student 4
        $student4 = User::factory()->create([
            'name' => 'Mary Johnson',
            'username' => 'maryjohnson',
            'email' => 'maryjohnson@student.com',
            'password' => bcrypt('studentpassword'),
            'status' => 'pending',
        ]);
        $student4->assignRole('student');

        Student::create([
            'user_id' => $student4->id,
            'surname' => 'Johnson',
            'first_name' => 'Mary',
            'middle_name' => 'B',
            'sex' => 'Female',
            'dob' => '2001-09-22',
            'age' => 22,
            'place_of_birth' => 'City Name',
            'home_address' => 'Home Address',
            'mobile_number' => '0978123456',
            'email_address' => 'maryjohnson@student.com',
            'fathers_name' => 'Father Johnson',
            'fathers_educational_attainment' => 'Bachelor\'s Degree',
            'fathers_address' => 'Father\'s Address',
            'fathers_contact_number' => '0981234567',
            'fathers_occupation' => 'Doctor',
            'fathers_employer' => 'Hospital Name',
            'fathers_employer_address' => 'Employer Address',
            'mothers_name' => 'Mother Johnson',
            'mothers_educational_attainment' => 'Master\'s Degree',
            'mothers_address' => 'Mother\'s Address',
            'mothers_contact_number' => '0992345678',
            'mothers_occupation' => 'Teacher',
            'mothers_employer' => 'University Name',
            'mothers_employer_address' => 'Employer Address',
            'guardians_name' => 'Guardian Johnson',
            'guardians_educational_attainment' => 'PhD',
            'guardians_address' => 'Guardian\'s Address',
            'guardians_contact_number' => '0973456789',
            'guardians_occupation' => 'Lawyer',
            'guardians_employer' => 'Law Firm',
            'guardians_employer_address' => 'Employer Address',
            'living_situation' => 'with_relatives',
            'living_address' => 'Living Address',
            'living_contact_number' => '0964567890',
            'image' => 'path/to/image.jpg',
            'status' => 'not_enrolled',
        ]);

        // Student 5
        $student5 = User::factory()->create([
            'name' => 'James Anderson',
            'username' => 'jamesanderson',
            'email' => 'jamesanderson@student.com',
            'password' => bcrypt('studentpassword'),
            'status' => 'pending',
        ]);
        $student5->assignRole('student');

        Student::create([
            'user_id' => $student5->id,
            'surname' => 'Anderson',
            'first_name' => 'James',
            'middle_name' => 'C',
            'sex' => 'Male',
            'dob' => '2002-06-18',
            'age' => 21,
            'place_of_birth' => 'City Name',
            'home_address' => 'Home Address',
            'mobile_number' => '0967123456',
            'email_address' => 'jamesanderson@student.com',
            'fathers_name' => 'Father Anderson',
            'fathers_educational_attainment' => 'PhD',
            'fathers_address' => 'Father\'s Address',
            'fathers_contact_number' => '0951234567',
            'fathers_occupation' => 'Teacher',
            'fathers_employer' => 'University Name',
            'fathers_employer_address' => 'Employer Address',
            'mothers_name' => 'Mother Anderson',
            'mothers_educational_attainment' => 'Bachelor\'s Degree',
            'mothers_address' => 'Mother\'s Address',
            'mothers_contact_number' => '0942345678',
            'mothers_occupation' => 'Accountant',
            'mothers_employer' => 'Finance Company',
            'mothers_employer_address' => 'Employer Address',
            'guardians_name' => 'Guardian Anderson',
            'guardians_educational_attainment' => 'Master\'s Degree',
            'guardians_address' => 'Guardian\'s Address',
            'guardians_contact_number' => '0933456789',
            'guardians_occupation' => 'Software Engineer',
            'guardians_employer' => 'Tech Firm',
            'guardians_employer_address' => 'Employer Address',
            'living_situation' => 'with_family',
            'living_address' => 'Dormitory Address',
            'living_contact_number' => '0924567890',
            'image' => 'path/to/image.jpg',
            'status' => 'not_enrolled',
        ]);

        // Student 6 - Jose Rizal
        $student6 = User::factory()->create([
            'name' => 'Jose Rizal',
            'username' => 'joserizal',
            'email' => 'joserizal@student.com',
            'password' => bcrypt('studentpassword'),
            'status' => 'pending',
        ]);
        $student6->assignRole('student');

        Student::create([
            'user_id' => $student6->id,
            'surname' => 'Rizal',
            'first_name' => 'Jose',
            'middle_name' => 'Protacio',
            'sex' => 'Male',
            'dob' => '1861-06-19',
            'age' => 25, // Adjusted for modern times
            'place_of_birth' => 'Calamba, Laguna',
            'home_address' => 'Calamba, Laguna',
            'mobile_number' => '09123456789',
            'email_address' => 'joserizal@student.com',
            'fathers_name' => 'Francisco Rizal Mercado',
            'fathers_educational_attainment' => 'Businessman',
            'fathers_address' => 'Calamba, Laguna',
            'fathers_contact_number' => '09234567890',
            'fathers_occupation' => 'Farmer',
            'fathers_employer' => 'Self-employed',
            'fathers_employer_address' => 'Calamba, Laguna',
            'mothers_name' => 'Teodora Alonso Realonda',
            'mothers_educational_attainment' => 'Educated at home',
            'mothers_address' => 'Calamba, Laguna',
            'mothers_contact_number' => '09345678901',
            'mothers_occupation' => 'Homemaker',
            'mothers_employer' => 'N/A',
            'mothers_employer_address' => 'N/A',
            'guardians_name' => 'Paciano Rizal',
            'guardians_educational_attainment' => 'Military Leader',
            'guardians_address' => 'Calamba, Laguna',
            'guardians_contact_number' => '09456789012',
            'guardians_occupation' => 'Revolutionary',
            'guardians_employer' => 'Katipunan',
            'guardians_employer_address' => 'Manila',
            'living_situation' => 'with_guardian',
            'living_address' => 'Calamba, Laguna',
            'living_contact_number' => '09123456789',
            'image' => 'path/to/jose-rizal.jpg',
            'status' => 'not_enrolled',
        ]);

        // Student 7 - Manny Pacquiao
        $student7 = User::factory()->create([
            'name' => 'Manny Pacquiao',
            'username' => 'mannypacquiao',
            'email' => 'mannypacquiao@student.com',
            'password' => bcrypt('studentpassword'),
            'status' => 'pending',
        ]);
        $student7->assignRole('student');

        Student::create([
            'user_id' => $student7->id,
            'surname' => 'Pacquiao',
            'first_name' => 'Manny',
            'middle_name' => 'Dapidran',
            'sex' => 'Male',
            'dob' => '1978-12-17',
            'age' => 45,
            'place_of_birth' => 'Kibawe, Bukidnon',
            'home_address' => 'General Santos City',
            'mobile_number' => '09567890123',
            'email_address' => 'mannypacquiao@student.com',
            'fathers_name' => 'Rosalio Pacquiao',
            'fathers_educational_attainment' => 'High School',
            'fathers_address' => 'General Santos City',
            'fathers_contact_number' => '09678901234',
            'fathers_occupation' => 'Farmer',
            'fathers_employer' => 'Self-employed',
            'fathers_employer_address' => 'General Santos City',
            'mothers_name' => 'Dionisia Pacquiao',
            'mothers_educational_attainment' => 'Elementary',
            'mothers_address' => 'General Santos City',
            'mothers_contact_number' => '09789012345',
            'mothers_occupation' => 'Homemaker',
            'mothers_employer' => 'N/A',
            'mothers_employer_address' => 'N/A',
            'guardians_name' => 'Freddie Roach',
            'guardians_educational_attainment' => 'High School',
            'guardians_address' => 'Los Angeles, USA',
            'guardians_contact_number' => '09890123456',
            'guardians_occupation' => 'Boxing Trainer',
            'guardians_employer' => 'Wild Card Gym',
            'guardians_employer_address' => 'California, USA',
            'living_situation' => 'with_guardian',
            'living_address' => 'General Santos City',
            'living_contact_number' => '09567890123',
            'image' => 'path/to/manny-pacquiao.jpg',
            'status' => 'not_enrolled',
        ]);
    }
}
