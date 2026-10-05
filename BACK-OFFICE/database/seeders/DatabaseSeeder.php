<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\JobCategory;
use App\Models\Company;
use App\Models\JobVacancy;
use App\Models\Resume;
use App\Models\JobApplication;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Admin User
        |--------------------------------------------------------------------------
        */

        User::firstOrCreate(
            [
                'email' => 'admin@example.com',
            ],
            [
                'name' => 'Admin',
                'password' => Hash::make('12345678'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | Load JSON Data
        |--------------------------------------------------------------------------
        */

        $jobData = json_decode(
            file_get_contents(database_path('data/job_data.json')),
            true
        );

        $jobApplicationData = json_decode(
            file_get_contents(database_path('data/job_applications.json')),
            true
        );

        /*
        |--------------------------------------------------------------------------
        | Create Job Categories
        |--------------------------------------------------------------------------
        */

        foreach ($jobData['jobCategories'] as $category) {
            JobCategory::firstOrCreate([
                'name' => $category,
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Create Companies
        |--------------------------------------------------------------------------
        */

        foreach ($jobData['companies'] as $companyData) {
            $companyOwner = User::firstOrCreate(
                [
                    'email' => fake()->unique()->safeEmail(),
                ],
                [
                    'name' => fake()->name(),
                    'password' => Hash::make('12345678'),
                    'role' => 'company-owner',
                    'email_verified_at' => now(),
                ]
            );

            Company::firstOrCreate(
                [
                    'name' => $companyData['name'],
                ],
                [
                    'address' => $companyData['address'],
                    'website' => $companyData['website'],
                    'industry' => $companyData['industry'],
                    'ownerId' => $companyOwner->id,
                ]
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Create Job Vacancies
        |--------------------------------------------------------------------------
        */

        foreach ($jobData['jobVacancies'] as $jobsVacancyData) {
            // Find company
            $company = Company::where(
                'name',
                $jobsVacancyData['company']
            )->firstOrFail();

            // Find category
            $jobCategory = JobCategory::where(
                'name',
                $jobsVacancyData['category']
            )->firstOrFail();

            // Create vacancy
            JobVacancy::firstOrCreate(
                [
                    'title' => $jobsVacancyData['title'],
                    'companyId' => $company->id,
                ],
                [
                    'description' => $jobsVacancyData['description'],
                    'location' => $jobsVacancyData['location'],
                    'type' => $jobsVacancyData['type'],
                    'salary' => $jobsVacancyData['salary'],
                    'categoryId' => $jobCategory->id,
                ]
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Create Job Applications
        |--------------------------------------------------------------------------
        */

        foreach ($jobApplicationData['jobApplications'] as $applicationData) {

            /*
            |--------------------------------------------------------------------------
            | Get Random Job Vacancy
            |--------------------------------------------------------------------------
            */

            $jobsVacancy = JobVacancy::inRandomOrder()->firstOrFail();

            /*
            |--------------------------------------------------------------------------
            | Create Applicant
            |--------------------------------------------------------------------------
            */

            $applicant = User::firstOrCreate(
                [
                    'email' => fake()->unique()->safeEmail(),
                ],
                [
                    'name' => fake()->name(),
                    'password' => Hash::make('12345678'),
                    'role' => 'job-seeker',
                    'email_verified_at' => now(),
                ]
            );

            /*
            |--------------------------------------------------------------------------
            | Create Resume
            |--------------------------------------------------------------------------
            |
            | The JSON structure is:
            |
            | "resume": {
            |     "filename": "...",
            |     "fileUri": "...",
            |     "contactDetails": "...",
            |     "summary": "...",
            |     "skills": "...",
            |     "experience": "...",
            |     "education": "..."
            | }
            |
            */

            $resume = Resume::firstOrCreate(
                [
                    'userId' => $applicant->id,
                ],
                [
                    'filename' => $applicationData['resume']['filename'],
                    'fileurl' => $applicationData['resume']['fileUri'],
                    'contactdetails' => $applicationData['resume']['contactDetails'],
                    'summary' => $applicationData['resume']['summary'],
                    'skills' => $applicationData['resume']['skills'],
                    'education' => $applicationData['resume']['education'],
                    'experience' => $applicationData['resume']['experience'],
                ]
            );

            /*
            |--------------------------------------------------------------------------
            | Create Job Application
            |--------------------------------------------------------------------------
            */

            JobApplication::firstOrCreate(
                [
                    'jobVacancyId' => $jobsVacancy->id,
                    'userId' => $applicant->id,
                ],
                [
                    'resumeId' => $resume->id,
                    'status' => $applicationData['status'],

                    // JSON uses aiGeneratedScore
                    // Database column uses aigenratedScore
                    'aiGeneratedScore' => $applicationData['aiGeneratedScore'],

                    // JSON uses aiGeneratedFeedback
                    // Database column uses aigenratedFeedback
                    'aiGeneratedFeedback' => $applicationData['aiGeneratedFeedback'],
                ]
            );
        }
    }
}