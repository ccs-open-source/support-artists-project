<form action="{{ $route }}" method="post" class="mt-5">
    @csrf

    <div class="row">
        <div class="col col-12 col-md-6">
            @input(['field' => 'realName', 'label' => trans('artist.real-name'), 'help' => trans('artist.real-name-help')])
        </div>
        <div class="col col-12 col-md-6">
            @input(['field' => 'name', 'label' => trans('artist.name'), 'help' => trans('artist.name-help'), 'validation' => ['required' => true]])
        </div>
    </div>
    <div class="row">
        <div class="col col-12 col-md-8">
            @input(['field' => 'email', 'disabled' => (isset($type) && $type == 'profile'), 'label' => trans('artist.email'), 'help' => trans('artist.email-help')])
        </div>
        <div class="col col-12 col-md-4">
            @input(['field' => 'password', 'label' => trans('artist.password'), 'help' => trans('artist.password-help'), 'type' => 'password'])
        </div>
    </div>
    @if (isset($type) && $type === 'profile')
    <div class="row">
        <div class="col col-12 col-md-4 offset-md-8">
            @input([
            'field' => 'password_confirmation',
            'label' => trans('artist.password-confirmation'),
            'help' => trans('artist.password-help'), 'type' => 'password'])
        </div>
    </div>
    @endif

    <hr class="my-4">

    <div class="row">
        <div class="col col-12 col-md-8">
            @input(['field' => 'address', 'label' => trans('artist.address'), 'help' => trans('artist.address-help')])
        </div>
        <div class="col col-12 col-md-4">
            @input(['field' => 'city', 'label' => trans('artist.city'), 'help' => trans('artist.city-help')])
        </div>
    </div>
    <div class="row">
        <div class="col col-12 col-md-4">
            @input(['field' => 'postalCode', 'label' => trans('artist.postal-code'), 'help' => trans('artist.postal-code-help')])
        </div>
        <div class="col col-12 col-md-4">
            @input(['field' => 'countryCode', 'label' => trans('artist.country-code'), 'help' => trans('artist.country-code-help')])
        </div>
        <div class="col col-12 col-md-4">
            @input(['field' => 'vat', 'label' => trans('artist.vat'), 'help' => trans('artist.vat-help')])
        </div>
    </div>

    <hr class="my-4">

    <div class="row">
        <div class="col col-12 col-md-6">
            @input(['field' => 'activityProof', 'label' => trans('artist.activity-proof'), 'help' => trans('artist.activity-proof-help')])
        </div>
        <div class="col col-12 col-md-6">
            @checkbox([
            'field' => 'wantDonation',
            'type' => 'checkbox',
            'label' => trans('artist.want-donation'),
            'class' => 'mt-4',
            'validation' => [

            ]
            ])
        </div>
    </div>
    <div class="row">
        <div class="col col-12 col-md-6">
            @input(['field' => 'iban', 'label' => trans('artist.iban'), 'help' => trans('artist.iban-help')])
        </div>
    </div>

    <div class="row mb-5">
        <div class="col col-12 col-md-4">
            @btnPrimary(['title' => trans('actions.submit')])
        </div>
    </div>
</form>
