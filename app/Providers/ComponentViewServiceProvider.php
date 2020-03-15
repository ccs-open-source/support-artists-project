<?php

namespace App\Providers;


use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class ComponentViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::include('components.form.alert', 'alert');
        Blade::include('components.form.divider', 'divider');
        Blade::include('components.form.btn-create', 'btnCreate');
        Blade::include('components.form.btn-delete', 'btnDelete');
        Blade::include('components.form.btn-edit', 'btnEdit');
        Blade::include('components.form.btn-primary', 'btnPrimary');
        Blade::include('components.form.btn-secondary', 'btnSecondary');
        Blade::include('components.form.btn-tertiary', 'btnTertiary');
        Blade::include('components.form.btn-back', 'btnBack');
        Blade::include('components.form.btn-save', 'btnSave');
        Blade::include('components.form.btn-save-and-edit', 'btnSaveEdit');

        Blade::include('components.form.input', 'input');
        Blade::include('components.form.select', 'select');
        Blade::include('components.form.textarea', 'textarea');
        Blade::include('components.form.checkbox', 'checkbox');
        Blade::include('components.form.datepicker', 'datepicker');
        Blade::include('components.form.datetimepicker', 'datetimepicker');

    }
}
