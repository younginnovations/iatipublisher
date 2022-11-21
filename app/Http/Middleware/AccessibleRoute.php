<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 * Class AccessibleRoute.
 */
class AccessibleRoute
{
    public function handle(Request $request, Closure $next): mixed
    {
        $accessibleRoutes = [
            'reporting_org',
            'description',
            'activity_status',
            'activity_date',
            'activity_scope',
            'recipient_country',
            'recipient_region',
            'collaboration_type',
            'default_flow_type',
            'default_finance_type',
            'default_aid_type',
            'default_tied_status',
            'capital_spend',
            'related_activity',
            'conditions',
            'sector',
            'humanitarian_scope',
            'legacy_data',
            'tag',
            'policy_marker',
            'other_identifier',
            'country_budget_items',
            'budget',
            'participating_org',
            'document_link',
            'contact_info',
            'location',
            'planned_disbursement',

        ];

        $params = $request->route()->parameters();

        if (array_key_exists('element', $params) && in_array($params['element'], $accessibleRoutes, true)) {
            return $next($request);
        }

        return response(['status'=>false, 'message' => 'Activity element delete denied']);
    }
}
