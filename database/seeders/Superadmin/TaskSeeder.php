<?php

namespace Database\Seeders\Superadmin;

use App\Models\Lead;
use App\Models\Task;
use Carbon\Carbon;
use Faker\Generator;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $leads                      = Lead::all();
        $faker                      = app(Generator::class);
        foreach ($leads as $lead) {
            switch ($lead->status) {
                case 'New':
                    Task::create([
                        'lead_id'           => $lead->id,
                        'type'              => 'Call',
                        'task'              => 'Initial welcome call to introduce services',
                        'due_date'          => Carbon::now()->addDays($lead->id),
                        'priority'          => 'High',
                        'status'            => 'Pending',
                        'created_by'        => 'Manager',
                        'created_by_id'     => 2,
                        'assigned_to'       => 3,
                    ]);
                    break;
                case 'Contacted':
                    Task::create([
                        'lead_id'           => $lead->id,
                        'type'              => 'Call',
                        'task'              => 'Initial welcome call to introduce services',
                        'due_date'          => Carbon::now()->addDays($lead->id + 1),
                        'priority'          => 'High',
                        'status'            => 'Completed',
                        'created_by'        => 'Manager',
                        'created_by_id'     => 2,
                        'assigned_to'       => 3,
                    ]);
                    Task::create([
                        'lead_id'           => $lead->id,
                        'type'              => 'Email',
                        'task'              => $faker->randomElement(['Send introduction email with company profile', 'Send follow-up email to introduce services', 'Send product/service brochure']),
                        'due_date'          => Carbon::now()->addDays($lead->id),
                        'priority'          => 'High',
                        'status'            => 'Pending',
                        'created_by'        => 'Manager',
                        'created_by_id'     => 2,
                        'assigned_to'       => 3,
                    ]);
                    break;
                case 'Quoted':
                    Task::create([
                        'lead_id'           => $lead->id,
                        'type'              => 'Call',
                        'task'              => 'Initial welcome call to introduce services',
                        'due_date'          => Carbon::now()->addDays($lead->id),
                        'priority'          => 'High',
                        'status'            => 'Completed',
                        'created_by'        => 'Manager',
                        'created_by_id'     => 2,
                        'assigned_to'       => 3,
                    ]);
                    Task::create([
                        'lead_id'           => $lead->id,
                        'type'              => 'Email',
                        'task'              => $faker->randomElement(['Send introduction email with company profile', 'Send follow-up email to introduce services', 'Send product/service brochure']),
                        'due_date'          => Carbon::now()->addDays($lead->id + 1),
                        'priority'          => 'Medium',
                        'status'            => 'Completed',
                        'created_by'        => 'Manager',
                        'created_by_id'     => 2,
                        'assigned_to'       => 3,
                    ]);
                    Task::create([
                        'lead_id'           => $lead->id,
                        'type'              => 'Meeting',
                        'task'              => $faker->randomElement(['Arrange negotiation call/meeting', 'Arrange follow-up meeting']),
                        'due_date'          => Carbon::now()->addDays($lead->id + 2),
                        'priority'          => 'Medium',
                        'status'            => 'pending',
                        'created_by'        => 'Manager',
                        'created_by_id'     => 2,
                        'assigned_to'       => 3,
                    ]);
                    break;
                case 'Negotiation':
                    Task::create([
                        'lead_id'           => $lead->id,
                        'type'              => 'Call',
                        'task'              => 'Initial welcome call to introduce services',
                        'due_date'          => Carbon::now()->addDays($lead->id),
                        'priority'          => 'High',
                        'status'            => 'Completed',
                        'created_by'        => 'Manager',
                        'created_by_id'     => 2,
                        'assigned_to'       => 3,
                    ]);
                    Task::create([
                        'lead_id'           => $lead->id,
                        'type'              => 'Email',
                        'task'              => $faker->randomElement(['Send introduction email with company profile', 'Send follow-up email to introduce services', 'Send product/service brochure']),
                        'due_date'          => Carbon::now()->addDays($lead->id + 1),
                        'priority'          => 'Medium',
                        'status'            => 'Completed',
                        'created_by'        => 'Manager',
                        'created_by_id'     => 2,
                        'assigned_to'       => 3,
                    ]);
                    Task::create([
                        'lead_id'           => $lead->id,
                        'type'              => 'Meeting',
                        'task'              => $faker->randomElement(['Arrange negotiation call/meeting', 'Arrange follow-up meeting']),
                        'due_date'          => Carbon::now()->addDays($lead->id + 2),
                        'priority'          => 'Medium',
                        'status'            => 'Completed',
                        'created_by'        => 'Manager',
                        'created_by_id'     => 2,
                        'assigned_to'       => 3,
                    ]);
                    Task::create([
                        'lead_id'           => $lead->id,
                        'type'              => 'Follow Up',
                        'task'              => $faker->randomElement(['Get final decision from client', 'Schedule future reconnect (3–4 days)']),
                        'due_date'          => Carbon::now()->addDays($lead->id + 3),
                        'priority'          => 'Medium',
                        'status'            => 'Pending',
                        'created_by'        => 'Manager',
                        'created_by_id'     => 2,
                        'assigned_to'       => 3,
                    ]);
                    break;
                case 'Won':
                    Task::create([
                        'lead_id'           => $lead->id,
                        'type'              => 'Call',
                        'task'              => 'Initial welcome call to introduce services',
                        'due_date'          => Carbon::now()->addDays($lead->id),
                        'priority'          => 'High',
                        'status'            => 'Completed',
                        'created_by'        => 'Manager',
                        'created_by_id'     => 2,
                        'assigned_to'       => 3,
                    ]);
                    Task::create([
                        'lead_id'           => $lead->id,
                        'type'              => 'Email',
                        'task'              => $faker->randomElement(['Send introduction email with company profile', 'Send follow-up email to introduce services', 'Send product/service brochure']),
                        'due_date'          => Carbon::now()->addDays($lead->id + 1),
                        'priority'          => 'Medium',
                        'status'            => 'Completed',
                        'created_by'        => 'Manager',
                        'created_by_id'     => 2,
                        'assigned_to'       => 3,
                    ]);
                    Task::create([
                        'lead_id'           => $lead->id,
                        'type'              => 'Meeting',
                        'task'              => $faker->randomElement(['Arrange negotiation call/meeting', 'Arrange follow-up meeting']),
                        'due_date'          => Carbon::now()->addDays($lead->id + 2),
                        'priority'          => 'Medium',
                        'status'            => 'Completed',
                        'created_by'        => 'Manager',
                        'created_by_id'     => 2,
                        'assigned_to'       => 3,
                    ]);
                    Task::create([
                        'lead_id'           => $lead->id,
                        'type'              => 'Follow Up',
                        'task'              => $faker->randomElement(['Get final decision from client', 'Schedule future reconnect (3–4 days)']),
                        'due_date'          => Carbon::now()->addDays($lead->id + 3),
                        'priority'          => 'Medium',
                        'status'            => 'Completed',
                        'created_by'        => 'Manager',
                        'created_by_id'     => 2,
                        'assigned_to'       => 3,
                    ]);
                    Task::create([
                        'lead_id'           => $lead->id,
                        'type'              => 'Visit',
                        'task'              => $faker->randomElement(['Visit Event Location']),
                        'due_date'          => Carbon::now()->addDays($lead->id + 4),
                        'priority'          => 'Medium',
                        'status'            => 'Pending',
                        'created_by'        => 'Manager',
                        'created_by_id'     => 2,
                        'assigned_to'       => 3,
                    ]);
                    break;
                default:
                    Task::create([
                        'lead_id'           => $lead->id,
                        'type'              => 'Call',
                        'task'              => 'Initial welcome call to introduce services',
                        'due_date'          => Carbon::now()->addDays($lead->id),
                        'priority'          => 'High',
                        'status'            => 'Completed',
                        'created_by'        => 'Manager',
                        'created_by_id'     => 2,
                        'assigned_to'       => 3,
                    ]);
                    Task::create([
                        'lead_id'           => $lead->id,
                        'type'              => 'Email',
                        'task'              => $faker->randomElement(['Send introduction email with company profile', 'Send follow-up email to introduce services', 'Send product/service brochure']),
                        'due_date'          => Carbon::now()->addDays($lead->id + 1),
                        'priority'          => 'Medium',
                        'status'            => 'Completed',
                        'created_by'        => 'Manager',
                        'created_by_id'     => 2,
                        'assigned_to'       => 3,
                    ]);
                    Task::create([
                        'lead_id'           => $lead->id,
                        'type'              => 'Meeting',
                        'task'              => $faker->randomElement(['Arrange negotiation call/meeting', 'Arrange follow-up meeting']),
                        'due_date'          => Carbon::now()->addDays($lead->id + 2),
                        'priority'          => 'Medium',
                        'status'            => 'Completed',
                        'created_by'        => 'Manager',
                        'created_by_id'     => 2,
                        'assigned_to'       => 3,
                    ]);
                    Task::create([
                        'lead_id'           => $lead->id,
                        'type'              => 'Follow Up',
                        'task'              => $faker->randomElement(['Get final decision from client', 'Schedule future reconnect (1–2 days)']),
                        'due_date'          => Carbon::now()->addDays($lead->id + 3),
                        'priority'          => 'Medium',
                        'status'            => 'Completed',
                        'created_by'        => 'Manager',
                        'created_by_id'     => 2,
                        'assigned_to'       => 3,
                    ]);
                    Task::create([
                        'lead_id'           => $lead->id,
                        'type'              => 'Follow Up',
                        'task'              => $faker->randomElement(['Get final decision from client', 'Schedule future reconnect (1–2 days)']),
                        'due_date'          => Carbon::now()->addDays($lead->id + 4),
                        'priority'          => 'Medium',
                        'status'            => 'Completed',
                        'created_by'        => 'Manager',
                        'created_by_id'     => 2,
                        'assigned_to'       => 3,
                    ]);
                    Task::create([
                        'lead_id'           => $lead->id,
                        'type'              => 'General',
                        'task'              => $faker->randomElement(['Update CRM with reason for lost lead']),
                        'due_date'          => Carbon::now()->addDays($lead->id + 5),
                        'priority'          => 'Medium',
                        'status'            => 'Pending',
                        'created_by'        => 'Manager',
                        'created_by_id'     => 2,
                        'assigned_to'       => 3,
                    ]);
                    break;
            }
        }
    }
}
