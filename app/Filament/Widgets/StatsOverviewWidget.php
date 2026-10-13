<?php

namespace App\Filament\Widgets;

use App\Models\College;
use App\Models\CollegeReview;
use App\Models\Course;
use App\Models\Lead;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget as BaseStatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseStatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $totalColleges = College::count();
        $regularColleges = College::where('college_mode', 'regular')->count();
        $onlineColleges = College::where('college_mode', 'online')->count();

        $totalLeads = Lead::count();
        $newLeadsToday = Lead::whereDate('created_at', today())->count();

        $pendingReviews = CollegeReview::where('status', 'pending')->count();
        $totalCourses = Course::count();

        return [
            Stat::make('Total Colleges', (string) $totalColleges)
                ->description("{$regularColleges} Regular • {$onlineColleges} Online")
                ->descriptionIcon(Heroicon::OutlinedAcademicCap)
                ->color('primary'),

            Stat::make('Total Leads', (string) $totalLeads)
                ->description("+{$newLeadsToday} received today")
                ->descriptionIcon(Heroicon::OutlinedUserGroup)
                ->color('warning'),

            Stat::make('Pending Reviews', (string) $pendingReviews)
                ->description($pendingReviews > 0 ? 'Awaiting moderation' : 'All reviews moderated')
                ->descriptionIcon(Heroicon::OutlinedChatBubbleBottomCenterText)
                ->color($pendingReviews > 0 ? 'danger' : 'success'),

            Stat::make('Academic Courses', (string) $totalCourses)
                ->description('UG, PG & Diploma catalog')
                ->descriptionIcon(Heroicon::OutlinedBookOpen)
                ->color('success'),
        ];
    }
}
