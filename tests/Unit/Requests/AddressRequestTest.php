<?php

use App\Http\Requests\AddressRequest;

it('authorizes any user', function () {
    $request = new AddressRequest();

    expect($request->authorize())->toBeTrue();
});

it('has the correct validation rules', function () {
    $request = new AddressRequest();

    expect($request->rules())->toEqual([
        'organization_id' => ['required', 'exists:organizations'],
        'number' => ['required'],
        'name' => ['required'],
        'zip_code' => ['required'],
        'country' => ['required'],
        'region' => ['required'],
    ]);
});
