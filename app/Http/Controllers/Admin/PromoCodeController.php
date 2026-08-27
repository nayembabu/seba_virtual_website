<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PromoCode;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PromoCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $promoCodes = PromoCode::orderByDesc("id")->paginate(10);
        return view("admin.promo_codes.index", compact("promoCodes"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin.promo_codes.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            "code" => "required|string|max:50|unique:promo_codes,code",
            "usage_limit" => "required|integer|min:0",
            "promo_amount" => "required|integer|min:0",
            "promo_type" => ["required", Rule::in(["flat", "percent"])],
            "is_active" => "boolean",
        ]);

        PromoCode::create($request->all());

        return redirect()->route("admin.promo-codes.index")->with("success", "Promo code created successfully.");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PromoCode  $promoCode
     * @return \Illuminate\Http\Response
     */
    public function edit(PromoCode $promoCode)
    {
        return view("admin.promo_codes.edit", compact("promoCode"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PromoCode  $promoCode
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PromoCode $promoCode)
    {
        $request->validate([
            "code" => ["required", "string", "max:50", Rule::unique("promo_codes", "code")->ignore($promoCode->id)],
            "usage_limit" => "required|integer|min:0",
            "promo_amount" => "required|integer|min:0",
            "promo_type" => ["required", Rule::in(["flat", "percent"])],
            "is_active" => "boolean",
        ]);

        $promoCode->update($request->all());

        return redirect()->route("admin.promo-codes.index")->with("success", "Promo code updated successfully.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PromoCode  $promoCode
     * @return \Illuminate\Http\Response
     */
    public function destroy(PromoCode $promoCode)
    {
        $promoCode->delete();

        return redirect()->route("admin.promo-codes.index")->with("success", "Promo code deleted successfully.");
    }
} 