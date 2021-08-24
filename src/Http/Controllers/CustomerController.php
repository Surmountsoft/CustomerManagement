<?php

/**
 * Customer controller
 *
 * @package CSoftech\Customer\Http\Controllers
 *
 * @class CustomerController
 *
 * @author Rahul Sharma <rahul.sharma@surmountsoft.in>
 *
 * @copyright 2021 SurmountSoft Pvt. Ltd. All rights reserved.
 */

namespace CSoftech\Customer\Http\Controllers;

use Illuminate\Http\Request;
use CSoftech\Customer\Http\Requests\CustomerRequest;
use CSoftech\Customer\Models\Country;
use CSoftech\Customer\Models\State;
use CSoftech\Customer\Models\City;
use CSoftech\Customer\Models\Customer;
use CSoftech\Customer\Models\User;
use Yajra\DataTables\Facades\DataTables;
use CSoftech\Customer\Models\Address;
use App\Http\Controllers\Controller;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('view::customer.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
            $countries = Country::pluck('country', 'id')->toArray();
            return view('view::customer.create', compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\CustomerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CustomerRequest $request)
    {
        try {
            \DB::BeginTransaction();
            $customer = Customer::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'company_name' => $request->company_name,
            ]);
            $customer->address()->create([
                'country_id' => $request->country_id,
                'state_id' => $request->state_id,
                'city_id' => $request->city_id,
                'pincode' => $request->pincode,
                'address_line_one' => $request->address_line_1,
                'address_line_two' => $request->address_line_2,
            ]);
            \DB::commit();
            return redirect()->route('customers.index')->with('success', trans('tran::messages.attribute_action_successfully',['attribute' => trans('tran::views.customer'), 'action' => 'added']));
        } catch (\Exception $error) {
            \DB::rollback();
         
            return redirect()->back()->withInput()->with('error', trans('tran::messages.internal_server_error'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customer = Customer::whereId($id)->first();
        $countries = Country::pluck('country', 'id')->toArray();
        if (!is_null($customer->address)) {
            $states = State::whereCountryId($customer->address->country_id)->pluck('region', 'id')->toArray();
            $cities = City::whereCountryId($customer->address->country_id)
                ->whereRegionId($customer->address->state_id)
                ->pluck('city', 'id')
                ->toArray();
        } else {
            $states = State::pluck('region', 'id')->toArray();
            $cities = City::pluck('city', 'id')
                ->toArray();
        }
        return view('view::customer.show', compact('customer', 'countries', 'states', 'cities'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customer = Customer::whereId($id)->first();
        $countries = Country::pluck('country', 'id')->toArray();
        if (!is_null($customer->address)) {
            $states = State::whereCountryId($customer->address->country_id)->pluck('region', 'id')->toArray();
            $cities = City::whereCountryId($customer->address->country_id)
                ->whereRegionId($customer->address->state_id)
                ->pluck('city', 'id')
                ->toArray();
        } else {
            $states = State::pluck('region', 'id')->toArray();
            $cities = City::pluck('city', 'id')
                ->toArray();
        }
        return view('view::customer.edit', compact('customer', 'countries', 'states', 'cities'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\CustomerRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CustomerRequest $request, $id)
    {
        try {
            \DB::BeginTransaction();
            $customer = Customer::whereId($id)->first();
            $customer->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'company_name' => $request->company_name,
            ]);
            Address::updateOrCreate([
                'entity_id' => $customer->id,
                'entity_type' => get_class($customer),
            ], [
                'country_id' => $request->country_id,
                'state_id' => $request->state_id,
                'city_id' => $request->city_id,
                'address_line_one' => $request->address_line_1,
                'address_line_two' => $request->address_line_2,
                'pincode' => $request->pincode,
            ]);
            \DB::commit();
            return redirect()->route('customers.index')->with('success', trans('tran::messages.attribute_action_successfully',['attribute' => trans('tran::views.customer'), 'action' => 'updated']));
        } catch (\Exception $error) {
            \DB::rollback();
            return redirect()->back()->with('error', trans('tran::messages.internal_server_error'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = Customer::whereId($id)->first();
        if (is_null($customer)) {
            return response()->json(['error' => trans('tran::messages.attribute_does_not_exists', [
                'attribute' => trans('tran::views.customer')])], 404);
        }
        try {
            \DB::BeginTransaction();
            $customer->delete();
            $customer->address()->delete();
            \DB::commit();
        } catch (\Exception $error) {
            \DB::rollback();
            return response()->json(['error' => trans('tran::messages.internal_server_error')], 500);
        }
        return response()->json(null, 204);
    }

    /**
     * get country-state list
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function countryStates(Request $request)
    {
        $states = State::whereCountryId($request->id)->pluck('region', 'id')->toArray();
        return response()->json(['states' => $states], 200);
    }

    /**
     * get state-cities list
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function stateCities(Request $request)
    {
        $cities = City::where('country_id', $request->country_id)
            ->where('region_id', $request->state_id)
            ->pluck('city', 'id')
            ->toArray();
        return response()->json(['cities' => $cities], 200);
    }

    /**
     * customer listing
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function customersData(Request $request)
    {
        $customers = Customer::query();
        $search = $request->search['value'];

        if (!is_null($search)) {
            $customers = $customers->where('first_name', 'LIKE', '%' . $search . '%')
                ->orWhere('last_name', 'LIKE', '%' . $search . '%')
                ->orWhere(\DB::raw("CONCAT(`first_name`, ' ', `last_name`)"), 'LIKE', "%" . $search . "%")
                ->orWhere('email', 'LIKE', '%' . $search . '%');
        }
        //filling the table with client information
        return DataTables::eloquent($customers)
    
            ->addColumn('name', function ($customer) {
                return  !is_null($customer->name) ? $customer->name : '-';
            })
            ->editColumn('email', function ($customer) {
                return  !is_null($customer->email) ? $customer->email : '-';
            })
            ->addColumn('abn', function ($customer) {
                return  !is_null($customer->abn) ? $customer->abn : '-';
            })
            ->addColumn('phone_number', function ($customer) {
                return  !is_null($customer->phone_number) ? $customer->phone_number : '-';
            })
            ->addColumn('actions', function ($customer) {
                $str = '';
                $str .= ' <a class="btn btn-link"  href="' . route('customers.show', [$customer->id]) . '"> <i class="far fa-eye mr-1 action-icon-size"></i></a>';              
                $str .= '<a href="' . route('customers.edit', [$customer->id]) . '"> <i class="fas fa-edit mr-1 action-icon-size"></i></a>';
                if($customer->is_blocked)
                    $str .= '<a href="JavaScript:void(0);" data-action="unblock" data-block-route="' . route("customers.block-unblock", ['customer' => $customer->id]) . '" data-customer-id="' . $customer->id . '" class="block-unblock-customer btn btn-link"><i class="fas fa-ban mr-1 action-icon-size" style="color:red"></i></a>';
                else 
                    $str .= '<a href="JavaScript:void(0);" data-action="block" data-block-route="' . route("customers.block-unblock", ['customer' => $customer->id]) . '" data-customer-id="' . $customer->id . '" class="block-unblock-customer btn btn-link"><i class="fas fa-ban mr-1 action-icon-size"></i></a>';
                $str .= '<a href="JavaScript:void(0);" data-destroy-route="' . route("customers.destroy", ['customer' => $customer->id]) . '" data-customer-id="' . $customer->id . '" class="delete-customer btn btn-link"><i class="fas fa-trash mr-3 action-icon-size" style="color:red"></i></a>';
                return $str;
            })
            ->editColumn('id', function ($customer){
                return $customer->id;
            })
            ->rawColumns(['name', 'email', 'abn', 'phone_number', 'actions', 'id'])
            ->make(true);
    }

    /**
     * Block unblock the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function blockUnblock($id)
    {
        $customer = Customer::whereId($id)->first();
        if (is_null($customer)) {
            return response()->json(['error' => trans('tran::messages.attribute_does_not_exists', [
                'attribute' => trans('tran::views.customer')])], 404);
        }
        try {
            \DB::BeginTransaction();
            $customer->update([
                'is_blocked' => $customer->is_blocked == 1 ? 0 : 1
            ]);
            \DB::commit();
        } catch (\Exception $error) {
            \DB::rollback();
            return response()->json(['error' => trans('tran::messages.internal_server_error')], 500);
        }
        return response()->json(['status' => $customer->is_blocked], 200);
    }

}
