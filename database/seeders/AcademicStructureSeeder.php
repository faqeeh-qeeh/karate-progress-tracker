<?php

namespace Database\Seeders;

use App\Models\AcademicClass;
use App\Models\Department;
use App\Models\StudyProgram;
use Illuminate\Database\Seeder;

class AcademicStructureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departmentsData = [
            [
                'name' => 'Teknik Informatika',
                'description' => 'Jurusan Teknik Informatika Politeknik Negeri Indramayu',
                'is_active' => true,
                'study_programs' => [
                    [
                        'name' => 'D4 Rekayasa Perangkat Lunak',
                        'description' => 'Program Studi Sarjana Terapan Rekayasa Perangkat Lunak',
                        'classes' => ['RPL 1A', 'RPL 1B', 'RPL 2A', 'RPL 2B', 'RPL 3A', 'RPL 3B', 'RPL 4A', 'RPL 4B'],
                    ],
                    [
                        'name' => 'D3 Teknik Informatika',
                        'description' => 'Program Studi Diploma Tiga Teknik Informatika',
                        'classes' => ['D3TI 1A', 'D3TI 1B', 'D3TI 2A', 'D3TI 2B', 'D3TI 3A', 'D3TI 3B'],
                    ],
                    [
                        'name' => 'D4 Sistem Informasi Kota Cerdas',
                        'description' => 'Program Studi Sarjana Terapan Sistem Informasi Kota Cerdas',
                        'classes' => ['SIKC 1A', 'SIKC 2A', 'SIKC 3A', 'SIKC 4A'],
                    ],
                ],
            ],
            [
                'name' => 'Teknik Mesin',
                'description' => 'Jurusan Teknik Mesin Politeknik Negeri Indramayu',
                'is_active' => true,
                'study_programs' => [
                    [
                        'name' => 'D3 Teknik Mesin',
                        'description' => 'Program Studi Diploma Tiga Teknik Mesin',
                        'classes' => ['TM 1A', 'TM 1B', 'TM 2A', 'TM 2B', 'TM 3A', 'TM 3B'],
                    ],
                    [
                        'name' => 'D4 Perancangan Manufaktur',
                        'description' => 'Program Studi Sarjana Terapan Perancangan Manufaktur',
                        'classes' => ['D4PM 1A', 'D4PM 2A', 'D4PM 3A', 'D4PM 4A'],
                    ],
                ],
            ],
            [
                'name' => 'Teknik Pendingin dan Tata Udara',
                'description' => 'Jurusan Teknik Pendingin dan Tata Udara Polindra',
                'is_active' => true,
                'study_programs' => [
                    [
                        'name' => 'D3 Teknik Pendingin dan Tata Udara',
                        'description' => 'Program Studi Diploma Tiga Teknik Pendingin dan Tata Udara',
                        'classes' => ['TPTU 1A', 'TPTU 1B', 'TPTU 2A', 'TPTU 2B', 'TPTU 3A', 'TPTU 3B'],
                    ],
                ],
            ],
            [
                'name' => 'Kesehatan',
                'description' => 'Jurusan Keperawatan dan Kesehatan Polindra',
                'is_active' => true,
                'study_programs' => [
                    [
                        'name' => 'D3 Keperawatan',
                        'description' => 'Program Studi Diploma Tiga Keperawatan',
                        'classes' => ['KEP 1A', 'KEP 1B', 'KEP 2A', 'KEP 2B', 'KEP 3A', 'KEP 3B'],
                    ],
                ],
            ],
        ];

        foreach ($departmentsData as $deptItem) {
            $department = Department::firstOrCreate(
                ['name' => $deptItem['name']],
                [
                    'description' => $deptItem['description'],
                    'is_active' => $deptItem['is_active'],
                ]
            );

            foreach ($deptItem['study_programs'] as $progItem) {
                $studyProgram = StudyProgram::firstOrCreate(
                    [
                        'department_id' => $department->id,
                        'name' => $progItem['name'],
                    ],
                    [
                        'description' => $progItem['description'],
                        'is_active' => true,
                    ]
                );

                foreach ($progItem['classes'] as $className) {
                    AcademicClass::firstOrCreate([
                        'study_program_id' => $studyProgram->id,
                        'name' => $className,
                    ]);
                }
            }
        }
    }
}
