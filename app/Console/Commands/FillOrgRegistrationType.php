<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\IATI\Models\Organization\Organization;
use App\IATI\Models\User\User;
use Arr;
use DB;
use Illuminate\Console\Command;

/**
 * Class FillOrgRegistrationType.
 */
class FillOrgRegistrationType extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:fillOrgRegistrationType';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fill registration type in organization';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        try {
            DB::beginTransaction();

            $registrationMethodMapping = [
                'new_org' =>'new_org',
                'existing_org' =>'existing_org',
                'user_create' =>'existing_org',
            ];

            $organizations = Organization::get();

            foreach ($organizations as $organization) {
                $user = User::where('organization_id', $organization->id)->first();
                $userRegistrationType = $user ? $user->registration_method : 'existing_org';
                $organization['registration_type'] = Arr::get($registrationMethodMapping, $userRegistrationType, 'existing_org');
                $organization->timestamps = false;
                $organization->saveQuietly(['touch' => false]);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            logger()->error($e);
        }
    }
}
