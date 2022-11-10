<?php

namespace Tests\Unit\Metrics;

use App\Models\DependencyVulnerability;
use App\Models\DependencyVulnerabilityRepository;
use Carbon\Carbon;

trait CreatesFakeDVRs
{
    protected function addDVRCreatedAtDateAndRepo(Carbon $date, $repo): DependencyVulnerabilityRepository
    {
        $vulnLastYear = DependencyVulnerability::factory()
            ->create([
                'created_at' => $date,
            ]);
        $vulnLastYear->repositories()->attach($repo);

        $dvr = $vulnLastYear->repositories->first()->pivot;
        $dvr->created_at = $date;
        $dvr->save();

        return $dvr;
    }

    protected function addDVRDismissedAtDate(Carbon $date, $repo): DependencyVulnerabilityRepository
    {
        $vulnLastYear = DependencyVulnerability::factory()
            ->create([
                'created_at' => $date,
            ]);
        $vulnLastYear->repositories()->attach($repo);

        $dvr = $vulnLastYear->repositories->first()->pivot;
        $dvr->dismissed_at = $date;
        $dvr->save();

        return $dvr;
    }

    protected function addDVRMergedAtDate(Carbon $date, $repo): DependencyVulnerabilityRepository
    {
        $vulnLastYear = DependencyVulnerability::factory()
            ->create([
                'created_at' => $date,
            ]);
        $vulnLastYear->repositories()->attach($repo);

        $dvr = $vulnLastYear->repositories->first()->pivot;
        $dvr->merged_at = $date;
        $dvr->save();

        return $dvr;
    }

    protected function addDVRDeployedAtDate(Carbon $date, $repo): DependencyVulnerabilityRepository
    {
        $vulnLastYear = DependencyVulnerability::factory()
            ->create([
                'created_at' => $date,
            ]);
        $vulnLastYear->repositories()->attach($repo);

        $dvr = $vulnLastYear->repositories->first()->pivot;
        $dvr->deployed_at = $date;
        $dvr->merged_at = $date->copy()->subDay();
        $dvr->save();

        return $dvr;
    }
}
