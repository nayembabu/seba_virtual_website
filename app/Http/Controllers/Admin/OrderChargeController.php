<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NidType;
use App\Models\PassportOrderType;
use App\Models\SignCopyOrderType;
use App\Models\SimConversionType;
use App\Models\SimNetworkOrderType;
use App\Models\TinOrderType;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class OrderChargeController extends Controller
{
    /**
     * Map of URL-safe group key => Eloquent model class.
     * This is the single source of truth for which tables are
     * exposed on this page and which model handles each one.
     */
    protected function map(): array
    {
        return [
            'nid'            => NidType::class,
            'passport'       => PassportOrderType::class,
            'sign_copy'      => SignCopyOrderType::class,
            'sim_conversion' => SimConversionType::class,
            'sim_network'    => SimNetworkOrderType::class,
            'tin'            => TinOrderType::class,
        ];
    }

    /**
     * Static presentation info (title/icon) per group.
     */
    protected function meta(): array
    {
        return [
            'nid'            => ['title' => 'NID Services',        'icon' => 'fa-id-card'],
            'passport'       => ['title' => 'Passport Orders',     'icon' => 'fa-passport'],
            'sign_copy'      => ['title' => 'Sign Copy Orders',    'icon' => 'fa-signature'],
            'sim_conversion' => ['title' => 'SIM Conversions',     'icon' => 'fa-sim-card'],
            'sim_network'    => ['title' => 'SIM / Network Orders','icon' => 'fa-network-wired'],
            'tin'            => ['title' => 'TIN Orders',          'icon' => 'fa-file-invoice-dollar'],
        ];
    }

    public function index()
    {
        $meta   = $this->meta();
        $groups = [];

        $totalServices = 0;
        $totalActive   = 0;
        $totalInactive = 0;
        $totalAmount   = 0;

        foreach ($this->map() as $key => $modelClass) {
            $items = $modelClass::orderBy('id')->get();

            $groups[$key] = [
                'title' => $meta[$key]['title'],
                'icon'  => $meta[$key]['icon'],
                'items' => $items,
            ];

            $totalServices += $items->count();
            $totalActive   += $items->where('is_active', 1)->count();
            $totalInactive += $items->where('is_active', 0)->count();
            $totalAmount   += $items->sum('cost');
        }

        return view('admin.order-charges.index', compact(
            'groups',
            'totalServices',
            'totalActive',
            'totalInactive',
            'totalAmount'
        ));
    }

    /**
     * Update ONLY the cost/amount for a single row of a single table.
     * No other field (name, code, is_active, etc.) can ever be touched here,
     * and rows can never be created or deleted from this screen.
     */
    public function update(Request $request, string $type, int $id)
    {
        $map = $this->map();

        if (! array_key_exists($type, $map)) {
            abort(404);
        }

        $request->validate([
            'cost' => ['required', 'numeric', 'min:0', 'max:99999999.99'],
        ]);

        $modelClass = $map[$type];

        /** @var \Illuminate\Database\Eloquent\Model $row */
        $row = $modelClass::findOrFail($id);

        // Explicitly set only 'cost' -- ignores any other keys in the request
        $row->cost = $request->input('cost');
        $row->save();

        return redirect()
            ->route('admin.order-charges.index')
            ->with('success', $row->name_bn . ' price updated successfully.');
    }
}