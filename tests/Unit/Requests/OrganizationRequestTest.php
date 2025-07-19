<?php

use App\Http\Requests\OrganizationRequest;

it('authorizes any user', function () {
    $request = new OrganizationRequest();

    expect($request->authorize())->toBeTrue();
});

it('has the correct validation rules', function () {
    $request = new OrganizationRequest();

    expect($request->rules())->toEqual([
        'name' => ['required'],
        'type' => ['required'],
        'logo' => ['nullable'],
    ]);
});
